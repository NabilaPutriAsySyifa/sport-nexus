<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - MULTI-STEP CHECKOUT WIZARD
     Ship To (Multi-Address) + Digital Payment Simulation (NO COD)
     ========================================================================= -->

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-6">
        <a href="<?php echo base_url(); ?>" class="hover:text-[#E5252A]">Home</a>
        <span>/</span>
        <a href="<?php echo base_url('cart.html'); ?>" class="hover:text-[#E5252A]">Keranjang Belanja</a>
        <span>/</span>
        <span class="text-slate-800 font-bold">Checkout Pembayaran</span>
    </nav>

    <div class="border-b border-slate-200 pb-4 mb-8">
        <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900">
            Checkout Transaksi Digital
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Simulasi transaksi pesanan non-tunai resmi Sport Nexus (Virtual Account, Kartu Kredit, QRIS)
        </p>
    </div>

    <!-- Main Checkout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Left Form Columns (Col 8) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Verified Authenticated Account Banner -->
            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-full bg-emerald-600 text-white flex items-center justify-center font-black flex-shrink-0 text-sm shadow">
                        ✓
                    </div>
                    <div>
                        <p class="font-bold text-emerald-950">
                            Akun Terverifikasi: <?php echo htmlspecialchars($this->session->userdata('user_name') ?: 'Customer Sport Nexus'); ?>
                            <span class="text-emerald-700 font-semibold">(<?php echo htmlspecialchars($this->session->userdata('user_email')); ?>)</span>
                        </p>
                        <p class="text-[11px] text-emerald-800">
                            Pesanan resmi terlindungi & tercatat di akun Anda dengan simulasi pembayaran digital non-tunai.
                        </p>
                    </div>
                </div>
                <span class="inline-flex items-center space-x-1.5 bg-emerald-100 text-emerald-800 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider self-start sm:self-auto border border-emerald-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Akun Resmi</span>
                </span>
            </div>

            <!-- STEP 1: ALAMAT PENGIRIMAN (SHIP TO) -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center space-x-3">
                        <span class="w-7 h-7 rounded-full bg-[#E5252A] text-white flex items-center justify-center font-black text-xs">1</span>
                        <h2 class="font-black text-sm uppercase tracking-wider text-slate-900">Alamat Pengiriman (Ship To)</h2>
                    </div>
                    <?php if ($this->session->userdata('user_logged_in')): ?>
                        <button type="button" onclick="openAddressModal()" class="text-xs font-bold text-[#E5252A] hover:underline flex items-center space-x-1">
                            <span>+ Tambah Alamat Baru</span>
                        </button>
                    <?php endif; ?>
                </div>

                <?php if ($this->session->userdata('user_logged_in') && !empty($addresses)): ?>
                    <!-- Saved Addresses Radio Cards -->
                    <div class="space-y-3" id="address-list-container">
                        <?php foreach ($addresses as $aidx => $addr): ?>
                            <div class="address-card-item p-4 rounded-xl border-2 transition-all <?php echo $aidx === 0 ? 'border-[#E5252A] bg-red-50/30' : 'border-slate-200 hover:border-slate-300'; ?>" data-id="<?php echo $addr->id; ?>">
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                                    <label class="flex items-start space-x-3 cursor-pointer flex-grow">
                                        <input type="radio" name="selected_address_id" value="<?php echo $addr->id; ?>" <?php echo $aidx === 0 ? 'checked' : ''; ?> class="mt-1 text-[#E5252A] focus:ring-[#E5252A]" 
                                               data-name="<?php echo htmlspecialchars($addr->recipient_name); ?>" 
                                               data-phone="<?php echo htmlspecialchars($addr->phone_number); ?>" 
                                               data-address="<?php echo htmlspecialchars($addr->full_address); ?>" 
                                               data-province="<?php echo htmlspecialchars($addr->province); ?>"
                                               data-city="<?php echo htmlspecialchars($addr->city); ?>" 
                                               data-district="<?php echo htmlspecialchars($addr->district); ?>" 
                                               data-postal="<?php echo htmlspecialchars($addr->postal_code); ?>"
                                               data-primary="<?php echo $addr->is_primary ? '1' : '0'; ?>">
                                        <div class="space-y-1 text-xs">
                                            <div class="flex items-center space-x-2 flex-wrap gap-y-1">
                                                <strong class="font-bold text-slate-900"><?php echo htmlspecialchars($addr->recipient_name); ?></strong>
                                                <span class="text-slate-500 font-medium">(<?php echo htmlspecialchars($addr->phone_number); ?>)</span>
                                                <?php if ($addr->is_primary): ?>
                                                    <span class="bg-[#1E2229] text-white text-[10px] font-bold px-2 py-0.5 rounded">Utama</span>
                                                <?php endif; ?>
                                            </div>
                                            <p class="text-slate-600"><?php echo htmlspecialchars($addr->full_address); ?></p>
                                            <p class="text-slate-400 font-semibold"><?php echo htmlspecialchars($addr->district . ', ' . $addr->city . ', ' . $addr->province . ' ' . $addr->postal_code); ?></p>
                                        </div>
                                    </label>
                                    <div class="flex items-center space-x-2 pl-7 sm:pl-0 flex-shrink-0 self-start">
                                        <button type="button" class="btn-edit-address text-xs font-bold text-slate-600 hover:text-[#E5252A] bg-slate-100 hover:bg-red-50 border border-slate-200 hover:border-red-200 px-2.5 py-1.5 rounded-lg transition-colors flex items-center space-x-1"
                                                data-id="<?php echo $addr->id; ?>"
                                                data-name="<?php echo htmlspecialchars($addr->recipient_name); ?>"
                                                data-phone="<?php echo htmlspecialchars($addr->phone_number); ?>"
                                                data-address="<?php echo htmlspecialchars($addr->full_address); ?>"
                                                data-province="<?php echo htmlspecialchars($addr->province); ?>"
                                                data-city="<?php echo htmlspecialchars($addr->city); ?>"
                                                data-district="<?php echo htmlspecialchars($addr->district); ?>"
                                                data-postal="<?php echo htmlspecialchars($addr->postal_code); ?>"
                                                data-primary="<?php echo $addr->is_primary ? '1' : '0'; ?>"
                                                title="Ubah Alamat">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            <span>Ubah</span>
                                        </button>
                                        <button type="button" class="btn-delete-address text-xs font-bold text-red-600 hover:text-white bg-red-50 hover:bg-[#E5252A] border border-red-200 hover:border-[#E5252A] px-2.5 py-1.5 rounded-lg transition-colors flex items-center space-x-1 shadow-sm"
                                                data-id="<?php echo $addr->id; ?>"
                                                data-name="<?php echo htmlspecialchars($addr->recipient_name); ?>"
                                                title="Hapus Alamat">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            <span>Hapus</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- Guest or Manual Address Form -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="space-y-1">
                            <label class="font-bold text-slate-700">Nama Penerima *</label>
                            <input type="text" id="manual-name" value="<?php echo htmlspecialchars($this->session->userdata('user_name') ?: 'Nabila Putri'); ?>" placeholder="Nama lengkap penerima" class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="font-bold text-slate-700">Nomor Telepon/HP *</label>
                            <input type="text" id="manual-phone" value="085711942921" placeholder="Contoh: 08123456789" class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                        </div>
                        <div class="sm:col-span-2 space-y-1">
                            <label class="font-bold text-slate-700">Alamat Lengkap *</label>
                            <textarea id="manual-address" rows="2" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan" class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-1 focus:ring-[#E5252A] focus:outline-none">Grand Metropolitan Mall Lt. 2 Unit 16, Jl. KH. Noer Ali No. 1</textarea>
                        </div>
                        <div class="space-y-1">
                            <label class="font-bold text-slate-700">Kota / Kabupaten *</label>
                            <select id="manual-city" class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-1 focus:ring-[#E5252A] focus:outline-none bg-white font-medium">
                                <option value="Kota Bekasi" selected>Kota Bekasi</option>
                                <option value="Kab. Karawang">Kab. Karawang</option>
                                <option value="DKI Jakarta">DKI Jakarta</option>
                                <option value="Kota Depok">Kota Depok</option>
                                <option value="Kota Bogor">Kota Bogor</option>
                                <option value="Kota Bandung">Kota Bandung</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="font-bold text-slate-700">Kode Pos *</label>
                            <input type="text" id="manual-postal" value="17148" placeholder="17148" class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- STEP 2: PILIHAN KURIR PENGIRIMAN -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center space-x-3 pb-3 border-b border-slate-100">
                    <span class="w-7 h-7 rounded-full bg-[#E5252A] text-white flex items-center justify-center font-black text-xs">2</span>
                    <h2 class="font-black text-sm uppercase tracking-wider text-slate-900">Opsi Kurir Pengiriman</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="border-2 border-[#E5252A] bg-red-50/20 p-4 rounded-xl cursor-pointer flex items-start space-x-3 courier-option">
                        <input type="radio" name="courier" value="Regular Courier" checked class="mt-1 text-[#E5252A] focus:ring-[#E5252A]" data-fee="0">
                        <div class="text-xs space-y-1">
                            <div class="flex items-center space-x-2">
                                <strong class="font-black text-slate-900">Regular Courier</strong>
                                <span class="bg-emerald-100 text-emerald-700 font-bold px-2 py-0.5 rounded text-[10px]">GRATIS</span>
                            </div>
                            <p class="text-slate-500">Estimasi 2 - 3 Hari Kerja</p>
                            <p class="text-[11px] text-slate-400">JNE / J&T Express / SiCepat</p>
                        </div>
                    </label>

                    <label class="border-2 border-slate-200 hover:border-slate-300 p-4 rounded-xl cursor-pointer flex items-start space-x-3 courier-option">
                        <input type="radio" name="courier" value="Express (1 Hari)" class="mt-1 text-[#E5252A] focus:ring-[#E5252A]" data-fee="25000">
                        <div class="text-xs space-y-1">
                            <div class="flex items-center space-x-2">
                                <strong class="font-black text-slate-900">Express Courier</strong>
                                <span class="font-bold text-slate-800">Rp 25.000</span>
                            </div>
                            <p class="text-slate-500">Estimasi 1 Hari Kerja Sampai</p>
                            <p class="text-[11px] text-slate-400">Paxel / JNE YES Garansi Kilat</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- STEP 3: METODE PEMBAYARAN DIGITAL NON-TUNAI (STRICTLY NO COD) -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center space-x-3">
                        <span class="w-7 h-7 rounded-full bg-[#E5252A] text-white flex items-center justify-center font-black text-xs">3</span>
                        <h2 class="font-black text-sm uppercase tracking-wider text-slate-900">Metode Pembayaran Digital (Non-Cash)</h2>
                    </div>
                    <span class="text-[11px] font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded">NO COD</span>
                </div>

                <div class="space-y-3">
                    <!-- Option 1: Virtual Account -->
                    <label class="border-2 border-[#E5252A] bg-red-50/20 p-4 rounded-xl cursor-pointer block payment-channel-option">
                        <div class="flex items-start space-x-3">
                            <input type="radio" name="payment_channel" value="BCA Virtual Account" checked class="mt-1 text-[#E5252A] focus:ring-[#E5252A]">
                            <div class="flex-grow space-y-1 text-xs">
                                <div class="flex items-center justify-between">
                                    <strong class="font-black text-slate-900 text-sm">Virtual Account (Bank Transfer)</strong>
                                    <span class="text-[11px] font-bold text-emerald-600">Verifikasi Otomatis</span>
                                </div>
                                <p class="text-slate-500">Mendukung BCA, Mandiri, BRI, BNI Virtual Account.</p>
                                <div class="flex items-center space-x-2 pt-1 font-bold text-slate-700">
                                    <span class="border border-slate-200 px-2 py-0.5 rounded bg-white">BCA</span>
                                    <span class="border border-slate-200 px-2 py-0.5 rounded bg-white">MANDIRI</span>
                                    <span class="border border-slate-200 px-2 py-0.5 rounded bg-white">BRI</span>
                                    <span class="border border-slate-200 px-2 py-0.5 rounded bg-white">BNI</span>
                                </div>
                            </div>
                        </div>
                    </label>

                    <!-- Option 2: QRIS Instant Digital -->
                    <label class="border-2 border-slate-200 hover:border-slate-300 p-4 rounded-xl cursor-pointer block payment-channel-option">
                        <div class="flex items-start space-x-3">
                            <input type="radio" name="payment_channel" value="QRIS" class="mt-1 text-[#E5252A] focus:ring-[#E5252A]">
                            <div class="flex-grow space-y-1 text-xs">
                                <div class="flex items-center justify-between">
                                    <strong class="font-black text-slate-900 text-sm">QRIS (GoPay / OVO / ShopeePay / Dana)</strong>
                                    <span class="text-[11px] font-bold text-emerald-600">Scan QR Bebas Biaya</span>
                                </div>
                                <p class="text-slate-500">Scan langsung dari aplikasi mobile banking atau e-wallet apa pun.</p>
                            </div>
                        </div>
                    </label>

                    <!-- Option 3: Credit Card / Debit Online -->
                    <label class="border-2 border-slate-200 hover:border-slate-300 p-4 rounded-xl cursor-pointer block payment-channel-option">
                        <div class="flex items-start space-x-3">
                            <input type="radio" name="payment_channel" value="Credit Card (Visa / Mastercard)" class="mt-1 text-[#E5252A] focus:ring-[#E5252A]">
                            <div class="flex-grow space-y-1 text-xs">
                                <div class="flex items-center justify-between">
                                    <strong class="font-black text-slate-900 text-sm">Kartu Kredit / Debit Online</strong>
                                    <span class="text-[11px] font-bold text-slate-600">3D Secure Protected</span>
                                </div>
                                <p class="text-slate-500">Mendukung kartu berlogo Visa, Mastercard, dan JCB.</p>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- STEP 4: REVIEW PRODUK DALAM PESANAN -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center space-x-3 pb-3 border-b border-slate-100">
                    <span class="w-7 h-7 rounded-full bg-[#E5252A] text-white flex items-center justify-center font-black text-xs">4</span>
                    <h2 class="font-black text-sm uppercase tracking-wider text-slate-900">Produk yang Dipesan (<?php echo $cart['count']; ?> Item)</h2>
                </div>

                <div class="divide-y divide-slate-100">
                    <?php foreach ($cart['items'] as $it): ?>
                        <div class="py-3 flex items-center justify-between text-xs">
                            <div class="flex items-center space-x-3">
                                <?php $chk_img = !empty($it['thumbnail']) ? $it['thumbnail'] : (!empty($it['image_url']) ? $it['image_url'] : base_url('assets/images/placeholder-shoe.png')); ?>
                                <img src="<?php echo htmlspecialchars($chk_img); ?>" alt="item" class="w-12 h-12 object-contain bg-slate-50 rounded border border-slate-200 p-1">
                                <div>
                                    <strong class="font-bold text-slate-900 block"><?php echo htmlspecialchars($it['name']); ?></strong>
                                    <span class="text-slate-500">EUR <?php echo htmlspecialchars($it['size_eu']); ?> • <?php echo htmlspecialchars($it['color']); ?> • <?php echo $it['qty']; ?> pasang</span>
                                </div>
                            </div>
                            <?php 
                            $chk_price = isset($it['sale_price']) ? $it['sale_price'] : (isset($it['price']) ? $it['price'] : 0);
                            ?>
                            <span class="font-black text-slate-900">
                                Rp <?php echo number_format($chk_price * $it['qty'], 0, ',', '.'); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <!-- Right Summary Panel (Col 4) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Promo Code Box -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Gunakan Kupon Promo</h3>
                <div class="flex items-center space-x-2">
                    <input type="text" id="promo-code-input" placeholder="Contoh: NEXUS50" class="uppercase text-xs p-2.5 flex-grow border border-slate-300 rounded-lg focus:ring-1 focus:ring-[#E5252A] focus:outline-none font-bold">
                    <button type="button" id="btn-apply-promo" class="bg-[#1E2229] hover:bg-[#2D333D] text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow transition-colors">
                        Terapkan
                    </button>
                </div>
                <div id="promo-feedback-msg" class="hidden text-xs font-bold pt-1"></div>

                <!-- Promo quick chips -->
                <div class="pt-2 border-t border-slate-100">
                    <span class="text-[11px] text-slate-400 block mb-1.5 font-semibold">Promo Aktif:</span>
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" class="promo-quick-chip text-[10px] bg-slate-100 hover:bg-red-50 hover:text-[#E5252A] text-slate-700 font-bold px-2 py-1 rounded border border-slate-200 transition-colors" data-code="NEXUS50">
                            NEXUS50 (50% Off)
                        </button>
                        <button type="button" class="promo-quick-chip text-[10px] bg-slate-100 hover:bg-red-50 hover:text-[#E5252A] text-slate-700 font-bold px-2 py-1 rounded border border-slate-200 transition-colors" data-code="DISKON10">
                            DISKON10 (10% Off)
                        </button>
                        <button type="button" class="promo-quick-chip text-[10px] bg-slate-100 hover:bg-red-50 hover:text-[#E5252A] text-slate-700 font-bold px-2 py-1 rounded border border-slate-200 transition-colors" data-code="NEXUSHEMAT">
                            NEXUSHEMAT (Rp 50K)
                        </button>
                    </div>
                </div>
            </div>

            <!-- Final Cost Breakdown -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 sticky top-28">
                <h3 class="font-black text-sm uppercase tracking-wider text-slate-900 border-b border-slate-100 pb-3">Ringkasan Pembayaran</h3>

                <input type="hidden" id="checkout-subtotal-val" value="<?php echo $cart['total']; ?>">
                <input type="hidden" id="checkout-shipping-val" value="0">
                <input type="hidden" id="checkout-discount-val" value="0">
                <input type="hidden" id="checkout-active-promo" value="">

                <div class="space-y-2.5 text-xs">
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Total Harga (Subtotal)</span>
                        <strong class="text-slate-900">Rp <?php echo number_format($cart['total'], 0, ',', '.'); ?></strong>
                    </div>

                    <div class="flex items-center justify-between text-slate-600">
                        <span>Biaya Pengiriman</span>
                        <span id="display-shipping-fee" class="font-bold text-emerald-600">GRATIS</span>
                    </div>

                    <div id="row-discount" class="hidden flex items-center justify-between text-emerald-600">
                        <span>Diskon Promo (<span id="display-promo-code"></span>)</span>
                        <span id="display-discount-fee" class="font-bold">-Rp 0</span>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-between">
                        <div>
                            <span class="text-sm font-black text-slate-900 block">Total Tagihan</span>
                            <span class="text-[10px] text-slate-400">Termasuk PPN</span>
                        </div>
                        <span id="display-grand-total" class="text-2xl font-black text-[#E5252A]">
                            Rp <?php echo number_format($cart['total'], 0, ',', '.'); ?>
                        </span>
                    </div>
                </div>

                <!-- Final Submit Button -->
                <button type="button" id="btn-submit-order" class="w-full bg-[#E5252A] hover:bg-[#c41c21] text-white py-4 px-6 rounded-xl font-black text-xs uppercase tracking-wider flex items-center justify-center space-x-2 shadow-xl hover:shadow-red-500/25 transition-all">
                    <span>Bayar Sekarang (Konfirmasi)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </button>

                <div class="text-[11px] text-slate-400 text-center space-y-1 pt-2">
                    <p>✔ Pesanan Anda langsung diproses secara otomatis</p>
                    <p>Nomor resi pengiriman akan langsung diterbitkan</p>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Modal: Tambah Alamat Baru -->
<div id="add-address-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
            <h4 class="font-black text-slate-900 uppercase text-sm">Tambah Alamat Pengiriman Baru</h4>
            <button type="button" onclick="closeAddressModal()" class="text-slate-400 hover:text-slate-700 font-black text-lg">&times;</button>
        </div>

        <form id="form-new-address" class="space-y-3 text-xs">
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-bold text-slate-700">Nama Penerima *</label>
                    <input type="text" id="modal-name" required class="w-full p-2 border border-slate-300 rounded focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
                <div class="space-y-1">
                    <label class="font-bold text-slate-700">Nomor Telepon *</label>
                    <input type="text" id="modal-phone" required class="w-full p-2 border border-slate-300 rounded focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
            </div>
            <div class="space-y-1">
                <label class="font-bold text-slate-700">Alamat Lengkap *</label>
                <textarea id="modal-address" rows="2" required class="w-full p-2 border border-slate-300 rounded focus:ring-1 focus:ring-[#E5252A] focus:outline-none"></textarea>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div class="space-y-1">
                    <label class="font-bold text-slate-700">Kota *</label>
                    <input type="text" id="modal-city" value="Kota Bekasi" required class="w-full p-2 border border-slate-300 rounded focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
                <div class="space-y-1">
                    <label class="font-bold text-slate-700">Kecamatan *</label>
                    <input type="text" id="modal-district" value="Bekasi Selatan" required class="w-full p-2 border border-slate-300 rounded focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
                <div class="space-y-1">
                    <label class="font-bold text-slate-700">Kode Pos *</label>
                    <input type="text" id="modal-postal" value="17148" required class="w-full p-2 border border-slate-300 rounded focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
            </div>
            <div class="flex items-center space-x-2 pt-2">
                <input type="checkbox" id="modal-primary" class="rounded text-[#E5252A] focus:ring-[#E5252A]">
                <label for="modal-primary" class="text-slate-700 font-semibold cursor-pointer">Jadikan sebagai alamat utama</label>
            </div>

            <div class="flex items-center space-x-3 pt-3">
                <button type="button" onclick="closeAddressModal()" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 rounded-lg">Batal</button>
                <button type="submit" class="w-1/2 bg-[#E5252A] hover:bg-[#c41c21] text-white font-bold py-2.5 rounded-lg shadow">Simpan Alamat</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Ubah Alamat Pengiriman (Edit) -->
<div id="edit-address-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
            <h4 class="font-black text-slate-900 uppercase text-sm">Ubah Alamat Pengiriman</h4>
            <button type="button" onclick="closeEditAddressModal()" class="text-slate-400 hover:text-slate-700 font-black text-lg">&times;</button>
        </div>

        <form id="form-edit-address" class="space-y-3 text-xs">
            <input type="hidden" id="edit-modal-id" name="address_id" value="">
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-bold text-slate-700">Nama Penerima *</label>
                    <input type="text" id="edit-modal-name" required class="w-full p-2 border border-slate-300 rounded focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
                <div class="space-y-1">
                    <label class="font-bold text-slate-700">Nomor Telepon *</label>
                    <input type="text" id="edit-modal-phone" required class="w-full p-2 border border-slate-300 rounded focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
            </div>
            <div class="space-y-1">
                <label class="font-bold text-slate-700">Alamat Lengkap *</label>
                <textarea id="edit-modal-address" rows="2" required class="w-full p-2 border border-slate-300 rounded focus:ring-1 focus:ring-[#E5252A] focus:outline-none"></textarea>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div class="space-y-1">
                    <label class="font-bold text-slate-700">Kota *</label>
                    <input type="text" id="edit-modal-city" required class="w-full p-2 border border-slate-300 rounded focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
                <div class="space-y-1">
                    <label class="font-bold text-slate-700">Kecamatan *</label>
                    <input type="text" id="edit-modal-district" required class="w-full p-2 border border-slate-300 rounded focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
                <div class="space-y-1">
                    <label class="font-bold text-slate-700">Kode Pos *</label>
                    <input type="text" id="edit-modal-postal" required class="w-full p-2 border border-slate-300 rounded focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                </div>
            </div>
            <div class="flex items-center space-x-2 pt-2">
                <input type="checkbox" id="edit-modal-primary" class="rounded text-[#E5252A] focus:ring-[#E5252A]">
                <label for="edit-modal-primary" class="text-slate-700 font-semibold cursor-pointer">Jadikan sebagai alamat utama</label>
            </div>

            <div class="flex items-center space-x-3 pt-3">
                <button type="button" onclick="closeEditAddressModal()" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 rounded-lg">Batal</button>
                <button type="submit" id="btn-save-edit-address" class="w-1/2 bg-[#E5252A] hover:bg-[#c41c21] text-white font-bold py-2.5 rounded-lg shadow">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Konfirmasi Hapus Alamat -->
<div id="delete-address-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center space-x-3 text-red-600">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <div>
                <h4 class="font-black text-slate-900 text-sm">Hapus Alamat Pengiriman</h4>
                <p class="text-xs text-slate-500 font-medium" id="delete-address-name-preview">Nama Penerima</p>
            </div>
        </div>

        <p class="text-xs text-slate-600 font-semibold py-2">
            Apakah Anda yakin ingin menghapus alamat pengiriman ini? Tindakan ini tidak dapat dibatalkan.
        </p>

        <input type="hidden" id="pending-delete-address-id" value="">

        <div class="flex items-center space-x-3 pt-2">
            <button type="button" onclick="closeDeleteAddressModal()" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold py-2.5 rounded-xl transition-colors">
                Batal
            </button>
            <button type="button" id="btn-confirm-delete-address" class="w-1/2 bg-[#E5252A] hover:bg-[#c41c21] text-white text-xs font-bold py-2.5 rounded-xl shadow transition-colors">
                Ya, Hapus Alamat
            </button>
        </div>
    </div>
</div>

<script>
function openAddressModal() {
    document.getElementById('add-address-modal').classList.remove('hidden');
}
function closeAddressModal() {
    document.getElementById('add-address-modal').classList.add('hidden');
}
function openEditAddressModal(btn) {
    document.getElementById('edit-modal-id').value = btn.dataset.id;
    document.getElementById('edit-modal-name').value = btn.dataset.name;
    document.getElementById('edit-modal-phone').value = btn.dataset.phone;
    document.getElementById('edit-modal-address').value = btn.dataset.address;
    document.getElementById('edit-modal-city').value = btn.dataset.city;
    document.getElementById('edit-modal-district').value = btn.dataset.district;
    document.getElementById('edit-modal-postal').value = btn.dataset.postal;
    document.getElementById('edit-modal-primary').checked = (btn.dataset.primary === '1');
    document.getElementById('edit-address-modal').classList.remove('hidden');
}
function closeEditAddressModal() {
    document.getElementById('edit-address-modal').classList.add('hidden');
}
function openDeleteAddressModal(id, name) {
    document.getElementById('pending-delete-address-id').value = id;
    document.getElementById('delete-address-name-preview').textContent = name;
    document.getElementById('delete-address-modal').classList.remove('hidden');
}
function closeDeleteAddressModal() {
    document.getElementById('delete-address-modal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
    let subtotal = parseFloat(document.getElementById('checkout-subtotal-val').value) || 0;
    let shippingFee = 0;
    let discountFee = 0;

    function recalculateTotal() {
        const grandTotal = Math.max(0, subtotal + shippingFee - discountFee);
        document.getElementById('display-grand-total').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }

    // 1. Courier Selection
    document.querySelectorAll('input[name="courier"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            shippingFee = parseFloat(e.target.dataset.fee) || 0;
            document.getElementById('checkout-shipping-val').value = shippingFee;

            const feeLabel = document.getElementById('display-shipping-fee');
            if (shippingFee === 0) {
                feeLabel.textContent = 'GRATIS';
                feeLabel.className = 'font-bold text-emerald-600';
            } else {
                feeLabel.textContent = 'Rp ' + shippingFee.toLocaleString('id-ID');
                feeLabel.className = 'font-bold text-slate-900';
            }

            document.querySelectorAll('.courier-option').forEach(card => {
                card.classList.remove('border-[#E5252A]', 'bg-red-50/20');
                card.classList.add('border-slate-200');
            });
            e.target.closest('.courier-option').classList.add('border-[#E5252A]', 'bg-red-50/20');

            recalculateTotal();
        });
    });

    // 2. Payment Channel Radio styling
    document.querySelectorAll('input[name="payment_channel"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            document.querySelectorAll('.payment-channel-option').forEach(card => {
                card.classList.remove('border-[#E5252A]', 'bg-red-50/20');
                card.classList.add('border-slate-200');
            });
            e.target.closest('.payment-channel-option').classList.add('border-[#E5252A]', 'bg-red-50/20');
        });
    });

    // 3. Address Radio styling
    document.querySelectorAll('input[name="selected_address_id"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            document.querySelectorAll('#address-list-container .address-card-item').forEach(card => {
                card.classList.remove('border-[#E5252A]', 'bg-red-50/30');
                card.classList.add('border-slate-200');
            });
            const parentCard = e.target.closest('.address-card-item');
            if (parentCard) {
                parentCard.classList.remove('border-slate-200');
                parentCard.classList.add('border-[#E5252A]', 'bg-red-50/30');
            }
        });
    });

    // 4. Promo Code Handler
    const promoInput = document.getElementById('promo-code-input');
    const btnApplyPromo = document.getElementById('btn-apply-promo');
    const promoFeedback = document.getElementById('promo-feedback-msg');

    function applyPromoCode(code) {
        if (!code) return;

        const formData = new FormData();
        formData.append('promo_code', code);
        formData.append('subtotal', subtotal);

        fetch('<?php echo base_url("checkout/apply_promo"); ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                discountFee = parseFloat(data.discount) || 0;
                document.getElementById('checkout-discount-val').value = discountFee;
                document.getElementById('checkout-active-promo').value = data.code;

                document.getElementById('row-discount').classList.remove('hidden');
                document.getElementById('display-promo-code').textContent = data.code;
                document.getElementById('display-discount-fee').textContent = '-Rp ' + discountFee.toLocaleString('id-ID');

                promoFeedback.textContent = '✔ ' + data.message;
                promoFeedback.className = 'text-xs font-bold text-emerald-600 block';

                window.showNexusToast('Kupon ' + data.code + ' berhasil digunakan!', 'success');
                recalculateTotal();
            } else {
                promoFeedback.textContent = '✖ ' + (data.message || 'Kupon promo tidak valid');
                promoFeedback.className = 'text-xs font-bold text-red-600 block';
            }
        })
        .catch(err => {
            console.error(err);
            promoFeedback.textContent = '✖ Gagal memvalidasi kupon.';
            promoFeedback.className = 'text-xs font-bold text-red-600 block';
        });
    }

    btnApplyPromo.addEventListener('click', () => {
        applyPromoCode(promoInput.value.trim().toUpperCase());
    });

    document.querySelectorAll('.promo-quick-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            promoInput.value = chip.dataset.code;
            applyPromoCode(chip.dataset.code);
        });
    });

    // 5. Add Address Modal Form Submit
    const formNewAddress = document.getElementById('form-new-address');
    if (formNewAddress) {
        formNewAddress.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData();
            formData.append('recipient_name', document.getElementById('modal-name').value);
            formData.append('phone_number', document.getElementById('modal-phone').value);
            formData.append('full_address', document.getElementById('modal-address').value);
            formData.append('province', 'Jawa Barat');
            formData.append('city', document.getElementById('modal-city').value);
            formData.append('district', document.getElementById('modal-district').value);
            formData.append('postal_code', document.getElementById('modal-postal').value);
            formData.append('is_primary', document.getElementById('modal-primary').checked ? 1 : 0);

            fetch('<?php echo base_url("checkout/add_address"); ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    closeAddressModal();
                    window.showNexusToast('Alamat baru berhasil ditambahkan!', 'success');
                    setTimeout(() => window.location.reload(), 300);
                } else {
                    alert(data.message || 'Gagal menyimpan alamat.');
                }
            });
        });
    }

    // 5b. Edit Address Button Trigger
    document.querySelectorAll('.btn-edit-address').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            openEditAddressModal(btn);
        });
    });

    // 5c. Edit Address Form Submit
    const formEditAddress = document.getElementById('form-edit-address');
    if (formEditAddress) {
        formEditAddress.addEventListener('submit', (e) => {
            e.preventDefault();
            const btnSave = document.getElementById('btn-save-edit-address');
            btnSave.disabled = true;
            btnSave.textContent = 'Menyimpan...';

            const formData = new FormData();
            formData.append('address_id', document.getElementById('edit-modal-id').value);
            formData.append('recipient_name', document.getElementById('edit-modal-name').value);
            formData.append('phone_number', document.getElementById('edit-modal-phone').value);
            formData.append('full_address', document.getElementById('edit-modal-address').value);
            formData.append('province', 'Jawa Barat');
            formData.append('city', document.getElementById('edit-modal-city').value);
            formData.append('district', document.getElementById('edit-modal-district').value);
            formData.append('postal_code', document.getElementById('edit-modal-postal').value);
            formData.append('is_primary', document.getElementById('edit-modal-primary').checked ? 1 : 0);

            fetch('<?php echo base_url("checkout/update_address"); ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                btnSave.disabled = false;
                btnSave.textContent = 'Simpan Perubahan';
                if (data.status === 'success') {
                    closeEditAddressModal();
                    window.showNexusToast('Alamat berhasil diperbarui!', 'success');
                    setTimeout(() => window.location.reload(), 300);
                } else {
                    window.showNexusToast(data.message || 'Gagal memperbarui alamat.', 'error');
                }
            })
            .catch(err => {
                console.error(err);
                btnSave.disabled = false;
                btnSave.textContent = 'Simpan Perubahan';
                window.showNexusToast('Terjadi kesalahan koneksi.', 'error');
            });
        });
    }

    // 5d. Delete Address Trigger & Confirm
    document.querySelectorAll('.btn-delete-address').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            openDeleteAddressModal(btn.dataset.id, btn.dataset.name);
        });
    });

    const btnConfirmDeleteAddress = document.getElementById('btn-confirm-delete-address');
    if (btnConfirmDeleteAddress) {
        btnConfirmDeleteAddress.addEventListener('click', () => {
            const addressId = document.getElementById('pending-delete-address-id').value;
            if (!addressId) return;

            btnConfirmDeleteAddress.disabled = true;
            btnConfirmDeleteAddress.textContent = 'Menghapus...';

            const formData = new FormData();
            formData.append('address_id', addressId);

            fetch('<?php echo base_url("checkout/delete_address"); ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                btnConfirmDeleteAddress.disabled = false;
                btnConfirmDeleteAddress.textContent = 'Ya, Hapus Alamat';
                closeDeleteAddressModal();
                if (data.status === 'success') {
                    window.showNexusToast('Alamat berhasil dihapus!', 'success');
                    setTimeout(() => window.location.reload(), 300);
                } else {
                    window.showNexusToast(data.message || 'Gagal menghapus alamat.', 'error');
                }
            })
            .catch(err => {
                console.error(err);
                btnConfirmDeleteAddress.disabled = false;
                btnConfirmDeleteAddress.textContent = 'Ya, Hapus Alamat';
                window.showNexusToast('Terjadi kesalahan koneksi.', 'error');
            });
        });
    }

    // 6. Submit Final Order Checkout
    const btnSubmit = document.getElementById('btn-submit-order');
    btnSubmit.addEventListener('click', () => {
        // Collect address info
        let name = '', phone = '', address = '', city = 'Kota Bekasi', district = 'Bekasi Selatan', postal = '17148';

        const checkedRadio = document.querySelector('input[name="selected_address_id"]:checked');
        if (checkedRadio) {
            name = checkedRadio.dataset.name;
            phone = checkedRadio.dataset.phone;
            address = checkedRadio.dataset.address;
            city = checkedRadio.dataset.city;
            district = checkedRadio.dataset.district;
            postal = checkedRadio.dataset.postal;
        } else {
            const manName = document.getElementById('manual-name');
            const manPhone = document.getElementById('manual-phone');
            const manAddr = document.getElementById('manual-address');
            const manCity = document.getElementById('manual-city');
            const manPostal = document.getElementById('manual-postal');

            if (!manName.value || !manPhone.value || !manAddr.value) {
                window.showNexusToast('Mohon lengkapi data penerima dan alamat pengiriman.', 'error');
                return;
            }
            name = manName.value;
            phone = manPhone.value;
            address = manAddr.value;
            city = manCity.value;
            postal = manPostal.value;
        }

        const courier = document.querySelector('input[name="courier"]:checked').value;
        const payment = document.querySelector('input[name="payment_channel"]:checked').value;
        const promo = document.getElementById('checkout-active-promo').value;

        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span>Memproses Pembayaran Digital...</span>';

        const formData = new FormData();
        formData.append('recipient_name', name);
        formData.append('recipient_phone', phone);
        formData.append('shipping_address', address);
        formData.append('city', city);
        formData.append('district', district);
        formData.append('postal_code', postal);
        formData.append('shipping_courier', courier);
        formData.append('payment_method', payment);
        formData.append('promo_code', promo);

        fetch('<?php echo base_url("checkout/process"); ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                let targetUrl = data.redirect_url;
                if (!targetUrl && data.invoice_number) {
                    targetUrl = '<?php echo base_url("invoice/"); ?>' + data.invoice_number.replace('#', '');
                }
                if (targetUrl) {
                    targetUrl = targetUrl.replace('/#', '/');
                }
                window.location.href = targetUrl;
            } else {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<span>Bayar Sekarang (Konfirmasi)</span>';
                window.showNexusToast(data.message || 'Gagal memproses transaksi.', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<span>Bayar Sekarang (Konfirmasi)</span>';
            window.showNexusToast('Terjadi kesalahan saat memproses pesanan.', 'error');
        });
    });
});
</script>
