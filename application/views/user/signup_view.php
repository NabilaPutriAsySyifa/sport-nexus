<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - CUSTOMER REGISTRATION (SIGN UP)
     PDF Specification (Pages 4-8):
     - Title "Sign Up", top right link "Sign in with SPORT NEXUS"
     - Email + [Send] button + Validation Code (OTP)
     - Password & Confirm Password (min 8 chars)
     - Personal Details: First Name, Last Name
     - Interactive Calendar Date Picker (DD/MM/YYYY, << >> Year, < > Month, 1-31 Grid)
     - Gender Dropdown (Male / Female)
     - Full-width "Sign Up" button
     - STRICT EXCLUSIONS: No phone number, NO terms & conditions checkbox, NO newsletter, NO MAPCLUB
     ========================================================================= -->

<div class="max-w-lg mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl p-8 sm:p-10 space-y-6">

        <!-- Top Header & Fast Link -->
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h1 class="text-2xl font-black uppercase tracking-tight text-slate-900">
                Sign Up
            </h1>
            <a href="<?php echo base_url('signin.html' . (!empty($redirect) ? '?redirect=' . urlencode($redirect) : '')); ?>" class="text-xs font-bold text-[#E5252A] hover:underline flex items-center space-x-1">
                <span>Sign in with SPORT NEXUS</span>
                <span>&rarr;</span>
            </a>
        </div>

        <!-- Mandatory Checkout Notice -->
        <?php if (!empty($auth_notice)): ?>
            <div class="bg-amber-50 border-2 border-amber-400 text-amber-900 text-xs font-medium p-4 rounded-xl flex items-start space-x-2.5 shadow-sm">
                <span class="text-base flex-shrink-0">⚠️</span>
                <div>
                    <strong class="font-bold block text-amber-950 mb-0.5">Wajib Memiliki Akun Terdaftar:</strong>
                    <span><?php echo htmlspecialchars($auth_notice); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Duplication / Error Alert (PDF Page 3 & 6) -->
        <?php if (!empty($error)): ?>
            <div id="signup-alert-error" class="bg-red-50 border-2 border-[#E5252A] text-red-700 text-xs font-bold p-4 rounded-xl flex items-center space-x-2.5 shadow-sm">
                <span class="text-base flex-shrink-0">🚫</span>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <!-- Sign Up Form (Strictly No Phone Number, No Terms Checkbox!) -->
        <form method="POST" action="<?php echo base_url('signup.html' . (!empty($redirect) ? '?redirect=' . urlencode($redirect) : '')); ?>" id="form-signup" class="space-y-4 text-xs">
            <?php if (!empty($redirect)): ?>
                <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
            <?php endif; ?>

            <!-- 1. Email Address & OTP Trigger -->
            <div class="space-y-1.5">
                <label for="signup-email" class="font-bold text-slate-700 block">Email *</label>
                <div class="flex items-center space-x-2">
                    <input type="email" id="signup-email" name="email" required placeholder="Email address" value="<?php echo htmlspecialchars($this->input->post('email') ?: ''); ?>" class="flex-grow p-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none font-medium">
                    <button type="button" id="btn-send-otp" class="bg-[#1E2229] hover:bg-[#2D333D] text-white px-5 py-3 rounded-xl font-bold text-xs uppercase tracking-wider transition-colors flex-shrink-0 shadow">
                        Send
                    </button>
                </div>
                <p class="text-[11px] text-slate-500 font-medium pt-0.5">
                    Please click <strong>"Send"</strong> to get the Validation Code on your email.
                </p>
                <div id="otp-status-feedback" class="text-[11px] font-bold text-emerald-600 hidden"></div>
            </div>

            <!-- 2. Validation Code (OTP) -->
            <div class="space-y-1.5">
                <label for="validation-code" class="font-bold text-slate-700 block">Validation Code *</label>
                <input type="text" id="validation-code" name="validation_code" required maxlength="6" placeholder="Validation Code" class="w-full p-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none font-mono font-bold tracking-widest text-center text-sm">
            </div>

            <!-- 3. Password & Confirm Password -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label for="signup-password" class="font-bold text-slate-700 block">Password *</label>
                    <input type="password" id="signup-password" name="password" minlength="8" required placeholder="Password" class="w-full p-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none font-medium">
                </div>
                <div class="space-y-1.5">
                    <label for="signup-confirm-password" class="font-bold text-slate-700 block">Confirm password *</label>
                    <input type="password" id="signup-confirm-password" name="confirm_password" minlength="8" required placeholder="Confirm password" class="w-full p-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none font-medium">
                </div>
            </div>

            <!-- 4. Personal Details (PDF Page 5) -->
            <div class="pt-2 border-t border-slate-100 space-y-3">
                <h3 class="font-black text-slate-900 uppercase text-xs tracking-wider">
                    Personal Details
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="space-y-1.5">
                        <label for="first-name" class="font-bold text-slate-700 block">First Name *</label>
                        <input type="text" id="first-name" name="first_name" required placeholder="First Name" class="w-full p-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none font-medium">
                    </div>
                    <div class="space-y-1.5">
                        <label for="last-name" class="font-bold text-slate-700 block">Last Name *</label>
                        <input type="text" id="last-name" name="last_name" required placeholder="Last Name" class="w-full p-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none font-medium">
                    </div>
                </div>

                <!-- Gender Dropdown & Interactive Calendar Date Picker -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Gender Dropdown -->
                    <div class="space-y-1.5">
                        <label for="gender-select" class="font-bold text-slate-700 block">Gender *</label>
                        <div class="relative">
                            <select id="gender-select" name="gender" class="w-full p-3 pr-10 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none bg-white font-medium appearance-none cursor-pointer">
                                <option value="Male" selected>Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Interactive Calendar Date Picker (DD/MM/YYYY) -->
                    <div class="space-y-1.5 relative">
                        <label for="dob-display-input" class="font-bold text-slate-700 block">Date of Birth *</label>
                        <div class="relative">
                            <input type="text" id="dob-display-input" name="date_of_birth" required readonly placeholder="DD/MM/YYYY" value="21/02/2000" class="w-full p-3 pr-10 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#E5252A] focus:outline-none font-medium bg-white cursor-pointer select-none">
                            <button type="button" id="btn-toggle-calendar" class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-500 hover:text-[#E5252A]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </button>
                        </div>

                        <!-- Interactive Calendar Pop-up Box (PDF Page 8) -->
                        <div id="calendar-popup" class="absolute left-0 sm:right-0 sm:left-auto top-full mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-slate-200 p-4 hidden z-50 select-none">
                            <!-- Nav Header: <<, <, Month Year, >, >> -->
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div class="flex items-center space-x-1">
                                    <button type="button" id="cal-prev-year" class="p-1 rounded hover:bg-slate-100 font-bold text-slate-600 text-xs" title="Previous Year">&laquo;</button>
                                    <button type="button" id="cal-prev-month" class="p-1 rounded hover:bg-slate-100 font-bold text-slate-600 text-xs" title="Previous Month">&lsaquo;</button>
                                </div>

                                <strong id="cal-month-year-label" class="font-black text-slate-900 text-xs">2000 October</strong>

                                <div class="flex items-center space-x-1">
                                    <button type="button" id="cal-next-month" class="p-1 rounded hover:bg-slate-100 font-bold text-slate-600 text-xs" title="Next Month">&rsaquo;</button>
                                    <button type="button" id="cal-next-year" class="p-1 rounded hover:bg-slate-100 font-bold text-slate-600 text-xs" title="Next Year">&raquo;</button>
                                </div>
                            </div>

                            <!-- Day Headers -->
                            <div class="grid grid-cols-7 gap-1 pt-2 pb-1 text-center font-bold text-[10px] text-slate-400 uppercase">
                                <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                            </div>

                            <!-- Days Grid (1-31) -->
                            <div id="cal-days-grid" class="grid grid-cols-7 gap-1 text-center text-xs">
                                <!-- Injected dynamically -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Full-width Submit Button: Sign Up (Zero terms checkbox, zero newsletter - PDF Page 6) -->
            <button type="submit" id="btn-submit-signup" class="w-full bg-[#E5252A] hover:bg-[#c41c21] text-white py-3.5 px-4 rounded-xl font-black uppercase tracking-wider text-xs shadow-lg hover:shadow-red-500/25 transition-all mt-4">
                Sign Up
            </button>
        </form>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. OTP Sender Simulation
    const btnSendOtp = document.getElementById('btn-send-otp');
    const emailInput = document.getElementById('signup-email');
    const otpFeedback = document.getElementById('otp-status-feedback');
    const otpInput = document.getElementById('validation-code');

    btnSendOtp.addEventListener('click', () => {
        const email = emailInput.value.trim();
        if (!email || !email.includes('@')) {
            alert('Please enter a valid email address.');
            return;
        }

        btnSendOtp.disabled = true;
        btnSendOtp.textContent = 'Sending...';

        const formData = new FormData();
        formData.append('email', email);

        fetch('<?php echo base_url("auth/send_otp"); ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                otpFeedback.classList.remove('hidden');
                otpFeedback.innerHTML = `✔ Validation Code sent to <strong>${email}</strong>!`;
                if (data.otp) {
                    otpInput.value = data.otp; // Simulation autofill for convenient testing
                }
                btnSendOtp.textContent = 'Sent';
            } else {
                alert(data.message || 'Failed to send verification code.');
                btnSendOtp.disabled = false;
                btnSendOtp.textContent = 'Send';
            }
        })
        .catch(err => {
            alert('Failed to connect to verification server.');
            btnSendOtp.disabled = false;
            btnSendOtp.textContent = 'Send';
        });
    });

    // 2. Interactive Date of Birth Calendar Picker (DD/MM/YYYY)
    const dobInput = document.getElementById('dob-display-input');
    const toggleCalBtn = document.getElementById('btn-toggle-calendar');
    const calPopup = document.getElementById('calendar-popup');
    const monthYearLabel = document.getElementById('cal-month-year-label');
    const daysGrid = document.getElementById('cal-days-grid');
    const btnPrevYear = document.getElementById('cal-prev-year');
    const btnNextYear = document.getElementById('cal-next-year');
    const btnPrevMonth = document.getElementById('cal-prev-month');
    const btnNextMonth = document.getElementById('cal-next-month');

    const monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    let currentCalYear = 2000;
    let currentCalMonth = 1; // 0-indexed, 1 = Feb
    let selectedDay = 21;

    function renderCalendar() {
        monthYearLabel.textContent = `${currentCalYear} ${monthNames[currentCalMonth]}`;
        daysGrid.innerHTML = '';

        const firstDayIndex = new Date(currentCalYear, currentCalMonth, 1).getDay();
        const totalDaysInMonth = new Date(currentCalYear, currentCalMonth + 1, 0).getDate();
        const prevMonthTotalDays = new Date(currentCalYear, currentCalMonth, 0).getDate();

        // Render previous month overflow days
        for (let x = firstDayIndex; x > 0; x--) {
            const dimDay = document.createElement('div');
            dimDay.className = 'p-1.5 text-slate-300 text-center font-medium';
            dimDay.textContent = prevMonthTotalDays - x + 1;
            daysGrid.appendChild(dimDay);
        }

        // Render current month days
        for (let d = 1; d <= totalDaysInMonth; d++) {
            const dayCell = document.createElement('button');
            dayCell.type = 'button';
            const isSelected = (d === selectedDay);
            dayCell.className = `p-1.5 rounded-lg text-center font-bold transition-colors ${
                isSelected 
                    ? 'bg-[#E5252A] text-white shadow' 
                    : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900'
            }`;
            dayCell.textContent = d;
            dayCell.onclick = () => {
                selectedDay = d;
                const formattedDay = String(d).padStart(2, '0');
                const formattedMonth = String(currentCalMonth + 1).padStart(2, '0');
                dobInput.value = `${formattedDay}/${formattedMonth}/${currentCalYear}`;
                calPopup.classList.add('hidden');
            };
            daysGrid.appendChild(dayCell);
        }
    }

    function toggleCalendar() {
        calPopup.classList.toggle('hidden');
        if (!calPopup.classList.contains('hidden')) {
            renderCalendar();
        }
    }

    dobInput.addEventListener('click', toggleCalendar);
    toggleCalBtn.addEventListener('click', toggleCalendar);

    btnPrevYear.addEventListener('click', (e) => {
        e.stopPropagation();
        currentCalYear--;
        renderCalendar();
    });
    btnNextYear.addEventListener('click', (e) => {
        e.stopPropagation();
        currentCalYear++;
        renderCalendar();
    });
    btnPrevMonth.addEventListener('click', (e) => {
        e.stopPropagation();
        currentCalMonth--;
        if (currentCalMonth < 0) {
            currentCalMonth = 11;
            currentCalYear--;
        }
        renderCalendar();
    });
    btnNextMonth.addEventListener('click', (e) => {
        e.stopPropagation();
        currentCalMonth++;
        if (currentCalMonth > 11) {
            currentCalMonth = 0;
            currentCalYear++;
        }
        renderCalendar();
    });

    // Close calendar on click outside
    document.addEventListener('click', (e) => {
        if (!calPopup.contains(e.target) && e.target !== dobInput && !toggleCalBtn.contains(e.target)) {
            calPopup.classList.add('hidden');
        }
    });

    renderCalendar();
});
</script>
