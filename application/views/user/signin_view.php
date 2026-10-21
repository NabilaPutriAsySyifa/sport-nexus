<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - CUSTOMER SIGN IN (PDF Pages 3-4)
     - Header "Sign In" (left) + "I don't have an account" (right -> /signup.html)
     - Top full-width button: "Sign In with SPORT NEXUS"
     - Visual divider: — OR —
     - Email (placeholder: "Email")
     - Password (placeholder: "Password") with toggle eye
     - "Forgot passwords?" link
     - Full-width submit button: "Sign In"
     - Strict exclusions: Zero MAPCLUB, zero legal/terms text under submit
     ========================================================================= -->

<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl p-8 space-y-6">

        <!-- Header & Quick Access Link -->
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h1 class="text-2xl font-black uppercase tracking-tight text-slate-900">
                Sign In
            </h1>
            <a href="<?php echo base_url('signup.html' . (!empty($redirect) ? '?redirect=' . urlencode($redirect) : '')); ?>" class="text-xs font-bold text-[#E5252A] hover:underline">
                I don't have an account
            </a>
        </div>

        <?php if (!empty($auth_notice)): ?>
            <div class="bg-amber-50 border-2 border-amber-400 text-amber-900 text-xs font-medium p-4 rounded-xl flex items-start space-x-2.5 shadow-sm">
                <span class="text-base flex-shrink-0">⚠️</span>
                <div>
                    <strong class="font-bold block text-amber-950 mb-0.5">Wajib Masuk Akun untuk Pembelian:</strong>
                    <span><?php echo htmlspecialchars($auth_notice); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="bg-red-50 border-2 border-[#E5252A] text-red-700 text-xs font-bold p-3.5 rounded-xl flex items-center space-x-2">
                <span class="text-base">🚫</span>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($this->input->get('registered') == 1): ?>
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold p-3.5 rounded-xl flex items-center space-x-2">
                <span class="text-base text-emerald-600">✔</span>
                <span>Registrasi berhasil! Silakan sign in dengan email dan password Anda.</span>
            </div>
        <?php endif; ?>

        <!-- Brand Button: Sign In with SPORT NEXUS (Replaces MAPCLUB) -->
        <div>
            <button type="button" onclick="document.getElementById('signin-email').focus()" class="w-full bg-[#1E2229] hover:bg-[#2D333D] text-white py-3.5 px-4 rounded-xl font-black uppercase tracking-wider text-xs shadow-md transition-all flex items-center justify-center space-x-2">
                <span>Sign In with SPORT NEXUS</span>
            </button>
        </div>

        <!-- Visual Divider: — OR — -->
        <div class="relative flex items-center justify-center">
            <div class="border-t border-slate-200 w-full"></div>
            <span class="bg-white px-3 text-xs font-bold text-slate-400 uppercase tracking-widest absolute">— OR —</span>
        </div>

        <!-- Sign In Form -->
        <form method="POST" action="<?php echo base_url('signin.html' . (!empty($redirect) ? '?redirect=' . urlencode($redirect) : '')); ?>" class="space-y-4 text-xs">
            <?php if (!empty($redirect)): ?>
                <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
            <?php endif; ?>
            <!-- Email -->
            <div class="space-y-1.5">
                <label for="signin-email" class="font-bold text-slate-700 block">Email *</label>
                <input type="email" id="signin-email" name="email" required placeholder="Email" value="<?php echo htmlspecialchars($this->input->post('email') ?: 'nabila@gmail.com'); ?>" class="w-full p-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none font-medium">
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="signin-password" class="font-bold text-slate-700">Password *</label>
                    <a href="#" onclick="alert('Untuk simulasi, Anda dapat menggunakan akun demo nabila@gmail.com / User123!'); return false;" class="text-[11px] font-bold text-[#E5252A] hover:underline">
                        Forgot passwords?
                    </a>
                </div>
                <div class="relative">
                    <input type="password" id="signin-password" name="password" required value="User123!" placeholder="Password" class="w-full p-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none font-medium pr-10">
                    <button type="button" id="toggle-password" class="absolute right-3 top-3 text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
            </div>

            <!-- Submit Button (Full-width "Sign In") -->
            <button type="submit" class="w-full bg-[#E5252A] hover:bg-[#c41c21] text-white py-3.5 px-4 rounded-xl font-black uppercase tracking-wider text-xs shadow-lg hover:shadow-red-500/25 transition-all">
                Sign In
            </button>
        </form>

        <!-- Demo Account Helper Box -->
        <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl space-y-1.5 text-xs">
            <span class="font-bold text-slate-800 block">Akun Pengguna Terdaftar (Demo):</span>
            <div class="text-slate-600 flex justify-between">
                <span>Email: <strong class="text-slate-900">nabila@gmail.com</strong></span>
                <span>Pass: <strong class="text-slate-900">User123!</strong></span>
            </div>
            <p class="text-[11px] text-slate-400">Dilengkapi dengan 3 multi-alamat di wilayah Bekasi & simulasi non-COD.</p>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const pwdInput = document.getElementById('signin-password');
    const toggleBtn = document.getElementById('toggle-password');
    if (toggleBtn && pwdInput) {
        toggleBtn.addEventListener('click', () => {
            const isPass = pwdInput.type === 'password';
            pwdInput.type = isPass ? 'text' : 'password';
        });
    }
});
</script>

