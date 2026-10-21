<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - CUSTOMERS (DATA PENGGUNA TERDAFTAR)
     Admin View: Nama, Email, Tanggal Lahir (Date Picker), Gender & Riwayat Order
     ========================================================================= -->

<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-200 gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                <span class="text-xs font-black uppercase text-slate-400 tracking-wider">Customer Relationship</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900 mt-0.5">
                Data Pelanggan Terdaftar
            </h1>
            <p class="text-xs text-slate-500">
                Basis data akun pelanggan resmi Sport Nexus yang telah diverifikasi via OTP email.
            </p>
        </div>

        <span class="text-xs bg-slate-900 text-white font-mono font-bold px-3 py-1.5 rounded-lg shadow-sm">
            Total Pelanggan: <?php echo count($customers); ?> Akun
        </span>
    </div>

    <!-- Customers Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="p-3.5">ID & Nama Lengkap</th>
                        <th class="p-3.5">Email Terdaftar</th>
                        <th class="p-3.5">Gender</th>
                        <th class="p-3.5">Tanggal Lahir</th>
                        <th class="p-3.5">Alamat Tersimpan</th>
                        <th class="p-3.5 text-center">Total Order</th>
                        <th class="p-3.5">Terdaftar Sejak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    <?php if (!empty($customers)): ?>
                        <?php foreach ($customers as $c): ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <!-- ID & Full Name -->
                                <td class="p-3.5">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-black text-slate-700 text-xs flex-shrink-0">
                                            <?php echo strtoupper(substr($c->first_name ?: 'U', 0, 1) . substr($c->last_name ?: 'S', 0, 1)); ?>
                                        </div>
                                        <div>
                                            <strong class="text-slate-900 block"><?php echo htmlspecialchars($c->first_name . ' ' . $c->last_name); ?></strong>
                                            <span class="text-[10px] text-slate-400 font-mono">UID #<?php echo $c->id; ?></span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Email -->
                                <td class="p-3.5 font-mono text-slate-800">
                                    <?php echo htmlspecialchars($c->email); ?>
                                    <span class="inline-block text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.2 rounded ml-1">OTP Verified</span>
                                </td>

                                <!-- Gender -->
                                <td class="p-3.5">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full font-bold text-[10px] uppercase <?php echo ($c->gender === 'Female') ? 'bg-pink-100 text-pink-700' : 'bg-blue-100 text-blue-700'; ?>">
                                        <?php echo htmlspecialchars($c->gender ?: 'Male'); ?>
                                    </span>
                                </td>

                                <!-- Date of Birth (from date picker DD/MM/YYYY) -->
                                <td class="p-3.5 text-slate-800 font-medium">
                                    <?php echo !empty($c->date_of_birth) ? date('d/m/Y', strtotime($c->date_of_birth)) : '-'; ?>
                                </td>

                                <!-- Stored Addresses -->
                                <td class="p-3.5 max-w-xs">
                                    <?php if (!empty($c->addresses)): ?>
                                        <span class="text-[11px] font-semibold text-slate-700 block truncate" title="<?php echo htmlspecialchars($c->addresses[0]->full_address); ?>">
                                            <?php echo htmlspecialchars($c->addresses[0]->city . ' - ' . $c->addresses[0]->full_address); ?>
                                        </span>
                                        <?php if (count($c->addresses) > 1): ?>
                                            <span class="text-[10px] text-slate-400 font-bold">+<?php echo count($c->addresses) - 1; ?> alamat lain</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-slate-400 italic">Belum menyimpan alamat</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Total Order -->
                                <td class="p-3.5 text-center">
                                    <span class="inline-block font-black text-xs px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800">
                                        <?php echo $c->order_count; ?> Order
                                    </span>
                                </td>

                                <!-- Registered At -->
                                <td class="p-3.5 text-[11px] text-slate-400">
                                    <?php echo date('d M Y, H:i', strtotime($c->created_at)); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">Belum ada akun pelanggan terdaftar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
