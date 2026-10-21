<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - REPORTS & AUDIT (LAPORAN & AUDIT SISTEM)
     Rekap penjualan bulanan, perputaran stok per gerai (Bekasi & Karawang)
     ========================================================================= -->

<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-200 gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                <span class="text-xs font-black uppercase text-slate-400 tracking-wider">Business Intelligence</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900 mt-0.5">
                Laporan & Audit Operasional
            </h1>
            <p class="text-xs text-slate-500">
                Rekapitulasi omzet penjualan, perputaran stok gerai (Bekasi & Karawang), serta efektivitas voucher promo.
            </p>
        </div>

        <div class="flex items-center space-x-2">
            <a href="<?php echo base_url('admin/orders/export-csv'); ?>" class="bg-[#1E2229] hover:bg-[#2D333D] text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow transition-all flex items-center space-x-2">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Unduh Laporan Penjualan (CSV)</span>
            </a>
        </div>
    </div>

    <!-- 1. FINANCIAL & ORDER KPIS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Omzet Bersih</span>
                <div class="text-xl sm:text-2xl font-black text-[#E5252A]">
                    Rp <?php echo number_format($total_revenue, 0, ',', '.'); ?>
                </div>
                <span class="text-[11px] text-emerald-600 font-semibold">100% Non-Tunai Digital</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-50 text-[#E5252A] flex items-center justify-center font-bold text-lg">
                💳
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pesanan Masuk</span>
                <div class="text-2xl font-black text-slate-900"><?php echo isset($order_kpis['total_orders']) ? $order_kpis['total_orders'] : 0; ?> Pesanan</div>
                <span class="text-[11px] text-slate-500">Seluruh channel digital</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg">
                📦
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pesanan Siap Kirim</span>
                <div class="text-2xl font-black text-amber-500"><?php echo isset($order_kpis['ready_to_ship']) ? $order_kpis['ready_to_ship'] : 0; ?> Paket</div>
                <span class="text-[11px] text-amber-600 font-semibold">Menunggu Kurir Logistik</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg">
                🚚
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pesanan Selesai</span>
                <div class="text-2xl font-black text-emerald-600"><?php echo isset($order_kpis['completed_orders']) ? $order_kpis['completed_orders'] : 0; ?> Sukses</div>
                <span class="text-[11px] text-emerald-600 font-semibold">Terkonfirmasi Diterima</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">
                ✔
            </div>
        </div>
    </div>

    <!-- 2. DISTRIBUTION PER CITY (BEKASI & KARAWANG) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- City Sales Breakdown -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                    <h3 class="font-black text-sm uppercase text-slate-900 tracking-wider">Distribusi Wilayah Gerai (Bekasi & Karawang)</h3>
                </div>
                <span class="text-xs text-slate-400 font-mono">Area Operasi</span>
            </div>

            <div class="space-y-3">
                <?php if (!empty($city_stats)): ?>
                    <?php foreach ($city_stats as $cs): ?>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                            <div>
                                <strong class="text-sm font-black text-slate-900 block"><?php echo htmlspecialchars($cs->city ?: 'Kota Lain'); ?></strong>
                                <span class="text-xs text-slate-500 font-medium"><?php echo $cs->orders_count; ?> Pesanan Terlayani</span>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-black text-[#E5252A] block">Rp <?php echo number_format($cs->revenue, 0, ',', '.'); ?></span>
                                <span class="text-[10px] text-emerald-600 font-bold">Terverifikasi</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="p-6 text-center text-xs text-slate-400">Belum ada pesanan per wilayah.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Brand Stock Allocation Summary -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                    <h3 class="font-black text-sm uppercase text-slate-900 tracking-wider">Alokasi Stok 6 Brand Mitra Resmi</h3>
                </div>
                <span class="text-xs text-slate-400 font-mono">1.543 Model</span>
            </div>

            <div class="space-y-2 text-xs">
                <?php if (!empty($brand_stock)): ?>
                    <?php foreach ($brand_stock as $bs): ?>
                        <div class="flex items-center justify-between p-2.5 hover:bg-slate-50 rounded-lg border border-slate-100">
                            <span class="font-bold text-slate-800"><?php echo htmlspecialchars($bs->brand_name); ?></span>
                            <div class="flex items-center space-x-3">
                                <span class="font-mono font-bold text-slate-900"><?php echo $bs->models_count; ?> Model SKU</span>
                                <span class="text-[10px] text-emerald-600 font-black bg-emerald-50 px-2 py-0.5 rounded">100% Ready</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
