<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - HERO BANNER SLIDER MANAGER (ADMIN PANEL)
     Spesifikasi PDF: Tabel Ringkasan Banner, Modal Editor 4 Brand & Global Settings
     ========================================================================= -->

<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-200 gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                <span class="text-xs font-black uppercase text-slate-400 tracking-wider">Marketing & Content</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900 mt-0.5">
                Hero Banner Slider Manager
            </h1>
            <p class="text-xs text-slate-500">
                Kelola konten poster promosi pada slider beranda utama (tambah, edit, urutkan, jadwalkan, dan nonaktifkan banner).
            </p>
        </div>

        <button type="button" onclick="openNewBannerModal()" class="bg-[#E5252A] hover:bg-[#c41c21] text-white px-4 py-2 rounded-xl text-xs font-bold shadow-lg hover:shadow-red-500/25 transition-all flex items-center space-x-1.5 self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span>+ Tambah Banner Baru</span>
        </button>
    </div>

    <!-- 1. TABEL RINGKASAN BANNER AKTIF (BANNER LIST VIEW) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">
                Daftar Slide Banner Beranda
            </h3>
            <span class="text-xs text-slate-400 font-semibold">Rasio Desktop: 16:9 / 16:7 (1920 × 840 px)</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="p-3.5 text-center w-12">Urutan</th>
                        <th class="p-3.5">Thumbnail (120 × 50 px)</th>
                        <th class="p-3.5">Judul Promo & Headline</th>
                        <th class="p-3.5">Target Brand</th>
                        <th class="p-3.5">URL Pengalihan (Link)</th>
                        <th class="p-3.5">Jadwal Tayang</th>
                        <th class="p-3.5 text-center">Status</th>
                        <th class="p-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    <?php if (!empty($banners)): ?>
                        <?php foreach ($banners as $b): 
                            $b_img = !empty($b->desktop_image) ? $b->desktop_image : 'uploads/banners/hero-banner-1.jpg';
                        ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <!-- Urutan (Sort Order) -->
                                <td class="p-3.5 text-center font-mono font-bold text-slate-900">
                                    <span class="inline-block px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-xs font-bold">
                                        Slide <?php echo $b->sort_order; ?>
                                    </span>
                                </td>

                                <!-- Thumbnail Image Preview -->
                                <td class="p-3.5">
                                    <div class="w-[120px] h-[50px] bg-slate-900 rounded-lg overflow-hidden border border-slate-200 flex-shrink-0 cursor-pointer shadow-sm" onclick='previewBanner("<?php echo base_url($b_img); ?>", "<?php echo htmlspecialchars($b->title); ?>")'>
                                        <img src="<?php echo base_url($b_img); ?>" alt="Banner" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    </div>
                                </td>

                                <!-- Judul Promo & Headline -->
                                <td class="p-3.5 space-y-0.5 max-w-xs">
                                    <strong class="font-bold text-slate-900 block"><?php echo htmlspecialchars($b->title); ?></strong>
                                    <span class="text-[11px] text-[#E5252A] font-black uppercase tracking-wider block"><?php echo htmlspecialchars($b->headline); ?></span>
                                    <span class="text-[10px] text-slate-400 line-clamp-1"><?php echo htmlspecialchars($b->subheadline); ?></span>
                                </td>

                                <!-- Target Brand -->
                                <td class="p-3.5">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase <?php 
                                        switch (strtolower($b->target_brand)) {
                                            case 'diadora': echo 'bg-red-100 text-red-800'; break;
                                            case 'new balance': echo 'bg-blue-100 text-blue-800'; break;
                                            case 'airwalk': echo 'bg-amber-100 text-amber-800'; break;
                                            case 'converse': echo 'bg-emerald-100 text-emerald-800'; break;
                                            default: echo 'bg-slate-100 text-slate-800'; break;
                                        }
                                    ?>">
                                        <?php echo htmlspecialchars($b->target_brand ?: 'All Brands'); ?>
                                    </span>
                                </td>

                                <!-- URL Pengalihan -->
                                <td class="p-3.5 font-mono text-[11px] text-slate-600">
                                    <span class="bg-slate-50 border border-slate-200 px-2 py-1 rounded block truncate max-w-[150px]">
                                        <?php echo htmlspecialchars($b->cta_link ?: 'brands.html'); ?>
                                    </span>
                                    <span class="text-[10px] text-slate-400 mt-0.5 block">CTA: "<?php echo htmlspecialchars($b->cta_label ?: 'Beli Sekarang'); ?>"</span>
                                </td>

                                <!-- Jadwal Tayang -->
                                <td class="p-3.5 text-[11px] text-slate-500">
                                    <?php if (!empty($b->start_date) && !empty($b->end_date)): ?>
                                        <span><?php echo date('d/m/y', strtotime($b->start_date)); ?> – <?php echo date('d/m/y', strtotime($b->end_date)); ?></span>
                                    <?php else: ?>
                                        <span class="text-emerald-600 font-bold">Selalu Aktif (Always-On)</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Status (Toggle Switch) -->
                                <td class="p-3.5 text-center">
                                    <button type="button" 
                                            class="btn-toggle-banner text-[10px] font-black uppercase px-2.5 py-1 rounded-full transition-colors <?php echo $b->is_published ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600'; ?>" 
                                            data-id="<?php echo $b->id; ?>"
                                            data-active="<?php echo $b->is_published; ?>">
                                        <?php echo $b->is_published ? 'Published' : 'Draft'; ?>
                                    </button>
                                </td>

                                <!-- Aksi (Action: Edit, Preview, Delete) -->
                                <td class="p-3.5 text-center space-x-1 whitespace-nowrap">
                                    <!-- Edit Button -->
                                    <button type="button" 
                                            class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-colors inline-block" 
                                            onclick='openEditBannerModal(<?php echo json_encode($b); ?>)' 
                                            title="Edit Banner">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>

                                    <!-- Preview Button -->
                                    <button type="button" 
                                            class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-colors inline-block" 
                                            onclick='previewBanner("<?php echo base_url($b_img); ?>", "<?php echo htmlspecialchars($b->title); ?>")' 
                                            title="Pratinjau Poster">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <button type="button" 
                                            class="p-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors inline-block" 
                                            onclick='deleteBanner(<?php echo $b->id; ?>, "<?php echo addslashes($b->title); ?>")' 
                                            title="Hapus Banner">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. PENGATURAN GLOBAL CAROUSEL (SLIDER GLOBAL SETTINGS) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <div class="flex items-center space-x-2 pb-3 border-b border-slate-100">
            <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
            <h3 class="font-black text-sm uppercase text-slate-900 tracking-wider">
                Pengaturan Global Carousel (Slider Global Settings)
            </h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-xs">
            <!-- Autoplay Interval -->
            <div class="space-y-1.5">
                <label class="font-bold text-slate-700 block">Autoplay Interval (Detik)</label>
                <select id="slider-interval" class="w-full p-2.5 border border-slate-300 rounded-lg bg-white font-medium focus:ring-1 focus:ring-[#E5252A]">
                    <option value="3">3 Detik</option>
                    <option value="5" selected>5 Detik (Pengaturan Baku)</option>
                    <option value="7">7 Detik</option>
                    <option value="10">10 Detik</option>
                </select>
                <p class="text-[11px] text-slate-400">Jeda rotasi otomatis pergantian slide poster beranda.</p>
            </div>

            <!-- Transition Effect -->
            <div class="space-y-1.5">
                <label class="font-bold text-slate-700 block">Efek Transisi Slide</label>
                <select id="slider-transition" class="w-full p-2.5 border border-slate-300 rounded-lg bg-white font-medium focus:ring-1 focus:ring-[#E5252A]">
                    <option value="slide" selected>Slide Horizontal (Geser Halus)</option>
                    <option value="fade">Smooth Fade (Pudar Elegan)</option>
                </select>
                <p class="text-[11px] text-slate-400">Gaya animasi pergantian poster saat timer berputar.</p>
            </div>

            <!-- Pause on Hover Switch -->
            <div class="space-y-1.5">
                <label class="font-bold text-slate-700 block">Pause on Hover Switch</label>
                <div class="flex items-center space-x-3 pt-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="slider-pause-hover" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E5252A]"></div>
                    </label>
                    <span class="text-xs font-semibold text-slate-700">Aktif (Pause on Hover)</span>
                </div>
                <p class="text-[11px] text-slate-400">Menghentikan timer rotasi ketika mouse berada di atas poster.</p>
            </div>
        </div>

        <div class="pt-3 border-t border-slate-100 flex justify-end">
            <button type="button" onclick="saveSliderSettings()" class="bg-[#1E2229] hover:bg-[#2D333D] text-white px-5 py-2 rounded-xl text-xs font-bold shadow transition-all">
                Simpan Pengaturan Slider
            </button>
        </div>
    </div>

</div>

<!-- Banner Editor Modal (Formulir Tambah / Edit Banner) -->
<div id="banner-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 sm:p-8 space-y-5 shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
            <h4 id="banner-modal-title" class="font-black text-slate-900 uppercase text-sm">Formulir Tambah / Edit Poster Banner</h4>
            <button type="button" onclick="closeBannerModal()" class="text-slate-400 hover:text-slate-700 font-black text-xl">&times;</button>
        </div>

        <form id="form-banner" class="space-y-4 text-xs">
            <input type="hidden" id="modal-banner-id" name="id">

            <!-- 1. Image Asset Upload / Preview -->
            <div class="space-y-2">
                <label class="font-bold text-slate-700 block">Aset Gambar Poster (Desktop 16:9 / 16:7) *</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <span class="text-[11px] text-slate-500 font-medium">Desktop Image Path:</span>
                        <input type="text" id="modal-desktop-image" name="desktop_image" required placeholder="uploads/banners/hero-banner-1.jpg" class="w-full p-2.5 border border-slate-300 rounded-lg font-mono text-[11px] focus:ring-1 focus:ring-[#E5252A] focus:outline-none" oninput="updateLivePreview()">
                    </div>
                    <div class="space-y-1">
                        <span class="text-[11px] text-slate-500 font-medium">Mobile Image Path (1:1):</span>
                        <input type="text" id="modal-mobile-image" name="mobile_image" placeholder="uploads/banners/hero-banner-1-mobile.jpg" class="w-full p-2.5 border border-slate-300 rounded-lg font-mono text-[11px] focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                    </div>
                </div>

                <!-- Live Preview Box -->
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                    <span class="text-[10px] font-black uppercase text-slate-400 tracking-wider">Live Preview Poster:</span>
                    <div class="w-full h-32 bg-slate-900 rounded-lg overflow-hidden flex items-center justify-center relative">
                        <img id="modal-preview-img" src="<?php echo base_url('uploads/banners/hero-banner-1.jpg'); ?>" alt="Preview" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <!-- 2. Pengaturan Konten & Teks Promosi -->
            <div class="space-y-3 pt-2 border-t border-slate-100">
                <div class="space-y-1">
                    <label for="modal-title" class="font-bold text-slate-700 block">Judul Internal Promo *</label>
                    <input type="text" id="modal-title" name="title" required placeholder="Contoh: The Ultimate Sneaker Collection" class="w-full p-2.5 border border-slate-300 rounded-lg font-bold focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>

                <div class="space-y-1">
                    <label for="modal-headline" class="font-bold text-slate-700 block">Headline Banner (Teks Besar) *</label>
                    <input type="text" id="modal-headline" name="headline" required placeholder="Contoh: SPORT NEXUS: THE ULTIMATE SNEAKER COLLECTION" class="w-full p-2.5 border border-slate-300 rounded-lg font-black uppercase focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>

                <div class="space-y-1">
                    <label for="modal-subheadline" class="font-bold text-slate-700 block">Sub-Headline (Penjelasan Singkat) *</label>
                    <textarea id="modal-subheadline" name="subheadline" rows="2" required placeholder="Temukan siluet ikonik dari Diadora, New Balance, Airwalk, dan Converse..." class="w-full p-2.5 border border-slate-300 rounded-lg font-medium focus:ring-1 focus:ring-[#E5252A] focus:outline-none"></textarea>
                </div>
            </div>

            <!-- 3. Pengaturan Tautan & CTA Button -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 border-t border-slate-100">
                <div class="space-y-1">
                    <label for="modal-cta-label" class="font-bold text-slate-700 block">Label Tombol CTA *</label>
                    <select id="modal-cta-label" name="cta_label" class="w-full p-2.5 border border-slate-300 rounded-lg bg-white font-bold focus:ring-1 focus:ring-[#E5252A]">
                        <option value="Beli Sekarang">Beli Sekarang</option>
                        <option value="Jelajahi Sekarang">Jelajahi Sekarang</option>
                        <option value="Lihat Koleksi">Lihat Koleksi</option>
                        <option value="Shop Collection">Shop Collection</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label for="modal-target-brand" class="font-bold text-slate-700 block">Target Brand</label>
                    <select id="modal-target-brand" name="target_brand" class="w-full p-2.5 border border-slate-300 rounded-lg bg-white font-medium focus:ring-1 focus:ring-[#E5252A]" onchange="onTargetBrandChange(this.value)">
                        <option value="All">Semua Brand (All)</option>
                        <option value="Diadora">Diadora</option>
                        <option value="New Balance">New Balance</option>
                        <option value="Airwalk">Airwalk</option>
                        <option value="Converse">Converse</option>
                        <option value="Nike">Nike</option>
                        <option value="Puma">Puma</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label for="modal-cta-link" class="font-bold text-slate-700 block">Target URL (Rute) *</label>
                    <input type="text" id="modal-cta-link" name="cta_link" required value="brands.html" class="w-full p-2.5 border border-slate-300 rounded-lg font-mono text-[11px] font-bold focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
            </div>

            <!-- 4. Penjadwalan & Visibilitas -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 border-t border-slate-100">
                <div class="space-y-1">
                    <label for="modal-sort-order" class="font-bold text-slate-700 block">Urutan Slide (1-5) *</label>
                    <input type="number" id="modal-sort-order" name="sort_order" min="1" max="10" value="1" required class="w-full p-2.5 border border-slate-300 rounded-lg font-bold text-center focus:ring-1 focus:ring-[#E5252A]">
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label class="font-bold text-slate-700 block">Status Publikasi</label>
                    <div class="flex items-center space-x-4 pt-2">
                        <label class="flex items-center space-x-1.5 cursor-pointer font-bold text-slate-800">
                            <input type="radio" name="is_published" id="modal-pub-1" value="1" checked class="text-[#E5252A] focus:ring-[#E5252A]">
                            <span>Published (Aktif)</span>
                        </label>
                        <label class="flex items-center space-x-1.5 cursor-pointer font-medium text-slate-600">
                            <input type="radio" name="is_published" id="modal-pub-0" value="0" class="text-[#E5252A] focus:ring-[#E5252A]">
                            <span>Draft (Sembunyikan)</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-3 pt-3 border-t border-slate-200">
                <button type="button" onclick="closeBannerModal()" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="w-1/2 bg-[#E5252A] hover:bg-[#c41c21] text-white font-bold py-2.5 rounded-xl shadow transition-colors">
                    Simpan Poster Banner
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Image Preview Modal -->
<div id="preview-image-modal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md hidden flex items-center justify-center p-4">
    <div class="max-w-3xl w-full bg-slate-900 rounded-2xl overflow-hidden p-4 space-y-3 border border-slate-700">
        <div class="flex items-center justify-between text-white">
            <h5 id="preview-title" class="font-bold text-xs uppercase tracking-wider">Poster Banner</h5>
            <button type="button" onclick="closePreviewModal()" class="text-slate-400 hover:text-white font-black text-xl">&times;</button>
        </div>
        <div class="w-full aspect-video bg-black rounded-xl overflow-hidden flex items-center justify-center">
            <img id="preview-full-img" src="" alt="Banner Preview" class="w-full h-full object-contain">
        </div>
    </div>
</div>

<script>
function openNewBannerModal() {
    document.getElementById('form-banner').reset();
    document.getElementById('modal-banner-id').value = '';
    document.getElementById('banner-modal-title').textContent = 'Tambah Poster Banner Baru';
    document.getElementById('modal-desktop-image').value = 'uploads/banners/hero-banner-1.jpg';
    document.getElementById('modal-preview-img').src = '<?php echo base_url("uploads/banners/hero-banner-1.jpg"); ?>';
    document.getElementById('modal-sort-order').value = <?php echo count($banners) + 1; ?>;
    document.getElementById('banner-modal').classList.remove('hidden');
}

function openEditBannerModal(b) {
    document.getElementById('modal-banner-id').value = b.id;
    document.getElementById('banner-modal-title').textContent = 'Edit Poster: ' + b.title;
    document.getElementById('modal-title').value = b.title;
    document.getElementById('modal-headline').value = b.headline;
    document.getElementById('modal-subheadline').value = b.subheadline;
    document.getElementById('modal-desktop-image').value = b.desktop_image;
    document.getElementById('modal-mobile-image').value = b.mobile_image || '';
    document.getElementById('modal-cta-label').value = b.cta_label || 'Beli Sekarang';
    document.getElementById('modal-target-brand').value = b.target_brand || 'All';
    document.getElementById('modal-cta-link').value = b.cta_link || 'brands.html';
    document.getElementById('modal-sort-order').value = b.sort_order;
    if (b.is_published == 1) {
        document.getElementById('modal-pub-1').checked = true;
    } else {
        document.getElementById('modal-pub-0').checked = true;
    }
    document.getElementById('modal-preview-img').src = '<?php echo base_url(); ?>' + b.desktop_image;
    document.getElementById('banner-modal').classList.remove('hidden');
}

function closeBannerModal() {
    document.getElementById('banner-modal').classList.add('hidden');
}

function updateLivePreview() {
    const val = document.getElementById('modal-desktop-image').value;
    if (val) {
        document.getElementById('modal-preview-img').src = val.startsWith('http') ? val : '<?php echo base_url(); ?>' + val;
    }
}

function onTargetBrandChange(brand) {
    const linkInput = document.getElementById('modal-cta-link');
    if (brand === 'All') {
        linkInput.value = 'brands.html';
    } else {
        linkInput.value = 'brands/' + brand.toLowerCase().replace(/\s+/g, '-');
    }
}

function previewBanner(imgUrl, title) {
    document.getElementById('preview-title').textContent = title;
    document.getElementById('preview-full-img').src = imgUrl;
    document.getElementById('preview-image-modal').classList.remove('hidden');
}

function closePreviewModal() {
    document.getElementById('preview-image-modal').classList.add('hidden');
}

function deleteBanner(id, title) {
    if (confirm('Apakah Anda yakin ingin menghapus banner "' + title + '"?')) {
        fetch('<?php echo base_url("admin/banners/delete/"); ?>' + id, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                window.location.reload();
            } else {
                alert(data.message || 'Gagal menghapus banner');
            }
        });
    }
}

function saveSliderSettings() {
    const interval = document.getElementById('slider-interval').value;
    const trans = document.getElementById('slider-transition').value;
    const pause = document.getElementById('slider-pause-hover').checked;
    localStorage.setItem('sportnexus_slider_interval', interval);
    localStorage.setItem('sportnexus_slider_transition', trans);
    localStorage.setItem('sportnexus_slider_pause', pause);
    alert('Pengaturan Global Slider berhasil disimpan!');
}

document.addEventListener('DOMContentLoaded', function () {
    // Form Banner Submit
    const formB = document.getElementById('form-banner');
    if (formB) {
        formB.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(formB);
            fetch('<?php echo base_url("admin/banners/save"); ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                closeBannerModal();
                if (data.status === 'success') {
                    window.location.reload();
                } else {
                    alert(data.message || 'Gagal menyimpan banner');
                }
            });
        });
    }

    // Toggle status
    document.querySelectorAll('.btn-toggle-banner').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            fetch('<?php echo base_url("admin/dashboard/toggle_banner/"); ?>' + id, {
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
