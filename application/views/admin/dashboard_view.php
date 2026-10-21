<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - ADMIN ANALYTICS DASHBOARD
     KPI Cards, Quota Tracking, Stock Depletion Audit & Live Orders Stream
     ========================================================================= -->

<div class="space-y-8">

    <!-- Page Header & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-200 gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="w-3 h-3 rounded-full bg-[#E5252A]"></span>
                <span class="text-xs font-black uppercase text-slate-400 tracking-wider">Internal Operations</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900 mt-0.5">
                Dashboard Analitik & Inventaris
            </h1>
            <p class="text-xs text-slate-500">
                Pemantauan real-time kuota fisik 1.443 pasang sepatu dan arus pesanan non-tunai.
            </p>
        </div>

        <div class="flex items-center space-x-3">
            <a href="<?php echo base_url('admin/orders'); ?>" class="bg-white hover:bg-slate-50 text-slate-800 border border-slate-300 px-4 py-2 rounded-xl text-xs font-bold shadow-sm transition-all flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span>Kelola Pesanan</span>
            </a>
            <a href="<?php echo base_url('admin/inventory'); ?>" class="bg-[#E5252A] hover:bg-[#c41c21] text-white px-4 py-2 rounded-xl text-xs font-bold shadow-lg hover:shadow-red-500/25 transition-all flex items-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                <span>Master Stok Sepatu</span>
            </a>
        </div>
    </div>

    <!-- 1. TOP KPI METRICS (4 CARDS) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Footwear Models -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Model Sepatu</span>
                <div class="text-2xl font-black text-slate-900"><?php echo number_format($total_products, 0, ',', '.'); ?> SKU</div>
                <div class="text-[11px] text-emerald-600 font-semibold flex items-center space-x-1">
                    <span>✔ 100% Terpublikasi</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-50 text-[#E5252A] flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
        </div>

        <!-- Card 2: Low Stock Warning -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Stok Kritis (&le; 5 Pasang)</span>
                <div class="text-2xl font-black text-amber-500"><?php echo $low_stock_count; ?> Varian</div>
                <div class="text-[11px] text-slate-500">
                    <a href="<?php echo base_url('admin/inventory?status=menipis'); ?>" class="text-[#E5252A] hover:underline font-bold">Audit Stok Menipis &raquo;</a>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>

        <!-- Card 3: Total Orders -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pesanan Masuk</span>
                <div class="text-2xl font-black text-slate-900"><?php echo isset($order_kpis['total_orders']) ? $order_kpis['total_orders'] : 0; ?> Pesanan</div>
                <div class="text-[11px] text-slate-500">Digital Settlement Non-Cash</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
        </div>

        <!-- Card 4: Total Revenue -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Omzet Transaksi</span>
                <div class="text-2xl font-black text-[#E5252A]">
                    Rp <?php echo isset($order_kpis['total_revenue']) ? number_format($order_kpis['total_revenue'], 0, ',', '.') : '0'; ?>
                </div>
                <div class="text-[11px] text-emerald-600 font-semibold">Tercatat di Sistem Keuangan</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <!-- 2. BRAND DISTRIBUTION QUOTA BOARD -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Distribusi Kuota Brand Footwear Resmi</h3>
                <p class="text-xs text-slate-500">6 Brand Resmi Terkurasi (1.543 Model / 1.443 Kuota Fisik)</p>
            </div>
            <a href="<?php echo base_url('admin/inventory'); ?>" class="text-xs font-bold text-[#E5252A] hover:underline">Lihat Detail Inventaris &raquo;</a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <?php 
            $quotas = array(
                'Diadora' => array('target' => 500, 'color' => 'bg-red-500'),
                'New Balance' => array('target' => 200, 'color' => 'bg-blue-600'),
                'Airwalk' => array('target' => 400, 'color' => 'bg-slate-700'),
                'Converse' => array('target' => 240, 'color' => 'bg-amber-600'),
                'Nike' => array('target' => 121, 'color' => 'bg-emerald-600'),
                'Puma' => array('target' => 82, 'color' => 'bg-indigo-600')
            );
            foreach ($quotas as $bname => $qinfo): 
                // calculate current count from brand_stats
                $bcount = 0;
                if (!empty($brand_stats)) {
                    foreach ($brand_stats as $bs) {
                        if (stripos($bs->brand_name, $bname) !== false) {
                            $bcount += (int)$bs->count;
                        }
                    }
                }
                $pct = min(100, round(($bcount / $qinfo['target']) * 100));
            ?>
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <strong class="font-black text-slate-900"><?php echo $bname; ?></strong>
                        <span class="text-slate-500 font-bold"><?php echo $bcount; ?></span>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-1.5 overflow-hidden">
                        <div class="<?php echo $qinfo['color']; ?> h-1.5 rounded-full" style="width: <?php echo $pct; ?>%;"></div>
                    </div>
                    <div class="flex items-center justify-between text-[10px] text-slate-400">
                        <span>Target: <?php echo $qinfo['target']; ?></span>
                        <span class="font-bold text-slate-700"><?php echo $pct; ?>%</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- 3. TWO-COLUMN OPERATIONAL STREAM: RECENT ORDERS & LOW STOCK -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Left: Arus Pesanan Terbaru (Col 7) -->
        <div class="lg:col-span-7 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Arus Pesanan Terbaru (Real-Time)</h3>
                </div>
                <a href="<?php echo base_url('admin/orders'); ?>" class="text-xs font-bold text-[#E5252A] hover:underline">Semua Pesanan &raquo;</a>
            </div>

            <?php if (!empty($recent_orders)): ?>
                <div class="divide-y divide-slate-100 text-xs">
                    <?php foreach ($recent_orders as $ord): ?>
                        <div class="py-3.5 flex items-center justify-between">
                            <div class="space-y-1">
                                <div class="flex items-center space-x-2">
                                    <strong class="font-bold text-slate-900 text-sm"><?php echo htmlspecialchars($ord->invoice_number); ?></strong>
                                    <span class="bg-emerald-100 text-emerald-800 font-black px-2 py-0.5 rounded text-[10px]">
                                        <?php echo htmlspecialchars($ord->order_status); ?>
                                    </span>
                                </div>
                                <div class="text-slate-500">
                                    <span><?php echo htmlspecialchars($ord->recipient_name); ?></span>
                                    <span>•</span>
                                    <span><?php echo htmlspecialchars($ord->city); ?></span>
                                    <span>•</span>
                                    <span><?php echo htmlspecialchars($ord->payment_method); ?></span>
                                </div>
                            </div>

                            <div class="text-right space-y-1">
                                <span class="font-black text-sm text-slate-900 block">
                                    Rp <?php echo number_format($ord->total_amount, 0, ',', '.'); ?>
                                </span>
                                <a href="<?php echo base_url('admin/shipping-label/' . $ord->id); ?>" target="_blank" class="text-[11px] font-bold text-[#E5252A] hover:underline">
                                    Cetak Thermal Label &raquo;
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-8 text-center text-xs text-slate-400">Belum ada transaksi pesanan yang masuk.</div>
            <?php endif; ?>
        </div>

        <!-- Right: Stok Kritis Audit Alert (Col 5) -->
        <div class="lg:col-span-5 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                    <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Audit Stok Menipis</h3>
                </div>
                <span class="text-xs text-amber-600 font-bold">Stok &le; 5</span>
            </div>

            <?php if (!empty($low_stock_items)): ?>
                <div class="divide-y divide-slate-100 text-xs">
                    <?php foreach ($low_stock_items as $lsi): ?>
                        <div class="py-3 flex items-center justify-between">
                            <div class="space-y-0.5 max-w-[240px]">
                                <span class="text-[10px] font-bold uppercase text-slate-400"><?php echo htmlspecialchars($lsi->brand_name); ?></span>
                                <strong class="font-bold text-slate-800 block truncate"><?php echo htmlspecialchars($lsi->name); ?></strong>
                                <span class="text-slate-500">Ukuran EUR <?php echo htmlspecialchars($lsi->size_eu); ?></span>
                            </div>

                            <div class="text-right">
                                <span class="inline-block bg-amber-100 text-amber-800 font-black px-2.5 py-1 rounded text-xs">
                                    Sisa <?php echo $lsi->stock_qty; ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-8 text-center text-xs text-slate-400">Seluruh stok inventaris berada di atas batas aman.</div>
            <?php endif; ?>
        </div>

    </div>

</div>
