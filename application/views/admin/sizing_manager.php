<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - GENDER SIZING MANAGER (MEN, WOMEN, KIDS)
     Brand KPIs, Batch Size Restocking & Sizing Matrix Table
     ========================================================================= -->

<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-200 gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                <span class="text-xs font-black uppercase text-slate-400 tracking-wider">Gender Sizing Management</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900 mt-0.5">
                <?php echo htmlspecialchars($page_title); ?>
            </h1>
            <p class="text-xs text-slate-500">
                Audit matriks ukuran khusus kategori <?php echo htmlspecialchars($gender_category); ?> dan penambahan stok batch fisik.
            </p>
        </div>

        <!-- Gender Switcher Navigation Tabs -->
        <div class="flex items-center space-x-2 bg-slate-200/80 p-1 rounded-xl">
            <a href="<?php echo base_url('admin/men'); ?>" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all <?php echo ($gender_category === 'Men') ? 'bg-[#E5252A] text-white shadow' : 'text-slate-700 hover:text-slate-900'; ?>">
                Men's Sizing
            </a>
            <a href="<?php echo base_url('admin/women'); ?>" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all <?php echo ($gender_category === 'Women') ? 'bg-[#E5252A] text-white shadow' : 'text-slate-700 hover:text-slate-900'; ?>">
                Women's Sizing
            </a>
            <a href="<?php echo base_url('admin/kids'); ?>" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all <?php echo ($gender_category === 'Kids') ? 'bg-[#E5252A] text-white shadow' : 'text-slate-700 hover:text-slate-900'; ?>">
                Kids' Sizing
            </a>
        </div>
    </div>

    <!-- 1. BATCH RESTOCK TOOL -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <form id="form-batch-stock" class="flex flex-col md:flex-row md:items-end justify-between gap-4 text-xs">
            <div class="space-y-1">
                <span class="font-black text-slate-900 uppercase tracking-wider block">Batch Restock Ukuran (Semua Produk <?php echo $gender_category; ?>)</span>
                <p class="text-slate-500">Tambahkan stok fisik secara serentak ke semua model sepatu untuk ukuran tertentu.</p>
            </div>

            <div class="flex items-center space-x-3">
                <div class="space-y-1">
                    <label class="font-bold text-slate-700 block">Ukuran (EUR):</label>
                    <select id="batch-size" class="p-2 border border-slate-300 rounded-lg font-bold bg-white focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                        <?php foreach ($target_sizes as $ts): ?>
                            <option value="<?php echo $ts; ?>">EUR <?php echo $ts; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="font-bold text-slate-700 block">Tambah Jumlah (Pasang):</label>
                    <input type="number" id="batch-qty" min="1" max="100" value="5" class="w-24 p-2 border border-slate-300 rounded-lg font-bold text-center focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>

                <div class="self-end">
                    <button type="submit" class="bg-[#E5252A] hover:bg-[#c41c21] text-white font-bold py-2.5 px-4 rounded-lg shadow transition-colors flex items-center space-x-1">
                        <span>+ Tambah Stok Batch</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- 2. BRAND KPI SUMMARY CARDS -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3">
        <div class="bg-white p-3 rounded-xl border border-slate-200 text-center shadow-sm">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total <?php echo $gender_category; ?></span>
            <span class="text-lg font-black text-slate-900"><?php echo isset($kpi_total) ? $kpi_total : 0; ?></span>
            <span class="text-[10px] text-emerald-600 font-semibold block">Model</span>
        </div>
        <div class="bg-white p-3 rounded-xl border border-slate-200 text-center shadow-sm">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Diadora</span>
            <span class="text-lg font-black text-slate-900"><?php echo isset($kpi_diadora) ? $kpi_diadora : 0; ?></span>
            <span class="text-[10px] text-slate-400 block">Model</span>
        </div>
        <div class="bg-white p-3 rounded-xl border border-slate-200 text-center shadow-sm">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Airwalk</span>
            <span class="text-lg font-black text-slate-900"><?php echo isset($kpi_airwalk) ? $kpi_airwalk : 0; ?></span>
            <span class="text-[10px] text-slate-400 block">Model</span>
        </div>
        <div class="bg-white p-3 rounded-xl border border-slate-200 text-center shadow-sm">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">New Balance</span>
            <span class="text-lg font-black text-slate-900"><?php echo isset($kpi_nb) ? $kpi_nb : 0; ?></span>
            <span class="text-[10px] text-slate-400 block">Model</span>
        </div>
        <div class="bg-white p-3 rounded-xl border border-slate-200 text-center shadow-sm">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Converse</span>
            <span class="text-lg font-black text-slate-900"><?php echo isset($kpi_converse) ? $kpi_converse : 0; ?></span>
            <span class="text-[10px] text-slate-400 block">Model</span>
        </div>
        <div class="bg-white p-3 rounded-xl border border-slate-200 text-center shadow-sm">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nike</span>
            <span class="text-lg font-black text-slate-900"><?php echo isset($kpi_nike) ? $kpi_nike : 0; ?></span>
            <span class="text-[10px] text-slate-400 block">Model</span>
        </div>
        <div class="bg-white p-3 rounded-xl border border-slate-200 text-center shadow-sm">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Puma</span>
            <span class="text-lg font-black text-slate-900"><?php echo isset($kpi_puma) ? $kpi_puma : 0; ?></span>
            <span class="text-[10px] text-slate-400 block">Model</span>
        </div>
    </div>

    <!-- 3. FOOTWEAR SIZE MATRIX TABLE -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="p-3.5">Sepatu / Model</th>
                        <th class="p-3.5">Brand</th>
                        <th class="p-3.5 text-center">Total Fisik</th>
                        <th class="p-3.5">Matriks Ukuran <?php echo $gender_category; ?> (EUR: Stok)</th>
                        <th class="p-3.5 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $p): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-3.5">
                                    <div class="flex items-center space-x-3">
                                        <?php $sz_img = !empty($p->thumbnail) ? $p->thumbnail : (!empty($p->image_url) ? $p->image_url : base_url('assets/images/placeholder-shoe.png')); ?>
                                        <img src="<?php echo htmlspecialchars($sz_img); ?>" alt="shoe" class="w-10 h-10 object-contain bg-slate-50 rounded border border-slate-200 p-1 flex-shrink-0">
                                        <div class="max-w-xs">
                                            <strong class="font-bold text-slate-900 block truncate"><?php echo htmlspecialchars($p->name); ?></strong>
                                            <span class="text-[11px] font-mono text-slate-400"><?php echo htmlspecialchars($p->sku); ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-3.5 font-bold text-slate-800"><?php echo htmlspecialchars($p->brand_name); ?></td>
                                <td class="p-3.5 text-center">
                                    <span class="inline-block font-black text-xs px-2.5 py-1 rounded-full <?php echo $p->total_stock <= 5 ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800'; ?>">
                                        <?php echo $p->total_stock; ?> psg
                                    </span>
                                </td>
                                <td class="p-3.5">
                                    <div class="flex flex-wrap gap-1 max-w-md">
                                        <?php if (!empty($p->skus)): ?>
                                            <?php foreach ($p->skus as $sk): ?>
                                                <span class="inline-block text-[10px] px-1.5 py-0.5 rounded font-mono font-bold border <?php echo $sk->stock_qty <= 5 ? 'bg-amber-50 border-amber-300 text-amber-800' : 'bg-slate-50 border-slate-200 text-slate-700'; ?>">
                                                    <?php echo $sk->size_eu; ?>: <strong class="<?php echo $sk->stock_qty <= 0 ? 'text-red-500' : ''; ?>"><?php echo $sk->stock_qty; ?></strong>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="p-3.5 text-center">
                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">
                                        Aktif
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="p-8 text-center text-slate-400">Tidak ada produk ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="p-4 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
                <span>Halaman <?php echo $current_page; ?> dari <?php echo $total_pages; ?></span>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const batchForm = document.getElementById('form-batch-stock');
    if (batchForm) {
        batchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const size = document.getElementById('batch-size').value;
            const qty = document.getElementById('batch-qty').value;

            const formData = new FormData();
            formData.append('size_eu', size);
            formData.append('add_qty', qty);

            fetch('<?php echo base_url("admin/men/batch_stock_update"); ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert(data.message || 'Gagal menambahkan stok batch');
                }
            });
        });
    }
});
</script>
