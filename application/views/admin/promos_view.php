<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - PROMO VOUCHERS & DISCOUNT MANAGEMENT
     ========================================================================= -->

<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-200 gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                <span class="text-xs font-black uppercase text-slate-400 tracking-wider">Promotion & Marketing</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900 mt-0.5">
                Manajemen Promo & Kupon Diskon
            </h1>
            <p class="text-xs text-slate-500">
                Kelola kupon promosi digital non-tunai, pembatasan kuota pakai, dan potongan harga checkout.
            </p>
        </div>

        <button type="button" onclick="openPromoModal()" class="bg-[#E5252A] hover:bg-[#c41c21] text-white px-4 py-2 rounded-xl text-xs font-bold shadow-lg hover:shadow-red-500/25 transition-all flex items-center space-x-1.5 self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span>+ Buat Kupon Baru</span>
        </button>
    </div>

    <!-- 1. KPI SUMMARY CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Kupon Promo</span>
                <div class="text-2xl font-black text-slate-900"><?php echo $total_promos; ?> Kupon</div>
                <span class="text-[11px] text-slate-500">Tersedia di sistem checkout</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-50 text-[#E5252A] flex items-center justify-center font-bold text-base">
                🎟
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kupon Aktif</span>
                <div class="text-2xl font-black text-emerald-600"><?php echo $active_promos; ?> Aktif</div>
                <span class="text-[11px] text-emerald-600 font-semibold">Siap Digunakan Pelanggan</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-base">
                ✔
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Klaim Terpakai</span>
                <div class="text-2xl font-black text-slate-900"><?php echo $total_used; ?> Kali</div>
                <span class="text-[11px] text-slate-500">Redeem otomatis saat order</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-base">
                📊
            </div>
        </div>
    </div>

    <!-- 2. PROMOS DATA TABLE -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="p-3.5">Kode Promo</th>
                        <th class="p-3.5">Besaran Diskon</th>
                        <th class="p-3.5">Min. Pembelian</th>
                        <th class="p-3.5">Kuota & Penggunaan</th>
                        <th class="p-3.5">Periode Berlaku</th>
                        <th class="p-3.5 text-center">Status</th>
                        <th class="p-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    <?php if (!empty($promos)): ?>
                        <?php foreach ($promos as $pr): 
                            $quota_pct = ($pr->quota_limit > 0) ? min(100, round(($pr->used_count / $pr->quota_limit) * 100)) : 0;
                        ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-3.5">
                                    <span class="font-mono font-black text-sm text-[#E5252A] bg-red-50 border border-red-200 px-2.5 py-1 rounded">
                                        <?php echo htmlspecialchars($pr->promo_code); ?>
                                    </span>
                                </td>
                                <td class="p-3.5 font-bold text-slate-900">
                                    <?php if ($pr->discount_type === 'percentage'): ?>
                                        <span class="text-sm font-black"><?php echo round($pr->discount_value); ?>%</span>
                                    <?php else: ?>
                                        <span class="text-sm font-black">Rp <?php echo number_format($pr->discount_value, 0, ',', '.'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3.5 text-slate-600">
                                    Rp <?php echo number_format($pr->min_purchase, 0, ',', '.'); ?>
                                </td>
                                <td class="p-3.5 space-y-1">
                                    <div class="flex items-center justify-between text-[11px]">
                                        <span><?php echo $pr->used_count; ?> / <?php echo $pr->quota_limit; ?></span>
                                        <span class="font-bold text-slate-700"><?php echo $quota_pct; ?>%</span>
                                    </div>
                                    <div class="w-32 bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-red-500 h-1.5 rounded-full" style="width: <?php echo $quota_pct; ?>%;"></div>
                                    </div>
                                </td>
                                <td class="p-3.5 text-slate-500 text-[11px]">
                                    <?php echo date('d M Y', strtotime($pr->start_date)); ?> s/d <?php echo date('d M Y', strtotime($pr->end_date)); ?>
                                </td>
                                <td class="p-3.5 text-center">
                                    <button type="button" 
                                            class="btn-toggle-promo text-[10px] font-black uppercase px-2.5 py-1 rounded-full transition-colors <?php echo $pr->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600'; ?>" 
                                            data-id="<?php echo $pr->id; ?>">
                                        <?php echo $pr->is_active ? 'Aktif' : 'Non-Aktif'; ?>
                                    </button>
                                </td>
                                <td class="p-3.5 text-center">
                                    <button type="button" 
                                            class="btn-delete-promo text-slate-400 hover:text-red-600 transition-colors p-1" 
                                            data-id="<?php echo $pr->id; ?>" 
                                            data-code="<?php echo htmlspecialchars($pr->promo_code); ?>" 
                                            title="Hapus Kupon">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal: Buat Kupon Baru -->
<div id="new-promo-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between pb-2 border-b border-slate-200">
            <h4 class="font-black text-slate-900 uppercase text-xs">Buat Kupon Promo Baru</h4>
            <button type="button" onclick="closePromoModal()" class="text-slate-400 hover:text-slate-700 font-black text-lg">&times;</button>
        </div>

        <form id="form-create-promo" class="space-y-3 text-xs">
            <div class="space-y-1">
                <label for="create-promo-code" class="font-bold text-slate-700 block">Kode Promo *</label>
                <input type="text" id="create-promo-code" name="promo_code" required placeholder="Contoh: DISKON25" class="w-full p-2.5 border border-slate-300 rounded-lg uppercase font-mono font-bold focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label for="create-discount-type" class="font-bold text-slate-700 block">Tipe Diskon *</label>
                    <select id="create-discount-type" name="discount_type" class="w-full p-2.5 border border-slate-300 rounded-lg font-medium bg-white focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                        <option value="percentage">Persentase (%)</option>
                        <option value="fixed">Nominal Tetap (Rp)</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label for="create-discount-value" class="font-bold text-slate-700 block">Nilai Diskon *</label>
                    <input type="number" id="create-discount-value" name="discount_value" required min="1" placeholder="Misal: 25 atau 50000" class="w-full p-2.5 border border-slate-300 rounded-lg font-bold focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label for="create-min-purchase" class="font-bold text-slate-700 block">Min. Belanja (Rp) *</label>
                    <input type="number" id="create-min-purchase" name="min_purchase" value="100000" required class="w-full p-2.5 border border-slate-300 rounded-lg font-medium focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
                <div class="space-y-1">
                    <label for="create-quota" class="font-bold text-slate-700 block">Batas Kuota Pemakaian *</label>
                    <input type="number" id="create-quota" name="quota_limit" value="200" required min="1" class="w-full p-2.5 border border-slate-300 rounded-lg font-medium focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label for="create-start-date" class="font-bold text-slate-700 block">Tanggal Mulai *</label>
                    <input type="date" id="create-start-date" name="start_date" value="<?php echo date('Y-m-d'); ?>" required class="w-full p-2.5 border border-slate-300 rounded-lg font-medium bg-white focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
                <div class="space-y-1">
                    <label for="create-end-date" class="font-bold text-slate-700 block">Tanggal Berakhir *</label>
                    <input type="date" id="create-end-date" name="end_date" value="<?php echo date('Y-m-d', strtotime('+1 year')); ?>" required class="w-full p-2.5 border border-slate-300 rounded-lg font-medium bg-white focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
            </div>

            <div class="flex items-center space-x-2 pt-3">
                <button type="button" onclick="closePromoModal()" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 rounded-lg">Batal</button>
                <button type="submit" class="w-1/2 bg-[#E5252A] hover:bg-[#c41c21] text-white font-bold py-2.5 rounded-lg shadow">Simpan Kupon</button>
            </div>
        </form>
    </div>
</div>

<script>
function openPromoModal() {
    document.getElementById('new-promo-modal').classList.remove('hidden');
}
function closePromoModal() {
    document.getElementById('new-promo-modal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
    // 1. Create Promo Form
    const createForm = document.getElementById('form-create-promo');
    if (createForm) {
        createForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(createForm);

            fetch('<?php echo base_url("admin/promos/create"); ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    closePromoModal();
                    window.location.reload();
                } else {
                    alert(data.message || 'Gagal menambahkan kupon');
                }
            });
        });
    }

    // 2. Toggle Status Promo
    document.querySelectorAll('.btn-toggle-promo').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            fetch('<?php echo base_url("admin/promos/toggle_status/"); ?>' + id, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.reload();
                }
            });
        });
    });

    // 3. Delete Promo
    document.querySelectorAll('.btn-delete-promo').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const code = btn.dataset.code;
            if (confirm('Hapus kupon promo ' + code + '?')) {
                fetch('<?php echo base_url("admin/promos/delete/"); ?>' + id, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.reload();
                    }
                });
            }
        });
    });
});
</script>
