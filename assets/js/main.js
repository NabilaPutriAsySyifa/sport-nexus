/**
 * SPORT NEXUS - Global Utilities & Reactive Handlers
 */

(function () {
    'use strict';

    // 1. Toast Notification Utility
    window.showNexusToast = function (message, type = 'success') {
        let toast = document.getElementById('nexus-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'nexus-toast';
            document.body.appendChild(toast);
        }

        const isSuccess = type === 'success';
        const bgColor = isSuccess ? '#10B981' : '#E5252A';
        const icon = isSuccess ? '✔' : '✖';

        toast.innerHTML = `
            <div style="display: flex; align-items: center; gap: 10px; background-color: ${bgColor}; color: #ffffff; padding: 14px 22px; border-radius: 8px; font-weight: 600; font-size: 14px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); animation: slideInDown 0.3s ease;">
                <span style="font-size: 18px; line-height: 1;">${icon}</span>
                <span>${message}</span>
            </div>
        `;
        toast.style.display = 'block';

        setTimeout(() => {
            if (toast) toast.style.display = 'none';
        }, 3500);
    };

    // 2. Language Selector (i18n)
    const translations = {
        'id': {
            'store_location': 'Lokasi Toko',
            'sign_in': 'Masuk Akun',
            'help': 'Bantuan',
            'search_placeholder': 'Cari model sepatu, brand, atau SKU...',
            'explore_all': 'Jelajahi Semua Produk',
            'brands': 'MEREK',
            'sports': 'OLAHRAGA',
            'men': 'PRIA',
            'women': 'WANITA',
            'kids': 'ANAK',
            'sale': 'DISKON',
            'all_products': 'Semua Produk',
            'checkout': 'Bayar Sekarang',
            'add_to_cart': 'Tambah ke Keranjang',
            'select_size': 'Pilih Ukuran',
            'select_color': 'Pilih Warna',
            'out_of_stock': 'Stok Habis'
        },
        'en': {
            'store_location': 'Store Location',
            'sign_in': 'Sign In',
            'help': 'Help',
            'search_placeholder': 'Search shoe models, brands, or SKU...',
            'explore_all': 'Explore All Products',
            'brands': 'BRANDS',
            'sports': 'SPORTS',
            'men': 'MEN',
            'women': 'WOMEN',
            'kids': 'KIDS',
            'sale': 'SALE',
            'all_products': 'All Products',
            'checkout': 'Checkout',
            'add_to_cart': 'Add to Cart',
            'select_size': 'Select Size',
            'select_color': 'Select Color',
            'out_of_stock': 'Out of Stock'
        }
    };

    window.setLanguage = function (lang) {
        localStorage.setItem('nexus_lang', lang);
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (translations[lang] && translations[lang][key]) {
                if (el.tagName === 'INPUT') {
                    el.placeholder = translations[lang][key];
                } else {
                    el.textContent = translations[lang][key];
                }
            }
        });
        const langLabel = document.getElementById('current-lang-label');
        if (langLabel) langLabel.textContent = lang.toUpperCase();
    };

    // Initialize Language
    document.addEventListener('DOMContentLoaded', () => {
        const savedLang = localStorage.getItem('nexus_lang') || 'id';
        window.setLanguage(savedLang);

        // Update Cart Badge from LocalStorage if not logged in
        syncCartBadge();
    });

    function syncCartBadge() {
        const badge = document.getElementById('header-cart-badge');
        if (!badge) return;
        
        let guestCart = [];
        try {
            guestCart = JSON.parse(localStorage.getItem('nexus_guest_cart')) || [];
        } catch (e) { guestCart = []; }
        
        const count = guestCart.reduce((sum, it) => sum + (it.qty || 1), 0);
        if (count > 0) {
            badge.textContent = count;
            badge.style.display = 'inline-flex';
        }
    }

    window.updateCartBadge = function (newCount) {
        const badge = document.getElementById('header-cart-badge');
        if (badge) {
            badge.textContent = newCount;
            badge.style.display = newCount > 0 ? 'inline-flex' : 'none';
        }
    };

})();
