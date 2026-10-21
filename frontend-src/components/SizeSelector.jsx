import React, { useState } from 'react';

export default function SizeSelector({ 
  product = {}, 
  availableSizes = [], 
  availableColors = [],
  baseUrl = '',
  onAddToCartSuccess
}) {
  const [selectedSize, setSelectedSize] = useState(null);
  const [selectedColor, setSelectedColor] = useState(availableColors[0] || product.color || 'Default');
  const [quantity, setQuantity] = useState(1);
  const [errorMessage, setErrorMessage] = useState('');
  const [isSubmitting, setIsSubmitting] = useState(false);

  // Default sizes if none passed
  const sizes = availableSizes.length > 0 ? availableSizes : [
    { eu: '39', us: '6.5', stock: 4 },
    { eu: '40', us: '7', stock: 8 },
    { eu: '41', us: '8', stock: 10 },
    { eu: '42', us: '8.5', stock: 6 },
    { eu: '43', us: '9.5', stock: 2 },
    { eu: '44', us: '10', stock: 0 }, // out of stock
  ];

  const handleAddToCart = async () => {
    if (!selectedSize) {
      setErrorMessage('Silakan pilih ukuran sepatu terlebih dahulu');
      return;
    }
    setErrorMessage('');
    setIsSubmitting(true);

    const payload = {
      product_id: product.id,
      sku: product.sku,
      name: product.name,
      brand: product.brand_name,
      price: product.sale_price || product.original_price,
      original_price: product.original_price,
      thumbnail: product.thumbnail,
      size: selectedSize.eu,
      color: selectedColor,
      qty: quantity
    };

    try {
      // 1. Try sending to CI3 backend cart endpoint
      const response = await fetch(`${baseUrl}cart/add_ajax`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(payload)
      });

      // 2. LocalStorage sync for Guest Cart support
      let guestCart = JSON.parse(localStorage.getItem('sport_nexus_cart') || '[]');
      const existingIdx = guestCart.findIndex(
        item => item.sku === payload.sku && item.size === payload.size && item.color === payload.color
      );
      if (existingIdx > -1) {
        guestCart[existingIdx].qty += quantity;
      } else {
        guestCart.push(payload);
      }
      localStorage.setItem('sport_nexus_cart', JSON.stringify(guestCart));

      // 3. Update navbar badge counter
      const totalCount = guestCart.reduce((sum, item) => sum + item.qty, 0);
      const badgeElem = document.getElementById('navbar-cart-badge');
      if (badgeElem) {
        badgeElem.textContent = totalCount;
        badgeElem.classList.remove('hidden');
      }

      // 4. Trigger global toast notification
      if (window.showToast) {
        window.showToast('✔ Produk berhasil ditambahkan ke keranjang belanja!', 'success');
      }

      if (onAddToCartSuccess) {
        onAddToCartSuccess(payload);
      }
    } catch (err) {
      console.warn('Network sync failed, stored in LocalStorage fallback:', err);
      // Fallback: stored in LocalStorage
      let guestCart = JSON.parse(localStorage.getItem('sport_nexus_cart') || '[]');
      guestCart.push(payload);
      localStorage.setItem('sport_nexus_cart', JSON.stringify(guestCart));

      if (window.showToast) {
        window.showToast('✔ Produk berhasil ditambahkan ke keranjang belanja!', 'success');
      }
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <div className="space-y-6">
      {/* Error Alert if size not chosen */}
      {errorMessage && (
        <div className="p-3 bg-red-50 border-l-4 border-sport-red text-xs text-red-700 font-semibold flex items-center space-x-2 rounded-r">
          <svg className="w-4 h-4 text-sport-red flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fillRule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clipRule="evenodd" />
          </svg>
          <span>{errorMessage}</span>
        </div>
      )}

      {/* Color Selector */}
      <div>
        <div className="flex items-center justify-between mb-2">
          <label className="font-heading font-bold text-xs uppercase tracking-wider text-slate-800">
            Pilih Warna: <span className="text-sport-red font-semibold capitalize">{selectedColor}</span>
          </label>
        </div>
        <div className="flex items-center space-x-3">
          {(availableColors.length > 0 ? availableColors : [product.color || 'Standard']).map((col) => {
            const isSelected = selectedColor === col;
            return (
              <button
                key={col}
                type="button"
                onClick={() => setSelectedColor(col)}
                className={`px-3 py-1.5 rounded-lg text-xs font-semibold border transition-all ${
                  isSelected 
                    ? 'border-2 border-sport-red bg-sport-red/5 text-slate-900 shadow-sm'
                    : 'border-slate-300 bg-white text-slate-700 hover:border-slate-400'
                }`}
              >
                {col}
              </button>
            );
          })}
        </div>
      </div>

      {/* Size Pill Buttons */}
      <div>
        <div className="flex items-center justify-between mb-2">
          <label className="font-heading font-bold text-xs uppercase tracking-wider text-slate-800">
            Pilih Ukuran (EUR): {selectedSize && <span className="text-sport-red font-semibold">EU {selectedSize.eu} (US {selectedSize.us})</span>}
          </label>
          <a href="#size-guide" className="text-xs text-slate-400 hover:text-sport-red underline">
            Panduan Ukuran
          </a>
        </div>

        <div className="grid grid-cols-4 sm:grid-cols-6 gap-2">
          {sizes.map((sz) => {
            const isOut = sz.stock <= 0;
            const isSelected = selectedSize && selectedSize.eu === sz.eu;

            return (
              <button
                key={sz.eu}
                type="button"
                disabled={isOut}
                onClick={() => {
                  setSelectedSize(sz);
                  setErrorMessage('');
                }}
                className={`py-2 px-3 rounded-xl border text-center transition-all ${
                  isOut
                    ? 'bg-slate-100 text-slate-300 border-slate-200 cursor-not-allowed line-through'
                    : isSelected
                    ? 'border-2 border-sport-red bg-red-50/50 text-slate-900 font-bold shadow-md scale-105'
                    : 'bg-white text-slate-800 border-slate-300 hover:border-slate-500'
                }`}
              >
                <div className="text-xs font-black">EU {sz.eu}</div>
                <div className="text-[10px] text-slate-400">US {sz.us}</div>
              </button>
            );
          })}
        </div>
      </div>

      {/* Quantity Adjuster */}
      <div className="flex items-center space-x-4">
        <label className="font-heading font-bold text-xs uppercase tracking-wider text-slate-800">
          Jumlah:
        </label>
        <div className="flex items-center border border-slate-300 rounded-lg overflow-hidden bg-white">
          <button 
            type="button"
            onClick={() => setQuantity(Math.max(1, quantity - 1))}
            className="px-3 py-1.5 text-slate-600 hover:bg-slate-100 font-bold"
          >
            -
          </button>
          <span className="px-4 py-1.5 text-xs font-bold text-slate-900 min-w-[32px] text-center">
            {quantity}
          </span>
          <button 
            type="button"
            onClick={() => setQuantity(quantity + 1)}
            className="px-3 py-1.5 text-slate-600 hover:bg-slate-100 font-bold"
          >
            +
          </button>
        </div>
      </div>

      {/* Add To Cart Button */}
      <div className="pt-2">
        <button
          type="button"
          onClick={handleAddToCart}
          disabled={isSubmitting}
          className="w-full py-3.5 bg-sport-red hover:bg-[#c41c21] text-white font-heading font-black text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-red-500/20 active:scale-95 transition-all duration-200 flex items-center justify-center space-x-2"
        >
          <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
          </svg>
          <span>{isSubmitting ? 'Menambahkan...' : 'Tambah ke Keranjang'}</span>
        </button>
      </div>
    </div>
  );
}
