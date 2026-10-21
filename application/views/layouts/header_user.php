<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' | Sport Nexus' : 'Sport Nexus - Retail Sepatu Olahraga Resmi'; ?></title>
    <meta name="description" content="Sport Nexus adalah platform e-commerce ritel sepatu independen terkurasi untuk brand Diadora, New Balance, Airwalk, Converse, Nike, dan Puma.">
    <!-- Tailwind CSS v3 compiled output -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/tailwind.output.css'); ?>">
    <!-- Tailwind CDN for JIT styling support -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sport-red': '#E5252A',
                        'sport-red-hover': '#c41c21',
                        'charcoal': '#1E2229',
                        'charcoal-light': '#2D333D',
                        'neutral-slate': '#F8FAFC',
                    }
                }
            }
        }
    </script>
    <style>
        .mega-menu-container {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            width: 100%;
            background: #FFFFFF;
            border-top: 2px solid #E5252A;
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.12);
            z-index: 999;
            animation: fadeInDown 0.2s ease-out;
        }
        .mega-menu-container::before {
            content: '';
            position: absolute;
            top: -15px;
            left: 0;
            right: 0;
            height: 15px;
        }
        .has-mega-menu:hover .mega-menu-container {
            display: block;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

<!-- =========================================================================
     TWO-TIER HEADER SECTION
     Tier 1: Top System Utility Bar (Dark Slate / Charcoal)
     Tier 2: Main Navigation Bar (Clean White)
     ========================================================================= -->
<header class="w-full sticky top-0 z-50 shadow-md">
    <!-- TIER 1: TOP UTILITY BAR (Latar Gelap / Charcoal) -->
    <div class="bg-[#1E2229] text-slate-300 text-xs py-2 px-4 sm:px-8 border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <!-- Store Location (Bekasi & Karawang) -->
                <a href="<?php echo base_url('store-location.html'); ?>" class="flex items-center space-x-1.5 hover:text-[#E5252A] transition-colors">
                    <svg class="w-3.5 h-3.5 text-[#E5252A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span data-i18n="store_location">Store Location</span>
                </a>
            </div>

            <div class="flex items-center space-x-5">
                <!-- User Sign In / Profile -->
                <?php if ($this->session->userdata('user_logged_in')): 
                    $c_name = $this->session->userdata('user_name') ?: 'Customer';
                    $c_words = preg_split('/\s+/', trim($c_name));
                    $c_initials = '';
                    if (count($c_words) >= 2) {
                        $c_initials = strtoupper(mb_substr($c_words[0], 0, 1) . mb_substr($c_words[1], 0, 1));
                    } elseif (count($c_words) === 1 && !empty($c_words[0])) {
                        $c_initials = strtoupper(mb_substr($c_words[0], 0, min(2, mb_strlen($c_words[0]))));
                    } else {
                        $c_initials = 'CU';
                    }
                ?>
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-white font-semibold hover:text-[#E5252A] transition-colors py-0.5">
                            <div class="w-6 h-6 rounded-full bg-[#E5252A] text-white flex items-center justify-center font-black text-[10px] shadow-sm uppercase tracking-wide">
                                <?php echo $c_initials; ?>
                            </div>
                            <span>Hi, <?php echo htmlspecialchars($c_name); ?></span>
                            <svg class="w-3 h-3 text-slate-400 group-hover:text-[#E5252A] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="absolute right-0 mt-1.5 w-48 bg-white text-slate-800 rounded-xl shadow-xl border border-slate-200 py-1.5 hidden group-hover:block z-50 text-xs">
                            <div class="px-3.5 py-2 border-b border-slate-100 flex items-center space-x-2.5">
                                <div class="w-7 h-7 rounded-full bg-[#E5252A] text-white flex items-center justify-center font-black text-[11px] shadow-xs">
                                    <?php echo $c_initials; ?>
                                </div>
                                <div class="truncate">
                                    <div class="font-bold text-slate-900 truncate"><?php echo htmlspecialchars($c_name); ?></div>
                                    <div class="text-[10px] text-slate-400">Akun Pelanggan</div>
                                </div>
                            </div>
                            <a href="<?php echo base_url('cart.html'); ?>" class="block px-3.5 py-2 hover:bg-slate-50 font-medium text-slate-700">Keranjang Belanja</a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <a href="<?php echo base_url('signout'); ?>" class="block px-3.5 py-2 hover:bg-red-50 text-red-600 font-bold">Keluar (Log Out)</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo base_url('signin.html'); ?>" class="flex items-center space-x-1 hover:text-white transition-colors">
                        <span data-i18n="sign_in">Sign In</span>
                    </a>
                <?php endif; ?>

                <span class="text-slate-600">|</span>

                <!-- Language Selector Dropdown -->
                <div class="relative group">
                    <button class="flex items-center space-x-1 hover:text-white transition-colors">
                        <span id="current-lang-label">ID</span>
                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="absolute right-0 mt-1 w-32 bg-white text-slate-800 rounded-md shadow-lg border border-slate-200 py-1 hidden group-hover:block z-50 text-xs">
                        <button onclick="window.setLanguage('id')" class="w-full text-left px-3 py-1.5 hover:bg-slate-100 flex items-center justify-between">
                            <span>Indonesia</span>
                            <span class="text-slate-400 font-bold">ID</span>
                        </button>
                        <button onclick="window.setLanguage('en')" class="w-full text-left px-3 py-1.5 hover:bg-slate-100 flex items-center justify-between">
                            <span>English</span>
                            <span class="text-slate-400 font-bold">EN</span>
                        </button>
                    </div>
                </div>

                <span class="text-slate-600">|</span>

                <!-- Help Dropdown (WhatsApp & Email) -->
                <div class="relative group">
                    <button class="flex items-center space-x-1 hover:text-white transition-colors">
                        <span data-i18n="help">Help</span>
                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="absolute right-0 mt-1 w-64 bg-white text-slate-800 rounded-md shadow-xl border border-slate-200 p-3 hidden group-hover:block z-50">
                        <div class="font-bold text-slate-700 text-xs mb-2 border-b pb-1">Kontak Resmi Sport Nexus</div>
                        <a href="mailto:sportnexusone@gmail.com?subject=Tanya%20Sport%20Nexus" class="flex items-center space-x-2.5 py-2 px-2 hover:bg-slate-50 rounded text-slate-700 hover:text-[#E5252A] transition-colors">
                            <span class="text-base">✉</span>
                            <div>
                                <div class="font-semibold text-[11px]">Email Resmi</div>
                                <div class="text-[10px] text-slate-500">sportnexusone@gmail.com</div>
                            </div>
                        </a>
                        <a href="https://wa.me/6285717372990?text=Halo%20Sport%20Nexus,%20saya%20ingin%20bertanya" target="_blank" rel="noopener noreferrer" class="flex items-center space-x-2.5 py-2 px-2 hover:bg-slate-50 rounded text-slate-700 hover:text-emerald-600 transition-colors">
                            <span class="text-base text-emerald-500">🟢</span>
                            <div>
                                <div class="font-semibold text-[11px]">WhatsApp Resmi</div>
                                <div class="text-[10px] text-slate-500">+62 857-1737-2990</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TIER 2: MAIN NAVIGATION BAR (Latar Putih) -->
    <div class="bg-white border-b border-slate-200 px-4 sm:px-8 relative">
        <div class="max-w-7xl mx-auto flex items-center justify-between h-20">
            <!-- Brand Logo: SPORT NEXUS -->
            <a href="<?php echo base_url(); ?>" class="flex items-center space-x-3 shrink-0">
                <div class="w-10 h-10 rounded-lg bg-[#E5252A] flex items-center justify-center text-white shadow-md shadow-red-500/20">
                    <!-- Silhouette Runner Icon -->
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M13 4a2 2 0 100-4 2 2 0 000 4zM6 14l3-3 3 2 4-6M9 11v6l-4 4M15 13l4 3v5"/>
                    </svg>
                </div>
                <div>
                    <span class="font-black italic text-2xl tracking-tight text-[#1E2229]">SPORT</span>
                    <span class="font-black italic text-2xl tracking-tight text-[#E5252A]">NEXUS</span>
                </div>
            </a>

            <!-- Mega Menu Navigation Links (BRANDS, SPORTS, MEN, WOMEN, KIDS, SALE) -->
            <nav class="hidden lg:flex items-center space-x-8 font-bold text-sm tracking-wide text-slate-700">
                
                <!-- 1. BRANDS MEGA MENU (1.443 SKU) -->
                <div class="py-7 has-mega-menu">
                    <a href="<?php echo base_url('brands.html'); ?>" class="hover:text-[#E5252A] transition-colors py-2 flex items-center space-x-1">
                        <span data-i18n="brands">BRANDS</span>
                        <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <div class="mega-menu-container p-8">
                        <div class="max-w-7xl mx-auto grid grid-cols-4 gap-8">
                            <div>
                                <h4 class="font-black text-xs text-slate-400 uppercase tracking-widest mb-4">A - C</h4>
                                <ul class="space-y-2.5 text-sm font-semibold">
                                    <li><a href="<?php echo base_url('brands/airwalk'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Airwalk</span><span class="text-xs text-slate-400 font-normal">400 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('brands/converse'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Converse</span><span class="text-xs text-slate-400 font-normal">150 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('brands/converse-kids'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Converse Kids</span><span class="text-xs text-slate-400 font-normal">90 SKU</span></a></li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-black text-xs text-slate-400 uppercase tracking-widest mb-4">D - N</h4>
                                <ul class="space-y-2.5 text-sm font-semibold">
                                    <li><a href="<?php echo base_url('brands/diadora'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Diadora</span><span class="text-xs text-slate-400 font-normal">500 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('brands/new-balance'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>New Balance</span><span class="text-xs text-slate-400 font-normal">200 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('brands/nike'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Nike</span><span class="text-xs text-slate-400 font-normal">100 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('brands/nike-young-athletes'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Nike Young Athletes</span><span class="text-xs text-slate-400 font-normal">20 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('brands/nike-golf'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Nike Golf</span><span class="text-xs text-slate-400 font-normal">1 SKU</span></a></li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-black text-xs text-slate-400 uppercase tracking-widest mb-4">P</h4>
                                <ul class="space-y-2.5 text-sm font-semibold">
                                    <li><a href="<?php echo base_url('brands/puma'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Puma</span><span class="text-xs text-slate-400 font-normal">80 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('brands/puma-golf'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Puma Golf</span><span class="text-xs text-slate-400 font-normal">2 SKU</span></a></li>
                                </ul>
                            </div>
                            <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 text-center flex flex-col justify-center items-center">
                                <span class="text-3xl font-black text-[#E5252A] mb-1">1.443</span>
                                <span class="text-xs text-slate-500 font-semibold mb-4">Total Pasang Sepatu Terkurasi</span>
                                <a href="<?php echo base_url('brands.html'); ?>" class="btn-nexus-primary text-xs w-full py-2.5">Lihat Semua Brand</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. SPORTS MEGA MENU (421 SKU) -->
                <div class="py-7 has-mega-menu">
                    <a href="<?php echo base_url('sports.html'); ?>" class="hover:text-[#E5252A] transition-colors py-2 flex items-center space-x-1">
                        <span data-i18n="sports">SPORTS</span>
                        <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <div class="mega-menu-container p-8">
                        <div class="max-w-4xl mx-auto grid grid-cols-3 gap-8">
                            <div>
                                <h4 class="font-black text-xs text-slate-400 uppercase tracking-widest mb-4">Running & Fitness</h4>
                                <ul class="space-y-2.5 text-sm font-semibold">
                                    <li><a href="<?php echo base_url('sports.html?activity=Running'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Running</span><span class="text-xs text-slate-400 font-normal">812 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('sports.html?activity=Lifestyle'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Lifestyle & Athleisure</span><span class="text-xs text-slate-400 font-normal">143 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('sports.html?activity=Fitness'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Fitness & Gym</span><span class="text-xs text-slate-400 font-normal">13 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('sports.html?activity=Walking'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Walking</span><span class="text-xs text-slate-400 font-normal">7 SKU</span></a></li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-black text-xs text-slate-400 uppercase tracking-widest mb-4">Court & Field</h4>
                                <ul class="space-y-2.5 text-sm font-semibold">
                                    <li><a href="<?php echo base_url('sports.html?activity=Soccer'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Soccer & Futsal</span><span class="text-xs text-slate-400 font-normal">16 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('sports.html?activity=Tennis'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Tennis</span><span class="text-xs text-slate-400 font-normal">14 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('sports.html?activity=Golf'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Golf Specialist</span><span class="text-xs text-slate-400 font-normal">3 SKU</span></a></li>
                                </ul>
                            </div>
                            <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 flex flex-col justify-between">
                                <div>
                                    <div class="text-xs font-bold text-red-600 uppercase tracking-wider mb-1">Sports Focused</div>
                                    <h4 class="font-bold text-slate-800 text-base mb-2">Performa Maksimal</h4>
                                    <p class="text-xs text-slate-500">1.033 SKU sepatu atletik dari Diadora, Nike, New Balance, Puma & Converse.</p>
                                </div>
                                <a href="<?php echo base_url('sports.html'); ?>" class="btn-nexus-primary text-xs w-full py-2.5 mt-4">Katalog Olahraga</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. MEN MEGA MENU (772 SKU) -->
                <div class="py-7 has-mega-menu">
                    <a href="<?php echo base_url('men.html'); ?>" class="hover:text-[#E5252A] transition-colors py-2 flex items-center space-x-1">
                        <span data-i18n="men">MEN</span>
                        <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <div class="mega-menu-container p-8">
                        <div class="max-w-5xl mx-auto grid grid-cols-3 gap-8">
                            <div>
                                <h4 class="font-black text-xs text-slate-400 uppercase tracking-widest mb-4">Footwear Kategori Pria</h4>
                                <ul class="space-y-2.5 text-sm font-semibold">
                                    <li><a href="<?php echo base_url('men.html?footwear_type=Sneakers'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Sneakers</span><span class="text-xs text-slate-400 font-normal">291 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('men.html?footwear_type=Running'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Running</span><span class="text-xs text-slate-400 font-normal">219 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('men.html?footwear_type=Walking'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Walking</span><span class="text-xs text-slate-400 font-normal">216 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('men.html?footwear_type=Leisure'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Leisure</span><span class="text-xs text-slate-400 font-normal">3 SKU</span></a></li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-black text-xs text-slate-400 uppercase tracking-widest mb-4">Performance & Court</h4>
                                <ul class="space-y-2.5 text-sm font-semibold">
                                    <li><a href="<?php echo base_url('men.html?footwear_type=Sandals'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Sandals & Slides</span><span class="text-xs text-slate-400 font-normal">17 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('men.html?footwear_type=Soccer'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Soccer</span><span class="text-xs text-slate-400 font-normal">8 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('men.html?footwear_type=Tennis'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Tennis</span><span class="text-xs text-slate-400 font-normal">8 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('men.html?footwear_type=Golf'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Golf Specialist</span><span class="text-xs text-slate-400 font-normal">3 SKU</span></a></li>
                                </ul>
                            </div>
                            <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 flex flex-col justify-between">
                                <div>
                                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Ukuran EUR 39 – 46</div>
                                    <h4 class="font-bold text-slate-800 text-base mb-2">Koleksi Pria Lengkap</h4>
                                    <p class="text-xs text-slate-500">Total 772 pasang sepatu pria original dari 8 brand dewasa resmi.</p>
                                </div>
                                <a href="<?php echo base_url('men.html'); ?>" class="btn-nexus-primary text-xs w-full py-2.5 mt-4">Jelajahi Sepatu Pria</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. WOMEN MEGA MENU (552 SKU) -->
                <div class="py-7 has-mega-menu">
                    <a href="<?php echo base_url('women.html'); ?>" class="hover:text-[#E5252A] transition-colors py-2 flex items-center space-x-1">
                        <span data-i18n="women">WOMEN</span>
                        <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <div class="mega-menu-container p-8">
                        <div class="max-w-4xl mx-auto grid grid-cols-3 gap-8">
                            <div>
                                <h4 class="font-black text-xs text-slate-400 uppercase tracking-widest mb-4">Footwear Kategori Wanita</h4>
                                <ul class="space-y-2.5 text-sm font-semibold">
                                    <li><a href="<?php echo base_url('women.html?footwear_type=Sneakers'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Sneakers</span><span class="text-xs text-slate-400 font-normal">207 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('women.html?footwear_type=Walking'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Walking</span><span class="text-xs text-slate-400 font-normal">175 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('women.html?footwear_type=Running'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Running</span><span class="text-xs text-slate-400 font-normal">151 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('women.html?footwear_type=Leisure'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Leisure</span><span class="text-xs text-slate-400 font-normal">1 SKU</span></a></li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-black text-xs text-slate-400 uppercase tracking-widest mb-4">Lifestyle & Sport</h4>
                                <ul class="space-y-2.5 text-sm font-semibold">
                                    <li><a href="<?php echo base_url('women.html?footwear_type=Tennis'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Tennis</span><span class="text-xs text-slate-400 font-normal">8 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('women.html?footwear_type=Sandals'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Sandals & Slides</span><span class="text-xs text-slate-400 font-normal">6 SKU</span></a></li>
                                </ul>
                            </div>
                            <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 flex flex-col justify-between">
                                <div>
                                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Ukuran EUR 36 – 41</div>
                                    <h4 class="font-bold text-slate-800 text-base mb-2">Koleksi Wanita Lengkap</h4>
                                    <p class="text-xs text-slate-500">Total 552 pasang sepatu wanita orisinil dengan bantalan ergonomis.</p>
                                </div>
                                <a href="<?php echo base_url('women.html'); ?>" class="btn-nexus-primary text-xs w-full py-2.5 mt-4">Jelajahi Sepatu Wanita</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. KIDS MEGA MENU (267 SKU) -->
                <div class="py-7 has-mega-menu">
                    <a href="<?php echo base_url('kids.html'); ?>" class="hover:text-[#E5252A] transition-colors py-2 flex items-center space-x-1">
                        <span data-i18n="kids">KIDS</span>
                        <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <div class="mega-menu-container p-8">
                        <div class="max-w-3xl mx-auto grid grid-cols-2 gap-8">
                            <div>
                                <h4 class="font-black text-xs text-slate-400 uppercase tracking-widest mb-4">Footwear Anak / Junior</h4>
                                <ul class="space-y-2.5 text-sm font-semibold">
                                    <li><a href="<?php echo base_url('kids.html?footwear_type=Sneakers'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Sneakers</span><span class="text-xs text-slate-400 font-normal">165 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('kids.html?footwear_type=Running'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Running</span><span class="text-xs text-slate-400 font-normal">88 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('kids.html?footwear_type=Soccer'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Soccer & Futsal</span><span class="text-xs text-slate-400 font-normal">8 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('kids.html?footwear_type=Sandals'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Sandals</span><span class="text-xs text-slate-400 font-normal">3 SKU</span></a></li>
                                    <li><a href="<?php echo base_url('kids.html?footwear_type=Tennis'); ?>" class="hover:text-[#E5252A] flex items-center justify-between"><span>Tennis</span><span class="text-xs text-slate-400 font-normal">1 SKU</span></a></li>
                                </ul>
                            </div>
                            <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 flex flex-col justify-between">
                                <div>
                                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Ukuran EUR 20 – 35</div>
                                    <h4 class="font-bold text-slate-800 text-base mb-2">Sepatu Anak & Balita</h4>
                                    <p class="text-xs text-slate-500">267 pilihan sepatu anak resmi dari Diadora, Nike YA, New Balance, dan Converse Kids.</p>
                                </div>
                                <a href="<?php echo base_url('kids.html'); ?>" class="btn-nexus-primary text-xs w-full py-2.5 mt-4">Lihat Sepatu Anak</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. SALE (Perilaku Khusus: ZERO MEGA MENU, direct link) -->
                <div class="py-7">
                    <a href="<?php echo base_url('sale.html'); ?>" class="text-[#E5252A] hover:underline font-extrabold tracking-wider transition-colors py-2">
                        <span data-i18n="sale">SALE</span>
                    </a>
                </div>
            </nav>

            <!-- Search Bar & Cart Icon -->
            <div class="flex items-center space-x-4">
                <!-- Search Bar -->
                <form action="<?php echo base_url('brands.html'); ?>" method="GET" class="relative hidden sm:block">
                    <input type="text" name="search" data-i18n="search_placeholder" placeholder="Cari sepatu, brand, SKU..." class="bg-slate-100 hover:bg-slate-200/70 focus:bg-white text-xs text-slate-800 placeholder-slate-400 rounded-full pl-9 pr-4 py-2.5 w-56 lg:w-72 focus:outline-none focus:ring-2 focus:ring-[#E5252A] border border-transparent transition-all">
                    <span class="absolute left-3 top-2.5 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                </form>

                <!-- Shopping Cart Icon with Dynamic Badge -->
                <a href="<?php echo base_url('cart.html'); ?>" class="relative p-2.5 text-slate-700 hover:text-[#E5252A] transition-colors" title="Keranjang Belanja">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span id="header-cart-badge" class="absolute top-1 right-1 bg-[#E5252A] text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow" style="display: <?php echo (!empty($cart_count) && $cart_count > 0) ? 'inline-flex' : 'none'; ?>;">
                        <?php echo $cart_count ?: 0; ?>
                    </span>
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Main Page Content Container -->
<main class="flex-grow">
