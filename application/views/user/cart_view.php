<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - SHOPPING CART VIEW
     Interactive Cart Items, Quantity Recalculation & Deletion Modal
     ========================================================================= -->

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-6">
        <a href="<?php echo base_url(); ?>" class="hover:text-[#E5252A]">Home</a>
        <span>/</span>
        <span class="text-slate-800 font-bold">Keranjang Belanja</span>
    </nav>

    <div class="flex items-center justify-between border-b border-slate-200 pb-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900">
            Keranjang Belanja (<span id="cart-total-items"><?php echo !empty($cart['count']) ? $cart['count'] : 0; ?></span>)
        </h1>
        <a href="<?php echo base_url('brands.html'); ?>" class="text-xs font-bold text-[#E5252A] hover:underline flex items-center space-x-1">
            <span>Lanjut Belanja Sepatu</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    <?php if (!empty($cart['items'])): ?>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8" id="cart-content-wrapper">

            <!-- Cart Items Table/List (Col 8) -->
            <div class="lg:col-span-8 space-y-4">
                
                <!-- Select All Bar -->
                <div class="bg-white px-5 py-3.5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-3 cursor-pointer select-none font-bold text-slate-800">
                        <input type="checkbox" id="check-all-items" class="w-4 h-4 rounded text-[#E5252A] focus:ring-[#E5252A] cursor-pointer" <?php echo ($cart['selected_count'] === $cart['count'] && $cart['count'] > 0) ? 'checked' : ''; ?>>
                        <span>Pilih Semua (<span id="selected-summary-count"><?php echo $cart['selected_count']; ?></span> dari <?php echo $cart['count']; ?> produk dipilih)</span>
                    </label>
                    <button type="button" id="btn-trigger-delete-selected" class="text-xs font-bold text-red-600 hover:text-[#E5252A] flex items-center space-x-1.5 transition-colors <?php echo ($cart['selected_count'] > 0) ? '' : 'hidden'; ?>">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>Hapus Produk Terpilih</span>
                    </button>
                </div>

                <?php foreach ($cart['items'] as $item): ?>
                    <?php 
                    $unit_price = isset($item['sale_price']) ? $item['sale_price'] : (isset($item['price']) ? $item['price'] : 0);
                    $item_total = $unit_price * (int)$item['qty'];
                    $is_sel = !empty($item['selected']);
                    ?>
                    <div class="cart-item-card bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center gap-4 transition-all <?php echo $is_sel ? 'border-slate-200 ring-1 ring-slate-100' : 'opacity-70 bg-slate-50/60 border-dashed border-slate-300'; ?>" data-item-key="<?php echo htmlspecialchars($item['key']); ?>">
                        
                        <!-- Item Selection Checkbox -->
                        <div class="flex-shrink-0 self-start sm:self-center pr-1">
                            <input type="checkbox" 
                                   class="item-checkbox w-4 h-4 rounded text-[#E5252A] focus:ring-[#E5252A] cursor-pointer" 
                                   data-key="<?php echo htmlspecialchars($item['key']); ?>" 
                                   data-unit-price="<?php echo $unit_price; ?>" 
                                   data-qty="<?php echo $item['qty']; ?>" 
                                   <?php echo $is_sel ? 'checked' : ''; ?> 
                                   title="Pilih produk ini untuk checkout">
                        </div>

                        <!-- Image -->
                        <div class="w-24 h-24 bg-slate-50 rounded-xl overflow-hidden border border-slate-200/80 flex-shrink-0 flex items-center justify-center p-2">
                            <?php 
                            $c_img = !empty($item['thumbnail']) ? $item['thumbnail'] : (!empty($item['image_url']) ? $item['image_url'] : base_url('assets/images/placeholder-shoe.png'));
                            ?>
                            <img src="<?php echo htmlspecialchars($c_img); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="max-h-full max-w-full object-contain">
                        </div>

                        <!-- Product Info -->
                        <div class="flex-grow space-y-1 text-center sm:text-left">
                            <span class="text-[11px] font-black uppercase text-slate-400 tracking-wider"><?php echo htmlspecialchars($item['brand_name']); ?></span>
                            <h3 class="font-bold text-sm text-slate-900 hover:text-[#E5252A] transition-colors">
                                <a href="<?php echo base_url('product/' . ($item['sku'] ?: $item['product_id'])); ?>">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </a>
                            </h3>
                            <div class="flex items-center justify-center sm:justify-start space-x-3 text-xs text-slate-600">
                                <span>Ukuran: <strong class="text-slate-800">EUR <?php echo htmlspecialchars($item['size_eu']); ?></strong></span>
                                <span>•</span>
                                <span>Warna: <strong class="text-slate-800"><?php echo htmlspecialchars($item['color']); ?></strong></span>
                            </div>
                            <div class="text-xs text-slate-500 font-semibold">
                                Rp <?php echo number_format($unit_price, 0, ',', '.'); ?> / pasang
                            </div>
                        </div>

                        <!-- Quantity Selector (- / +) -->
                        <div class="flex items-center space-x-2">
                            <div class="flex items-center border-2 border-slate-200 rounded-xl overflow-hidden bg-white shadow-sm">
                                <button type="button" class="btn-qty-minus w-9 h-9 flex items-center justify-center text-slate-700 hover:bg-[#E5252A] hover:text-white font-black text-sm transition-colors" data-key="<?php echo htmlspecialchars($item['key']); ?>" title="Kurangi Jumlah">-</button>
                                <span class="item-qty-display w-11 text-center text-xs font-black text-slate-900 select-none" data-key="<?php echo htmlspecialchars($item['key']); ?>"><?php echo $item['qty']; ?></span>
                                <button type="button" class="btn-qty-plus w-9 h-9 flex items-center justify-center text-slate-700 hover:bg-[#E5252A] hover:text-white font-black text-sm transition-colors" data-key="<?php echo htmlspecialchars($item['key']); ?>" title="Tambah Jumlah">+</button>
                            </div>
                        </div>

                        <!-- Subtotal & Delete Button -->
                        <div class="text-center sm:text-right flex sm:flex-col justify-between sm:justify-center items-center sm:items-end w-full sm:w-auto gap-2.5">
                            <div class="font-black text-base text-slate-900 item-subtotal" data-key="<?php echo htmlspecialchars($item['key']); ?>">
                                Rp <?php echo number_format($item_total, 0, ',', '.'); ?>
                            </div>
                            <button type="button" class="btn-trigger-delete text-red-600 hover:text-white bg-red-50 hover:bg-[#E5252A] border border-red-200 hover:border-[#E5252A] text-xs font-bold px-3 py-1.5 rounded-lg flex items-center space-x-1.5 transition-all shadow-sm" data-key="<?php echo htmlspecialchars($item['key']); ?>" data-name="<?php echo htmlspecialchars($item['name']); ?>">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Hapus</span>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Cart Summary Order Card (Col 4) -->
            <div class="lg:col-span-4">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5 sticky top-28">
                    <h3 class="font-black text-sm uppercase tracking-wider text-slate-900 border-b border-slate-100 pb-3">Ringkasan Belanja</h3>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Total Harga (<span id="summary-qty"><?php echo $cart['selected_count']; ?></span> barang)</span>
                            <span id="summary-subtotal" class="font-bold text-slate-900">Rp <?php echo number_format($cart['selected_total'], 0, ',', '.'); ?></span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Biaya Pengiriman</span>
                            <span class="font-bold text-emerald-600">GRATIS</span>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-sm font-black text-slate-900">Total Tagihan</span>
                            <span id="summary-grand-total" class="text-xl font-black text-[#E5252A]">Rp <?php echo number_format($cart['selected_total'], 0, ',', '.'); ?></span>
                        </div>
                    </div>

                    <!-- Customer Authentication Notice -->
                    <?php if (!$this->session->userdata('user_logged_in')): ?>
                        <div class="p-3.5 bg-amber-50 border border-amber-200 rounded-xl text-amber-900 text-[11px] space-y-1">
                            <div class="flex items-center space-x-1.5 font-bold text-amber-950">
                                <span>⚠️</span>
                                <span>Wajib Masuk Akun:</span>
                            </div>
                            <p class="text-amber-800 leading-relaxed">
                                Untuk menyelesaikan transaksi & simulasi pembayaran, Anda wajib masuk ke akun terdaftar Anda.
                            </p>
                        </div>
                    <?php endif; ?>

                    <!-- Checkout Button -->
                    <button type="button" id="btn-proceed-checkout" class="w-full bg-[#E5252A] hover:bg-[#c41c21] disabled:bg-slate-300 disabled:cursor-not-allowed text-white py-3.5 px-6 rounded-xl font-black text-xs uppercase tracking-wider flex items-center justify-center space-x-2 shadow-lg hover:shadow-red-500/25 transition-all" <?php echo ($cart['selected_count'] === 0) ? 'disabled' : ''; ?>>
                        <span><?php echo $this->session->userdata('user_logged_in') ? 'Lanjut ke Pembayaran' : 'Masuk Akun & Bayar'; ?></span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>

                    <div class="pt-2 text-[11px] text-slate-400 space-y-1.5 text-center">
                        <p>🔒 Transaksi aman dengan enkripsi SSL 256-bit</p>
                        <p>Simulasi pembayaran digital instan tanpa COD</p>
                    </div>
                </div>
            </div>

        </div>
    <?php else: ?>
        <!-- Empty Cart State -->
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center space-y-4 max-w-lg mx-auto shadow-sm">
            <div class="w-20 h-20 bg-red-50 text-[#E5252A] rounded-full flex items-center justify-center mx-auto">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <h3 class="text-xl font-black text-slate-900 uppercase">Keranjang Belanja Kosong</h3>
            <p class="text-xs sm:text-sm text-slate-500">
                Anda belum menambahkan sepatu olahraga ke dalam keranjang. Silakan jelajahi koleksi sepatu resmi terkurasi kami!
            </p>
            <div class="pt-3">
                <a href="<?php echo base_url('brands.html'); ?>" class="inline-flex items-center space-x-2 bg-[#E5252A] text-white text-xs font-bold px-7 py-3 rounded-xl shadow-lg hover:bg-[#c41c21] transition-all">
                    <span>Mulai Belanja Sepatu</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    <?php endif; ?>

</div>

<!-- Delete Confirmation Modal (Prompt: "Are you sure to delete the products?") -->
<div id="delete-confirm-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center space-x-3 text-red-600">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <div>
                <h4 class="font-black text-slate-900 text-sm">Hapus Produk dari Keranjang</h4>
                <p class="text-xs text-slate-500" id="delete-product-name-preview">Sepatu</p>
            </div>
        </div>

        <p class="text-xs text-slate-600 font-semibold py-2">
            Apakah Anda yakin ingin menghapus produk ini dari keranjang belanja?
        </p>

        <input type="hidden" id="pending-delete-key" value="">

        <div class="flex items-center space-x-3 pt-2">
            <button type="button" onclick="closeDeleteModal()" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold py-2.5 rounded-xl transition-colors">
                Batal
            </button>
            <button type="button" id="btn-confirm-delete" class="w-1/2 bg-[#E5252A] hover:bg-[#c41c21] text-white text-xs font-bold py-2.5 rounded-xl shadow transition-colors">
                Ya, Hapus Produk
            </button>
        </div>
    </div>
</div>

<!-- Modal: Konfirmasi Hapus Produk Terpilih -->
<div id="delete-selected-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center space-x-3 text-red-600">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <div>
                <h4 class="font-black text-slate-900 text-sm">Hapus Produk Terpilih</h4>
                <p class="text-xs text-slate-500">Hapus semua item yang sedang dicentang</p>
            </div>
        </div>

        <p class="text-xs text-slate-600 font-semibold py-2">
            Apakah Anda yakin ingin menghapus semua produk yang dicentang dari keranjang belanja?
        </p>

        <div class="flex items-center space-x-3 pt-2">
            <button type="button" onclick="closeDeleteSelectedModal()" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold py-2.5 rounded-xl transition-colors">
                Batal
            </button>
            <button type="button" id="btn-confirm-delete-selected" class="w-1/2 bg-[#E5252A] hover:bg-[#c41c21] text-white text-xs font-bold py-2.5 rounded-xl shadow transition-colors">
                Ya, Hapus Semua
            </button>
        </div>
    </div>
</div>

<script>
let activeDeleteKey = null;

function closeDeleteModal() {
    document.getElementById('delete-confirm-modal').classList.add('hidden');
    activeDeleteKey = null;
}

function closeDeleteSelectedModal() {
    document.getElementById('delete-selected-modal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
    // 1. Recalculate Selected Cart Helper
    function recalculateSelectedCart() {
        let totalCount = 0;
        let selectedCount = 0;
        let selectedTotal = 0;

        const allCheckboxes = document.querySelectorAll('.item-checkbox');
        totalCount = allCheckboxes.length;

        allCheckboxes.forEach(cb => {
            const card = cb.closest('.cart-item-card');
            if (cb.checked) {
                const qty = parseInt(cb.dataset.qty) || 1;
                const price = parseFloat(cb.dataset.unitPrice) || 0;
                selectedCount += qty;
                selectedTotal += price * qty;

                card.classList.remove('opacity-70', 'bg-slate-50/60', 'border-dashed', 'border-slate-300');
                card.classList.add('border-slate-200', 'ring-1', 'ring-slate-100');
            } else {
                card.classList.remove('border-slate-200', 'ring-1', 'ring-slate-100');
                card.classList.add('opacity-70', 'bg-slate-50/60', 'border-dashed', 'border-slate-300');
            }
        });

        // Update DOM elements
        const summaryCountEl = document.getElementById('selected-summary-count');
        if (summaryCountEl) summaryCountEl.textContent = selectedCount;

        const summaryQtyEl = document.getElementById('summary-qty');
        if (summaryQtyEl) summaryQtyEl.textContent = selectedCount;

        const subtotalEl = document.getElementById('summary-subtotal');
        if (subtotalEl) subtotalEl.textContent = 'Rp ' + selectedTotal.toLocaleString('id-ID');

        const grandTotalEl = document.getElementById('summary-grand-total');
        if (grandTotalEl) grandTotalEl.textContent = 'Rp ' + selectedTotal.toLocaleString('id-ID');

        const checkAllEl = document.getElementById('check-all-items');
        if (checkAllEl) {
            const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
            checkAllEl.checked = (checkedBoxes.length === totalCount && totalCount > 0);
        }

        const btnDeleteSelected = document.getElementById('btn-trigger-delete-selected');
        if (btnDeleteSelected) {
            if (selectedCount > 0) {
                btnDeleteSelected.classList.remove('hidden');
            } else {
                btnDeleteSelected.classList.add('hidden');
            }
        }

        const btnCheckout = document.getElementById('btn-proceed-checkout');
        if (btnCheckout) {
            btnCheckout.disabled = (selectedCount === 0);
        }
    }

    // 2. Individual Checkbox Change
    document.querySelectorAll('.item-checkbox').forEach(cb => {
        cb.addEventListener('change', () => {
            recalculateSelectedCart();

            const formData = new FormData();
            formData.append('key', cb.dataset.key);
            formData.append('selected', cb.checked ? 1 : 0);

            fetch('<?php echo base_url("cart/toggle_select"); ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
        });
    });

    // 3. Select All Checkbox Change
    const checkAll = document.getElementById('check-all-items');
    if (checkAll) {
        checkAll.addEventListener('change', () => {
            const isChecked = checkAll.checked;
            document.querySelectorAll('.item-checkbox').forEach(cb => {
                cb.checked = isChecked;
            });
            recalculateSelectedCart();

            const formData = new FormData();
            formData.append('selected', isChecked ? 1 : 0);

            fetch('<?php echo base_url("cart/select_all"); ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
        });
    }

    // 4. Delete Single Item Trigger Buttons
    document.querySelectorAll('.btn-trigger-delete').forEach(btn => {
        btn.addEventListener('click', () => {
            activeDeleteKey = btn.dataset.key;
            document.getElementById('pending-delete-key').value = activeDeleteKey;
            document.getElementById('delete-product-name-preview').textContent = btn.dataset.name;
            document.getElementById('delete-confirm-modal').classList.remove('hidden');
        });
    });

    // 5. Confirm Single Item Delete Execution
    document.getElementById('btn-confirm-delete').addEventListener('click', () => {
        const key = document.getElementById('pending-delete-key').value;
        if (!key) return;

        const formData = new FormData();
        formData.append('key', key);

        fetch('<?php echo base_url("cart/remove"); ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            closeDeleteModal();
            if (data.status === 'success') {
                window.showNexusToast('Item telah dihapus dari keranjang.', 'success');
                setTimeout(() => window.location.reload(), 300);
            }
        })
        .catch(err => {
            console.error(err);
            window.showNexusToast('Gagal menghapus produk.', 'error');
        });
    });

    // 6. Delete Selected Items Trigger & Confirm
    const btnTriggerDeleteSelected = document.getElementById('btn-trigger-delete-selected');
    if (btnTriggerDeleteSelected) {
        btnTriggerDeleteSelected.addEventListener('click', () => {
            document.getElementById('delete-selected-modal').classList.remove('hidden');
        });
    }

    const btnConfirmDeleteSelected = document.getElementById('btn-confirm-delete-selected');
    if (btnConfirmDeleteSelected) {
        btnConfirmDeleteSelected.addEventListener('click', () => {
            btnConfirmDeleteSelected.disabled = true;
            btnConfirmDeleteSelected.textContent = 'Menghapus...';

            fetch('<?php echo base_url("cart/remove_selected"); ?>', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                closeDeleteSelectedModal();
                if (data.status === 'success') {
                    window.showNexusToast('Produk terpilih telah dihapus.', 'success');
                    setTimeout(() => window.location.reload(), 300);
                }
            })
            .catch(err => {
                console.error(err);
                btnConfirmDeleteSelected.disabled = false;
                btnConfirmDeleteSelected.textContent = 'Ya, Hapus Semua';
                window.showNexusToast('Gagal menghapus produk terpilih.', 'error');
            });
        });
    }

    // 7. Proceed to Checkout Button
    const btnProceedCheckout = document.getElementById('btn-proceed-checkout');
    if (btnProceedCheckout) {
        btnProceedCheckout.addEventListener('click', () => {
            const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
            if (checkedBoxes.length === 0) {
                window.showNexusToast('Silakan pilih minimal 1 produk untuk melanjutkan ke pembayaran.', 'error');
                return;
            }
            <?php if (!$this->session->userdata('user_logged_in')): ?>
                window.showNexusToast('Wajib login akun terlebih dahulu sebelum ke pembayaran!', 'warning');
                setTimeout(() => {
                    window.location.href = '<?php echo base_url("signin.html?redirect=checkout.html"); ?>';
                }, 400);
            <?php else: ?>
                window.location.href = '<?php echo base_url("checkout.html"); ?>';
            <?php endif; ?>
        });
    }

    // 8. Update Quantity Controls
    function updateItemQty(key, newQty) {
        if (newQty < 1) return;

        const formData = new FormData();
        formData.append('key', key);
        formData.append('qty', newQty);

        fetch('<?php echo base_url("cart/update"); ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                window.location.reload();
            }
        });
    }

    document.querySelectorAll('.btn-qty-minus').forEach(btn => {
        btn.addEventListener('click', () => {
            const key = btn.dataset.key;
            const display = document.querySelector(`.item-qty-display[data-key="${key}"]`);
            let curr = parseInt(display.textContent) || 1;
            if (curr > 1) {
                updateItemQty(key, curr - 1);
            } else {
                const deleteBtn = document.querySelector(`.btn-trigger-delete[data-key="${key}"]`);
                if (deleteBtn) {
                    deleteBtn.click();
                }
            }
        });
    });

    document.querySelectorAll('.btn-qty-plus').forEach(btn => {
        btn.addEventListener('click', () => {
            const key = btn.dataset.key;
            const display = document.querySelector(`.item-qty-display[data-key="${key}"]`);
            let curr = parseInt(display.textContent) || 1;
            updateItemQty(key, curr + 1);
        });
    });
});
</script>
