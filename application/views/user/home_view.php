<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - HOMEPAGE VIEW
     Inspired by Sports Station Footwear Experience
     ========================================================================= -->

<div class="space-y-12 pb-16">

    <!-- 1. HERO BANNER CAROUSEL -->
    <section class="relative overflow-hidden bg-slate-900 group" id="hero-carousel">
        <div class="relative w-full h-[320px] sm:h-[460px] md:h-[540px] lg:h-[600px] overflow-hidden">
            <?php if (!empty($hero_banners)): ?>
                <?php foreach ($hero_banners as $idx => $banner): 
                    $b_img = !empty($banner->desktop_image) ? $banner->desktop_image : (!empty($banner->image_url) ? $banner->image_url : 'uploads/banners/hero-banner-1.jpg');
                    $b_title = !empty($banner->headline) ? $banner->headline : (!empty($banner->title) ? $banner->title : 'SPORT NEXUS FOOTWEAR');
                    $b_sub = !empty($banner->subheadline) ? $banner->subheadline : (!empty($banner->subtitle) ? $banner->subtitle : '');
                    $b_link = !empty($banner->cta_link) ? $banner->cta_link : 'brands.html';
                    $b_cta = !empty($banner->cta_label) ? $banner->cta_label : (!empty($banner->cta_text) ? $banner->cta_text : 'Beli Sekarang');
                ?>
                    <div class="carousel-slide absolute inset-0 transition-opacity duration-700 ease-in-out <?php echo $idx === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none'; ?>" data-slide-index="<?php echo $idx; ?>">
                        <img src="<?php echo base_url($b_img); ?>" alt="<?php echo htmlspecialchars($b_title); ?>" class="w-full h-full object-cover object-center transform scale-100 group-hover:scale-105 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/30 to-transparent flex items-end">
                            <div class="max-w-7xl mx-auto w-full px-6 sm:px-10 pb-12 sm:pb-16 text-white space-y-3">
                                <?php if (!empty($b_title)): ?>
                                    <span class="inline-block px-3 py-1 bg-[#E5252A] text-white text-xs font-bold uppercase tracking-wider rounded">Official Footwear 2026</span>
                                    <h2 class="text-2xl sm:text-4xl md:text-5xl font-black italic tracking-wide uppercase drop-shadow-lg">
                                        <?php echo htmlspecialchars($b_title); ?>
                                    </h2>
                                <?php endif; ?>
                                <?php if (!empty($b_sub)): ?>
                                    <p class="text-sm sm:text-base text-slate-200 max-w-xl font-medium drop-shadow">
                                        <?php echo htmlspecialchars($b_sub); ?>
                                    </p>
                                <?php endif; ?>
                                <?php if (!empty($b_link)): ?>
                                    <div class="pt-2">
                                        <a href="<?php echo base_url($b_link); ?>" class="inline-flex items-center space-x-2 bg-[#E5252A] hover:bg-[#c41c21] text-white px-7 py-3 rounded-md font-extrabold text-sm uppercase tracking-wider shadow-lg hover:shadow-red-500/30 transition-all">
                                            <span><?php echo htmlspecialchars($b_cta); ?></span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback slide -->
                <div class="w-full h-full bg-[#1E2229] flex items-center justify-center text-white">
                    <div class="text-center space-y-3">
                        <h2 class="text-3xl font-black">CURATED FOOTWEAR EXPERIENCE</h2>
                        <p class="text-slate-400">Diadora, New Balance, Airwalk, Converse, Nike, Puma</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Carousel Navigation Controls -->
        <button id="carousel-prev" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 bg-black/40 hover:bg-[#E5252A] text-white rounded-full flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 shadow-lg" aria-label="Previous Slide">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button id="carousel-next" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 bg-black/40 hover:bg-[#E5252A] text-white rounded-full flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 shadow-lg" aria-label="Next Slide">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </button>

        <!-- Carousel Dots -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex items-center space-x-2" id="carousel-dots">
            <?php if (!empty($hero_banners)): ?>
                <?php foreach ($hero_banners as $idx => $banner): ?>
                    <button class="carousel-dot w-3 h-3 rounded-full transition-all <?php echo $idx === 0 ? 'bg-[#E5252A] w-8' : 'bg-white/50 hover:bg-white'; ?>" data-slide="<?php echo $idx; ?>" aria-label="Slide <?php echo $idx + 1; ?>"></button>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- 2. INFINITE MARQUEE BAR -->
    <section class="border-y border-slate-200 bg-white py-4 shadow-sm overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
            <div class="flex-shrink-0 mr-6">
                <a href="<?php echo base_url('brands.html'); ?>" class="inline-flex items-center space-x-1 text-xs font-black uppercase text-slate-700 hover:text-[#E5252A] tracking-wider transition-colors">
                    <span>SEE ALL BRANDS</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Animated Marquee Track -->
            <div class="marquee-wrapper flex-grow overflow-hidden relative">
                <div class="marquee-track flex items-center space-x-12 animate-marquee whitespace-nowrap">
                    <?php 
                    $marquee_brands = array(
                        array('name' => 'DIADORA', 'slug' => 'diadora', 'quota' => '500'),
                        array('name' => 'NEW BALANCE', 'slug' => 'new-balance', 'quota' => '200'),
                        array('name' => 'AIRWALK', 'slug' => 'airwalk', 'quota' => '400'),
                        array('name' => 'CONVERSE', 'slug' => 'converse', 'quota' => '240'),
                        array('name' => 'NIKE', 'slug' => 'nike', 'quota' => '121'),
                        array('name' => 'PUMA', 'slug' => 'puma', 'quota' => '82'),
                        // Duplicate for smooth seamless loop
                        array('name' => 'DIADORA', 'slug' => 'diadora', 'quota' => '500'),
                        array('name' => 'NEW BALANCE', 'slug' => 'new-balance', 'quota' => '200'),
                        array('name' => 'AIRWALK', 'slug' => 'airwalk', 'quota' => '400'),
                        array('name' => 'CONVERSE', 'slug' => 'converse', 'quota' => '240'),
                        array('name' => 'NIKE', 'slug' => 'nike', 'quota' => '121'),
                        array('name' => 'PUMA', 'slug' => 'puma', 'quota' => '82')
                    );
                    foreach ($marquee_brands as $mb): ?>
                        <a href="<?php echo base_url('brands/' . $mb['slug']); ?>" class="inline-flex items-center space-x-2 text-sm font-black italic tracking-widest text-slate-800 hover:text-[#E5252A] transition-colors">
                            <span class="w-2 h-2 rounded-full bg-[#E5252A]"></span>
                            <span><?php echo $mb['name']; ?></span>
                            <span class="text-[11px] font-semibold text-slate-400 not-italic">(<?php echo $mb['quota']; ?>)</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. BRAND SHOWCASE TILES -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl sm:text-2xl font-black uppercase tracking-tight text-slate-900">Official Brand Footwear</h3>
                <p class="text-xs sm:text-sm text-slate-500">Koleksi sepatu resmi dengan garansi keaslian 100%</p>
            </div>
            <a href="<?php echo base_url('brands.html'); ?>" class="text-xs font-bold text-[#E5252A] hover:underline flex items-center space-x-1">
                <span>Lihat Semua Brand</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <?php
            $brand_cards = array(
                array('name' => 'Diadora', 'slug' => 'diadora', 'quota' => '500 Pasang', 'color' => 'hover:border-red-500', 'logo' => 'assets/images/brands/diadora.svg'),
                array('name' => 'New Balance', 'slug' => 'new-balance', 'quota' => '200 Pasang', 'color' => 'hover:border-red-500', 'logo' => 'assets/images/brands/new-balance.svg'),
                array('name' => 'Airwalk', 'slug' => 'airwalk', 'quota' => '400 Pasang', 'color' => 'hover:border-red-500', 'logo' => 'assets/images/brands/airwalk.svg'),
                array('name' => 'Converse', 'slug' => 'converse', 'quota' => '240 Pasang', 'color' => 'hover:border-red-500', 'logo' => 'assets/images/brands/converse.svg'),
                array('name' => 'Nike', 'slug' => 'nike', 'quota' => '121 Pasang', 'color' => 'hover:border-red-500', 'logo' => 'assets/images/brands/nike.svg'),
                array('name' => 'Puma', 'slug' => 'puma', 'quota' => '82 Pasang', 'color' => 'hover:border-red-500', 'logo' => 'assets/images/brands/puma.svg')
            );
            foreach ($brand_cards as $bc): ?>
                <a href="<?php echo base_url('brands/' . $bc['slug']); ?>" class="bg-white rounded-xl p-5 border border-slate-200 hover:shadow-lg <?php echo $bc['color']; ?> transition-all flex flex-col items-center justify-center text-center group">
                    <div class="h-12 w-28 flex items-center justify-center mb-3">
                        <img src="<?php echo base_url($bc['logo']); ?>" alt="<?php echo $bc['name']; ?>" class="max-h-8 max-w-full object-contain filter grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-300">
                    </div>
                    <span class="text-sm font-black text-slate-800 group-hover:text-[#E5252A] transition-colors"><?php echo $bc['name']; ?></span>
                    <span class="text-[11px] text-slate-400 mt-0.5"><?php echo $bc['quota']; ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 4. FEATURED FOOTWEAR CARDS -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <span class="text-xs font-bold text-[#E5252A] uppercase tracking-wider">Paling Diminati</span>
                <h3 class="text-xl sm:text-2xl font-black uppercase tracking-tight text-slate-900">Featured Footwear</h3>
            </div>
            <a href="<?php echo base_url('brands.html'); ?>" class="text-xs font-bold text-[#E5252A] hover:underline flex items-center space-x-1">
                <span>Jelajahi Semua Sepatu</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            <?php if (!empty($featured_products)): ?>
                <?php foreach ($featured_products as $p): 
                    $f_img = !empty($p->thumbnail) ? $p->thumbnail : (!empty($p->image_url) ? $p->image_url : base_url('assets/images/placeholder-shoe.png'));
                    $f_sizes = !empty($p->available_sizes) ? $p->available_sizes : '20-46';
                ?>
                    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-xl hover:border-slate-300 transition-all flex flex-col group">
                        <!-- Image & Badges -->
                        <div class="relative bg-slate-100 aspect-square overflow-hidden">
                            <a href="<?php echo base_url('product/' . $p->sku); ?>" class="block w-full h-full">
                                <img src="<?php echo htmlspecialchars($f_img); ?>" alt="<?php echo htmlspecialchars($p->name); ?>" class="w-full h-full object-contain object-center group-hover:scale-105 transition-transform duration-300 p-4">
                            </a>

                            <!-- Discount Badge -->
                            <?php if ($p->discount_percent > 0): ?>
                                <span class="absolute top-2.5 left-2.5 bg-[#E5252A] text-white text-[11px] font-black px-2 py-0.5 rounded shadow">
                                    -<?php echo round($p->discount_percent); ?>%
                                </span>
                            <?php endif; ?>

                            <!-- Sport / Gender Tag -->
                            <span class="absolute bottom-2.5 left-2.5 bg-black/60 backdrop-blur-sm text-white text-[10px] font-semibold px-2 py-0.5 rounded uppercase">
                                <?php echo htmlspecialchars($p->gender); ?> • <?php echo htmlspecialchars($p->primary_sport); ?>
                            </span>
                        </div>

                        <!-- Product Info -->
                        <div class="p-4 flex flex-col flex-grow justify-between space-y-2">
                            <div>
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider"><?php echo htmlspecialchars($p->brand_name); ?></span>
                                <h4 class="font-bold text-sm text-slate-900 group-hover:text-[#E5252A] transition-colors line-clamp-2 mt-0.5">
                                    <a href="<?php echo base_url('product/' . $p->sku); ?>">
                                        <?php echo htmlspecialchars($p->name); ?>
                                    </a>
                                </h4>
                            </div>

                            <div class="pt-2 border-t border-slate-100">
                                <div class="flex items-baseline space-x-2">
                                    <span class="text-base font-black text-slate-900">
                                        Rp <?php echo number_format($p->sale_price, 0, ',', '.'); ?>
                                    </span>
                                    <?php if ($p->discount_percent > 0): ?>
                                        <span class="text-xs text-slate-400 line-through">
                                            Rp <?php echo number_format($p->original_price, 0, ',', '.'); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="text-[11px] text-slate-500 mt-1 flex items-center justify-between">
                                    <span>Tersedia EUR <?php echo htmlspecialchars($f_sizes); ?></span>
                                    <span class="text-emerald-600 font-semibold">Tersedia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- 5. SHOP BY SIZE SECTION (3-COLUMN STATIC GRID AS SPECIFIED IN DOCUMENT) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <div class="text-center max-w-2xl mx-auto mb-8">
                <span class="text-xs font-bold text-[#E5252A] uppercase tracking-wider">Cari Pas Sesuai Ukuran Kaki Anda</span>
                <h3 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900 mt-1">Shop by Size</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Pilih ukuran sepatu yang tepat untuk kenyamanan berolahraga maksimal.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Column 1: MEN (12 Sizes) -->
                <div class="bg-slate-50 rounded-xl p-5 border border-slate-200">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                            <h4 class="font-black text-slate-900 uppercase tracking-wider text-sm">Men's Footwear</h4>
                        </div>
                        <a href="<?php echo base_url('men.html'); ?>" class="text-[11px] font-bold text-[#E5252A] hover:underline">Lihat Semua</a>
                    </div>
                    <div class="grid grid-cols-3 gap-2.5">
                        <?php if (!empty($size_matrix_men)): ?>
                            <?php foreach ($size_matrix_men as $sm): ?>
                                <a href="<?php echo base_url('men.html?size_eu=' . $sm['eu']); ?>" class="bg-white hover:bg-[#E5252A] hover:text-white border border-slate-200 hover:border-[#E5252A] rounded-lg p-2.5 text-center transition-all group shadow-sm">
                                    <div class="text-xs font-bold text-slate-800 group-hover:text-white">US <?php echo $sm['us']; ?></div>
                                    <div class="text-[10px] text-slate-400 group-hover:text-white/80 font-semibold mt-0.5">EU <?php echo $sm['eu']; ?></div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Column 2: WOMEN (12 Sizes) -->
                <div class="bg-slate-50 rounded-xl p-5 border border-slate-200">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                            <h4 class="font-black text-slate-900 uppercase tracking-wider text-sm">Women's Footwear</h4>
                        </div>
                        <a href="<?php echo base_url('women.html'); ?>" class="text-[11px] font-bold text-[#E5252A] hover:underline">Lihat Semua</a>
                    </div>
                    <div class="grid grid-cols-3 gap-2.5">
                        <?php if (!empty($size_matrix_women)): ?>
                            <?php foreach ($size_matrix_women as $sw): ?>
                                <a href="<?php echo base_url('women.html?size_eu=' . $sw['eu']); ?>" class="bg-white hover:bg-[#E5252A] hover:text-white border border-slate-200 hover:border-[#E5252A] rounded-lg p-2.5 text-center transition-all group shadow-sm">
                                    <div class="text-xs font-bold text-slate-800 group-hover:text-white">US <?php echo $sw['us']; ?></div>
                                    <div class="text-[10px] text-slate-400 group-hover:text-white/80 font-semibold mt-0.5">EU <?php echo $sw['eu']; ?></div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Column 3: KIDS (12 Sizes) -->
                <div class="bg-slate-50 rounded-xl p-5 border border-slate-200">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                            <h4 class="font-black text-slate-900 uppercase tracking-wider text-sm">Kids' Footwear</h4>
                        </div>
                        <a href="<?php echo base_url('kids.html'); ?>" class="text-[11px] font-bold text-[#E5252A] hover:underline">Lihat Semua</a>
                    </div>
                    <div class="grid grid-cols-3 gap-2.5">
                        <?php if (!empty($size_matrix_kids)): ?>
                            <?php foreach ($size_matrix_kids as $sk): ?>
                                <a href="<?php echo base_url('kids.html?size_eu=' . $sk['eu']); ?>" class="bg-white hover:bg-[#E5252A] hover:text-white border border-slate-200 hover:border-[#E5252A] rounded-lg p-2.5 text-center transition-all group shadow-sm">
                                    <div class="text-xs font-bold text-slate-800 group-hover:text-white">US <?php echo $sk['us']; ?></div>
                                    <div class="text-[10px] text-slate-400 group-hover:text-white/80 font-semibold mt-0.5">EU <?php echo $sk['eu']; ?></div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. VALUE PROPOSITION PILLARS -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-xl border border-slate-200 flex items-start space-x-3 shadow-sm">
                <div class="w-10 h-10 rounded-lg bg-red-50 text-[#E5252A] flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <h5 class="font-black text-sm text-slate-900">100% Original Guarantee</h5>
                    <p class="text-xs text-slate-500 mt-0.5">Produk resmi berlisensi langsung dari brand terkemuka.</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 flex items-start space-x-3 shadow-sm">
                <div class="w-10 h-10 rounded-lg bg-red-50 text-[#E5252A] flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h5 class="font-black text-sm text-slate-900">Non-Cash Digital Sim</h5>
                    <p class="text-xs text-slate-500 mt-0.5">Simulasi pembayaran instan QRIS, Virtual Account & Kartu Kredit.</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 flex items-start space-x-3 shadow-sm">
                <div class="w-10 h-10 rounded-lg bg-red-50 text-[#E5252A] flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                </div>
                <div>
                    <h5 class="font-black text-sm text-slate-900">Express & Regular Courier</h5>
                    <p class="text-xs text-slate-500 mt-0.5">Pengiriman cepat ke seluruh Indonesia dengan nomor resi aktif.</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 flex items-start space-x-3 shadow-sm">
                <div class="w-10 h-10 rounded-lg bg-red-50 text-[#E5252A] flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                </div>
                <div>
                    <h5 class="font-black text-sm text-slate-900">Bekasi & Karawang Stores</h5>
                    <p class="text-xs text-slate-500 mt-0.5">4 gerai resmi di Grand Metropolitan, Summarecon, KCP & Grand Outlet.</p>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- Carousel & Marquee Interactive Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.carousel-dot');
    const prevBtn = document.getElementById('carousel-prev');
    const nextBtn = document.getElementById('carousel-next');
    let currentIndex = 0;
    let timer = null;

    function showSlide(index) {
        if (!slides.length) return;
        if (index >= slides.length) index = 0;
        if (index < 0) index = slides.length - 1;
        currentIndex = index;

        slides.forEach((s, idx) => {
            if (idx === currentIndex) {
                s.classList.remove('opacity-0', 'z-0', 'pointer-events-none');
                s.classList.add('opacity-100', 'z-10');
            } else {
                s.classList.add('opacity-0', 'z-0', 'pointer-events-none');
                s.classList.remove('opacity-100', 'z-10');
            }
        });

        dots.forEach((d, idx) => {
            if (idx === currentIndex) {
                d.classList.add('bg-[#E5252A]', 'w-8');
                d.classList.remove('bg-white/50', 'w-3');
            } else {
                d.classList.remove('bg-[#E5252A]', 'w-8');
                d.classList.add('bg-white/50', 'w-3');
            }
        });
    }

    function startAutoPlay() {
        stopAutoPlay();
        timer = setInterval(() => {
            showSlide(currentIndex + 1);
        }, 5000);
    }

    function stopAutoPlay() {
        if (timer) clearInterval(timer);
    }

    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
            showSlide(currentIndex - 1);
            startAutoPlay();
        });
        nextBtn.addEventListener('click', () => {
            showSlide(currentIndex + 1);
            startAutoPlay();
        });
    }

    dots.forEach(d => {
        d.addEventListener('click', (e) => {
            const idx = parseInt(e.target.dataset.slide);
            showSlide(idx);
            startAutoPlay();
        });
    });

    const carouselEl = document.getElementById('hero-carousel');
    if (carouselEl) {
        carouselEl.addEventListener('mouseenter', stopAutoPlay);
        carouselEl.addEventListener('mouseleave', startAutoPlay);
    }

    startAutoPlay();
});
</script>
