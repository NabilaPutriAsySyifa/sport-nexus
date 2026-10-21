<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - DIGITAL TRANSACTION INVOICE
     ========================================================================= -->

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">

    <!-- Invoice Header Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-10 space-y-8" id="invoice-card">

        <!-- Top Row: Logo & Status Badge -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-slate-200">
            <div>
                <div class="font-black italic text-2xl tracking-wider text-[#1E2229]">
                    SPORT <span class="text-[#E5252A]">NEXUS</span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Official Footwear Retailer Indonesia</p>
            </div>

            <div class="text-left sm:text-right space-y-1">
                <span class="inline-flex items-center space-x-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-black px-3 py-1 rounded-full">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>PEMBAYARAN LUNAS (PAID)</span>
                </span>
                <div class="text-sm font-black text-slate-900 tracking-wide pt-1">
                    #<?php echo htmlspecialchars(ltrim($order->invoice_number, '#')); ?>
                </div>
                <div class="text-[11px] text-slate-400">
                    <?php echo date('d F Y, H:i', strtotime($order->created_at)); ?> WIB
                </div>
            </div>
        </div>

        <!-- 2. Transaction Information Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-xs border-b border-slate-200 pb-6">
            <!-- Col 1: Destination -->
            <div class="space-y-1.5">
                <span class="text-slate-400 font-bold uppercase tracking-wider block">Penerima & Alamat</span>
                <strong class="text-slate-900 text-sm block"><?php echo htmlspecialchars($order->recipient_name); ?></strong>
                <p class="text-slate-600"><?php echo htmlspecialchars($order->recipient_phone); ?></p>
                <p class="text-slate-600"><?php echo htmlspecialchars($order->shipping_address); ?></p>
                <p class="text-slate-400"><?php echo htmlspecialchars($order->district . ', ' . $order->city . ' ' . $order->postal_code); ?></p>
            </div>

            <!-- Col 2: Courier & Tracking -->
            <div class="space-y-1.5">
                <span class="text-slate-400 font-bold uppercase tracking-wider block">Metode Pengiriman</span>
                <strong class="text-slate-900 text-sm block"><?php echo htmlspecialchars($order->shipping_courier); ?></strong>
                <div class="pt-1">
                    <span class="text-[11px] text-slate-400 block">Nomor Resi Pelacakan:</span>
                    <span class="font-mono font-bold text-xs bg-slate-100 text-slate-800 px-2 py-0.5 rounded border border-slate-200 inline-block mt-0.5">
                        <?php echo htmlspecialchars($order->tracking_number); ?>
                    </span>
                </div>
                <p class="text-[11px] text-emerald-600 font-semibold mt-1">Status: Siap Dikirim dari Hub Bekasi</p>
            </div>

            <!-- Col 3: Digital Payment -->
            <div class="space-y-1.5">
                <span class="text-slate-400 font-bold uppercase tracking-wider block">Kanal Pembayaran</span>
                <strong class="text-slate-900 text-sm block"><?php echo htmlspecialchars($order->payment_method); ?></strong>
                <span class="text-slate-500 block">Digital Non-Cash (Tanpa COD)</span>
                <?php if (!empty($order->promo_code)): ?>
                    <div class="pt-1">
                        <span class="text-[11px] text-slate-400 block">Kupon Promo Terpakai:</span>
                        <span class="font-bold text-[#E5252A] bg-red-50 px-2 py-0.5 rounded text-[11px] inline-block mt-0.5">
                            <?php echo htmlspecialchars($order->promo_code); ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- 3. Purchased Items Table -->
        <div class="space-y-3">
            <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Rincian Produk Footwear</h3>
            <div class="overflow-x-auto border border-slate-200 rounded-xl">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200">
                        <tr>
                            <th class="p-3">Produk</th>
                            <th class="p-3 text-center">Ukuran (EUR)</th>
                            <th class="p-3 text-center">Warna</th>
                            <th class="p-3 text-center">Jumlah</th>
                            <th class="p-3 text-right">Harga Satuan</th>
                            <th class="p-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <?php if (!empty($order->items)): ?>
                            <?php foreach ($order->items as $it): ?>
                                <tr>
                                    <td class="p-3 font-semibold text-slate-900">
                                        <div class="flex items-center space-x-3">
                                            <?php if (!empty($it->thumbnail)): ?>
                                                <img src="<?php echo htmlspecialchars($it->thumbnail); ?>" alt="shoe" class="w-10 h-10 object-contain bg-slate-50 rounded border border-slate-200 p-1 flex-shrink-0">
                                            <?php endif; ?>
                                            <div>
                                                <span class="text-[10px] text-slate-400 uppercase tracking-wider block"><?php echo htmlspecialchars($it->brand_name); ?></span>
                                                <span><?php echo htmlspecialchars($it->product_name); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3 text-center font-bold">EUR <?php echo htmlspecialchars($it->size_eu); ?></td>
                                    <td class="p-3 text-center"><?php echo htmlspecialchars($it->color); ?></td>
                                    <td class="p-3 text-center font-bold"><?php echo $it->quantity; ?></td>
                                    <td class="p-3 text-right">Rp <?php echo number_format($it->unit_price, 0, ',', '.'); ?></td>
                                    <td class="p-3 text-right font-black text-slate-900">Rp <?php echo number_format($it->subtotal, 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 4. Financial Audit Summary -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6 pt-4 border-t border-slate-200">
            <div class="text-xs text-slate-500 space-y-1 max-w-sm">
                <p class="font-bold text-slate-800">Catatan Pengiriman:</p>
                <p>Pesanan telah diverifikasi secara digital dan kuota stok 1.443 pasang telah terpotong pada sistem Sport Nexus. Harap simpan bukti invoice digital ini untuk keperluan klaim garansi.</p>
            </div>

            <div class="w-full sm:w-72 space-y-2 text-xs">
                <div class="flex items-center justify-between text-slate-600">
                    <span>Subtotal:</span>
                    <strong class="text-slate-800">Rp <?php echo number_format($order->subtotal, 0, ',', '.'); ?></strong>
                </div>

                <?php if ($order->discount_amount > 0): ?>
                    <div class="flex items-center justify-between text-emerald-600 font-bold">
                        <span>Potongan Diskon:</span>
                        <span>-Rp <?php echo number_format($order->discount_amount, 0, ',', '.'); ?></span>
                    </div>
                <?php endif; ?>

                <div class="flex items-center justify-between text-slate-600">
                    <span>Biaya Ongkir:</span>
                    <span><?php echo $order->shipping_fee > 0 ? 'Rp ' . number_format($order->shipping_fee, 0, ',', '.') : 'GRATIS'; ?></span>
                </div>

                <div class="pt-2 border-t border-slate-200 flex items-center justify-between">
                    <span class="text-sm font-black text-slate-900">Total Pembayaran:</span>
                    <span class="text-xl font-black text-[#E5252A]">
                        Rp <?php echo number_format($order->total_amount, 0, ',', '.'); ?>
                    </span>
                </div>
            </div>
        </div>

    </div>

    <!-- Actions (Print & Back) -->
    <div class="flex items-center justify-between mt-6">
        <a href="<?php echo base_url('brands.html'); ?>" class="inline-flex items-center space-x-2 text-xs font-bold text-slate-600 hover:text-[#E5252A] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Katalog Sepatu</span>
        </a>

        <button type="button" onclick="window.print()" class="inline-flex items-center space-x-2 bg-[#1E2229] hover:bg-[#2D333D] text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>Cetak Invoice</span>
        </button>
    </div>

</div>

<style>
@media print {
    header, footer, nav, button, a {
        display: none !important;
    }
    #invoice-card {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.location.hash && window.location.hash.startsWith('#SN-')) {
        const cleanInv = window.location.hash.replace('#', '');
        if (cleanInv) {
            window.location.replace('<?php echo base_url("invoice/"); ?>' + cleanInv);
        }
    }
});
</script>
