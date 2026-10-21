<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - MASTER FOOTWEAR INVENTORY
     8 Brand KPI Cards, Inline Size Stock Matrix Editor, Publish Toggle
     ========================================================================= -->

<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-200 gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                <span class="text-xs font-black uppercase text-slate-400 tracking-wider">Catalog & Stock Management</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900 mt-0.5">
                Master Footwear Inventory
            </h1>
            <p class="text-xs text-slate-500">
                Audit dan kelola 1.543 model sepatu terdaftar, stok ukuran EUR 20–46, dan status publikasi katalog.
            </p>
        </div>

        <div class="flex items-center space-x-3">
            <span class="text-xs bg-slate-900 text-white font-mono font-bold px-3 py-1.5 rounded-lg shadow-sm">
                Total: <?php echo number_format($total_products, 0, ',', '.'); ?> Produk
            </span>
        </div>
    </div>

    <!-- 1. 8 BRAND & INVENTORY KPI CARDS -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        <!-- 1. Total -->
        <a href="<?php echo base_url('admin/inventory'); ?>" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-slate-400 shadow-sm transition-all text-center group">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total SKU</span>
            <span class="text-lg font-black text-slate-900 group-hover:text-[#E5252A]"><?php echo $kpi_total; ?></span>
            <span class="text-[10px] text-emerald-600 block font-semibold">100% Aktif</span>
        </a>

        <!-- 2. Diadora -->
        <a href="<?php echo base_url('admin/inventory?brand=Diadora'); ?>" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-red-400 shadow-sm transition-all text-center group">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Diadora</span>
            <span class="text-lg font-black text-slate-900 group-hover:text-[#E5252A]"><?php echo $kpi_diadora; ?></span>
            <span class="text-[10px] text-slate-500 block">Kuota: 500</span>
        </a>

        <!-- 3. Airwalk -->
        <a href="<?php echo base_url('admin/inventory?brand=Airwalk'); ?>" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-red-400 shadow-sm transition-all text-center group">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Airwalk</span>
            <span class="text-lg font-black text-slate-900 group-hover:text-[#E5252A]"><?php echo $kpi_airwalk; ?></span>
            <span class="text-[10px] text-slate-500 block">Kuota: 400</span>
        </a>

        <!-- 4. New Balance -->
        <a href="<?php echo base_url('admin/inventory?brand=New+Balance'); ?>" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-red-400 shadow-sm transition-all text-center group">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">New Balance</span>
            <span class="text-lg font-black text-slate-900 group-hover:text-[#E5252A]"><?php echo $kpi_nb; ?></span>
            <span class="text-[10px] text-slate-500 block">Kuota: 200</span>
        </a>

        <!-- 5. Converse -->
        <a href="<?php echo base_url('admin/inventory?brand=Converse'); ?>" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-red-400 shadow-sm transition-all text-center group">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Converse</span>
            <span class="text-lg font-black text-slate-900 group-hover:text-[#E5252A]"><?php echo $kpi_converse; ?></span>
            <span class="text-[10px] text-slate-500 block">Kuota: 240</span>
        </a>

        <!-- 6. Nike -->
        <a href="<?php echo base_url('admin/inventory?brand=Nike'); ?>" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-red-400 shadow-sm transition-all text-center group">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nike</span>
            <span class="text-lg font-black text-slate-900 group-hover:text-[#E5252A]"><?php echo $kpi_nike; ?></span>
            <span class="text-[10px] text-slate-500 block">Kuota: 121</span>
        </a>

        <!-- 7. Puma -->
        <a href="<?php echo base_url('admin/inventory?brand=Puma'); ?>" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-red-400 shadow-sm transition-all text-center group">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Puma</span>
            <span class="text-lg font-black text-slate-900 group-hover:text-[#E5252A]"><?php echo $kpi_puma; ?></span>
            <span class="text-[10px] text-slate-500 block">Kuota: 82</span>
        </a>

        <!-- 8. Low Stock Alert -->
        <a href="<?php echo base_url('admin/inventory?status=menipis'); ?>" class="bg-amber-50 p-3 rounded-xl border border-amber-200 hover:border-amber-400 shadow-sm transition-all text-center group">
            <span class="text-[10px] font-bold text-amber-700 uppercase tracking-wider block">Stok Kritis</span>
            <span class="text-lg font-black text-amber-600"><?php echo $kpi_low_stock; ?></span>
            <span class="text-[10px] text-amber-600 block font-semibold">&le; 5 Pasang</span>
        </a>
    </div>

    <!-- 2. SEARCH & FILTER TOOLBAR -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="<?php echo base_url('admin/inventory'); ?>" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 text-xs">
            <!-- Search Input -->
            <div>
                <input type="text" name="search" value="<?php echo htmlspecialchars($filters['search'] ?: ''); ?>" placeholder="Cari SKU atau Nama Sepatu..." class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-1 focus:ring-[#E5252A] focus:outline-none font-medium">
            </div>

            <!-- Brand Filter -->
            <div>
                <select name="brand" class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-1 focus:ring-[#E5252A] focus:outline-none bg-white font-medium">
                    <option value="">Semua Brand (6 Brand)</option>
                    <option value="Diadora" <?php echo ($filters['brand'] === 'Diadora') ? 'selected' : ''; ?>>Diadora</option>
                    <option value="New Balance" <?php echo ($filters['brand'] === 'New Balance') ? 'selected' : ''; ?>>New Balance</option>
                    <option value="Airwalk" <?php echo ($filters['brand'] === 'Airwalk') ? 'selected' : ''; ?>>Airwalk</option>
                    <option value="Converse" <?php echo ($filters['brand'] === 'Converse') ? 'selected' : ''; ?>>Converse</option>
                    <option value="Nike" <?php echo ($filters['brand'] === 'Nike') ? 'selected' : ''; ?>>Nike</option>
                    <option value="Puma" <?php echo ($filters['brand'] === 'Puma') ? 'selected' : ''; ?>>Puma</option>
                </select>
            </div>

            <!-- Gender Filter -->
            <div>
                <select name="gender" class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-1 focus:ring-[#E5252A] focus:outline-none bg-white font-medium">
                    <option value="">Semua Gender</option>
                    <option value="Men" <?php echo ($filters['gender'] === 'Men') ? 'selected' : ''; ?>>Men</option>
                    <option value="Women" <?php echo ($filters['gender'] === 'Women') ? 'selected' : ''; ?>>Women</option>
                    <option value="Boys" <?php echo ($filters['gender'] === 'Boys') ? 'selected' : ''; ?>>Boys</option>
                    <option value="Girls" <?php echo ($filters['gender'] === 'Girls') ? 'selected' : ''; ?>>Girls</option>
                    <option value="Unisex" <?php echo ($filters['gender'] === 'Unisex') ? 'selected' : ''; ?>>Unisex</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-center space-x-2">
                <button type="submit" class="w-full bg-[#1E2229] hover:bg-[#2D333D] text-white font-bold py-2.5 rounded-lg shadow transition-colors">
                    Filter Data
                </button>
                <a href="<?php echo base_url('admin/inventory'); ?>" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-3 py-2.5 rounded-lg transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- 3. INVENTORY TABLE -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="p-3.5">Sepatu / Model</th>
                        <th class="p-3.5">SKU Code</th>
                        <th class="p-3.5">Kategori / Sport</th>
                        <th class="p-3.5 text-right">Harga Retail & Diskon</th>
                        <th class="p-3.5 text-center">Total Fisik</th>
                        <th class="p-3.5">Matriks Ukuran (EUR : Stok)</th>
                        <th class="p-3.5 text-center">Status</th>
                        <th class="p-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $p): ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <!-- Sepatu / Model -->
                                <td class="p-3.5">
                                    <div class="flex items-center space-x-3">
                                        <?php $inv_img = !empty($p->thumbnail) ? $p->thumbnail : (!empty($p->image_url) ? $p->image_url : base_url('assets/images/placeholder-shoe.png')); ?>
                                        <img src="<?php echo htmlspecialchars($inv_img); ?>" alt="shoe" class="w-12 h-12 object-contain bg-slate-50 rounded-lg border border-slate-200 p-1 flex-shrink-0">
                                        <div class="max-w-xs">
                                            <span class="text-[10px] font-black uppercase tracking-wider text-[#E5252A] block"><?php echo htmlspecialchars($p->brand_name); ?></span>
                                            <strong class="text-slate-900 font-bold block truncate" title="<?php echo htmlspecialchars($p->name); ?>"><?php echo htmlspecialchars($p->name); ?></strong>
                                            <span class="text-[11px] text-slate-400">Warna: <?php echo htmlspecialchars($p->color); ?></span>
                                        </div>
                                    </div>
                                </td>

                                <!-- SKU Code -->
                                <td class="p-3.5 font-mono text-slate-800 font-bold">
                                    <?php echo htmlspecialchars($p->sku); ?>
                                </td>

                                <!-- Kategori & Sport -->
                                <td class="p-3.5 space-y-1">
                                    <span class="inline-block bg-slate-100 text-slate-700 px-2 py-0.5 rounded font-bold text-[10px] uppercase">
                                        <?php echo htmlspecialchars($p->gender); ?>
                                    </span>
                                    <span class="inline-block bg-blue-50 text-blue-700 px-2 py-0.5 rounded font-bold text-[10px] uppercase ml-1">
                                        <?php echo htmlspecialchars($p->primary_sport); ?>
                                    </span>
                                </td>

                                <!-- Pricing -->
                                <td class="p-3.5 text-right space-y-0.5">
                                    <div class="font-black text-slate-900">
                                        Rp <?php echo number_format($p->sale_price, 0, ',', '.'); ?>
                                    </div>
                                    <?php if ($p->discount_percent > 0): ?>
                                        <div class="text-[11px] text-slate-400 line-through">
                                            Rp <?php echo number_format($p->original_price, 0, ',', '.'); ?>
                                        </div>
                                        <span class="text-[10px] font-black text-[#E5252A]">
                                            -<?php echo round($p->discount_percent); ?>%
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <!-- Total Stock -->
                                <td class="p-3.5 text-center">
                                    <span class="inline-block font-black text-xs px-2.5 py-1 rounded-full <?php echo $p->total_stock <= 5 ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800'; ?>">
                                        <?php echo $p->total_stock; ?> psg
                                    </span>
                                </td>

                                <!-- Matriks Ukuran (EUR : Stok) -->
                                <td class="p-3.5">
                                    <div class="flex flex-wrap gap-1 max-w-sm">
                                        <?php if (!empty($p->skus)): ?>
                                            <?php foreach ($p->skus as $sk): ?>
                                                <button type="button" 
                                                        class="inline-block text-[10px] px-1.5 py-0.5 rounded font-mono font-bold border transition-colors <?php echo $sk->stock_qty <= 5 ? 'bg-amber-50 border-amber-300 text-amber-800' : 'bg-slate-50 border-slate-200 text-slate-700 hover:border-slate-400'; ?>" 
                                                        onclick='openStockModal(<?php echo json_encode($sk); ?>, "<?php echo addslashes($p->name); ?>")' 
                                                        title="Klik untuk ubah stok EUR <?php echo $sk->size_eu; ?>">
                                                    <?php echo $sk->size_eu; ?>: <strong class="<?php echo $sk->stock_qty <= 0 ? 'text-red-500' : ''; ?>"><?php echo $sk->stock_qty; ?></strong>
                                                </button>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- Status Toggle -->
                                <td class="p-3.5 text-center">
                                    <button type="button" 
                                            class="btn-toggle-pub text-[10px] font-black uppercase px-2.5 py-1 rounded-full transition-colors <?php echo $p->is_published ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600'; ?>" 
                                            data-id="<?php echo $p->id; ?>" 
                                            data-status="<?php echo $p->is_published; ?>">
                                        <?php echo $p->is_published ? 'Published' : 'Draft'; ?>
                                    </button>
                                </td>

                                <!-- Actions -->
                                <td class="p-3.5 text-center">
                                    <a href="<?php echo base_url('product/' . $p->sku); ?>" target="_blank" class="text-xs font-bold text-slate-600 hover:text-[#E5252A] inline-block p-1" title="Lihat di Toko">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400">Tidak ada produk ditemukan sesuai filter.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="p-4 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
                <span>Halaman <?php echo $current_page; ?> dari <?php echo $total_pages; ?> (Total <?php echo number_format($total_products, 0, ',', '.'); ?> SKU)</span>
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

<!-- Inline Quick Stock Edit Modal -->
<div id="stock-edit-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between pb-2 border-b border-slate-200">
            <h4 class="font-black text-slate-900 uppercase text-xs">Update Stok Ukuran Sepatu</h4>
            <button type="button" onclick="closeStockModal()" class="text-slate-400 hover:text-slate-700 font-black text-lg">&times;</button>
        </div>

        <div class="space-y-1 text-xs">
            <p id="modal-product-title" class="font-bold text-slate-800 line-clamp-1">Model Sepatu</p>
            <p class="text-slate-500">Ukuran EUR: <strong id="modal-size-label" class="text-slate-900 font-bold">42</strong></p>
        </div>

        <form id="form-stock-update" class="space-y-4 text-xs">
            <input type="hidden" id="modal-sku-id" name="sku_id">

            <div class="space-y-1">
                <label for="modal-stock-qty" class="font-bold text-slate-700 block">Jumlah Stok Fisik *</label>
                <input type="number" id="modal-stock-qty" name="stock_qty" min="0" required class="w-full p-2.5 border border-slate-300 rounded-lg font-bold text-sm focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
            </div>

            <div class="flex items-center space-x-2 pt-2">
                <button type="button" onclick="closeStockModal()" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 rounded-lg">Batal</button>
                <button type="submit" class="w-1/2 bg-[#E5252A] hover:bg-[#c41c21] text-white font-bold py-2.5 rounded-lg shadow">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openStockModal(skuData, productName) {
    document.getElementById('modal-sku-id').value = skuData.id;
    document.getElementById('modal-product-title').textContent = productName;
    document.getElementById('modal-size-label').textContent = skuData.size_eu + (skuData.size_us ? ` (US ${skuData.size_us})` : '');
    document.getElementById('modal-stock-qty').value = skuData.stock_qty;
    document.getElementById('stock-edit-modal').classList.remove('hidden');
}

function closeStockModal() {
    document.getElementById('stock-edit-modal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
    // 1. Submit Stock Update
    const stockForm = document.getElementById('form-stock-update');
    if (stockForm) {
        stockForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const skuId = document.getElementById('modal-sku-id').value;
            const stockQty = document.getElementById('modal-stock-qty').value;

            const formData = new FormData();
            formData.append('sku_id', skuId);
            formData.append('stock_qty', stockQty);

            fetch('<?php echo base_url("admin/inventory/update_stock"); ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                closeStockModal();
                if (data.status === 'success') {
                    window.location.reload();
                } else {
                    alert(data.message || 'Gagal mengubah stok');
                }
            });
        });
    }

    // 2. Toggle Publish Status
    document.querySelectorAll('.btn-toggle-pub').forEach(btn => {
        btn.addEventListener('click', () => {
            const prodId = btn.dataset.id;
            fetch('<?php echo base_url("admin/inventory/toggle_publish/"); ?>' + prodId, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (data.is_published == 1) {
                        btn.className = 'btn-toggle-pub text-[10px] font-black uppercase px-2.5 py-1 rounded-full transition-colors bg-emerald-100 text-emerald-800';
                        btn.textContent = 'Published';
                    } else {
                        btn.className = 'btn-toggle-pub text-[10px] font-black uppercase px-2.5 py-1 rounded-full transition-colors bg-slate-200 text-slate-600';
                        btn.textContent = 'Draft';
                    }
                }
            });
        });
    });
});
</script>
