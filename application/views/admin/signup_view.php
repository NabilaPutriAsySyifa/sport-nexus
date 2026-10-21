<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Admin Registration | Sport Nexus'; ?></title>
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
<body class="bg-[#0F172A] text-slate-100 min-h-screen flex items-center justify-center p-4 antialiased font-sans">

    <div class="max-w-lg w-full bg-[#1E2229] border border-slate-700/60 rounded-2xl p-8 sm:p-10 shadow-2xl space-y-6">

        <!-- Logo & Header -->
        <div class="text-center space-y-2">
            <div class="font-black italic text-2xl tracking-wider text-white">
                SPORT <span class="text-[#E5252A]">NEXUS</span>
            </div>
            <div class="inline-block px-2.5 py-0.5 rounded bg-red-500/10 border border-red-500/20 text-[#E5252A] text-[11px] font-black uppercase tracking-wider">
                Authorized Personnel Only
            </div>
            <h1 class="text-lg font-black uppercase tracking-tight text-white pt-1">
                Registrasi Staf Back-Office
            </h1>
            <p class="text-xs text-slate-400">
                Pendaftaran akun staf internal memerlukan Master Secret Passcode perusahaan.
            </p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-semibold p-3.5 rounded-xl flex items-center space-x-2">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <!-- Sign Up Form -->
        <form method="POST" action="<?php echo base_url('admin/signup'); ?>" class="space-y-4 text-xs">

            <!-- 1. Master Passcode Field -->
            <div class="space-y-1.5 bg-slate-900/80 p-3.5 rounded-xl border border-slate-700">
                <label for="secret-passcode" class="font-black text-amber-400 flex items-center space-x-1.5">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                    <span>Master Secret Passcode *</span>
                </label>
                <input type="text" id="secret-passcode" name="secret_passcode" required value="NEXUS-ADMIN-2026" placeholder="Kunci otorisasi admin perusahaan" class="w-full p-2.5 bg-slate-950 border border-amber-500/40 rounded-lg text-amber-300 font-mono font-bold focus:ring-1 focus:ring-amber-400 focus:outline-none">
            </div>

            <!-- 2. Full Name & Employee ID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label for="admin-fullname" class="font-bold text-slate-300 block">Nama Lengkap Staf *</label>
                    <input type="text" id="admin-fullname" name="full_name" required placeholder="Contoh: Raden Wijaya" class="w-full p-3 bg-slate-900 border border-slate-700 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none text-white font-medium">
                </div>
                <div class="space-y-1.5">
                    <label for="admin-empid" class="font-bold text-slate-300 block">Employee ID *</label>
                    <input type="text" id="admin-empid" name="employee_id" required placeholder="SN-EMP-005" class="w-full p-3 bg-slate-900 border border-slate-700 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none text-white font-mono font-medium">
                </div>
            </div>

            <!-- 3. Work Email & Role Selection -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label for="admin-work-email" class="font-bold text-slate-300 block">Work Email (@sportnexus.com) *</label>
                    <input type="email" id="admin-work-email" name="work_email" required placeholder="staf@sportnexus.com" class="w-full p-3 bg-slate-900 border border-slate-700 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none text-white font-medium">
                </div>
                <div class="space-y-1.5">
                    <label for="admin-role" class="font-bold text-slate-300 block">Penugasan Peran (Role) *</label>
                    <select id="admin-role" name="role" class="w-full p-3 bg-slate-900 border border-slate-700 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none text-white font-medium">
                        <option value="Super Admin">Super Admin</option>
                        <option value="Stock & Catalog Manager" selected>Stock & Catalog Manager</option>
                        <option value="Order Operator">Order Operator</option>
                        <option value="Finance Staff">Finance Staff</option>
                    </select>
                </div>
            </div>

            <!-- 4. Password & Confirm Password -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label for="admin-pass" class="font-bold text-slate-300 block">Password (Min. 8 Karakter) *</label>
                    <input type="password" id="admin-pass" name="password" minlength="8" required placeholder="Minimal 8 karakter" class="w-full p-3 bg-slate-900 border border-slate-700 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none text-white font-medium">
                </div>
                <div class="space-y-1.5">
                    <label for="admin-confirm-pass" class="font-bold text-slate-300 block">Ulangi Password *</label>
                    <input type="password" id="admin-confirm-pass" name="confirm_password" minlength="8" required placeholder="Ulangi password" class="w-full p-3 bg-slate-900 border border-slate-700 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none text-white font-medium">
                </div>
            </div>

            <button type="submit" class="w-full bg-[#E5252A] hover:bg-[#c41c21] text-white py-3.5 px-4 rounded-xl font-black uppercase tracking-wider text-xs shadow-lg hover:shadow-red-500/25 transition-all">
                Daftarkan Akun Staf Admin
            </button>
        </form>

        <!-- Footer Link -->
        <div class="text-center text-xs text-slate-400 pt-2 border-t border-slate-700/50">
            <span>Sudah memiliki akun back-office?</span>
            <a href="<?php echo base_url('admin/signin'); ?>" class="font-bold text-[#E5252A] hover:underline ml-1">
                Sign In di sini
            </a>
        </div>

    </div>

</body>
</html>
