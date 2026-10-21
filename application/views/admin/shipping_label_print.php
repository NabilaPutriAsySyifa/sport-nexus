<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thermal Shipping Label - <?php echo htmlspecialchars($order->invoice_number); ?></title>
    <style>
        @page {
            size: 100mm 150mm;
            margin: 0;
        }
        * {
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
        }
        body {
            margin: 0;
            padding: 4mm;
            background: #fff;
            color: #000;
            width: 100mm;
            height: 150mm;
        }
        .label-container {
            border: 2px solid #000;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3mm;
        }
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 2mm;
        }
        .brand-title {
            font-size: 16px;
            font-weight: 900;
            font-style: italic;
            letter-spacing: 1px;
        }
        .courier-badge {
            border: 2px solid #000;
            padding: 2px 8px;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }
        .barcode-section {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding: 3mm 0;
        }
        .barcode-lines {
            font-family: monospace;
            font-size: 26px;
            letter-spacing: 5px;
            font-weight: 900;
            line-height: 1;
        }
        .tracking-text {
            font-size: 11px;
            font-family: monospace;
            font-weight: bold;
            margin-top: 2px;
        }
        .address-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2mm;
            border-bottom: 2px solid #000;
            padding: 2mm 0;
        }
        .addr-block {
            font-size: 10px;
            line-height: 1.3;
        }
        .addr-title {
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #ccc;
            margin-bottom: 2px;
        }
        .recipient-name {
            font-size: 13px;
            font-weight: 900;
        }
        .items-section {
            border-bottom: 1px solid #000;
            padding: 2mm 0;
            font-size: 9px;
            flex-grow: 1;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
        }
        .items-table th {
            text-align: left;
            border-bottom: 1px solid #000;
            font-size: 8px;
            padding: 1px 0;
        }
        .items-table td {
            padding: 2px 0;
        }
        .footer-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 8px;
            padding-top: 1mm;
        }
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 10px; text-align: center;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #000; color: #fff; font-weight: bold; border-radius: 4px; cursor: pointer;">
            🖨 Cetak Label Thermal (100 x 150 mm)
        </button>
    </div>

    <div class="label-container">
        <!-- 1. Header -->
        <div class="header-row">
            <div>
                <div class="brand-title">SPORT NEXUS</div>
                <div style="font-size: 8px; font-weight: bold;">ORIGINAL FOOTWEAR LOGISTICS</div>
            </div>
            <div class="courier-badge">
                <?php echo htmlspecialchars($order->shipping_courier); ?>
            </div>
        </div>

        <!-- 2. Barcode Simulation & Tracking Number -->
        <div class="barcode-section">
            <div class="barcode-lines">||| | |||| || ||||| ||| |||</div>
            <div class="tracking-text">RESI: <?php echo htmlspecialchars($order->tracking_number); ?></div>
            <div style="font-size: 9px; font-weight: bold; margin-top: 1px;">INVOICE: <?php echo htmlspecialchars($order->invoice_number); ?></div>
        </div>

        <!-- 3. Address Section (Destination & Origin) -->
        <div class="address-grid">
            <div class="addr-block" style="border: 1.5px solid #000; padding: 2mm; border-radius: 2px;">
                <div class="addr-title">PENERIMA (SHIP TO):</div>
                <div class="recipient-name"><?php echo htmlspecialchars($order->recipient_name); ?></div>
                <div style="font-weight: bold;"><?php echo htmlspecialchars($order->recipient_phone); ?></div>
                <div><?php echo htmlspecialchars($order->shipping_address); ?></div>
                <div style="font-weight: 900; font-size: 11px; margin-top: 2px;">
                    <?php echo htmlspecialchars($order->district . ', ' . $order->city . ' ' . $order->postal_code); ?>
                </div>
            </div>

            <div class="addr-block" style="padding: 1mm 2mm; background: #f5f5f5;">
                <div class="addr-title">PENGIRIM (SENDER):</div>
                <div style="font-weight: bold;">Sport Nexus Fulfillment Hub (Bekasi)</div>
                <div>Grand Metropolitan Mall Lt. 2 Unit 16, Kota Bekasi 17148</div>
                <div>Telp / CS: +62 857-1737-2990</div>
            </div>
        </div>

        <!-- 4. Package Contents Breakdown -->
        <div class="items-section">
            <div style="font-weight: bold; font-size: 9px; margin-bottom: 2px;">ISI PAKET (FOOTWEAR ITEMS):</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>NAMA PRODUK</th>
                        <th style="text-align: center;">EUR</th>
                        <th style="text-align: center;">WARNA</th>
                        <th style="text-align: right;">QTY</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($order->items)): ?>
                        <?php foreach ($order->items as $it): ?>
                            <tr>
                                <td style="font-weight: bold;"><?php echo htmlspecialchars($it->brand_name . ' - ' . $it->product_name); ?></td>
                                <td style="text-align: center; font-weight: bold;"><?php echo htmlspecialchars($it->size_eu); ?></td>
                                <td style="text-align: center;"><?php echo htmlspecialchars($it->color); ?></td>
                                <td style="text-align: right; font-weight: 900;"><?php echo $it->quantity; ?> psg</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- 5. Footer & Non-Cash Certification -->
        <div class="footer-row">
            <div>
                <strong>NON-CASH DIGITAL SETTLEMENT (NO COD)</strong><br>
                <span>Metode: <?php echo htmlspecialchars($order->payment_method); ?></span>
            </div>
            <div style="text-align: right;">
                <span>Berat Est: 1.0 Kg</span><br>
                <strong>Tgl: <?php echo date('d/m/Y', strtotime($order->created_at)); ?></strong>
            </div>
        </div>
    </div>

</body>
</html>
