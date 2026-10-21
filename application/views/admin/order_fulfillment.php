<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - ORDER MANAGEMENT & FULFILLMENT
     Order Stream, Status Updater, 4-Block Drawer & Shipping Label Integration
     ========================================================================= -->

<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-200 gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                <span class="text-xs font-black uppercase text-slate-400 tracking-wider">Fulfillment & Operations</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900 mt-0.5">
                Manajemen Pesanan & Pengiriman
            </h1>
            <p class="text-xs text-slate-500">
                Audit pesanan masuk dari seluruh kategori, verifikasi metode pembayaran non-COD, kontrol kurir logistik, serta pelacakan penggunaan promo code.
            </p>
        </div>

        <div class="flex items-center space-x-3">
            <a href="<?php echo base_url('admin/orders/export_csv'); ?>" class="bg-white hover:bg-slate-50 text-slate-800 border border-slate-300 px-4 py-2.5 rounded-xl text-xs font-bold shadow-sm transition-all flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>[ Ekspor Laporan Penjualan ]</span>
            </a>
        </div>
    </div>

    <!-- 1. KPI SUMMARY STATS (Exact 4 Cards as per PDF Page 63) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- TOTAL ORDERS -->
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">TOTAL ORDERS</span>
                <div class="text-2xl font-black text-slate-900"><?php echo isset($kpi['total_orders']) ? $kpi['total_orders'] : count($orders); ?> <span class="text-xs font-normal text-slate-500">Pesanan Masuk</span></div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-base">
                📦
            </div>
        </div>

        <!-- PAYMENT PENDING -->
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">PAYMENT PENDING</span>
                <div class="text-2xl font-black text-amber-500"><?php echo isset($kpi['payment_pending']) ? $kpi['payment_pending'] : 0; ?> <span class="text-xs font-normal text-slate-500">Transaksi (VA/QRIS)</span></div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-base">
                ⏳
            </div>
        </div>

        <!-- READY TO SHIP -->
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">READY TO SHIP</span>
                <div class="text-2xl font-black text-indigo-600"><?php echo isset($kpi['ready_to_ship']) ? $kpi['ready_to_ship'] : 0; ?> <span class="text-xs font-normal text-slate-500">Siap Kirim</span></div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-base">
                🚚
            </div>
        </div>

        <!-- COMPLETED ORDERS -->
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">COMPLETED ORDERS</span>
                <div class="text-2xl font-black text-emerald-600"><?php echo isset($kpi['completed_orders']) ? $kpi['completed_orders'] : 0; ?> <span class="text-xs font-normal text-slate-500">Sukses Kirim</span></div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-base">
                ✅
            </div>
        </div>
    </div>

    <!-- 2. FILTER TOOLBAR & SEARCH BAR (PDF Page 64) -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-3">
        <form method="GET" action="<?php echo base_url('admin/orders'); ?>" class="grid grid-cols-1 sm:grid-cols-12 gap-3 text-xs">
            <!-- Search Order -->
            <div class="sm:col-span-5">
                <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Pencarian Global (Search Order)</label>
                <input type="text" name="search" value="<?php echo htmlspecialchars($filters['search'] ?: ''); ?>" placeholder="Cari Nomor Invoice (Order ID), Nama Penerima, atau HP..." class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-1 focus:ring-[#E5252A] focus:outline-none font-medium">
            </div>

            <!-- Status Filter -->
            <div class="sm:col-span-3">
                <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Status Transaksi</label>
                <select name="status" class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-1 focus:ring-[#E5252A] focus:outline-none bg-white font-medium">
                    <option value="">Semua Status Transaksi</option>
                    <option value="Pending" <?php echo ($filters['status'] === 'Pending') ? 'selected' : ''; ?>>Menunggu Pembayaran (Pending)</option>
                    <option value="Paid" <?php echo ($filters['status'] === 'Paid') ? 'selected' : ''; ?>>Dibayar (Paid)</option>
                    <option value="Processing" <?php echo ($filters['status'] === 'Processing') ? 'selected' : ''; ?>>Sedang Dikemas (Processing)</option>
                    <option value="Shipped" <?php echo ($filters['status'] === 'Shipped') ? 'selected' : ''; ?>>Dalam Pengiriman (Shipped)</option>
                    <option value="Delivered" <?php echo ($filters['status'] === 'Delivered') ? 'selected' : ''; ?>>Selesai (Delivered/Completed)</option>
                    <option value="Cancelled" <?php echo ($filters['status'] === 'Cancelled') ? 'selected' : ''; ?>>Dibatalkan (Cancelled)</option>
                </select>
            </div>

            <!-- Payment Method Filter (Non-COD) -->
            <div class="sm:col-span-2">
                <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Metode Bayar (Digital)</label>
                <select name="payment_method" class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-1 focus:ring-[#E5252A] focus:outline-none bg-white font-medium">
                    <option value="">Semua Metode</option>
                    <option value="Virtual Account" <?php echo (isset($filters['payment_method']) && strpos($filters['payment_method'], 'Virtual Account') !== false) ? 'selected' : ''; ?>>Virtual Account (VA)</option>
                    <option value="Credit Card" <?php echo (isset($filters['payment_method']) && strpos($filters['payment_method'], 'Credit Card') !== false) ? 'selected' : ''; ?>>Credit Card</option>
                    <option value="QRIS" <?php echo (isset($filters['payment_method']) && strpos($filters['payment_method'], 'QRIS') !== false) ? 'selected' : ''; ?>>QRIS (GoPay/OVO/Dana)</option>
                </select>
            </div>

            <div class="sm:col-span-2 flex items-end space-x-2">
                <button type="submit" class="w-full bg-[#1E2229] hover:bg-[#2D333D] text-white font-bold py-2.5 rounded-lg shadow transition-colors">
                    Filter
                </button>
                <a href="<?php echo base_url('admin/orders'); ?>" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-3 py-2.5 rounded-lg transition-colors">
                    Reset
                </a>
            </div>
        </form>

        <!-- Bulk Actions Bar (PDF Page 64) -->
        <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs">
            <div class="flex items-center space-x-2">
                <span class="text-slate-500 font-medium">Tindakan Massal:</span>
                <select id="bulk-status-select" class="p-1.5 border border-slate-300 rounded-lg bg-white font-bold text-slate-800 focus:outline-none focus:ring-1 focus:ring-[#E5252A]">
                    <option value="">-- Pilih Status Baru --</option>
                    <option value="Processing">Ubah ke Processing</option>
                    <option value="Shipped">Ubah ke Shipped</option>
                    <option value="Delivered">Ubah ke Delivered (Selesai)</option>
                    <option value="Cancelled">Ubah ke Cancelled (Restitusi Stok)</option>
                </select>
                <button type="button" onclick="executeBulkStatusUpdate()" class="bg-[#E5252A] hover:bg-[#c41c21] text-white px-3 py-1.5 rounded-lg font-bold shadow-sm transition-colors">
                    [ Batch Update Status ]
                </button>
            </div>

            <div class="flex items-center space-x-2">
                <button type="button" onclick="printBulkSelectedLabels()" class="bg-slate-800 hover:bg-slate-900 text-white px-3 py-1.5 rounded-lg font-bold shadow-sm transition-colors flex items-center space-x-1">
                    <span>🖨️ [ Cetak Label Resi Massal ]</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 3. ORDERS TABLE (Order Master Table - PDF Page 65) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="p-3.5 text-center w-10">
                            <input type="checkbox" id="check-all-orders" onchange="toggleSelectAllOrders(this)" class="rounded text-[#E5252A] focus:ring-[#E5252A]">
                        </th>
                        <th class="p-3.5">No. Invoice & Waktu</th>
                        <th class="p-3.5">Nama Penerima & No. HP</th>
                        <th class="p-3.5">Detail Produk & Ukuran</th>
                        <th class="p-3.5 text-right">Total Tagihan</th>
                        <th class="p-3.5">Metode Bayar</th>
                        <th class="p-3.5 text-center">Kode Promo</th>
                        <th class="p-3.5 text-center">Status Pesanan</th>
                        <th class="p-3.5 text-center">Aksi Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $o): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <!-- Checkbox -->
                                <td class="p-3.5 text-center">
                                    <input type="checkbox" name="order_select[]" value="<?php echo $o->id; ?>" class="order-checkbox rounded text-[#E5252A] focus:ring-[#E5252A]">
                                </td>

                                <!-- Invoice & Date -->
                                <td class="p-3.5 space-y-0.5">
                                    <strong class="font-bold text-slate-900 block font-mono"><?php echo htmlspecialchars($o->invoice_number); ?></strong>
                                    <span class="text-[11px] text-slate-400"><?php echo date('d/m/Y H:i', strtotime($o->created_at)); ?></span>
                                </td>

                                <!-- Recipient & Phone -->
                                <td class="p-3.5 space-y-0.5">
                                    <strong class="text-slate-800 block"><?php echo htmlspecialchars($o->recipient_name); ?></strong>
                                    <span class="text-slate-500 font-mono text-[11px]"><?php echo htmlspecialchars($o->recipient_phone); ?></span>
                                </td>

                                <!-- Product Details & Size -->
                                <td class="p-3.5 space-y-1 max-w-xs">
                                    <?php if (!empty($o->items)): ?>
                                        <?php 
                                            $first = $o->items[0]; 
                                            $item_count = count($o->items);
                                        ?>
                                        <div class="text-slate-800 font-bold truncate">
                                            <?php echo htmlspecialchars($first->product_name); ?> (EU <?php echo htmlspecialchars($first->size_eu); ?>) x <?php echo $first->quantity; ?>
                                        </div>
                                        <?php if ($item_count > 1): ?>
                                            <span class="text-[10px] text-slate-400 font-bold block">+<?php echo ($item_count - 1); ?> produk lainnya</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-slate-400 italic">Item data</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Total Amount -->
                                <td class="p-3.5 text-right font-black text-slate-900 whitespace-nowrap">
                                    Rp <?php echo number_format($o->total_amount, 0, ',', '.'); ?>
                                </td>

                                <!-- Payment Method -->
                                <td class="p-3.5">
                                    <span class="inline-block bg-blue-50 text-blue-700 px-2 py-0.5 rounded font-bold text-[10px]">
                                        <?php echo htmlspecialchars($o->payment_method); ?>
                                    </span>
                                </td>

                                <!-- Promo Code -->
                                <td class="p-3.5 text-center">
                                    <?php if (!empty($o->promo_code)): ?>
                                        <span class="inline-block bg-purple-50 text-purple-700 border border-purple-200 px-2 py-0.5 rounded font-mono font-bold text-[10px]">
                                            <?php echo htmlspecialchars($o->promo_code); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-slate-400 text-[10px]">-</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Status Badge -->
                                <td class="p-3.5 text-center whitespace-nowrap">
                                    <span class="inline-block text-[10px] font-black uppercase px-2.5 py-1 rounded-full <?php 
                                        switch ($o->order_status) {
                                            case 'Paid': echo 'bg-emerald-100 text-emerald-800'; break;
                                            case 'Processing': echo 'bg-amber-100 text-amber-800'; break;
                                            case 'Shipped': echo 'bg-blue-100 text-blue-800'; break;
                                            case 'Delivered': echo 'bg-purple-100 text-purple-800'; break;
                                            case 'Cancelled': echo 'bg-red-100 text-red-800'; break;
                                            default: echo 'bg-slate-100 text-slate-700'; break;
                                        }
                                    ?>">
                                        <?php echo htmlspecialchars($o->order_status); ?>
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="p-3.5 text-center space-y-1 whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-1.5">
                                        <!-- [Detail] Drawer Trigger (PDF Page 66) -->
                                        <button type="button" 
                                                class="bg-[#1E2229] hover:bg-[#2D333D] text-white px-2.5 py-1 rounded-md text-[11px] font-bold transition-colors shadow-sm"
                                                onclick="openOrderDetailDrawer(<?php echo $o->id; ?>)">
                                            [Detail]
                                        </button>

                                        <!-- Update Status Trigger -->
                                        <button type="button" 
                                                class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-2.5 py-1 rounded-md text-[11px] font-bold transition-colors" 
                                                onclick='openStatusModal(<?php echo $o->id; ?>, "<?php echo $o->invoice_number; ?>", "<?php echo $o->order_status; ?>", "<?php echo $o->tracking_number; ?>")'>
                                            [Proses]
                                        </button>

                                        <!-- Thermal Label Print -->
                                        <a href="<?php echo base_url('admin/shipping-label/' . $o->id); ?>" target="_blank" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 px-2 py-1 rounded-md text-[11px] font-bold shadow-sm transition-colors flex items-center space-x-1" title="Cetak Resi Thermal 100x150 mm">
                                            <span>Label</span>
                                        </a>
                                    </div>
                                    <?php if (!empty($o->tracking_number)): ?>
                                        <div class="text-[10px] font-mono text-slate-400 truncate max-w-[120px] mx-auto">
                                            <?php echo htmlspecialchars($o->tracking_number); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="9" class="p-8 text-center text-slate-400">Tidak ada data pesanan ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="p-4 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
                <span>Halaman <?php echo $current_page; ?> dari <?php echo $total_pages; ?> (Total <?php echo $total_orders; ?> Pesanan)</span>
                <div class="flex items-center space-x-1">
                    <?php if ($current_page > 1): ?>
                        <a href="<?php $params = $_GET; $params['p'] = $current_page - 1; echo current_url() . '?' . http_build_query($params); ?>" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded font-bold text-slate-700">Prev</a>
                    <?php endif; ?>
                    <span class="px-3 py-1.5 bg-[#E5252A] text-white rounded font-bold"><?php echo $current_page; ?></span>
                    <?php if ($current_page < $total_pages): ?>
                        <a href="<?php $params = $_GET; $params['p'] = $current_page + 1; echo current_url() . '?' . http_build_query($params); ?>" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded font-bold text-slate-700">Next</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- =========================================================================
     4-BLOCK ORDER DETAIL DRAWER (PDF Pages 66-67)
     Blok 1: Shipping Details & Thermal Label Button
     Blok 2: Payment Verification (Non-COD, VA/CC/QRIS, Billing Address)
     Blok 3: Product Itemization & Physical Stock Deduction
     Blok 4: Financial Breakdown & Promo Code Audit
     ========================================================================= -->
<div id="order-detail-drawer" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex justify-end transition-opacity">
    <div class="bg-white w-full max-w-2xl h-full shadow-2xl flex flex-col overflow-hidden animate-slide-left">
        <!-- Drawer Header -->
        <div class="p-5 bg-slate-900 text-white flex items-center justify-between border-b border-slate-800">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                    <h3 id="drawer-invoice-title" class="text-sm font-black uppercase tracking-wider font-mono">Invoice: #SN-2026-001</h3>
                </div>
                <p id="drawer-order-date" class="text-[11px] text-slate-400 mt-0.5">Waktu Transaksi: 14/10/2026 10:15</p>
            </div>
            <button type="button" onclick="closeOrderDetailDrawer()" class="text-slate-400 hover:text-white font-black text-2xl px-2">&times;</button>
        </div>

        <!-- Drawer Content (Scrollable 4 Blocks) -->
        <div id="drawer-body" class="p-6 space-y-6 overflow-y-auto text-xs flex-grow">
            <!-- Loading indicator -->
            <div id="drawer-loading" class="text-center py-12 text-slate-400">
                <span class="inline-block animate-spin mr-2">⏳</span> Memuat rincian pesanan...
            </div>

            <div id="drawer-content-container" class="space-y-6 hidden">
                <!-- BLOK 1: VERIFIKASI DATA PENGIRIMAN (Shipping Details) -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                        <h4 class="font-black text-slate-900 uppercase text-xs flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <span>Blok 1: Verifikasi Data Pengiriman (Shipping Details)</span>
                        </h4>
                        <a id="drawer-btn-label" href="#" target="_blank" class="bg-[#E5252A] hover:bg-[#c41c21] text-white px-3 py-1 rounded-lg font-bold text-[11px] shadow transition-colors flex items-center space-x-1">
                            <span>[ Cetak Shipping Label ]</span>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-slate-700">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Penerima & Kontak</span>
                            <strong id="drawer-recipient-name" class="text-slate-900 block text-sm">Nabila Putri</strong>
                            <span id="drawer-recipient-phone" class="font-mono text-slate-600 block">085711942921</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Kurir Logistik Simulasi</span>
                            <strong id="drawer-courier" class="text-slate-900 block">Regular Courier (2-3 hari)</strong>
                            <span id="drawer-city" class="text-slate-600 block font-semibold">Kota Bekasi, Jawa Barat</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Alamat Lengkap Pengiriman</span>
                            <p id="drawer-address" class="text-slate-800 font-medium">Perum Rancamanyar Blok C No 13 RT 006 RW 007, Kec. Bekasi Selatan, Kota Bekasi 17148</p>
                        </div>
                    </div>
                </div>

                <!-- BLOK 2: INFORMASI PEMBAYARAN (Payment Verification) -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                        <h4 class="font-black text-slate-900 uppercase text-xs flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>Blok 2: Informasi Pembayaran (Payment Verification)</span>
                        </h4>
                        <span id="drawer-payment-badge" class="bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase px-2 py-0.5 rounded-full">
                            Lunas (Settled)
                        </span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-slate-700">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Kanal Pembayaran Digital (Non-COD)</span>
                            <strong id="drawer-payment-channel" class="text-slate-900 block text-sm">QRIS (Gopay/OVO/Dana)</strong>
                            <span class="text-[10px] text-emerald-600 font-bold">✔ Verifikasi Otomatis Terkonfirmasi</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Konfirmasi Alamat Penagihan</span>
                            <span class="inline-flex items-center space-x-1 text-slate-800 font-bold text-xs">
                                <span class="text-emerald-600">✔</span>
                                <span>Billing address same as shipping</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- BLOK 3: RINCIAN PRODUK FISIK (Product Itemization) -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                        <h4 class="font-black text-slate-900 uppercase text-xs flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#E5252A]"></span>
                            <span>Blok 3: Rincian Produk Fisik (Product Itemization)</span>
                        </h4>
                        <span class="text-[10px] text-slate-500 font-bold">100% Footwear Verified</span>
                    </div>
                    
                    <div id="drawer-items-list" class="space-y-3">
                        <!-- Items dynamically injected here -->
                    </div>

                    <div class="pt-2 border-t border-slate-200 flex items-center justify-between text-[11px] text-slate-600">
                        <span class="flex items-center space-x-1 text-emerald-700 font-bold">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Status Pengurangan Kuota: Kuota stok fisik telah tereduksi otomatis di database</span>
                        </span>
                    </div>
                </div>

                <!-- BLOK 4: AUDIT FINANSIAL & KUPON DISKON (Financial Breakdown) -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                        <h4 class="font-black text-slate-900 uppercase text-xs flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                            <span>Blok 4: Audit Finansial & Kupon Diskon (Financial Breakdown)</span>
                        </h4>
                        <span id="drawer-promo-badge" class="bg-purple-100 text-purple-800 px-2 py-0.5 rounded font-mono font-bold text-[10px]">
                            VOUCHER: NEXUS50
                        </span>
                    </div>

                    <div class="space-y-1.5 text-xs text-slate-700">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Subtotal Barang:</span>
                            <span id="drawer-subtotal" class="font-bold text-slate-800">Rp 499.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Biaya Ongkos Kirim (Shipping Fee):</span>
                            <span id="drawer-shipping" class="font-bold text-slate-800">Rp 0 (Free Shipping)</span>
                        </div>
                        <div class="flex justify-between text-emerald-600 font-bold">
                            <span>Voucher / Promo Code Discount:</span>
                            <span id="drawer-discount">- Rp 50.000</span>
                        </div>
                        <div class="border-t border-slate-200 pt-2 flex justify-between text-sm font-black text-slate-900">
                            <span>Total Akhir Tagihan:</span>
                            <span id="drawer-total" class="text-[#E5252A]">Rp 449.000</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Drawer Footer -->
        <div class="p-4 bg-slate-100 border-t border-slate-200 flex items-center justify-between">
            <button type="button" onclick="closeOrderDetailDrawer()" class="bg-slate-200 hover:bg-slate-300 text-slate-800 px-4 py-2 rounded-xl font-bold text-xs transition-colors">
                Tutup Drawer
            </button>
            <button type="button" id="drawer-action-process" class="bg-[#E5252A] hover:bg-[#c41c21] text-white px-5 py-2 rounded-xl font-bold text-xs shadow transition-colors">
                Update Status Pesanan Ini
            </button>
        </div>
    </div>
</div>

<!-- Order Status & Tracking Modal -->
<div id="status-update-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between pb-2 border-b border-slate-200">
            <h4 class="font-black text-slate-900 uppercase text-xs">Update Status Pesanan</h4>
            <button type="button" onclick="closeStatusModal()" class="text-slate-400 hover:text-slate-700 font-black text-lg">&times;</button>
        </div>

        <p id="modal-invoice-label" class="text-xs font-bold text-slate-800">#SN-2026-001</p>

        <form id="form-order-status" class="space-y-4 text-xs">
            <input type="hidden" id="modal-order-id" name="order_id">

            <div class="space-y-1">
                <label for="modal-order-status" class="font-bold text-slate-700 block">Status Baru *</label>
                <select id="modal-order-status" name="order_status" class="w-full p-2.5 border border-slate-300 rounded-lg font-bold bg-white focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                    <option value="Paid">Paid (Lunas)</option>
                    <option value="Processing">Processing (Sedang Disiapkan)</option>
                    <option value="Shipped">Shipped (Dalam Pengiriman)</option>
                    <option value="Delivered">Delivered (Tiba di Tujuan)</option>
                    <option value="Cancelled">Cancelled (Dibatalkan & Restitusi Stok)</option>
                </select>
            </div>

            <div class="space-y-1">
                <label for="modal-tracking-number" class="font-bold text-slate-700 block">Nomor Resi Pengiriman *</label>
                <input type="text" id="modal-tracking-number" name="tracking_number" required class="w-full p-2.5 border border-slate-300 rounded-lg font-mono font-bold focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
            </div>

            <div class="flex items-center space-x-2 pt-2">
                <button type="button" onclick="closeStatusModal()" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 rounded-lg">Batal</button>
                <button type="submit" class="w-1/2 bg-[#E5252A] hover:bg-[#c41c21] text-white font-bold py-2.5 rounded-lg shadow">Perbarui</button>
            </div>
        </form>
    </div>
</div>

<script>
// --- Checkbox and Bulk Actions ---
function toggleSelectAllOrders(master) {
    const boxes = document.querySelectorAll('.order-checkbox');
    boxes.forEach(b => b.checked = master.checked);
}

function getSelectedOrderIds() {
    const checked = document.querySelectorAll('.order-checkbox:checked');
    return Array.from(checked).map(c => c.value);
}

function executeBulkStatusUpdate() {
    const selected = getSelectedOrderIds();
    const newStatus = document.getElementById('bulk-status-select').value;

    if (selected.length === 0) {
        alert('Silakan pilih minimal satu pesanan dengan mencentang kotak di tabel.');
        return;
    }
    if (!newStatus) {
        alert('Silakan pilih status baru terlebih dahulu.');
        return;
    }

    if (!confirm(`Yakin ingin memperbarui ${selected.length} pesanan ke status "${newStatus}"?`)) {
        return;
    }

    const formData = new FormData();
    selected.forEach(id => formData.append('order_ids[]', id));
    formData.append('order_status', newStatus);

    fetch('<?php echo base_url("admin/orders/batch_update_status"); ?>', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            window.location.reload();
        } else {
            alert(data.message || 'Gagal memproses batch update.');
        }
    });
}

function printBulkSelectedLabels() {
    const selected = getSelectedOrderIds();
    if (selected.length === 0) {
        alert('Pilih minimal satu pesanan untuk dicetak label resinya.');
        return;
    }
    // Open labels
    selected.forEach(id => {
        window.open('<?php echo base_url("admin/shipping-label/"); ?>' + id, '_blank');
    });
}

// --- Order Status Modal ---
function openStatusModal(orderId, invoice, status, tracking) {
    document.getElementById('modal-order-id').value = orderId;
    document.getElementById('modal-invoice-label').textContent = 'Invoice: ' + invoice;
    document.getElementById('modal-order-status').value = status;
    document.getElementById('modal-tracking-number').value = tracking || '';
    document.getElementById('status-update-modal').classList.remove('hidden');
}
function closeStatusModal() {
    document.getElementById('status-update-modal').classList.add('hidden');
}

// --- 4-Block Order Detail Drawer ---
let activeDrawerOrderId = null;

function openOrderDetailDrawer(orderId) {
    activeDrawerOrderId = orderId;
    const drawer = document.getElementById('order-detail-drawer');
    const loading = document.getElementById('drawer-loading');
    const container = document.getElementById('drawer-content-container');

    drawer.classList.remove('hidden');
    loading.classList.remove('hidden');
    container.classList.add('hidden');

    fetch('<?php echo base_url("admin/orders/detail_json/"); ?>' + orderId, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(res => {
        if (res.status === 'success') {
            const o = res.data;
            document.getElementById('drawer-invoice-title').textContent = 'Invoice: ' + o.invoice_number;
            document.getElementById('drawer-order-date').textContent = 'Waktu Transaksi: ' + o.created_at;

            // Blok 1: Shipping
            document.getElementById('drawer-recipient-name').textContent = o.recipient_name;
            document.getElementById('drawer-recipient-phone').textContent = o.recipient_phone;
            document.getElementById('drawer-courier').textContent = o.shipping_courier || 'Regular Courier';
            document.getElementById('drawer-city').textContent = (o.city || 'Bekasi') + ' • ' + (o.postal_code || '');
            document.getElementById('drawer-address').textContent = o.shipping_address;
            document.getElementById('drawer-btn-label').href = '<?php echo base_url("admin/shipping-label/"); ?>' + o.id;

            // Blok 2: Payment
            document.getElementById('drawer-payment-channel').textContent = o.payment_method;
            const payBadge = document.getElementById('drawer-payment-badge');
            payBadge.textContent = o.order_status === 'Paid' || o.order_status === 'Shipped' || o.order_status === 'Delivered' ? 'LUNAS (SETTLED)' : o.order_status.toUpperCase();

            // Blok 3: Products
            const itemsList = document.getElementById('drawer-items-list');
            itemsList.innerHTML = '';
            if (o.items && o.items.length > 0) {
                o.items.forEach(it => {
                    const itemRow = document.createElement('div');
                    itemRow.className = 'flex items-center space-x-3 p-2 bg-white rounded-lg border border-slate-200';
                    itemRow.innerHTML = `
                        <img src="${it.thumbnail || '<?php echo base_url("assets/images/placeholder-shoe.png"); ?>'}" class="w-12 h-12 rounded object-cover border border-slate-100 flex-shrink-0" alt="${it.product_name}">
                        <div class="flex-grow">
                            <div class="font-bold text-slate-900 text-xs">${it.product_name}</div>
                            <div class="text-[11px] text-slate-500 font-mono">SKU: ${it.sku_code || '-'} • Warna: ${it.color || '-'}</div>
                            <div class="text-[11px] font-bold text-slate-800">Ukuran: EU ${it.size_eu} • Qty: ${it.quantity} pasang</div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <div class="font-bold text-slate-900">Rp ${Number(it.unit_price).toLocaleString('id-ID')}</div>
                            <div class="text-[10px] text-slate-400">Total: Rp ${Number(it.subtotal).toLocaleString('id-ID')}</div>
                        </div>
                    `;
                    itemsList.appendChild(itemRow);
                });
            }

            // Blok 4: Financial Breakdown
            document.getElementById('drawer-subtotal').textContent = 'Rp ' + Number(o.subtotal).toLocaleString('id-ID');
            document.getElementById('drawer-shipping').textContent = 'Rp ' + Number(o.shipping_fee).toLocaleString('id-ID') + (o.shipping_fee == 0 ? ' (Free Shipping)' : '');
            document.getElementById('drawer-discount').textContent = '- Rp ' + Number(o.discount_amount).toLocaleString('id-ID');
            document.getElementById('drawer-total').textContent = 'Rp ' + Number(o.total_amount).toLocaleString('id-ID');
            
            const promoBadge = document.getElementById('drawer-promo-badge');
            if (o.promo_code) {
                promoBadge.textContent = 'VOUCHER: ' + o.promo_code;
                promoBadge.classList.remove('hidden');
            } else {
                promoBadge.textContent = 'NO VOUCHER';
            }

            // Button Action in Footer
            document.getElementById('drawer-action-process').onclick = () => {
                closeOrderDetailDrawer();
                openStatusModal(o.id, o.invoice_number, o.order_status, o.tracking_number);
            };

            loading.classList.add('hidden');
            container.classList.remove('hidden');
        } else {
            alert('Gagal mengambil data rincian pesanan.');
            closeOrderDetailDrawer();
        }
    })
    .catch(err => {
        alert('Terjadi kesalahan memuat data.');
        closeOrderDetailDrawer();
    });
}

function closeOrderDetailDrawer() {
    document.getElementById('order-detail-drawer').classList.add('hidden');
}

// Status update submit
document.addEventListener('DOMContentLoaded', function () {
    const statusForm = document.getElementById('form-order-status');
    if (statusForm) {
        statusForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const orderId = document.getElementById('modal-order-id').value;
            const status = document.getElementById('modal-order-status').value;
            const tracking = document.getElementById('modal-tracking-number').value;

            const formData = new FormData();
            formData.append('order_id', orderId);
            formData.append('order_status', status);
            formData.append('tracking_number', tracking);

            fetch('<?php echo base_url("admin/orders/update_status"); ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                closeStatusModal();
                if (data.status === 'success') {
                    window.location.reload();
                } else {
                    alert(data.message || 'Gagal memperbarui status');
                }
            });
        });
    }
});
</script>

