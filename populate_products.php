<?php
// Script to populate 1,443 footwear products for Sport Nexus
set_time_limit(0);
ini_set('memory_limit', '512M');

$mysqli = new mysqli('localhost', 'root', '', 'sport_nexus');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}
$mysqli->set_charset('utf8mb4');

echo "Connected to MySQL. Preparing product import...\n";

function fetchGraphQL($brandFilter, $page = 1, $rows = 50) {
    $url = 'https://api.sportsstation.id/graphql?opname=BrowsePlpFull';
    $query = 'query BrowsePlpFull($category: String!, $currPage: Int, $rows: Int, $filters: [FilterInputDto], $lang: String) {
        browseCategoryPlp(category: $category, page: $currPage, rows: $rows, filters: $filters, acceptLanguage: $lang) {
            totalCount
            products {
                productCode
                productName
                mediaLink
                productPrice
                salePrice
                discount
                brand { brandName }
            }
        }
    }';

    $data = array(
        'operationName' => 'BrowsePlpFull',
        'query' => $query,
        'variables' => array(
            'category' => '*',
            'currPage' => (int)$page,
            'rows'     => (int)$rows,
            'filters'  => array(array('key' => 'brand_uFilter', 'value' => array($brandFilter)))
        )
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Origin-Alias: sportsstation.id',
        'Language: en-US',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
    ));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) return array();
    $json = json_decode($response, true);
    return isset($json['data']['browseCategoryPlp']['products']) ? $json['data']['browseCategoryPlp']['products'] : array();
}

$brandConfigs = array(
    array('name' => 'Diadora', 'filter' => 'Diadora', 'quota' => 500, 'brand_id' => 1, 'defaultSport' => 'Running', 'isKids' => false),
    array('name' => 'New Balance', 'filter' => 'New Balance', 'quota' => 200, 'brand_id' => 2, 'defaultSport' => 'Running', 'isKids' => false),
    array('name' => 'Airwalk', 'filter' => 'Airwalk', 'quota' => 400, 'brand_id' => 3, 'defaultSport' => 'Lifestyle', 'isKids' => false),
    array('name' => 'Converse', 'filter' => 'Converse', 'quota' => 150, 'brand_id' => 4, 'defaultSport' => 'Lifestyle', 'isKids' => false),
    array('name' => 'Converse Kids', 'filter' => 'Converse Kids', 'quota' => 90, 'brand_id' => 4, 'defaultSport' => 'Lifestyle', 'isKids' => true),
    array('name' => 'Nike', 'filter' => 'Nike', 'quota' => 100, 'brand_id' => 5, 'defaultSport' => 'Running', 'isKids' => false),
    array('name' => 'Nike Young Athletes', 'filter' => 'Nike Young Athletes', 'quota' => 20, 'brand_id' => 5, 'defaultSport' => 'Running', 'isKids' => true),
    array('name' => 'Nike Golf', 'filter' => 'Nike Golf', 'quota' => 1, 'brand_id' => 5, 'defaultSport' => 'Golf', 'isKids' => false),
    array('name' => 'Puma', 'filter' => 'Puma', 'quota' => 80, 'brand_id' => 6, 'defaultSport' => 'Running', 'isKids' => false),
    array('name' => 'Puma Golf', 'filter' => 'Puma Golf', 'quota' => 2, 'brand_id' => 6, 'defaultSport' => 'Golf', 'isKids' => false)
);

$mysqli->query("SET FOREIGN_KEY_CHECKS = 0");
$mysqli->query("TRUNCATE TABLE product_skus");
$mysqli->query("TRUNCATE TABLE products");
$mysqli->query("SET FOREIGN_KEY_CHECKS = 1");

$stmt_product = $mysqli->prepare("INSERT INTO products (sku, name, brand_id, brand_name, gender, primary_sport, footwear_type, color, original_price, discount_percent, sale_price, thumbnail, images, description, is_published) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");

$stmt_sku = $mysqli->prepare("INSERT INTO product_skus (product_id, sku_code, size_eu, size_us, stock_qty) VALUES (?, ?, ?, ?, ?)");

$totalImported = 0;

foreach ($brandConfigs as $cfg) {
    echo "Processing {$cfg['name']} (Target Quota: {$cfg['quota']})...\n";
    $collected = array();
    $page = 1;

    while (count($collected) < $cfg['quota'] && $page <= 12) {
        $items = fetchGraphQL($cfg['filter'], $page, 50);
        if (empty($items)) break;

        foreach ($items as $it) {
            $lower = strtolower($it['productName']);
            // Skip non-footwear
            if (strpos($lower, 't-shirt') !== false || strpos($lower, 'pants') !== false || 
                strpos($lower, 'hoodie') !== false || strpos($lower, 'jacket') !== false || 
                strpos($lower, 'cap') !== false || strpos($lower, 'bag') !== false || 
                strpos($lower, 'socks') !== false || strpos($lower, 'shorts') !== false) {
                continue;
            }
            $collected[] = $it;
            if (count($collected) >= $cfg['quota']) break;
        }
        $page++;
    }

    echo "Fetched " . count($collected) . " footwear items from API for {$cfg['name']}.\n";

    // If collected items < quota, generate realistic brand variations
    $baseCount = count($collected);
    $colorOptions = array('Navy', 'White', 'Black', 'Grey', 'Beige', 'Red', 'Blue', 'Pink', 'Green', 'Brown', 'Yellow', 'Orange');
    $cloneIdx = 1;

    while (count($collected) < $cfg['quota']) {
        $base = ($baseCount > 0) ? $collected[$cloneIdx % $baseCount] : array(
            'productCode' => 'SP_' . strtoupper(str_replace(' ', '', $cfg['name'])) . '_' . $cloneIdx,
            'productName' => $cfg['name'] . ' Pro Sport ' . $cloneIdx,
            'mediaLink' => 'https://bb-scm-prod-pim.oss-ap-southeast-5.aliyuncs.com/products/f5d88e9211c72b757bc0eab0281b7db4/helix/01-DIADORA-FFSSBDIAA-DIACA260103B-Black.jpg',
            'productPrice' => '699000',
            'salePrice' => '349500',
            'discount' => '50'
        );

        $vColor = $colorOptions[$cloneIdx % count($colorOptions)];
        $cleanName = preg_replace('/ - [^-]+$/', '', $base['productName']);
        $newName = $cleanName . ' - ' . $vColor;

        if ($cfg['name'] === 'Nike Golf' && stripos($newName, 'golf') === false) {
            $newName = 'Nike Infinity Pro 2 Spikeless Men\'s Golf Shoes - ' . $vColor;
        }
        if ($cfg['name'] === 'Puma Golf' && stripos($newName, 'golf') === false) {
            $newName = 'Puma GS-One Waterproof Men\'s Golf Shoes - ' . $vColor;
        }

        $collected[] = array(
            'productCode'  => $base['productCode'] . '_V' . $cloneIdx,
            'productName'  => $newName,
            'mediaLink'    => $base['mediaLink'],
            'productPrice' => !empty($base['productPrice']) ? $base['productPrice'] : '799000',
            'salePrice'    => !empty($base['salePrice']) ? $base['salePrice'] : '399500',
            'discount'     => !empty($base['discount']) ? $base['discount'] : '50'
        );
        $cloneIdx++;
    }

    // Insert items for this brand up to quota
    for ($i = 0; $i < $cfg['quota']; $i++) {
        $p = $collected[$i];
        $orig = floatval($p['productPrice']) ?: 599000;
        $disc = intval($p['discount']) ?: 0;
        if ($disc === 0 && !empty($p['salePrice']) && floatval($p['salePrice']) < $orig) {
            $disc = round((($orig - floatval($p['salePrice'])) / $orig) * 100);
        }
        $sale = $disc > 0 ? round($orig * (1 - $disc / 100)) : $orig;

        // Gender determination
        $gender = 'Men';
        $lower = strtolower($p['productName']);
        if ($cfg['isKids'] || strpos($lower, 'kids') !== false || strpos($lower, 'boy') !== false || strpos($lower, 'girl') !== false || strpos($lower, 'jr') !== false) {
            if (strpos($lower, 'girl') !== false) $gender = 'Girls';
            elseif (strpos($lower, 'boy') !== false) $gender = 'Boys';
            else $gender = 'Unisex Kids';
        } elseif (strpos($lower, "women's") !== false || strpos($lower, 'women') !== false || strpos($lower, 'wmn') !== false) {
            $gender = 'Women';
        } elseif (strpos($lower, 'unisex') !== false) {
            $gender = 'Unisex';
        }

        // Sport & Footwear type
        $sport = $cfg['defaultSport'];
        $ftype = 'Sneakers';
        if (strpos($lower, 'run') !== false || strpos($lower, 'speed') !== false || strpos($lower, 'revio') !== false || strpos($lower, 'rayna') !== false || strpos($lower, 'revolution') !== false) {
            $sport = 'Running';
            $ftype = 'Running';
        } elseif (strpos($lower, 'walk') !== false || strpos($lower, 'slip-on') !== false) {
            $sport = 'Walking';
            $ftype = 'Walking';
        } elseif (strpos($lower, 'futsal') !== false || strpos($lower, 'soccer') !== false || strpos($lower, 'pichichi') !== false) {
            $sport = 'Soccer';
            $ftype = 'Soccer';
        } elseif (strpos($lower, 'tennis') !== false || strpos($lower, 'court') !== false) {
            $sport = 'Tennis';
            $ftype = 'Tennis';
        } elseif (strpos($lower, 'badminton') !== false) {
            $sport = 'Badminton';
            $ftype = 'Badminton';
        } elseif (strpos($lower, 'basket') !== false || strpos($lower, 'all star pro') !== false || strpos($lower, 'weapon') !== false) {
            $sport = 'Basketball';
            $ftype = 'Sports Performance';
        } elseif (strpos($lower, 'golf') !== false) {
            $sport = 'Golf';
            $ftype = 'Golf';
        } elseif (strpos($lower, 'sandal') !== false || strpos($lower, 'slide') !== false) {
            $sport = 'Swimming';
            $ftype = 'Sandals';
        } elseif (strpos($lower, 'fitness') !== false || strpos($lower, 'train') !== false) {
            $sport = 'Fitness';
            $ftype = 'Sports Performance';
        } elseif (strpos($lower, 'leisure') !== false || strpos($lower, 'reidor') !== false || strpos($lower, 'gira') !== false) {
            $sport = 'Lifestyle';
            $ftype = 'Leisure';
        }

        // Color
        $color = 'Black';
        foreach ($colorOptions as $c) {
            if (stripos($p['productName'], $c) !== false) {
                $color = $c;
                break;
            }
        }

        $sku = substr(preg_replace('/[^a-zA-Z0-9_\-]/', '', $p['productCode']), 0, 50);
        $imagesJson = json_encode(array($p['mediaLink']));
        $desc = "Sepatu {$cfg['name']} resmi Sport Nexus. Menghadirkan performa dan kenyamanan optimal.";

        $stmt_product->bind_param(
            "ssisssssdiisss",
            $sku,
            $p['productName'],
            $cfg['brand_id'],
            $cfg['name'],
            $gender,
            $sport,
            $ftype,
            $color,
            $orig,
            $disc,
            $sale,
            $p['mediaLink'],
            $imagesJson,
            $desc
        );
        $stmt_product->execute();
        $prodId = $mysqli->insert_id;

        // Size Matrix
        if (in_array($gender, array('Boys', 'Girls', 'Unisex Kids'))) {
            $sizes = array('20', '22', '24', '26', '28', '29', '30', '31', '32', '33', '34', '35');
        } elseif ($gender === 'Women') {
            $sizes = array('36', '36.5', '37', '37.5', '38', '38.5', '39', '40', '40.5', '41');
        } else {
            $sizes = array('39', '40', '40.5', '41', '42', '42.5', '43', '44', '44.5', '45', '46');
        }

        foreach ($sizes as $sz) {
            $skuCode = $sku . '-EU' . $sz;
            $usVal = strval(round(floatval($sz) - 33, 1));
            $stock = rand(3, 12);
            $stmt_sku->bind_param("isssi", $prodId, $skuCode, $sz, $usVal, $stock);
            $stmt_sku->execute();
        }

        $totalImported++;
    }

    echo "Completed {$cfg['name']}: {$cfg['quota']} products stored.\n";
}

echo "\n============================================\n";
echo "SUCCESS! Total Footwear Products in Database: {$totalImported}\n";
echo "============================================\n";
