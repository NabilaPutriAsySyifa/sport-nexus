<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - BRAND SHOWCASE MANAGER (ADMIN PANEL)
     Spesifikasi PDF: Tabel Master Brand Carousel, Brand Editor Modal & Global Marquee Settings
     ========================================================================= -->

<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-200 gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                <span class="text-xs font-black uppercase text-slate-400 tracking-wider">Catalog & Brands</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900 mt-0.5">
                Brand Showcase Manager
            </h1>
            <p class="text-xs text-slate-500">
                Mengelola penayangan logo merek resmi pada pita carousel beranda, memantau alokasi kuota stok, dan konfigurasi filter katalog.
            </p>
        </div>

        <div class="flex items-center space-x-3">
            <span class="text-xs bg-slate-900 text-white font-mono font-bold px-3 py-1.5 rounded-lg shadow-sm">
                6 Brand Resmi Terkurasi
            </span>
        </div>
    </div>

    <!-- 1. TABEL MASTER DATA BRAND CAROUSEL (BRAND LIST TABLE) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">
                Daftar Brand Mitra & Status Pita Beranda
            </h3>
            <span class="text-xs text-slate-400 font-semibold">Tinggi Logo Standar: 32px – 40px</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs" id="brands-table">
                <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="p-3.5 text-center w-12">Urutan</th>
                        <th class="p-3.5">Logo Preview</th>
                        <th class="p-3.5">Nama Merek (Brand)</th>
                        <th class="p-3.5">Sub-Brand / Kategori Terkait</th>
                        <th class="p-3.5 text-center">Total Stok Terdata</th>
                        <th class="p-3.5">Slug URL Filter</th>
                        <th class="p-3.5 text-center">Status Tayang</th>
                        <th class="p-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    <?php if (!empty($brands)): ?>
                        <?php foreach ($brands as $b): 
                            $actual_count = $this->db->where('brand_name', $b->name)->count_all_results('products');
                            $sub_brands_arr = !empty($b->sub_brands) ? json_decode($b->sub_brands, true) : array();
                            $logo_path = !empty($b->logo) ? $b->logo : 'assets/images/brands/' . $b->slug . '.svg';
                        ?>
                            <tr class="hover:bg-slate-50/80 transition-colors" data-brand-id="<?php echo $b->id; ?>">
                                <!-- Urutan (Order) -->
                                <td class="p-3.5 text-center font-mono font-bold text-slate-900">
                                    <span class="inline-block w-6 h-6 rounded-full bg-slate-100 text-slate-700 text-center leading-6 text-xs">
                                        #<?php echo $b->display_order; ?>
                                    </span>
                                </td>

                                <!-- Logo Preview (32-40px height) -->
                                <td class="p-3.5">
                                    <div class="h-10 w-24 bg-white border border-slate-200 rounded-lg p-1.5 flex items-center justify-center shadow-sm">
                                        <img src="<?php echo base_url($logo_path); ?>" alt="<?php echo htmlspecialchars($b->name); ?>" class="max-h-8 max-w-full object-contain filter grayscale hover:grayscale-0 transition-all">
                                    </div>
                                </td>

                                <!-- Nama Brand -->
                                <td class="p-3.5">
                                    <strong class="font-black text-sm text-slate-900 block"><?php echo htmlspecialchars($b->name); ?></strong>
                                    <span class="text-[10px] text-slate-400 uppercase font-mono">Mitra Resmi</span>
                                </td>

                                <!-- Sub-Brand / Kategori Terkait -->
                                <td class="p-3.5">
                                    <?php if (!empty($sub_brands_arr)): ?>
                                        <div class="flex flex-wrap gap-1">
                                            <?php foreach ($sub_brands_arr as $sb): ?>
                                                <span class="bg-slate-100 text-slate-700 text-[10px] font-bold px-2 py-0.5 rounded border border-slate-200">
                                                    <?php echo htmlspecialchars($sb); ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-slate-400 italic text-[11px]">-</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Total Stok Terdata -->
                                <td class="p-3.5 text-center">
                                    <div class="font-black text-slate-900 text-sm">
                                        <?php echo $actual_count; ?> Sepatu
                                    </div>
                                    <span class="text-[10px] text-slate-400">Target Kuota: <?php echo $b->total_quota; ?> SKU</span>
                                </td>

                                <!-- Slug URL Filter -->
                                <td class="p-3.5 font-mono text-xs text-slate-600">
                                    <span class="bg-slate-50 border border-slate-200 px-2 py-1 rounded text-[#E5252A] font-bold">
                                        /brands/<?php echo htmlspecialchars($b->slug); ?>
                                    </span>
                                </td>

                                <!-- Status Tayang (Toggle Switch) -->
                                <td class="p-3.5 text-center">
                                    <button type="button" 
                                            class="btn-toggle-brand text-[10px] font-black uppercase px-2.5 py-1 rounded-full transition-colors <?php echo $b->show_in_marquee ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600'; ?>" 
                                            data-id="<?php echo $b->id; ?>"
                                            data-active="<?php echo $b->show_in_marquee; ?>"
                                            title="Toggle tampil pada Marquee Slider Beranda">
                                        <?php echo $b->show_in_marquee ? 'Aktif (Pita ON)' : 'Inaktif (Pita OFF)'; ?>
                                    </button>
                                </td>

                                <!-- Aksi (Action: Edit & Kelola Stok) -->
                                <td class="p-3.5 text-center space-x-1.5 whitespace-nowrap">
                                    <button type="button" 
                                            class="bg-slate-100 hover:bg-slate-200 text-slate-800 px-2.5 py-1 rounded-md text-[11px] font-bold transition-colors inline-flex items-center space-x-1"
                                            onclick='openBrandModal(<?php echo json_encode($b); ?>)'>
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>Edit</span>
                                    </button>

                                    <a href="<?php echo base_url('admin/inventory?brand=' . urlencode($b->name)); ?>" class="bg-[#1E2229] hover:bg-[#2D333D] text-white px-2.5 py-1 rounded-md text-[11px] font-bold shadow transition-colors inline-flex items-center space-x-1">
                                        <span>Kelola Stok</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. GLOBAL MARQUEE SETTINGS (PENGATURAN GLOBAL PITA CAROUSEL) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <div class="flex items-center space-x-2 pb-3 border-b border-slate-100">
            <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
            <h3 class="font-black text-sm uppercase text-slate-900 tracking-wider">
                Pengaturan Global Pita Carousel (Global Marquee Settings)
            </h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-xs">
            <!-- Scroll Speed -->
            <div class="space-y-1.5">
                <label class="font-bold text-slate-700 block">Kecepatan Geser Otomatis (Scroll Speed)</label>
                <select id="setting-scroll-speed" class="w-full p-2.5 border border-slate-300 rounded-lg bg-white font-medium focus:ring-1 focus:ring-[#E5252A]">
                    <option value="slow">Slow: 30 detik / putaran</option>
                    <option value="normal" selected>Normal: 20 detik / putaran (Default)</option>
                    <option value="fast">Fast: 12 detik / putaran</option>
                </select>
                <p class="text-[11px] text-slate-400">Durasi animasi marquee mendatar dari kanan ke kiri tanpa henti.</p>
            </div>

            <!-- Pause on Hover Toggle -->
            <div class="space-y-1.5">
                <label class="font-bold text-slate-700 block">Fitur Jeda Saat Kursor Masuk (Pause on Hover)</label>
                <div class="flex items-center space-x-3 pt-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="setting-pause-hover" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E5252A]"></div>
                    </label>
                    <span class="text-xs font-semibold text-slate-700">Aktif (Pause saat disentuh kursor)</span>
                </div>
                <p class="text-[11px] text-slate-400">Menghentikan putaran otomatis sementara agar logo mudah diklik.</p>
            </div>

            <!-- Global Route See All Brands -->
            <div class="space-y-1.5">
                <label class="font-bold text-slate-700 block">Tautan Tombol "See All Brands &gt;"</label>
                <input type="text" id="setting-see-all-route" readonly value="/brands.html" class="w-full p-2.5 border border-slate-200 bg-slate-50 rounded-lg font-mono text-slate-600 font-bold">
                <p class="text-[11px] text-slate-400">Mengarahkan ke indeks katalog penuh seluruh 1.543 produk.</p>
            </div>
        </div>

        <div class="pt-3 border-t border-slate-100 flex justify-end">
            <button type="button" onclick="saveMarqueeSettings()" class="bg-[#1E2229] hover:bg-[#2D333D] text-white px-5 py-2 rounded-xl text-xs font-bold shadow transition-all">
                Simpan Konfigurasi Marquee
            </button>
        </div>
    </div>

</div>

<!-- Brand Editor Modal (Formulir Pengaturan & Unggah Logo) -->
<div id="brand-edit-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-8 space-y-5 shadow-2xl">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
            <h4 class="font-black text-slate-900 uppercase text-sm">Formulir Pengaturan Mitra Brand</h4>
            <button type="button" onclick="closeBrandModal()" class="text-slate-400 hover:text-slate-700 font-black text-xl">&times;</button>
        </div>

        <form id="form-brand-edit" class="space-y-4 text-xs">
            <input type="hidden" id="modal-brand-id" name="id">

            <!-- Brand Name & Slug -->
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label for="modal-brand-name" class="font-bold text-slate-700 block">Nama Brand *</label>
                    <input type="text" id="modal-brand-name" name="name" required class="w-full p-2.5 border border-slate-300 rounded-lg font-bold focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
                <div class="space-y-1">
                    <label for="modal-brand-slug" class="font-bold text-slate-700 block">Brand Slug (URL) *</label>
                    <input type="text" id="modal-brand-slug" name="slug" required class="w-full p-2.5 border border-slate-300 rounded-lg font-mono focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
            </div>

            <!-- Target Quota & Display Order -->
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label for="modal-brand-quota" class="font-bold text-slate-700 block">Target Kuota Stok (SKU) *</label>
                    <input type="number" id="modal-brand-quota" name="total_quota" required min="1" class="w-full p-2.5 border border-slate-300 rounded-lg font-bold focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
                <div class="space-y-1">
                    <label for="modal-brand-order" class="font-bold text-slate-700 block">Nomor Urut Tampil (1-6) *</label>
                    <input type="number" id="modal-brand-order" name="display_order" required min="1" max="10" class="w-full p-2.5 border border-slate-300 rounded-lg font-bold focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
            </div>

            <!-- Sub-Brand Mapping Info -->
            <div class="space-y-1">
                <label class="font-bold text-slate-700 block">Pengelompokan Sub-Brand (JSON Format):</label>
                <input type="text" id="modal-brand-subbrands" name="sub_brands" placeholder='["Nike Young Athletes", "Nike Golf"]' class="w-full p-2.5 border border-slate-300 rounded-lg font-mono text-[11px] focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                <span class="text-[10px] text-slate-400">Contoh: ["Converse Kids"] atau ["Nike Young Athletes", "Nike Golf"]</span>
            </div>

            <!-- Show in Marquee & Active Toggles -->
            <div class="flex items-center space-x-6 p-3 bg-slate-50 rounded-xl border border-slate-200">
                <label class="flex items-center space-x-2 cursor-pointer font-bold text-slate-800">
                    <input type="checkbox" id="modal-brand-marquee" name="show_in_marquee" value="1" class="rounded text-[#E5252A] focus:ring-[#E5252A]">
                    <span>Tampilkan di Marquee Beranda</span>
                </label>
                <label class="flex items-center space-x-2 cursor-pointer font-bold text-slate-800">
                    <input type="checkbox" id="modal-brand-active" name="is_active" value="1" class="rounded text-[#E5252A] focus:ring-[#E5252A]">
                    <span>Status Mitra Aktif</span>
                </label>
            </div>

            <div class="flex items-center space-x-3 pt-3">
                <button type="button" onclick="closeBrandModal()" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="w-1/2 bg-[#E5252A] hover:bg-[#c41c21] text-white font-bold py-2.5 rounded-xl shadow transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openBrandModal(brand) {
    document.getElementById('modal-brand-id').value = brand.id;
    document.getElementById('modal-brand-name').value = brand.name;
    document.getElementById('modal-brand-slug').value = brand.slug;
    document.getElementById('modal-brand-quota').value = brand.total_quota;
    document.getElementById('modal-brand-order').value = brand.display_order;
    document.getElementById('modal-brand-subbrands').value = brand.sub_brands || '[]';
    document.getElementById('modal-brand-marquee').checked = (brand.show_in_marquee == 1);
    document.getElementById('modal-brand-active').checked = (brand.is_active == 1);
    document.getElementById('brand-edit-modal').classList.remove('hidden');
}

function closeBrandModal() {
    document.getElementById('brand-edit-modal').classList.add('hidden');
}

function saveMarqueeSettings() {
    const speed = document.getElementById('setting-scroll-speed').value;
    const pause = document.getElementById('setting-pause-hover').checked;
    localStorage.setItem('sportnexus_marquee_speed', speed);
    localStorage.setItem('sportnexus_marquee_pause', pause);
    alert('Konfigurasi Marquee berhasil disimpan!');
}

document.addEventListener('DOMContentLoaded', function () {
    // Submit Brand Edit
    const formBrand = document.getElementById('form-brand-edit');
    if (formBrand) {
        formBrand.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(formBrand);
            fetch('<?php echo base_url("admin/brands/save"); ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                closeBrandModal();
                if (data.status === 'success') {
                    window.location.reload();
                } else {
                    alert(data.message || 'Gagal menyimpan brand');
                }
            });
        });
    }

    // Toggle Marquee Button
    document.querySelectorAll('.btn-toggle-brand').forEach(btn => {
        btn.addEventListener('click', () => {
            const brandId = btn.dataset.id;
            fetch('<?php echo base_url("admin/brands/toggle/"); ?>' + brandId, {
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
});
</script>
