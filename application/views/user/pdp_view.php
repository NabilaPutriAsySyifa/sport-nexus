<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - PRODUCT DETAIL PAGE (PDP)
     Interactive Sizing Matrix & Strict Footwear Validation
     ========================================================================= -->

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-6">
        <a href="<?php echo base_url(); ?>" class="hover:text-[#E5252A]">Home</a>
        <span>/</span>
        <a href="<?php echo base_url('brands.html?brand=' . urlencode($product->brand_name)); ?>" class="hover:text-[#E5252A]">
            <?php echo htmlspecialchars($product->brand_name); ?>
        </a>
        <span>/</span>
        <span class="text-slate-800 font-bold truncate max-w-xs"><?php echo htmlspecialchars($product->name); ?></span>
    </nav>

    <!-- Main PDP Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">

        <!-- 1. Left Gallery (Col 7) -->
        <div class="lg:col-span-7 space-y-4">
            <!-- Main Featured Image -->
            <?php 
            $main_img = !empty($product->thumbnail) ? $product->thumbnail : (!empty($product->image_url) ? $product->image_url : base_url('assets/images/placeholder-shoe.png'));
            ?>
            <div class="relative bg-slate-100 rounded-2xl overflow-hidden aspect-square flex items-center justify-center border border-slate-200/80 group">
                <img id="pdp-main-image" src="<?php echo htmlspecialchars($main_img); ?>" alt="<?php echo htmlspecialchars($product->name); ?>" class="w-full h-full object-contain p-6 group-hover:scale-105 transition-transform duration-300">

                <!-- Discount Badge -->
                <?php if ($product->discount_percent > 0): ?>
                    <span class="absolute top-4 left-4 bg-[#E5252A] text-white text-xs font-black px-3 py-1 rounded-md shadow-md">
                        HEMAT <?php echo round($product->discount_percent); ?>%
                    </span>
                <?php endif; ?>

                <!-- 100% Original Badge -->
                <span class="absolute top-4 right-4 bg-slate-900/80 backdrop-blur-sm text-white text-[11px] font-bold px-3 py-1 rounded-md flex items-center space-x-1.5 shadow">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>100% Original</span>
                </span>
            </div>

            <!-- Gallery Thumbnails -->
            <?php 
            $gallery = array();
            if (!empty($main_img)) $gallery[] = $main_img;
            if (!empty($product->images)) {
                $decoded = is_array($product->images) ? $product->images : json_decode($product->images, true);
                if (is_array($decoded)) {
                    foreach ($decoded as $img) {
                        if (!in_array($img, $gallery)) $gallery[] = $img;
                    }
                }
            }
            if (!empty($product->gallery_images)) {
                $decoded = is_array($product->gallery_images) ? $product->gallery_images : json_decode($product->gallery_images, true);
                if (is_array($decoded)) {
                    foreach ($decoded as $img) {
                        if (!in_array($img, $gallery)) $gallery[] = $img;
                    }
                }
            }
            if (count($gallery) > 1): ?>
                <div class="flex items-center space-x-3 overflow-x-auto pb-2">
                    <?php foreach ($gallery as $gidx => $img_url): ?>
                        <button type="button" class="gallery-thumb flex-shrink-0 w-20 h-20 rounded-xl bg-slate-50 border-2 transition-all p-2 overflow-hidden <?php echo $gidx === 0 ? 'border-[#E5252A]' : 'border-slate-200 hover:border-slate-300'; ?>" data-image-src="<?php echo htmlspecialchars($img_url); ?>">
                            <img src="<?php echo htmlspecialchars($img_url); ?>" alt="Thumbnail" class="w-full h-full object-contain">
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- 2. Right Product Info & Add to Cart (Col 5) -->
        <div class="lg:col-span-5 flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <!-- Brand & Tags -->
                <div class="flex items-center space-x-2">
                    <a href="<?php echo base_url('brands.html?brand=' . urlencode($product->brand_name)); ?>" class="text-xs font-black uppercase tracking-wider text-[#E5252A] bg-red-50 px-2.5 py-1 rounded">
                        <?php echo htmlspecialchars($product->brand_name); ?>
                    </a>
                    <span class="text-xs font-semibold text-slate-400">•</span>
                    <span class="text-xs font-semibold text-slate-500 uppercase"><?php echo htmlspecialchars($product->gender); ?></span>
                    <span class="text-xs font-semibold text-slate-400">•</span>
                    <span class="text-xs font-semibold text-slate-500 uppercase"><?php echo htmlspecialchars($product->primary_sport); ?></span>
                </div>

                <!-- Product Title -->
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight">
                    <?php echo htmlspecialchars($product->name); ?>
                </h1>

                <!-- SKU & Rating -->
                <div class="flex items-center space-x-4 text-xs text-slate-500 pb-3 border-b border-slate-100">
                    <div>SKU: <strong class="text-slate-800"><?php echo htmlspecialchars($product->sku); ?></strong></div>
                    <div class="flex items-center space-x-1 text-amber-500">
                        <span>★ ★ ★ ★ ★</span>
                        <span class="text-slate-400">(4.9/5)</span>
                    </div>
                </div>

                <!-- Pricing Display -->
                <div class="space-y-1">
                    <div class="flex items-baseline space-x-3">
                        <span class="text-3xl font-black text-slate-900">
                            Rp <?php echo number_format($product->sale_price, 0, ',', '.'); ?>
                        </span>
                        <?php if ($product->discount_percent > 0): ?>
                            <span class="text-base text-slate-400 line-through">
                                Rp <?php echo number_format($product->original_price, 0, ',', '.'); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <?php if ($product->discount_percent > 0): ?>
                        <p class="text-xs text-emerald-600 font-bold">Hemat Rp <?php echo number_format($product->original_price - $product->sale_price, 0, ',', '.'); ?> dari harga retail!</p>
                    <?php endif; ?>
                </div>

                <!-- Color Selection -->
                <div class="space-y-2 pt-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-slate-800">Warna:</span>
                        <span id="selected-color-label" class="font-semibold text-slate-600"><?php echo htmlspecialchars($product->color ?: 'Standard'); ?></span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="button" class="color-pill px-3.5 py-1.5 rounded-lg border-2 border-[#E5252A] bg-red-50 text-xs font-bold text-slate-900 shadow-sm" data-color="<?php echo htmlspecialchars($product->color ?: 'Standard'); ?>">
                            <?php echo htmlspecialchars($product->color ?: 'Standard'); ?>
                        </button>
                    </div>
                </div>

                <!-- Interactive Size Selector Pills (EUR 20 - 46) -->
                <div class="space-y-2 pt-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-slate-800">Pilih Ukuran (EUR):</span>
                        <a href="#size-guide" onclick="openSizeGuideModal()" class="text-[#E5252A] font-bold hover:underline flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            <span>Panduan Ukuran</span>
                        </a>
                    </div>

                    <!-- Size Matrix Grid -->
                    <div class="grid grid-cols-4 sm:grid-cols-5 gap-2" id="size-matrix-container">
                        <?php if (!empty($product->skus)): ?>
                            <?php foreach ($product->skus as $sku_item): 
                                $is_oos = ($sku_item->stock_qty <= 0);
                                $is_low = ($sku_item->stock_qty > 0 && $sku_item->stock_qty <= 5);
                            ?>
                                <button type="button" 
                                    class="size-pill relative py-2.5 px-2 rounded-xl text-center border-2 transition-all <?php 
                                        if ($is_oos) {
                                            echo 'bg-slate-100 border-slate-200 text-slate-300 cursor-not-allowed';
                                        } else {
                                            echo 'bg-white border-slate-200 text-slate-800 hover:border-slate-400 hover:bg-slate-50 cursor-pointer shadow-sm';
                                        }
                                    ?>" 
                                    data-size-eu="<?php echo htmlspecialchars($sku_item->size_eu); ?>" 
                                    data-size-us="<?php echo htmlspecialchars($sku_item->size_us); ?>" 
                                    data-stock="<?php echo $sku_item->stock_qty; ?>"
                                    <?php echo $is_oos ? 'disabled' : ''; ?>>
                                    <div class="text-xs font-black">EUR <?php echo htmlspecialchars($sku_item->size_eu); ?></div>
                                    <div class="text-[10px] text-slate-400 font-semibold">US <?php echo htmlspecialchars($sku_item->size_us ?: '-'); ?></div>

                                    <?php if ($is_low): ?>
                                        <span class="absolute -top-1.5 -right-1.5 bg-amber-500 text-white text-[9px] font-black px-1.5 py-0.2 rounded-full shadow">
                                            Sisa <?php echo $sku_item->stock_qty; ?>
                                        </span>
                                    <?php elseif ($is_oos): ?>
                                        <span class="absolute -top-1.5 -right-1.5 bg-slate-400 text-white text-[8px] font-bold px-1 rounded">
                                            Habis
                                        </span>
                                    <?php endif; ?>
                                </button>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-span-4 text-xs text-slate-400">Varian ukuran sedang disiapkan.</div>
                        <?php endif; ?>
                    </div>
                    <div id="size-error-msg" class="hidden text-xs text-red-600 font-bold flex items-center space-x-1 pt-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>Silakan pilih ukuran sepatu terlebih dahulu!</span>
                    </div>
                </div>

                <!-- Quantity Selector -->
                <div class="space-y-2 pt-2">
                    <span class="text-xs font-bold text-slate-800">Jumlah:</span>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden bg-white shadow-sm">
                            <button type="button" id="qty-minus" class="w-9 h-9 flex items-center justify-center text-slate-600 hover:bg-slate-100 font-bold transition-colors">-</button>
                            <input type="number" id="pdp-qty" value="1" min="1" max="10" readonly class="w-12 text-center text-xs font-black text-slate-800 focus:outline-none">
                            <button type="button" id="qty-plus" class="w-9 h-9 flex items-center justify-center text-slate-600 hover:bg-slate-100 font-bold transition-colors">+</button>
                        </div>
                        <span id="stock-feedback" class="text-xs text-slate-400 font-medium">Pilih ukuran untuk melihat ketersediaan</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons (Add to Cart & Buy Now) -->
            <div class="space-y-2.5 pt-4 border-t border-slate-100">
                <input type="hidden" id="pdp-product-id" value="<?php echo $product->id; ?>">
                <input type="hidden" id="pdp-selected-size" value="">
                <input type="hidden" id="pdp-selected-color" value="<?php echo htmlspecialchars($product->color ?: 'Standard'); ?>">

                <!-- Primary: Tambah ke Keranjang -->
                <button type="button" id="btn-add-to-cart" class="w-full bg-[#E5252A] hover:bg-[#c41c21] text-white py-3.5 px-6 rounded-xl font-black text-sm uppercase tracking-wider flex items-center justify-center space-x-2 shadow-lg hover:shadow-red-500/25 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span>Tambah ke Keranjang</span>
                </button>

                <!-- Secondary: Beli Sekarang -->
                <button type="button" id="btn-buy-now" class="w-full bg-[#1E2229] hover:bg-[#2D333D] text-white py-3 px-6 rounded-xl font-bold text-xs uppercase tracking-wider transition-colors shadow flex items-center justify-center space-x-1.5">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span>Beli Sekarang (Langsung Checkout)</span>
                </button>
            </div>

            <!-- Mandatory Account Notice Badge -->
            <div class="flex items-center space-x-2 text-[11px] text-slate-600 bg-slate-50 border border-slate-200/90 rounded-xl p-2.5">
                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span><strong>Ketentuan Resmi:</strong> Pembelian & pembayaran wajib masuk akun terdaftar untuk verifikasi transaksi resmi.</span>
            </div>

            <!-- Assurance Perks -->
            <div class="grid grid-cols-2 gap-2 pt-3 text-[11px] text-slate-500 border-t border-slate-100">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>100% Produk Original</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Gratis Ongkir Seluruh RI</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Non-Cash Digital Sim</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Gerai Resmi Terverifikasi</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Product Description & Specs Accordion -->
    <div class="mt-10 bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
        <div class="border-b border-slate-200 pb-4">
            <h3 class="text-lg font-black uppercase tracking-tight text-slate-900">Deskripsi & Spesifikasi Produk</h3>
        </div>
        <div class="prose max-w-none text-xs sm:text-sm text-slate-600 leading-relaxed space-y-3">
            <p><?php echo nl2br(htmlspecialchars($product->description ?: 'Sepatu olahraga berkualitas tinggi yang didesain khusus untuk mendukung performa dan gaya harian Anda.')); ?></p>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 pt-4">
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <span class="text-xs text-slate-400 block font-semibold uppercase">Brand</span>
                    <strong class="text-slate-800 text-sm"><?php echo htmlspecialchars($product->brand_name); ?></strong>
                </div>
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <span class="text-xs text-slate-400 block font-semibold uppercase">Kategori / Gender</span>
                    <strong class="text-slate-800 text-sm"><?php echo htmlspecialchars($product->gender); ?></strong>
                </div>
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <span class="text-xs text-slate-400 block font-semibold uppercase">Aktivitas Utama</span>
                    <strong class="text-slate-800 text-sm"><?php echo htmlspecialchars($product->primary_sport); ?></strong>
                </div>
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <span class="text-xs text-slate-400 block font-semibold uppercase">Tipe Sepatu</span>
                    <strong class="text-slate-800 text-sm"><?php echo htmlspecialchars($product->footwear_type); ?></strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Footwear Carousel/Grid -->
    <?php if (!empty($related_products)): ?>
        <div class="mt-12 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-black uppercase tracking-tight text-slate-900">Koleksi Terkait dari <?php echo htmlspecialchars($product->brand_name); ?></h3>
                    <p class="text-xs text-slate-500">Pilihan sepatu lainnya dengan teknologi serupa</p>
                </div>
                <a href="<?php echo base_url('brands.html?brand=' . urlencode($product->brand_name)); ?>" class="text-xs font-bold text-[#E5252A] hover:underline">Lihat Semua &raquo;</a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
                <?php foreach ($related_products as $rp): 
                    $rp_img = !empty($rp->thumbnail) ? $rp->thumbnail : (!empty($rp->image_url) ? $rp->image_url : base_url('assets/images/placeholder-shoe.png'));
                ?>
                    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all flex flex-col group">
                        <div class="relative bg-slate-100 aspect-square overflow-hidden">
                            <a href="<?php echo base_url('product/' . $rp->sku); ?>">
                                <img src="<?php echo htmlspecialchars($rp_img); ?>" alt="<?php echo htmlspecialchars($rp->name); ?>" class="w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-300">
                            </a>
                        </div>
                        <div class="p-3.5 flex flex-col flex-grow justify-between space-y-1">
                            <h4 class="font-bold text-xs text-slate-900 line-clamp-1 group-hover:text-[#E5252A]">
                                <a href="<?php echo base_url('product/' . $rp->sku); ?>"><?php echo htmlspecialchars($rp->name); ?></a>
                            </h4>
                            <div class="text-xs font-black text-slate-900">
                                Rp <?php echo number_format($rp->sale_price, 0, ',', '.'); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<!-- Interactive Modal: Panduan Ukuran (Size Guide) -->
<div id="size-guide-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
            <h4 class="font-black text-slate-900 uppercase text-sm">Panduan Konversi Ukuran Sepatu</h4>
            <button type="button" onclick="closeSizeGuideModal()" class="text-slate-400 hover:text-slate-700 font-black text-lg">&times;</button>
        </div>
        <p class="text-xs text-slate-500">Standar konversi ukuran sepatu resmi Sport Nexus (EUR, US, dan panjang telapak kaki dalam cm):</p>
        <div class="max-h-72 overflow-y-auto border border-slate-200 rounded-lg text-xs">
            <table class="w-full text-left">
                <thead class="bg-slate-100 text-slate-700 font-bold sticky top-0">
                    <tr>
                        <th class="p-2.5">EUR</th>
                        <th class="p-2.5">US Men</th>
                        <th class="p-2.5">US Women</th>
                        <th class="p-2.5">Panjang (cm)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    <tr><td class="p-2 font-bold">36</td><td>4.5</td><td>6.0</td><td>23.0 cm</td></tr>
                    <tr><td class="p-2 font-bold">37</td><td>5.0</td><td>6.5</td><td>23.5 cm</td></tr>
                    <tr><td class="p-2 font-bold">38</td><td>5.5</td><td>7.0</td><td>24.0 cm</td></tr>
                    <tr><td class="p-2 font-bold">39</td><td>6.5</td><td>8.0</td><td>24.5 cm</td></tr>
                    <tr><td class="p-2 font-bold">40</td><td>7.0</td><td>8.5</td><td>25.0 cm</td></tr>
                    <tr><td class="p-2 font-bold">41</td><td>8.0</td><td>9.5</td><td>26.0 cm</td></tr>
                    <tr><td class="p-2 font-bold">42</td><td>8.5</td><td>10.0</td><td>26.5 cm</td></tr>
                    <tr><td class="p-2 font-bold">43</td><td>9.5</td><td>11.0</td><td>27.5 cm</td></tr>
                    <tr><td class="p-2 font-bold">44</td><td>10.0</td><td>11.5</td><td>28.0 cm</td></tr>
                    <tr><td class="p-2 font-bold">45</td><td>11.0</td><td>12.5</td><td>29.0 cm</td></tr>
                    <tr><td class="p-2 font-bold">46</td><td>12.0</td><td>13.5</td><td>30.0 cm</td></tr>
                </tbody>
            </table>
        </div>
        <button type="button" onclick="closeSizeGuideModal()" class="w-full bg-slate-900 text-white text-xs font-bold py-2.5 rounded-lg">Tutup</button>
    </div>
</div>

<!-- PDP Interactive Client Script -->
<script>
function openSizeGuideModal() {
    document.getElementById('size-guide-modal').classList.remove('hidden');
}
function closeSizeGuideModal() {
    document.getElementById('size-guide-modal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
    // 1. Gallery Thumbnail Switcher
    const thumbs = document.querySelectorAll('.gallery-thumb');
    const mainImg = document.getElementById('pdp-main-image');
    thumbs.forEach(t => {
        t.addEventListener('click', () => {
            thumbs.forEach(other => other.classList.replace('border-[#E5252A]', 'border-slate-200'));
            t.classList.replace('border-slate-200', 'border-[#E5252A]');
            mainImg.src = t.dataset.imageSrc;
        });
    });

    // 2. Size Pill Selector
    const sizePills = document.querySelectorAll('.size-pill:not([disabled])');
    const selectedSizeInput = document.getElementById('pdp-selected-size');
    const sizeErrorMsg = document.getElementById('size-error-msg');
    const stockFeedback = document.getElementById('stock-feedback');

    sizePills.forEach(pill => {
        pill.addEventListener('click', () => {
            sizeErrorMsg.classList.add('hidden');
            sizePills.forEach(p => {
                p.classList.remove('border-[#E5252A]', 'bg-red-50', 'text-[#E5252A]');
                p.classList.add('border-slate-200', 'bg-white', 'text-slate-800');
            });
            pill.classList.remove('border-slate-200', 'bg-white', 'text-slate-800');
            pill.classList.add('border-[#E5252A]', 'bg-red-50', 'text-[#E5252A]');

            const size = pill.dataset.sizeEu;
            const stock = parseInt(pill.dataset.stock) || 0;
            selectedSizeInput.value = size;

            stockFeedback.innerHTML = `<span class="text-emerald-600 font-bold">Tersedia ${stock} pasang</span> (EUR ${size})`;
        });
    });

    // 3. Quantity Controls
    const qtyInput = document.getElementById('pdp-qty');
    const qtyMinus = document.getElementById('qty-minus');
    const qtyPlus = document.getElementById('qty-plus');

    qtyMinus.addEventListener('click', () => {
        let val = parseInt(qtyInput.value) || 1;
        if (val > 1) qtyInput.value = val - 1;
    });

    qtyPlus.addEventListener('click', () => {
        let val = parseInt(qtyInput.value) || 1;
        if (val < 10) qtyInput.value = val + 1;
    });

    // 4. Add to Cart Handler (with strict validation)
    const btnAddToCart = document.getElementById('btn-add-to-cart');
    const btnBuyNow = document.getElementById('btn-buy-now');

    function executeAddToCart(isBuyNow = false) {
        const productId = document.getElementById('pdp-product-id').value;
        const sizeEu = selectedSizeInput.value;
        const color = document.getElementById('pdp-selected-color').value;
        const qty = parseInt(qtyInput.value) || 1;

        if (!sizeEu) {
            sizeErrorMsg.classList.remove('hidden');
            window.showNexusToast('Silakan pilih ukuran sepatu terlebih dahulu.', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('size_eu', sizeEu);
        formData.append('color', color);
        formData.append('qty', qty);

        fetch('<?php echo base_url("cart/add"); ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                window.showNexusToast('✔ Success Add to Cart: ' + qty + ' pasang EUR ' + sizeEu, 'success');

                // Update cart badge in header
                const badge = document.getElementById('header-cart-badge');
                if (badge) {
                    badge.textContent = data.cart_count;
                    badge.style.display = 'inline-flex';
                }

                if (isBuyNow) {
                    <?php if (!$this->session->userdata('user_logged_in')): ?>
                        window.showNexusToast('Sepatu ditambahkan! Anda wajib login akun terlebih dahulu sebelum pembayaran.', 'warning');
                        setTimeout(() => {
                            window.location.href = '<?php echo base_url("signin.html?redirect=checkout.html"); ?>';
                        }, 500);
                    <?php else: ?>
                        window.location.href = '<?php echo base_url("checkout.html"); ?>';
                    <?php endif; ?>
                }
            } else {
                window.showNexusToast(data.message || 'Gagal menambahkan ke keranjang.', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            window.showNexusToast('Terjadi kesalahan jaringan.', 'error');
        });
    }

    btnAddToCart.addEventListener('click', () => executeAddToCart(false));
    btnBuyNow.addEventListener('click', () => executeAddToCart(true));
});
</script>
