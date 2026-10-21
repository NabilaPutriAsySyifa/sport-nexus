import React, { useState, useEffect } from 'react';

export default function CartDrawer({ baseUrl = '', initialItems = [] }) {
  const [cartItems, setCartItems] = useState([]);
  const [selectedIndices, setSelectedIndices] = useState([]);
  const [deleteModalItem, setDeleteModalItem] = useState(null);

  // Load from LocalStorage or initialItems on mount
  useEffect(() => {
    let items = initialItems;
    if (!items || items.length === 0) {
      try {
        const local = localStorage.getItem('sport_nexus_cart');
        if (local) {
          items = JSON.parse(local);
        }
      } catch (e) {
        console.error('Error reading localStorage cart:', e);
      }
    }
    setCartItems(items || []);
    // By default select all items
    setSelectedIndices((items || []).map((_, i) => i));
  }, []);

  const saveCart = (newItems) => {
    setCartItems(newItems);
    localStorage.setItem('sport_nexus_cart', JSON.stringify(newItems));
    
    // Update navbar badge
    const totalCount = newItems.reduce((sum, item) => sum + (item.qty || 1), 0);
    const badgeElem = document.getElementById('navbar-cart-badge');
    if (badgeElem) {
      badgeElem.textContent = totalCount;
      if (totalCount > 0) badgeElem.classList.remove('hidden');
      else badgeElem.classList.add('hidden');
    }
  };

  const updateQty = (index, delta) => {
    const updated = [...cartItems];
    const newQty = (updated[index].qty || 1) + delta;
    if (newQty < 1) return;
    updated[index].qty = newQty;
    saveCart(updated);
  };

  const confirmDelete = (item) => {
    setDeleteModalItem(item);
  };

  const handleDeleteApproved = () => {
    if (!deleteModalItem) return;
    const updated = cartItems.filter(item => item !== deleteModalItem);
    saveCart(updated);
    setDeleteModalItem(null);
    setSelectedIndices(updated.map((_, i) => i));
    if (window.showToast) {
      window.showToast('Produk dihapus dari keranjang', 'info');
    }
  };

  const toggleSelectAll = () => {
    if (selectedIndices.length === cartItems.length) {
      setSelectedIndices([]);
    } else {
      setSelectedIndices(cartItems.map((_, i) => i));
    }
  };

  const toggleSelect = (index) => {
    if (selectedIndices.includes(index)) {
      setSelectedIndices(selectedIndices.filter(i => i !== index));
    } else {
      setSelectedIndices([...selectedIndices, index]);
    }
  };

  const formatRupiah = (num) => {
    return 'Rp ' + Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  };

  // Calculations
  const selectedItems = cartItems.filter((_, i) => selectedIndices.includes(i));
  const subtotalOriginal = selectedItems.reduce((sum, item) => {
    const orig = parseFloat(item.original_price || item.price || 0);
    return sum + (orig * (item.qty || 1));
  }, 0);

  const subtotalFinal = selectedItems.reduce((sum, item) => {
    const p = parseFloat(item.price || 0);
    return sum + (p * (item.qty || 1));
  }, 0);

  const discountTotal = subtotalOriginal - subtotalFinal;

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <h1 className="font-heading font-black text-2xl uppercase tracking-tight text-slate-900 mb-6">
        Shopping Cart
      </h1>

      {cartItems.length === 0 ? (
        <div className="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
          <div className="w-20 h-20 mx-auto mb-4 bg-slate-100 rounded-full flex items-center justify-center text-slate-400">
            <svg className="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
          </div>
          <h2 className="font-heading font-bold text-lg text-slate-800 mb-2">Keranjang Belanja Kosong</h2>
          <p className="text-xs text-slate-500 max-w-sm mx-auto mb-6">
            Jelajahi koleksi alas kaki terkurasi kami dari 6 brand resmi Sport Nexus.
          </p>
          <a
            href={`${baseUrl}brands.html`}
            className="inline-block px-6 py-3 bg-sport-red hover:bg-[#c41c21] text-white text-xs font-heading font-black uppercase tracking-wider rounded-xl shadow-md transition-colors"
          >
            Mulai Belanja Sepatu
          </a>
        </div>
      ) : (
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
          {/* Main Cart Items List */}
          <div className="lg:col-span-2 space-y-4">
            {/* Header / Select All */}
            <div className="bg-white border border-slate-200 rounded-xl p-4 flex items-center justify-between shadow-sm">
              <label className="flex items-center space-x-3 cursor-pointer select-none">
                <input 
                  type="checkbox"
                  checked={selectedIndices.length === cartItems.length && cartItems.length > 0}
                  onChange={toggleSelectAll}
                  className="w-4 h-4 rounded border-slate-300 text-sport-red focus:ring-sport-red accent-sport-red"
                />
                <span className="text-xs font-bold text-slate-800">
                  All Products ({cartItems.length})
                </span>
              </label>
              <span className="text-xs text-slate-400">
                {selectedIndices.length} produk terpilih
              </span>
            </div>

            {/* Product Items */}
            {cartItems.map((item, index) => {
              const isChecked = selectedIndices.includes(index);
              return (
                <div 
                  key={`${item.sku}-${item.size}-${index}`}
                  className="bg-white border border-slate-200 rounded-xl p-4 flex items-start space-x-4 shadow-sm"
                >
                  {/* Item Checkbox */}
                  <input 
                    type="checkbox"
                    checked={isChecked}
                    onChange={() => toggleSelect(index)}
                    className="mt-6 w-4 h-4 rounded border-slate-300 text-sport-red focus:ring-sport-red accent-sport-red"
                  />

                  {/* Thumbnail */}
                  <div className="w-20 h-20 bg-slate-50 rounded-lg p-2 border border-slate-100 flex-shrink-0">
                    <img 
                      src={item.thumbnail || '/assets/images/placeholder-shoe.png'} 
                      alt={item.name}
                      className="w-full h-full object-contain"
                    />
                  </div>

                  {/* Details */}
                  <div className="flex-grow">
                    <p className="text-[10px] font-bold uppercase text-slate-400">{item.brand || 'Sport Nexus'}</p>
                    <h3 className="font-heading font-bold text-xs sm:text-sm text-slate-900 leading-snug">
                      {item.name}
                    </h3>
                    <div className="flex items-center space-x-3 text-xs text-slate-500 mt-1">
                      <span>Varian: <strong className="text-slate-800">{item.color || 'Standard'}</strong></span>
                      <span>•</span>
                      <span>Ukuran: <strong className="text-sport-red font-bold">EU {item.size}</strong></span>
                    </div>
                    <div className="text-[10px] text-slate-400 font-mono mt-0.5">
                      SKU: {item.sku}
                    </div>

                    <div className="flex items-center justify-between mt-4">
                      {/* Price */}
                      <div className="flex items-baseline space-x-2">
                        <span className="text-sm font-black text-slate-900">
                          {formatRupiah(item.price)}
                        </span>
                        {item.original_price && parseFloat(item.original_price) > parseFloat(item.price) && (
                          <span className="text-xs text-slate-400 line-through">
                            {formatRupiah(item.original_price)}
                          </span>
                        )}
                      </div>

                      {/* Quantity & Delete Controls */}
                      <div className="flex items-center space-x-3">
                        <div className="flex items-center border border-slate-300 rounded-lg overflow-hidden bg-white text-xs">
                          <button 
                            type="button"
                            onClick={() => updateQty(index, -1)}
                            className="px-2.5 py-1 text-slate-600 hover:bg-slate-100 font-bold"
                          >
                            -
                          </button>
                          <span className="px-3 py-1 font-bold text-slate-900">
                            {item.qty || 1}
                          </span>
                          <button 
                            type="button"
                            onClick={() => updateQty(index, 1)}
                            className="px-2.5 py-1 text-slate-600 hover:bg-slate-100 font-bold"
                          >
                            +
                          </button>
                        </div>

                        {/* Trash Icon */}
                        <button 
                          type="button"
                          onClick={() => confirmDelete(item)}
                          className="p-1.5 text-slate-400 hover:text-sport-red transition-colors"
                          title="Hapus Produk"
                        >
                          <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>

          {/* Right Panel: Order Summary */}
          <div className="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-5 sticky top-24">
            <h2 className="font-heading font-black text-sm uppercase tracking-wider text-slate-900 border-b border-slate-100 pb-3">
              Order Summary ({selectedItems.length} items)
            </h2>

            <div className="space-y-3 text-xs">
              <div className="flex justify-between text-slate-600">
                <span>Subtotal (Harga Normal)</span>
                <span>{formatRupiah(subtotalOriginal)}</span>
              </div>
              {discountTotal > 0 && (
                <div className="flex justify-between text-sport-red font-semibold">
                  <span>Potongan Diskon Promo</span>
                  <span>-{formatRupiah(discountTotal)}</span>
                </div>
              )}
              <div className="flex justify-between text-slate-600">
                <span>Estimasi Pengiriman</span>
                <span className="text-emerald-600 font-bold">Gratis Ongkir</span>
              </div>
              <div className="border-t border-slate-200 pt-3 flex justify-between items-baseline">
                <span className="font-heading font-bold text-sm text-slate-900">Total Tagihan</span>
                <span className="font-heading font-black text-lg text-sport-red">
                  {formatRupiah(subtotalFinal)}
                </span>
              </div>
            </div>

            <a
              href={selectedItems.length > 0 ? `${baseUrl}checkout.html` : '#'}
              onClick={(e) => {
                if (selectedItems.length === 0) {
                  e.preventDefault();
                  alert('Pilih setidaknya 1 produk untuk checkout.');
                }
              }}
              className={`block w-full text-center py-3.5 font-heading font-black text-xs uppercase tracking-wider rounded-xl shadow-lg transition-all ${
                selectedItems.length > 0 
                  ? 'bg-sport-red hover:bg-[#c41c21] text-white shadow-red-500/20 active:scale-95'
                  : 'bg-slate-200 text-slate-400 cursor-not-allowed'
              }`}
            >
              Lanjut ke Checkout
            </a>

            <div className="text-[11px] text-slate-400 text-center flex items-center justify-center space-x-1">
              <svg className="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
              </svg>
              <span>100% Produk Asli & Garansi Resmi Sport Nexus</span>
            </div>
          </div>
        </div>
      )}

      {/* Delete Confirmation Modal */}
      {deleteModalItem && (
        <div className="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
          <div className="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl text-center space-y-4 animate-scale-up">
            <div className="w-12 h-12 rounded-full bg-red-100 text-sport-red mx-auto flex items-center justify-center">
              <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </div>
            <h3 className="font-heading font-black text-sm uppercase text-slate-900">
              Konfirmasi Hapus Produk
            </h3>
            <p className="text-xs text-slate-600 leading-relaxed">
              Are you sure to delete the products?
            </p>
            <div className="grid grid-cols-2 gap-3 pt-2">
              <button 
                type="button"
                onClick={() => setDeleteModalItem(null)}
                className="py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors"
              >
                No
              </button>
              <button 
                type="button"
                onClick={handleDeleteApproved}
                className="py-2.5 px-4 bg-sport-red hover:bg-[#c41c21] text-white text-xs font-bold rounded-xl shadow-md shadow-red-500/20 transition-colors"
              >
                Yes
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
