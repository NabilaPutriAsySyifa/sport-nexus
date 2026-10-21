<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Admin Sign In | Sport Nexus'; ?></title>
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

    <div class="max-w-md w-full bg-[#1E2229] border border-slate-700/60 rounded-2xl p-8 shadow-2xl space-y-6">

        <!-- Logo & Header -->
        <div class="text-center space-y-2">
            <div class="font-black italic text-2xl tracking-wider text-white">
                SPORT <span class="text-[#E5252A]">NEXUS</span>
            </div>
            <div class="inline-block px-2.5 py-0.5 rounded bg-red-500/10 border border-red-500/20 text-[#E5252A] text-[11px] font-black uppercase tracking-wider">
                Restricted Back-Office
            </div>
            <h1 class="text-lg font-black uppercase tracking-tight text-white pt-1">
                Portal Administrator
            </h1>
            <p class="text-xs text-slate-400">
                Audit kuota stok fisik 1.443 pasang sepatu, varian ukuran EUR 20–46, dan pemrosesan pesanan terpusat.
            </p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-semibold p-3.5 rounded-xl flex items-center space-x-2">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($this->input->get('registered') == 1): ?>
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-semibold p-3.5 rounded-xl flex items-center space-x-2">
                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>Registrasi admin berhasil! Silakan login dengan kredensial kerja Anda.</span>
            </div>
        <?php endif; ?>

        <!-- Sign In Form -->
        <form method="POST" action="<?php echo base_url('admin/signin'); ?>" class="space-y-4 text-xs">
            <div class="space-y-1.5">
                <label for="admin-email" class="font-bold text-slate-300 block">Work Email *</label>
                <input type="email" id="admin-email" name="work_email" required value="admin@sportnexus.com" placeholder="staf@sportnexus.com" class="w-full p-3 bg-slate-900 border border-slate-700 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none text-white font-medium">
            </div>

            <div class="space-y-1.5">
                <label for="admin-password" class="font-bold text-slate-300 block">Password *</label>
                <div class="relative">
                    <input type="password" id="admin-password" name="password" required value="Admin123!" placeholder="Masukkan password admin" class="w-full p-3 bg-slate-900 border border-slate-700 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none text-white font-medium pr-10">
                    <button type="button" id="toggle-admin-password" class="absolute right-3 top-3 text-slate-400 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#E5252A] hover:bg-[#c41c21] text-white py-3.5 px-4 rounded-xl font-black uppercase tracking-wider text-xs shadow-lg hover:shadow-red-500/25 transition-all">
                Masuk ke Back-Office
            </button>
        </form>

        <!-- Credentials Helper Box -->
        <div class="bg-slate-900/60 border border-slate-800 p-4 rounded-xl space-y-1 text-xs">
            <span class="font-bold text-slate-300 block">Kredensial Super Admin (Demo):</span>
            <div class="text-slate-400 flex justify-between">
                <span>Email: <strong class="text-white">admin@sportnexus.com</strong></span>
                <span>Pass: <strong class="text-white">Admin123!</strong></span>
            </div>
            <p class="text-[10px] text-slate-500 pt-1">Passcode Pendaftaran: <code class="text-amber-400 font-mono">NEXUS-ADMIN-2026</code></p>
        </div>

        <!-- Registration Link -->
        <div class="text-center text-xs text-slate-400 pt-2 border-t border-slate-700/50">
            <span>Perlu akses operasional staf baru?</span>
            <a href="<?php echo base_url('admin/signup'); ?>" class="font-bold text-[#E5252A] hover:underline ml-1">
                Registrasi Staf Admin
            </a>
        </div>

    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const pwdInput = document.getElementById('admin-password');
        const toggleBtn = document.getElementById('toggle-admin-password');
        if (toggleBtn && pwdInput) {
            toggleBtn.addEventListener('click', () => {
                pwdInput.type = (pwdInput.type === 'password') ? 'text' : 'password';
            });
        }
    });
    </script>
</body>
</html>
