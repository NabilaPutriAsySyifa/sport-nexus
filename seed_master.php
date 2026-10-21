<?php
$mysqli = new mysqli('localhost', 'root', '', 'sport_nexus');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// 1. Seed Brands
$brands = [
    [
        'name' => 'Diadora',
        'slug' => 'diadora',
        'sub_brands' => json_encode([]),
        'total_quota' => 500,
        'display_order' => 1,
        'logo' => 'assets/images/brands/diadora.svg'
    ],
    [
        'name' => 'New Balance',
        'slug' => 'new-balance',
        'sub_brands' => json_encode([]),
        'total_quota' => 200,
        'display_order' => 2,
        'logo' => 'assets/images/brands/new-balance.svg'
    ],
    [
        'name' => 'Airwalk',
        'slug' => 'airwalk',
        'sub_brands' => json_encode(['Kids Series']),
        'total_quota' => 400,
        'display_order' => 3,
        'logo' => 'assets/images/brands/airwalk.svg'
    ],
    [
        'name' => 'Converse',
        'slug' => 'converse',
        'sub_brands' => json_encode(['Converse Kids']),
        'total_quota' => 240, // 150 Adult + 90 Kids
        'display_order' => 4,
        'logo' => 'assets/images/brands/converse.svg'
    ],
    [
        'name' => 'Nike',
        'slug' => 'nike',
        'sub_brands' => json_encode(['Nike Young Athletes', 'Nike Golf']),
        'total_quota' => 121, // 100 Adult + 20 YA + 1 Golf
        'display_order' => 5,
        'logo' => 'assets/images/brands/nike.svg'
    ],
    [
        'name' => 'Puma',
        'slug' => 'puma',
        'sub_brands' => json_encode(['Puma Golf']),
        'total_quota' => 82, // 80 Adult + 2 Golf
        'display_order' => 6,
        'logo' => 'assets/images/brands/puma.svg'
    ]
];

$stmt = $mysqli->prepare("INSERT INTO brands (name, slug, sub_brands, total_quota, display_order, logo) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE total_quota = VALUES(total_quota), display_order = VALUES(display_order)");
foreach ($brands as $b) {
    $stmt->bind_param("sssiss", $b['name'], $b['slug'], $b['sub_brands'], $b['total_quota'], $b['display_order'], $b['logo']);
    $stmt->execute();
}

// 2. Seed Admin User
$admin_pass = password_hash('Admin123!', PASSWORD_BCRYPT);
$admin_sql = "INSERT INTO admin_users (work_email, password_hash, full_name, employee_id, role) 
              VALUES ('admin@sportnexus.com', '$admin_pass', 'Farrel Paksi', 'SN-ADM-001', 'Super Admin')
              ON DUPLICATE KEY UPDATE full_name = VALUES(full_name), role = VALUES(role)";
$mysqli->query($admin_sql);

// 3. Seed Default Customer User
$user_pass = password_hash('User123!', PASSWORD_BCRYPT);
$user_sql = "INSERT INTO users (email, password_hash, first_name, last_name, date_of_birth, gender)
             VALUES ('nabila@gmail.com', '$user_pass', 'Nabila', 'Putri Asy Syifa', '2004-02-21', 'Female')
             ON DUPLICATE KEY UPDATE first_name = VALUES(first_name)";
$mysqli->query($user_sql);
$user_id = $mysqli->insert_id ?: 1;

// 4. Seed User Addresses (Multi-address)
$mysqli->query("DELETE FROM user_addresses WHERE user_id = $user_id");
$addresses = [
    [
        'user_id' => $user_id,
        'recipient_name' => 'Nabila Putri Asy Syifa',
        'phone_number' => '085711942921',
        'full_address' => 'Perum Rancamanyar Blok J1 No. 13 RT 006/RW 007, Desa Rancamanyar',
        'province' => 'Jawa Barat',
        'city' => 'Kab. Karawang',
        'district' => 'Kota Baru',
        'postal_code' => '41374',
        'is_primary' => 1
    ],
    [
        'user_id' => $user_id,
        'recipient_name' => 'Nabila Putri (Kantor)',
        'phone_number' => '085711942921',
        'full_address' => 'Grand Metropolitan Mall Lt. 2 Unit 16, Jl. KH. Noer Ali No. 1',
        'province' => 'Jawa Barat',
        'city' => 'Kota Bekasi',
        'district' => 'Bekasi Selatan',
        'postal_code' => '17148',
        'is_primary' => 0
    ],
    [
        'user_id' => $user_id,
        'recipient_name' => 'Nabila Putri (Rumah Orang Tua)',
        'phone_number' => '081298765432',
        'full_address' => 'Jl. Ahmad Yani No. 88 RT 004/RW 001 Marga Jaya',
        'province' => 'Jawa Barat',
        'city' => 'Kota Bekasi',
        'district' => 'Bekasi Selatan',
        'postal_code' => '17141',
        'is_primary' => 0
    ]
];
$addr_stmt = $mysqli->prepare("INSERT INTO user_addresses (user_id, recipient_name, phone_number, full_address, province, city, district, postal_code, is_primary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($addresses as $a) {
    $addr_stmt->bind_param("isssssssi", $a['user_id'], $a['recipient_name'], $a['phone_number'], $a['full_address'], $a['province'], $a['city'], $a['district'], $a['postal_code'], $a['is_primary']);
    $addr_stmt->execute();
}

// 5. Seed Store Locations (4 stores in Bekasi & Karawang)
$mysqli->query("TRUNCATE TABLE store_locations");
$stores = [
    [
        'store_name' => 'Sport Nexus • The Grand Outlet - Karawang',
        'city' => 'Kab. Karawang',
        'address' => 'Jalan Trans Heksa, Wanasari, Telukjambe Barat, Karawang, Jawa Barat 41361',
        'postal_code' => '41361',
        'latitude' => -6.3558048,
        'longitude' => 107.2433629,
        'maps_url' => 'https://www.google.com/maps/dir//Sport+Station+%E2%80%A2+The+Grand+Outlet+-+Karawang,+Jalan+Trans+Heksa,+Wanasari,+Telukjambe+Barat,+Karawang,+West+Java+41361/@-6.4028672,107.4692096,14z/data=!4m8!4m7!1m0!1m5!1m1!1s0x2e699d771f07e427:0x9c8829ddf6d5c321!2m2!1d107.2433629!2d-6.3558048',
        'operating_hours' => '10:00 - 22:00 WIB',
        'phone' => '+62 857-1737-2990'
    ],
    [
        'store_name' => 'Sport Nexus • Karawang Central Plaza (KCP)',
        'city' => 'Kab. Karawang',
        'address' => 'Margakaya, Kec. Telukjambe Barat, Karawang, Jawa Barat 41361',
        'postal_code' => '41361',
        'latitude' => -6.3262000,
        'longitude' => 107.2942000,
        'maps_url' => 'https://www.google.com/maps/search/?api=1&query=Sports+Station+Karawang+Central+Plaza&daddr=M7CV%2BQ2G,+Margakaya,+Kec.+Telukjambe+Bar.,+Karawang,+Jawa+Barat+41361',
        'operating_hours' => '10:00 - 22:00 WIB',
        'phone' => '+62 857-1737-2990'
    ],
    [
        'store_name' => 'Sport Nexus • Grand Metropolitan Bekasi',
        'city' => 'Kota Bekasi',
        'address' => 'Grand Metropolitan Mall Bekasi, Jl. KH. Noer Ali No. 1, RT.007/RW.003, Pekayon Jaya, Kec. Bekasi Selatan, Kota Bekasi, Jawa Barat 17148',
        'postal_code' => '17148',
        'latitude' => -6.2483000,
        'longitude' => 106.9858000,
        'maps_url' => 'https://www.google.com/maps/search/?api=1&query=SPORTS+STATION+GRAND+METROPOLITAN+BEKASI&daddr=Grand+Metropolitan+Mall+Bekasi,+Jl.+KH.+Noer+Ali+No.1+1+UNIT+16-18JL,+RT.007/RW.003,+Pekayon+Jaya,+Kec.+Bekasi+Sel.,+Kota+Bks,+Jawa+Barat+17148',
        'operating_hours' => '10:00 - 22:00 WIB',
        'phone' => '+62 857-1737-2990'
    ],
    [
        'store_name' => 'Sport Nexus • Mega Bekasi Hypermall',
        'city' => 'Kota Bekasi',
        'address' => 'Mega Bekasi Hypermall, Jl. Ahmad Yani No. 1, RT.004/RW.001, Marga Jaya, Kec. Bekasi Selatan, Kota Bekasi, Jawa Barat 17141',
        'postal_code' => '17141',
        'latitude' => -6.2447000,
        'longitude' => 106.9984000,
        'maps_url' => 'https://www.google.com/maps/search/?api=1&query=SPORTS+STATION+MEGABEKASI+HYPERMALL&daddr=MEGA+BEKASI+HYPERMALL,+Jl.+Ahmad+Yani+No.1,+RT.004/RW.001,+Marga+Jaya,+Kec.+Bekasi+Sel.,+Kota+Bks,+Jawa+Barat+17141',
        'operating_hours' => '10:00 - 22:00 WIB',
        'phone' => '+62 857-1737-2990'
    ]
];
$store_stmt = $mysqli->prepare("INSERT INTO store_locations (store_name, city, address, postal_code, latitude, longitude, maps_url, operating_hours, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($stores as $s) {
    $store_stmt->bind_param("ssssddsss", $s['store_name'], $s['city'], $s['address'], $s['postal_code'], $s['latitude'], $s['longitude'], $s['maps_url'], $s['operating_hours'], $s['phone']);
    $store_stmt->execute();
}

// 6. Seed Promos
$mysqli->query("TRUNCATE TABLE promos");
$promos = [
    [
        'promo_code' => 'NEXUS50',
        'discount_type' => 'percentage',
        'discount_value' => 50.00,
        'min_purchase' => 100000.00,
        'quota_limit' => 200,
        'used_count' => 12,
        'start_date' => '2026-01-01',
        'end_date' => '2026-12-31',
        'is_active' => 1
    ],
    [
        'promo_code' => 'DISKON10',
        'discount_type' => 'percentage',
        'discount_value' => 10.00,
        'min_purchase' => 250000.00,
        'quota_limit' => 500,
        'used_count' => 45,
        'start_date' => '2026-01-01',
        'end_date' => '2026-12-31',
        'is_active' => 1
    ],
    [
        'promo_code' => 'NEXUSHEMAT',
        'discount_type' => 'fixed',
        'discount_value' => 50000.00,
        'min_purchase' => 300000.00,
        'quota_limit' => 300,
        'used_count' => 18,
        'start_date' => '2026-01-01',
        'end_date' => '2026-12-31',
        'is_active' => 1
    ],
    [
        'promo_code' => 'SPORTSALE',
        'discount_type' => 'percentage',
        'discount_value' => 25.00,
        'min_purchase' => 500000.00,
        'quota_limit' => 150,
        'used_count' => 8,
        'start_date' => '2026-01-01',
        'end_date' => '2026-12-31',
        'is_active' => 1
    ]
];
$promo_stmt = $mysqli->prepare("INSERT INTO promos (promo_code, discount_type, discount_value, min_purchase, quota_limit, used_count, start_date, end_date, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($promos as $p) {
    $promo_stmt->bind_param("ssddiissi", $p['promo_code'], $p['discount_type'], $p['discount_value'], $p['min_purchase'], $p['quota_limit'], $p['used_count'], $p['start_date'], $p['end_date'], $p['is_active']);
    $promo_stmt->execute();
}

// 7. Seed Hero Banners
$mysqli->query("TRUNCATE TABLE hero_banners");
$banners = [
    [
        'title' => 'The Ultimate Sneaker Collection',
        'headline' => 'SPORT NEXUS: THE ULTIMATE SNEAKER COLLECTION',
        'subheadline' => 'Temukan siluet ikonik dari Diadora, New Balance, Airwalk, dan Converse dengan penawaran eksklusif.',
        'desktop_image' => 'uploads/banners/hero-banner-1.jpg',
        'mobile_image' => 'uploads/banners/hero-banner-1-mobile.jpg',
        'cta_label' => 'Jelajahi Sekarang',
        'cta_link' => 'brands.html',
        'target_brand' => 'All',
        'sort_order' => 1,
        'is_published' => 1
    ],
    [
        'title' => 'Elevate Your Step: Diadora & New Balance',
        'headline' => 'ELEVATE YOUR STEP: DIADORA & NEW BALANCE',
        'subheadline' => 'Kenyamanan bantalan optimal untuk aktivitas lari dan gaya hidup harian.',
        'desktop_image' => 'uploads/banners/hero-banner-2.jpg',
        'mobile_image' => 'uploads/banners/hero-banner-2-mobile.jpg',
        'cta_label' => 'Lihat Koleksi',
        'cta_link' => 'brands/diadora',
        'target_brand' => 'Diadora',
        'sort_order' => 2,
        'is_published' => 1
    ],
    [
        'title' => 'Street Essentials: Airwalk & Converse',
        'headline' => 'STREET ESSENTIALS: AIRWALK & CONVERSE',
        'subheadline' => 'Desain kasual tanpa batas usia untuk gaya harian yang fleksibel dan percaya diri.',
        'desktop_image' => 'uploads/banners/hero-banner-3.jpg',
        'mobile_image' => 'uploads/banners/hero-banner-3-mobile.jpg',
        'cta_label' => 'Beli Sekarang',
        'cta_link' => 'brands/airwalk',
        'target_brand' => 'Airwalk',
        'sort_order' => 3,
        'is_published' => 1
    ]
];
$banner_stmt = $mysqli->prepare("INSERT INTO hero_banners (title, headline, subheadline, desktop_image, mobile_image, cta_label, cta_link, target_brand, sort_order, is_published) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($banners as $bn) {
    $banner_stmt->bind_param("ssssssssii", $bn['title'], $bn['headline'], $bn['subheadline'], $bn['desktop_image'], $bn['mobile_image'], $bn['cta_label'], $bn['cta_link'], $bn['target_brand'], $bn['sort_order'], $bn['is_published']);
    $banner_stmt->execute();
}

echo "Master tables seeded successfully!\n";
