<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' | Admin Portal' : 'Admin Portal | Sport Nexus'; ?></title>
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/tailwind.output.css'); ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sport-red': '#E5252A',
                        'charcoal': '#1E2229',
                        'dark-slate': '#0F172A'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex flex-col font-sans">

<!-- =========================================================================
     ADMIN TWO-TIER HEADER (PDF Pages 7-12)
     Tier 1: Top System Utility Bar (Dark Slate)
     Tier 2: Main Admin Navbar (Clean White with Module Dropdowns & Quick Action)
<?php
// Dynamically resolve admin identity and initials
$current_admin_name = !empty($admin_user->full_name) ? $admin_user->full_name : ($this->session->userdata('admin_name') ?: 'Admin');
$current_admin_role = !empty($admin_user->role) ? $admin_user->role : ($this->session->userdata('admin_role') ?: 'Super Admin');
$current_admin_nik  = !empty($admin_user->employee_id) ? $admin_user->employee_id : ($this->session->userdata('admin_employee_id') ?: 'SN-ADM-001');

// Compute dynamic initials (e.g. Farrel Paksi -> FP, Nabila Putri -> NP, Dimas Prasetyo -> DP)
$admin_words = preg_split('/\s+/', trim($current_admin_name));
$admin_initials = '';
if (count($admin_words) >= 2) {
    $admin_initials = strtoupper(mb_substr($admin_words[0], 0, 1) . mb_substr($admin_words[1], 0, 1));
} elseif (count($admin_words) === 1 && !empty($admin_words[0])) {
    $admin_initials = strtoupper(mb_substr($admin_words[0], 0, min(2, mb_strlen($admin_words[0]))));
} else {
    $admin_initials = 'AD';
}
?>

<header class="w-full sticky top-0 z-50 shadow-md border-b border-slate-200">
    <!-- TIER 1: TOP SYSTEM UTILITY BAR (Latar Hitam / Dark Slate) -->
    <div class="bg-[#0F172A] text-slate-300 text-xs py-2.5 px-4 sm:px-6 lg:px-8 xl:px-12 border-b border-slate-800">
        <div class="max-w-[1600px] mx-auto flex items-center justify-between">
            <!-- Left: System Health & DB Status with generous spacing -->
            <div class="flex items-center space-x-6 sm:space-x-8">
                <div class="flex items-center space-x-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="font-bold text-emerald-400 tracking-wide">System Online</span>
                </div>
                <div class="hidden sm:flex items-center space-x-2 text-slate-400">
                    <span class="text-slate-500 font-semibold">DB:</span>
                    <span class="text-slate-200 font-mono font-medium">Connected (Active Sync)</span>
                </div>
                <div class="hidden md:flex items-center space-x-2 text-slate-400">
                    <span class="text-slate-500 font-semibold">Total Footwear:</span>
                    <span class="text-white font-bold font-mono"><?php echo isset($total_skus) ? number_format($total_skus, 0, ',', '.') : '1.543'; ?> SKUs</span>
                </div>
            </div>

            <!-- Right: Alert Center, Notifications, Language, Dynamic Admin Profile -->
            <div class="flex items-center space-x-5 sm:space-x-7">
                <!-- Low Stock Alert Badge -->
                <div class="relative group">
                    <button class="flex items-center space-x-2 bg-amber-500/10 text-amber-400 border border-amber-500/30 px-3 py-1 rounded-full font-bold text-[11px] hover:bg-amber-500/20 transition-all shadow-sm">
                        <span class="text-amber-300">⚠️ Stok Rendah:</span>
                        <span class="font-mono font-black"><?php echo isset($low_stock_count) ? $low_stock_count : '8'; ?></span>
                    </button>
                    <!-- Quick Dropdown for Low Stock -->
                    <div class="absolute right-0 mt-2 w-72 bg-white text-slate-800 rounded-xl shadow-2xl border border-slate-200 p-3.5 hidden group-hover:block z-50">
                        <div class="font-bold text-xs text-slate-800 mb-2.5 border-b pb-1.5 flex justify-between items-center">
                            <span>Peringatan Stok Menipis</span>
                            <span class="text-amber-600 font-mono text-[11px] bg-amber-50 px-2 py-0.5 rounded">&lt; 5 pasang</span>
                        </div>
                        <div class="space-y-1.5 text-[11px] max-h-48 overflow-y-auto">
                            <div class="p-2 bg-amber-50/70 rounded-lg border border-amber-200 flex justify-between items-center">
                                <div>
                                    <div class="font-bold text-slate-800">Diadora Rayna Men's</div>
                                    <div class="text-slate-500 text-[10px]">Size EU 42 • Sisa 2 pasang</div>
                                </div>
                                <span class="bg-amber-500 text-white font-bold px-2 py-0.5 rounded text-[10px]">Kritis</span>
                            </div>
                            <div class="p-2 bg-red-50/70 rounded-lg border border-red-200 flex justify-between items-center">
                                <div>
                                    <div class="font-bold text-slate-800">Nike Court Vision Low</div>
                                    <div class="text-slate-500 text-[10px]">Size EU 41 • Sisa 1 pasang</div>
                                </div>
                                <span class="bg-red-500 text-white font-bold px-2 py-0.5 rounded text-[10px]">Habis Segera</span>
                            </div>
                        </div>
                        <a href="<?php echo base_url('admin/inventory?status=menipis'); ?>" class="block text-center text-[11px] text-[#E5252A] font-bold mt-2.5 pt-2 border-t hover:underline">
                            Audit Seluruh Stok Kritis &rarr;
                        </a>
                    </div>
                </div>

                <!-- Order Notification Bell -->
                <a href="<?php echo base_url('admin/orders'); ?>" class="relative text-slate-400 hover:text-white transition-colors p-1" title="Notifikasi Pesanan">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="absolute top-0 right-0 w-2 h-2 rounded-full bg-[#E5252A] ring-2 ring-[#0F172A]"></span>
                </a>

                <!-- Dynamic Language Selector (PDF Page 8-9) -->
                <div class="relative group">
                    <button class="flex items-center space-x-1.5 text-slate-300 hover:text-white font-bold text-[11px] py-1">
                        <span>LANGUAGE</span>
                        <svg class="w-3 h-3 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-40 bg-white text-slate-800 rounded-xl shadow-xl border border-slate-200 py-1.5 hidden group-hover:block z-50 text-xs">
                        <a href="?lang=id" class="flex items-center space-x-2.5 px-3.5 py-2 hover:bg-slate-100 font-medium">
                            <span class="w-4 h-2.5 bg-red-600 inline-block rounded-xs shadow-xs"></span>
                            <span>Indonesia (ID)</span>
                        </a>
                        <a href="?lang=en" class="flex items-center space-x-2.5 px-3.5 py-2 hover:bg-slate-100 font-medium">
                            <span class="w-4 h-2.5 bg-blue-800 inline-block rounded-xs shadow-xs"></span>
                            <span>English (EN)</span>
                        </a>
                    </div>
                </div>

                <!-- Admin Profile Dropdown (100% Dynamic Avatar & Identity) -->
                <div class="relative group">
                    <button class="flex items-center space-x-2.5 text-white font-medium hover:text-[#E5252A] transition-colors py-0.5">
                        <div class="w-7 h-7 rounded-full bg-[#E5252A] text-white flex items-center justify-center font-black text-[11px] shadow-sm uppercase tracking-wide">
                            <?php echo $admin_initials; ?>
                        </div>
                        <span class="font-bold text-xs"><?php echo htmlspecialchars($current_admin_name); ?></span>
                        <span class="bg-slate-700/80 text-slate-200 text-[10px] px-2 py-0.5 rounded font-mono font-medium"><?php echo htmlspecialchars($current_admin_role); ?></span>
                        <svg class="w-3 h-3 text-slate-400 group-hover:text-[#E5252A] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-56 bg-white text-slate-800 rounded-xl shadow-2xl border border-slate-200 py-1.5 hidden group-hover:block z-50">
                        <div class="px-4 py-3 border-b border-slate-100">
                            <div class="flex items-center space-x-3 mb-1">
                                <div class="w-8 h-8 rounded-full bg-[#E5252A] text-white flex items-center justify-center font-black text-xs uppercase shadow-sm">
                                    <?php echo $admin_initials; ?>
                                </div>
                                <div>
                                    <div class="font-black text-xs text-slate-900 leading-tight"><?php echo htmlspecialchars($current_admin_name); ?></div>
                                    <div class="text-[10px] font-mono text-[#E5252A] font-bold"><?php echo htmlspecialchars($current_admin_role); ?></div>
                                </div>
                            </div>
                            <div class="text-[10px] text-slate-400 font-mono mt-1">ID: <?php echo htmlspecialchars($current_admin_nik); ?></div>
                        </div>
                        <div class="py-1">
                            <a href="<?php echo base_url('admin/dashboard'); ?>" class="flex items-center space-x-2 px-4 py-2 hover:bg-slate-50 text-xs font-medium text-slate-700">
                                <span>👤</span>
                                <span>Profil Saya</span>
                            </a>
                            <a href="<?php echo base_url('admin/reports'); ?>" class="flex items-center space-x-2 px-4 py-2 hover:bg-slate-50 text-xs font-medium text-slate-700">
                                <span>📋</span>
                                <span>Activity Log & Audit</span>
                            </a>
                        </div>
                        <div class="border-t border-slate-100 my-1"></div>
                        <a href="<?php echo base_url('admin/signout'); ?>" class="flex items-center space-x-2 px-4 py-2.5 hover:bg-red-50 text-xs text-red-600 font-black">
                            <span>🚪</span>
                            <span>Keluar (Log Out)</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TIER 2: MAIN ADMIN NAVBAR (Latar Putih Bersih - Spacing Rapi & Lega) -->
    <div class="bg-white px-4 sm:px-6 lg:px-8 xl:px-12 border-b border-slate-200">
        <div class="max-w-[1600px] mx-auto flex items-center justify-between h-20">
            <!-- Brand & Portal Tag with Generous Right Margin -->
            <div class="flex items-center shrink-0 mr-6 lg:mr-8 xl:mr-10">
                <a href="<?php echo base_url('admin/dashboard'); ?>" class="flex items-center space-x-3">
                    <span class="font-black italic text-2xl tracking-tight text-[#1E2229]">SPORT <span class="text-[#E5252A]">NEXUS</span></span>
                    <span class="bg-[#1E2229] text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-md shadow-sm">ADMIN PORTAL</span>
                </a>
                <!-- Subtle Vertical Separator -->
                <div class="h-8 w-px bg-slate-200 ml-6 hidden lg:block"></div>
            </div>

            <!-- Admin Navigation Modules with Elegant Breathing Space -->
            <nav class="hidden md:flex items-center space-x-5 lg:space-x-7 xl:space-x-8 text-xs font-bold uppercase tracking-wider text-slate-600 flex-grow">
                <!-- A. DASHBOARD -->
                <a href="<?php echo base_url('admin/dashboard'); ?>" class="hover:text-[#E5252A] py-7 border-b-2 transition-all whitespace-nowrap <?php echo (uri_string() == 'admin/dashboard' || uri_string() == 'admin') ? 'border-[#E5252A] text-[#E5252A]' : 'border-transparent'; ?>">
                    DASHBOARD
                </a>

                <!-- B. PRODUCTS & STOCK (Hover Dropdown) -->
                <div class="relative group">
                    <a href="<?php echo base_url('admin/inventory'); ?>" class="flex items-center space-x-1.5 hover:text-[#E5252A] py-7 border-b-2 transition-all whitespace-nowrap <?php echo (strpos(uri_string(), 'admin/inventory') !== false || strpos(uri_string(), 'admin/men') !== false || strpos(uri_string(), 'admin/women') !== false || strpos(uri_string(), 'admin/kids') !== false || strpos(uri_string(), 'admin/size-matrix') !== false) ? 'border-[#E5252A] text-[#E5252A]' : 'border-transparent'; ?>">
                        <span>PRODUCTS & STOCK</span>
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-[#E5252A] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <div class="absolute left-0 mt-0 w-64 bg-white text-slate-800 rounded-xl shadow-2xl border border-slate-200 py-2 hidden group-hover:block z-50 text-xs normal-case">
                        <div class="px-4 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">Pusat Inventaris Sepatu</div>
                        <a href="<?php echo base_url('admin/inventory'); ?>" class="flex items-center justify-between px-4 py-2.5 hover:bg-slate-50 font-bold text-slate-800">
                            <span>Daftar Seluruh Sepatu</span>
                            <span class="text-[10px] font-mono bg-slate-100 px-1.5 py-0.5 rounded text-slate-600">1.543 SKU</span>
                        </a>
                        <a href="<?php echo base_url('admin/size-matrix'); ?>" class="flex items-center justify-between px-4 py-2 hover:bg-slate-50 font-medium text-slate-700">
                            <span>Manajemen Ukuran (Matrix US & EU)</span>
                            <span class="text-[10px] text-slate-400">12 Slot</span>
                        </a>
                        <div class="border-t border-slate-100 my-1"></div>
                        <a href="<?php echo base_url('admin/men'); ?>" class="flex items-center justify-between px-4 py-2 hover:bg-slate-50 font-medium text-slate-700">
                            <span>Sepatu Pria (Men's Footwear)</span>
                            <span class="text-[10px] font-mono bg-blue-50 text-blue-700 px-1.5 py-0.5 rounded">EUR 39–46</span>
                        </a>
                        <a href="<?php echo base_url('admin/women'); ?>" class="flex items-center justify-between px-4 py-2 hover:bg-slate-50 font-medium text-slate-700">
                            <span>Sepatu Wanita (Women's Footwear)</span>
                            <span class="text-[10px] font-mono bg-pink-50 text-pink-700 px-1.5 py-0.5 rounded">EUR 36–41</span>
                        </a>
                        <a href="<?php echo base_url('admin/kids'); ?>" class="flex items-center justify-between px-4 py-2 hover:bg-slate-50 font-medium text-slate-700">
                            <span>Sepatu Anak (Kids' Footwear)</span>
                            <span class="text-[10px] font-mono bg-amber-50 text-amber-700 px-1.5 py-0.5 rounded">EUR 20–35</span>
                        </a>
                        <div class="border-t border-slate-100 my-1"></div>
                        <a href="<?php echo base_url('admin/sports'); ?>" class="flex items-center justify-between px-4 py-2 hover:bg-slate-50 font-medium text-slate-700">
                            <span>Alokasi Olahraga & Aktivitas</span>
                            <span class="text-[10px] font-mono bg-emerald-50 text-emerald-700 px-1.5 py-0.5 rounded">421 SKU</span>
                        </a>
                    </div>
                </div>

                <!-- C. BRANDS (Hover Dropdown) -->
                <div class="relative group">
                    <a href="<?php echo base_url('admin/brands'); ?>" class="flex items-center space-x-1.5 hover:text-[#E5252A] py-7 border-b-2 transition-all whitespace-nowrap <?php echo strpos(uri_string(), 'admin/brands') !== false ? 'border-[#E5252A] text-[#E5252A]' : 'border-transparent'; ?>">
                        <span>BRANDS</span>
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-[#E5252A] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <div class="absolute left-0 mt-0 w-60 bg-white text-slate-800 rounded-xl shadow-2xl border border-slate-200 py-2 hidden group-hover:block z-50 text-xs normal-case">
                        <div class="px-4 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">Manajemen Merek Mitra</div>
                        <a href="<?php echo base_url('admin/brands'); ?>" class="block px-4 py-2.5 hover:bg-slate-50 font-bold text-[#E5252A]">
                            Pita Marquee & Urutan Logo &rarr;
                        </a>
                        <div class="border-t border-slate-100 my-1"></div>
                        <a href="<?php echo base_url('admin/inventory?brand=Diadora'); ?>" class="flex items-center justify-between px-4 py-1.5 hover:bg-slate-50 text-slate-700">
                            <span>Diadora</span>
                            <span class="font-mono text-slate-400 text-[11px]">500 SKU</span>
                        </a>
                        <a href="<?php echo base_url('admin/inventory?brand=Airwalk'); ?>" class="flex items-center justify-between px-4 py-1.5 hover:bg-slate-50 text-slate-700">
                            <span>Airwalk</span>
                            <span class="font-mono text-slate-400 text-[11px]">400 SKU</span>
                        </a>
                        <a href="<?php echo base_url('admin/inventory?brand=New+Balance'); ?>" class="flex items-center justify-between px-4 py-1.5 hover:bg-slate-50 text-slate-700">
                            <span>New Balance</span>
                            <span class="font-mono text-slate-400 text-[11px]">200 SKU</span>
                        </a>
                        <a href="<?php echo base_url('admin/inventory?brand=Converse'); ?>" class="flex items-center justify-between px-4 py-1.5 hover:bg-slate-50 text-slate-700">
                            <span>Converse</span>
                            <span class="font-mono text-slate-400 text-[11px]">240 SKU</span>
                        </a>
                        <a href="<?php echo base_url('admin/inventory?brand=Nike'); ?>" class="flex items-center justify-between px-4 py-1.5 hover:bg-slate-50 text-slate-700">
                            <span>Nike</span>
                            <span class="font-mono text-slate-400 text-[11px]">121 SKU</span>
                        </a>
                        <a href="<?php echo base_url('admin/inventory?brand=Puma'); ?>" class="flex items-center justify-between px-4 py-1.5 hover:bg-slate-50 text-slate-700">
                            <span>Puma</span>
                            <span class="font-mono text-slate-400 text-[11px]">82 SKU</span>
                        </a>
                    </div>
                </div>

                <!-- D. ORDERS -->
                <a href="<?php echo base_url('admin/orders'); ?>" class="hover:text-[#E5252A] py-7 border-b-2 transition-all whitespace-nowrap <?php echo strpos(uri_string(), 'admin/orders') !== false ? 'border-[#E5252A] text-[#E5252A]' : 'border-transparent'; ?>">
                    ORDERS
                </a>

                <!-- E. CUSTOMERS (PDF Page 10-11) -->
                <a href="<?php echo base_url('admin/customers'); ?>" class="hover:text-[#E5252A] py-7 border-b-2 transition-all whitespace-nowrap <?php echo strpos(uri_string(), 'admin/customers') !== false ? 'border-[#E5252A] text-[#E5252A]' : 'border-transparent'; ?>">
                    CUSTOMERS
                </a>

                <!-- F. REPORTS (PDF Page 11) -->
                <a href="<?php echo base_url('admin/reports'); ?>" class="hover:text-[#E5252A] py-7 border-b-2 transition-all whitespace-nowrap <?php echo strpos(uri_string(), 'admin/reports') !== false ? 'border-[#E5252A] text-[#E5252A]' : 'border-transparent'; ?>">
                    REPORTS
                </a>

                <!-- VOUCHERS -->
                <a href="<?php echo base_url('admin/promos'); ?>" class="hover:text-[#E5252A] py-7 border-b-2 transition-all whitespace-nowrap <?php echo strpos(uri_string(), 'admin/promos') !== false ? 'border-[#E5252A] text-[#E5252A]' : 'border-transparent'; ?>">
                    VOUCHERS
                </a>
            </nav>

            <!-- Global Admin Quick Actions with Visual Separator Divider & Spacious Layout -->
            <div class="flex items-center space-x-4 lg:space-x-5 shrink-0 pl-6 border-l border-slate-200">
                <!-- Quick Global Search Bar -->
                <form action="<?php echo base_url('admin/inventory'); ?>" method="GET" class="relative hidden xl:block">
                    <input type="text" name="search" placeholder="Cari SKU, Nama Sepatu, atau No. Order..." class="bg-slate-100 hover:bg-slate-100/90 focus:bg-white text-xs pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#E5252A] w-64 lg:w-72 font-medium transition-all shadow-xs">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                </form>

                <!-- Quick Action Button (+ Tambah Sepatu Baru - PDF Page 11) -->
                <button type="button" onclick="openQuickAddShoeModal()" class="bg-[#E5252A] hover:bg-[#c41c21] text-white text-xs font-black uppercase tracking-wider py-2.5 px-4 lg:px-5 rounded-xl shadow-md hover:shadow-lg hover:shadow-red-500/25 transition-all flex items-center space-x-2 flex-shrink-0">
                    <span class="text-base font-bold leading-none">+</span>
                    <span>Tambah Sepatu Baru</span>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- QUICK ADD SHOE MODAL (Global Quick Action - PDF Page 11) -->
<div id="quick-add-shoe-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                <h4 class="font-black text-slate-900 uppercase text-xs">Pendaftaran Sepatu Baru</h4>
            </div>
            <button type="button" onclick="closeQuickAddShoeModal()" class="text-slate-400 hover:text-slate-700 font-black text-xl">&times;</button>
        </div>

        <form id="form-quick-add-shoe" class="space-y-3.5 text-xs">
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-bold text-slate-700 block">Brand Resmi *</label>
                    <select name="brand_name" required class="w-full p-2.5 border border-slate-300 rounded-lg font-bold bg-white focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                        <option value="Diadora">Diadora</option>
                        <option value="Airwalk">Airwalk</option>
                        <option value="New Balance">New Balance</option>
                        <option value="Converse">Converse</option>
                        <option value="Converse Kids">Converse Kids</option>
                        <option value="Nike">Nike</option>
                        <option value="Nike Young Athletes">Nike Young Athletes</option>
                        <option value="Nike Golf">Nike Golf</option>
                        <option value="Puma">Puma</option>
                        <option value="Puma Golf">Puma Golf</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="font-bold text-slate-700 block">Kategori Gender *</label>
                    <select name="gender" required class="w-full p-2.5 border border-slate-300 rounded-lg font-bold bg-white focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                        <option value="Men">Men (Pria)</option>
                        <option value="Women">Women (Wanita)</option>
                        <option value="Kids">Kids (Anak)</option>
                        <option value="Unisex">Unisex</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-bold text-slate-700 block">Nama Model Sepatu *</label>
                <input type="text" name="name" required placeholder="Contoh: Diadora Reidor Men's - Navy" class="w-full p-2.5 border border-slate-300 rounded-lg font-medium focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-bold text-slate-700 block">Aktivitas / Olahraga *</label>
                    <select name="primary_sport" required class="w-full p-2.5 border border-slate-300 rounded-lg font-bold bg-white focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                        <option value="Running">Running</option>
                        <option value="Lifestyle">Lifestyle</option>
                        <option value="Fitness">Fitness</option>
                        <option value="Soccer">Soccer</option>
                        <option value="Basketball">Basketball</option>
                        <option value="Tennis">Tennis</option>
                        <option value="Badminton">Badminton</option>
                        <option value="Golf">Golf</option>
                        <option value="Walking">Walking</option>
                        <option value="Swimming">Swimming</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="font-bold text-slate-700 block">Tipe Footwear *</label>
                    <select name="footwear_type" required class="w-full p-2.5 border border-slate-300 rounded-lg font-bold bg-white focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                        <option value="Sneakers">Sneakers</option>
                        <option value="Running">Running</option>
                        <option value="Leisure">Leisure</option>
                        <option value="Sports Performance">Sports Performance</option>
                        <option value="Walking">Walking</option>
                        <option value="Sandals">Sandals</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div class="space-y-1">
                    <label class="font-bold text-slate-700 block">Harga Ritel Asli (Rp) *</label>
                    <input type="number" id="quick-original-price" name="original_price" required min="10000" placeholder="499000" class="w-full p-2.5 border border-slate-300 rounded-lg font-bold focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
                <div class="space-y-1">
                    <label class="font-bold text-slate-700 block">Diskon (%)</label>
                    <input type="number" id="quick-discount-pct" name="discount_percent" min="0" max="90" value="0" class="w-full p-2.5 border border-slate-300 rounded-lg font-bold focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
                <div class="space-y-1">
                    <label class="font-bold text-slate-700 block">Warna Dominan</label>
                    <input type="text" name="color" placeholder="Black / White" class="w-full p-2.5 border border-slate-300 rounded-lg font-medium focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-bold text-slate-700 block">URL Foto Sepatu (Thumbnail)</label>
                <input type="url" name="thumbnail" placeholder="https://www.sportsstation.id/media/catalog/product/..." class="w-full p-2.5 border border-slate-300 rounded-lg font-mono text-[11px] focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
            </div>

            <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl text-[11px] text-slate-600">
                <span>ℹ️ Sistem akan mengalokasikan kode SKU resmi dan matriks ukuran standar (stok 5 pasang/ukuran).</span>
            </div>

            <div class="flex items-center space-x-2 pt-2">
                <button type="button" onclick="closeQuickAddShoeModal()" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 rounded-lg">Batal</button>
                <button type="submit" class="w-1/2 bg-[#E5252A] hover:bg-[#c41c21] text-white font-bold py-2.5 rounded-lg shadow">Daftarkan Sepatu</button>
            </div>
        </form>
    </div>
</div>

<script>
function openQuickAddShoeModal() {
    document.getElementById('quick-add-shoe-modal').classList.remove('hidden');
}
function closeQuickAddShoeModal() {
    document.getElementById('quick-add-shoe-modal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    const quickAddForm = document.getElementById('form-quick-add-shoe');
    if (quickAddForm) {
        quickAddForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(quickAddForm);

            fetch('<?php echo base_url("admin/inventory/save_product"); ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message || 'Sepatu baru berhasil ditambahkan!');
                    closeQuickAddShoeModal();
                    window.location.href = '<?php echo base_url("admin/inventory"); ?>';
                } else {
                    alert(data.message || 'Gagal menambahkan sepatu.');
                }
            })
            .catch(err => {
                alert('Terjadi kesalahan jaringan.');
            });
        });
    }
});
</script>

<main class="flex-grow max-w-7xl w-full mx-auto p-4 sm:p-6 lg:p-8">

