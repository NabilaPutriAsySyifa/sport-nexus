import React, { useState, useEffect } from 'react';

export default function CheckoutWizard({ baseUrl = '', currentUser = null }) {
  // Multi-Addresses (> 2 addresses supported)
  const [addresses, setAddresses] = useState([
    {
      id: 1,
      name: 'Nabila Putri Asy Syifa',
      phone: '085711942921',
      address: 'Perum Rancamanyar Blok J6 No. 13 RT 006/007, Desa Wanasari',
      district: 'Kec. Telukjambe Barat',
      city: 'Kab. Karawang',
      province: 'Jawa Barat',
      postal_code: '41361',
      is_default: true
    },
    {
      id: 2,
      name: 'Nabila Putri (Kantor)',
      phone: '085711942921',
      address: 'Grand Metropolitan Mall Lt. 2 No. 16, Jl. KH. Noer Ali',
      district: 'Kec. Bekasi Selatan',
      city: 'Kota Bekasi',
      province: 'Jawa Barat',
      postal_code: '17148',
      is_default: false
    },
    {
      id: 3,
      name: 'Rumah Keluarga Syifa',
      phone: '081298765432',
      address: 'Jl. Ahmad Yani No. 1 RT 004/001, Marga Jaya',
      district: 'Kec. Bekasi Selatan',
      city: 'Kota Bekasi',
      province: 'Jawa Barat',
      postal_code: '17141',
      is_default: false
    }
  ]);
  const [selectedAddressId, setSelectedAddressId] = useState(1);
  const [showAddressModal, setShowAddressModal] = useState(false);
  const [newAddress, setNewAddress] = useState({
    name: '', phone: '', address: '', province: 'Jawa Barat', city: 'Kab. Karawang', district: 'Telukjambe Barat', postal_code: ''
  });

  // Pay With options (Strictly NO COD)
  const [paymentMethod, setPaymentMethod] = useState('va_bca');
  const [billingSameAsShipping, setBillingSameAsShipping] = useState(true);
  const [shippingMethod, setShippingMethod] = useState('regular');

  // Promo Code
  const [promoCodeInput, setPromoCodeInput] = useState('');
  const [appliedPromo, setAppliedPromo] = useState(null);
  const [promoError, setPromoError] = useState('');

  // Agreement Checkbox
  const [termsAgreed, setTermsAgreed] = useState(true);

  // Cart Items
  const [checkoutItems, setCheckoutItems] = useState([]);
  const [isSubmitting, setIsSubmitting] = useState(false);

  useEffect(() => {
    try {
      const local = localStorage.getItem('sport_nexus_cart');
      if (local) {
        setCheckoutItems(JSON.parse(local));
      }
    } catch (e) {
      console.error(e);
    }
  }, []);

  const handleApplyPromo = () => {
    const code = promoCodeInput.trim().toUpperCase();
    setPromoError('');
    if (!code) return;

    if (code === 'NEXUS50') {
      setAppliedPromo({ code: 'NEXUS50', discount: 50000, desc: 'Potongan Rp 50.000 Spesial Nexus' });
    } else if (code === 'DISKON10') {
      setAppliedPromo({ code: 'DISKON10', percent: 10, desc: 'Diskon 10% Semua Produk' });
    } else if (code === 'NEXUSHEMAT') {
      setAppliedPromo({ code: 'NEXUSHEMAT', discount: 25000, desc: 'Potongan Rp 25.000 Voucher Promo' });
    } else {
      setPromoError('Kode promo tidak valid atau telah kadaluarsa.');
      setAppliedPromo(null);
    }
  };

  const handleSaveAddress = (e) => {
    e.preventDefault();
    if (!newAddress.name || !newAddress.phone || !newAddress.address || !newAddress.postal_code) {
      alert('Lengkapi seluruh kolom alamat terlebih dahulu.');
      return;
    }
    const newId = Date.now();
    const created = { ...newAddress, id: newId, is_default: false };
    setAddresses([...addresses, created]);
    setSelectedAddressId(newId);
    setShowAddressModal(false);
    setNewAddress({ name: '', phone: '', address: '', province: 'Jawa Barat', city: 'Kab. Karawang', district: 'Telukjambe Barat', postal_code: '' });
  };

  const handleDeleteAddress = (id) => {
    if (addresses.length <= 1) {
      alert('Minimal harus memiliki 1 alamat pengiriman.');
      return;
    }
    const filtered = addresses.filter(a => a.id !== id);
    setAddresses(filtered);
    if (selectedAddressId === id) {
      setSelectedAddressId(filtered[0].id);
    }
  };

  const formatRupiah = (num) => {
    return 'Rp ' + Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  };

  // Calculations
  const subtotal = checkoutItems.reduce((sum, item) => sum + (parseFloat(item.price || 0) * (item.qty || 1)), 0);
  const shippingFee = shippingMethod === 'express' ? 25000 : 0; // regular is free promo
  
  let discountAmount = 0;
  if (appliedPromo) {
    if (appliedPromo.discount) discountAmount = appliedPromo.discount;
    else if (appliedPromo.percent) discountAmount = (subtotal * appliedPromo.percent) / 100;
  }
  const grandTotal = Math.max(0, subtotal + shippingFee - discountAmount);

  const handleFinalCheckout = async () => {
    if (!termsAgreed) {
      alert('Anda wajib menyetujui Ketentuan Layanan & Kebijakan Privasi.');
      return;
    }
    if (checkoutItems.length === 0) {
      alert('Keranjang belanja kosong.');
      return;
    }

    setIsSubmitting(true);
    const selectedAddr = addresses.find(a => a.id === selectedAddressId) || addresses[0];

    const payload = {
      address: selectedAddr,
      payment_method: paymentMethod,
      shipping_method: shippingMethod,
      promo_code: appliedPromo ? appliedPromo.code : null,
      items: checkoutItems,
      subtotal,
      shipping_fee: shippingFee,
      discount: discountAmount,
      total: grandTotal
    };

    try {
      const resp = await fetch(`${baseUrl}checkout/process_ajax`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(payload)
      });
      const res = await resp.json();
      if (res && res.invoice_url) {
        localStorage.removeItem('sport_nexus_cart');
        window.location.href = res.invoice_url;
      } else {
        // Fallback simulate redirect to invoice
        localStorage.removeItem('sport_nexus_cart');
        window.location.href = `${baseUrl}invoice.html?order_id=SN-${Date.now().toString().slice(-6)}`;
      }
    } catch (e) {
      localStorage.removeItem('sport_nexus_cart');
      window.location.href = `${baseUrl}invoice.html?order_id=SN-${Date.now().toString().slice(-6)}`;
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <h1 className="font-heading font-black text-2xl uppercase tracking-tight text-slate-900 mb-8">
        Multi-Step Checkout
      </h1>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        {/* Left 2 Cols: The 3 Steps Form */}
        <div className="lg:col-span-2 space-y-6">
          
          {/* STEP 1: Ship To (Multi-Address) */}
          <div className="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div className="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
              <h2 className="font-heading font-black text-sm uppercase text-slate-900 flex items-center space-x-2">
                <span className="w-6 h-6 rounded-full bg-sport-red text-white flex items-center justify-center text-xs font-bold">1</span>
                <span>Ship To (Alamat Pengiriman)</span>
              </h2>
              <button 
                type="button"
                onClick={() => setShowAddressModal(true)}
                className="text-xs text-sport-red hover:underline font-bold flex items-center space-x-1"
              >
                <span>+ Add New Address</span>
              </button>
            </div>

            {/* Address List with Radio Button */}
            <div className="space-y-3">
              {addresses.map((addr) => {
                const isSelected = addr.id === selectedAddressId;
                return (
                  <label 
                    key={addr.id}
                    className={`block p-4 rounded-xl border transition-all cursor-pointer ${
                      isSelected 
                        ? 'border-2 border-sport-red bg-red-50/20 shadow-sm'
                        : 'border-slate-200 hover:border-slate-300 bg-white'
                    }`}
                  >
                    <div className="flex items-start space-x-3">
                      <input 
                        type="radio"
                        name="shipping_address"
                        checked={isSelected}
                        onChange={() => setSelectedAddressId(addr.id)}
                        className="mt-1 w-4 h-4 text-sport-red focus:ring-sport-red accent-sport-red"
                      />
                      <div className="flex-grow">
                        <div className="flex items-center justify-between">
                          <span className="font-heading font-bold text-xs text-slate-900">
                            {addr.name} ({addr.phone})
                          </span>
                          <div className="flex items-center space-x-2 text-[11px]">
                            <button 
                              type="button" 
                              onClick={(e) => { e.preventDefault(); alert('Fitur edit alamat dibuka.'); }}
                              className="text-slate-400 hover:text-slate-700 underline"
                            >
                              Edit
                            </button>
                            <span className="text-slate-300">•</span>
                            <button 
                              type="button" 
                              onClick={(e) => { e.preventDefault(); handleDeleteAddress(addr.id); }}
                              className="text-slate-400 hover:text-sport-red underline"
                            >
                              Delete
                            </button>
                          </div>
                        </div>
                        <p className="text-xs text-slate-600 mt-1 leading-relaxed">
                          {addr.address}, {addr.district}, {addr.city}, {addr.province} {addr.postal_code}
                        </p>
                      </div>
                    </div>
                  </label>
                );
              })}
            </div>
          </div>

          {/* STEP 2: Pay With (Strict Non-COD) */}
          <div className="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div className="border-b border-slate-100 pb-3 mb-4">
              <h2 className="font-heading font-black text-sm uppercase text-slate-900 flex items-center space-x-2">
                <span className="w-6 h-6 rounded-full bg-sport-red text-white flex items-center justify-center text-xs font-bold">2</span>
                <span>Pay With (Simulasi Pembayaran Non-Tunai)</span>
              </h2>
              <p className="text-[11px] text-slate-400 mt-1">
                Seluruh transaksi wajib melalui kanal digital resmi Sport Nexus. (Metode COD Ditiadakan).
              </p>
            </div>

            {/* Payment Options */}
            <div className="space-y-3 mb-6">
              {/* Virtual Account */}
              <label className={`block p-4 rounded-xl border cursor-pointer transition-all ${
                paymentMethod.startsWith('va_') ? 'border-2 border-sport-red bg-red-50/20' : 'border-slate-200 hover:border-slate-300'
              }`}>
                <div className="flex items-center space-x-3">
                  <input 
                    type="radio" 
                    name="pay_method"
                    value="va_bca"
                    checked={paymentMethod.startsWith('va_')}
                    onChange={() => setPaymentMethod('va_bca')}
                    className="w-4 h-4 text-sport-red focus:ring-sport-red accent-sport-red"
                  />
                  <div>
                    <span className="font-heading font-bold text-xs text-slate-900">Virtual Account (BCA, Mandiri, BRI, BNI)</span>
                    <p className="text-[11px] text-slate-500">Konfirmasi pembayaran otomatis dalam 15 menit</p>
                  </div>
                </div>
              </label>

              {/* Credit Card */}
              <label className={`block p-4 rounded-xl border cursor-pointer transition-all ${
                paymentMethod === 'cc' ? 'border-2 border-sport-red bg-red-50/20' : 'border-slate-200 hover:border-slate-300'
              }`}>
                <div className="flex items-center space-x-3">
                  <input 
                    type="radio" 
                    name="pay_method"
                    value="cc"
                    checked={paymentMethod === 'cc'}
                    onChange={() => setPaymentMethod('cc')}
                    className="w-4 h-4 text-sport-red focus:ring-sport-red accent-sport-red"
                  />
                  <div>
                    <span className="font-heading font-bold text-xs text-slate-900">Credit Card (Visa, Mastercard, JCB)</span>
                    <p className="text-[11px] text-slate-500">Enkripsi 3D Secure 256-bit transaksi aman</p>
                  </div>
                </div>
              </label>

              {/* QRIS */}
              <label className={`block p-4 rounded-xl border cursor-pointer transition-all ${
                paymentMethod === 'qris' ? 'border-2 border-sport-red bg-red-50/20' : 'border-slate-200 hover:border-slate-300'
              }`}>
                <div className="flex items-center space-x-3">
                  <input 
                    type="radio" 
                    name="pay_method"
                    value="qris"
                    checked={paymentMethod === 'qris'}
                    onChange={() => setPaymentMethod('qris')}
                    className="w-4 h-4 text-sport-red focus:ring-sport-red accent-sport-red"
                  />
                  <div>
                    <span className="font-heading font-bold text-xs text-slate-900">QRIS (Gopay, ShopeePay, OVO, Dana)</span>
                    <p className="text-[11px] text-slate-500">Pindai kode QR instan dari seluruh aplikasi e-wallet</p>
                  </div>
                </div>
              </label>
            </div>

            {/* Shipping Method Options */}
            <div className="border-t border-slate-100 pt-4">
              <label className="font-heading font-bold text-xs uppercase text-slate-800 block mb-2">
                Opsi Kurir Logistik:
              </label>
              <div className="grid grid-cols-2 gap-3">
                <label className={`p-3 rounded-xl border text-xs cursor-pointer ${
                  shippingMethod === 'regular' ? 'border-2 border-sport-red bg-red-50/20 font-bold' : 'border-slate-200'
                }`}>
                  <input 
                    type="radio" 
                    name="shipping_method"
                    checked={shippingMethod === 'regular'}
                    onChange={() => setShippingMethod('regular')}
                    className="mr-2 accent-sport-red"
                  />
                  <span>Regular Courier (2-3 hari) - Free</span>
                </label>
                <label className={`p-3 rounded-xl border text-xs cursor-pointer ${
                  shippingMethod === 'express' ? 'border-2 border-sport-red bg-red-50/20 font-bold' : 'border-slate-200'
                }`}>
                  <input 
                    type="radio" 
                    name="shipping_method"
                    checked={shippingMethod === 'express'}
                    onChange={() => setShippingMethod('express')}
                    className="mr-2 accent-sport-red"
                  />
                  <span>Express 1 Hari (+Rp 25.000)</span>
                </label>
              </div>
            </div>

            {/* Checkbox Billing Address */}
            <label className="flex items-center space-x-2 text-xs text-slate-700 mt-4 cursor-pointer select-none">
              <input 
                type="checkbox"
                checked={billingSameAsShipping}
                onChange={(e) => setBillingSameAsShipping(e.target.checked)}
                className="w-4 h-4 rounded border-slate-300 text-sport-red focus:ring-sport-red accent-sport-red"
              />
              <span>Billing address same as shipping</span>
            </label>
          </div>

          {/* STEP 3: Product List */}
          <div className="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <h2 className="font-heading font-black text-sm uppercase text-slate-900 flex items-center space-x-2 border-b border-slate-100 pb-3 mb-4">
              <span className="w-6 h-6 rounded-full bg-sport-red text-white flex items-center justify-center text-xs font-bold">3</span>
              <span>Product List (Daftar Produk Terpilih)</span>
            </h2>

            <div className="space-y-3">
              {checkoutItems.map((item, idx) => (
                <div key={idx} className="flex items-center space-x-4 border-b border-slate-50 pb-3">
                  <div className="w-16 h-16 bg-slate-50 rounded-lg p-1 border border-slate-100 flex-shrink-0">
                    <img src={item.thumbnail || '/assets/images/placeholder-shoe.png'} alt={item.name} className="w-full h-full object-contain" />
                  </div>
                  <div className="flex-grow">
                    <p className="text-[10px] font-bold uppercase text-slate-400">{item.brand || 'Sport Nexus'}</p>
                    <h4 className="font-heading font-bold text-xs text-slate-900">{item.name}</h4>
                    <p className="text-[11px] text-slate-500 mt-0.5">
                      Varian: <strong>{item.color || 'Standard'}</strong> | Size: <strong className="text-sport-red">EU {item.size}</strong>
                    </p>
                  </div>
                  <div className="text-right">
                    <span className="text-xs font-black text-slate-900">{formatRupiah(item.price)}</span>
                    <span className="text-xs text-slate-400 block">x {item.qty || 1}</span>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>

        {/* Right Col: Order Summary & Coupon */}
        <div className="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-6 sticky top-24">
          <h2 className="font-heading font-black text-sm uppercase tracking-wider text-slate-900 border-b border-slate-100 pb-3">
            Order Summary ({checkoutItems.length} items)
          </h2>

          {/* Promo Code Box */}
          <div>
            <label className="text-[11px] font-bold uppercase text-slate-500 block mb-2">
              Kupon Diskon (Promo Code)
            </label>
            <div className="flex space-x-2">
              <input 
                type="text" 
                placeholder="Promo code (cth: NEXUS50)"
                value={promoCodeInput}
                onChange={(e) => setPromoCodeInput(e.target.value)}
                className="flex-grow text-xs px-3 py-2 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sport-red uppercase font-mono"
              />
              <button 
                type="button"
                onClick={handleApplyPromo}
                className="px-4 py-2 bg-sport-red hover:bg-[#c41c21] text-white text-xs font-heading font-bold uppercase rounded-xl transition-colors"
              >
                Apply
              </button>
            </div>
            {promoError && (
              <p className="text-[11px] text-red-500 mt-1 font-semibold">{promoError}</p>
            )}
            {appliedPromo && (
              <p className="text-[11px] text-emerald-600 mt-1 font-semibold flex items-center space-x-1">
                <span>✔ {appliedPromo.desc}</span>
              </p>
            )}
          </div>

          {/* Breakdown */}
          <div className="space-y-3 text-xs border-t border-slate-100 pt-4">
            <div className="flex justify-between text-slate-600">
              <span>Subtotal</span>
              <span>{formatRupiah(subtotal)}</span>
            </div>
            <div className="flex justify-between text-slate-600">
              <span>Shipping Fee</span>
              <span>{shippingFee === 0 ? <strong className="text-emerald-600">Gratis</strong> : formatRupiah(shippingFee)}</span>
            </div>
            {discountAmount > 0 && (
              <div className="flex justify-between text-sport-red font-semibold">
                <span>Voucher Discount</span>
                <span>-{formatRupiah(discountAmount)}</span>
              </div>
            )}
            <div className="border-t border-slate-200 pt-3 flex justify-between items-baseline">
              <span className="font-heading font-bold text-sm text-slate-900">Total</span>
              <span className="font-heading font-black text-lg text-sport-red">{formatRupiah(grandTotal)}</span>
            </div>
          </div>

          {/* Terms checkbox */}
          <label className="flex items-start space-x-2 text-[11px] text-slate-500 cursor-pointer select-none">
            <input 
              type="checkbox"
              checked={termsAgreed}
              onChange={(e) => setTermsAgreed(e.target.checked)}
              className="mt-0.5 w-4 h-4 rounded border-slate-300 text-sport-red focus:ring-sport-red accent-sport-red flex-shrink-0"
            />
            <span>
              By clicking "Checkout", you have read and agree to our <a href="#" className="underline">Privacy Policy</a> and <a href="#" className="underline">Terms & Conditions</a>.
            </span>
          </label>

          {/* Final Checkout Button */}
          <button
            type="button"
            onClick={handleFinalCheckout}
            disabled={isSubmitting}
            className="w-full py-4 bg-sport-red hover:bg-[#c41c21] text-white font-heading font-black text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-red-500/25 active:scale-95 transition-all"
          >
            {isSubmitting ? 'Memproses Transaksi...' : 'Checkout'}
          </button>
        </div>
      </div>

      {/* Add Address Modal */}
      {showAddressModal && (
        <div className="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
          <form onSubmit={handleSaveAddress} className="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <h3 className="font-heading font-black text-sm uppercase text-slate-900 border-b border-slate-100 pb-3">
              Tambah Alamat Baru
            </h3>
            <div className="space-y-3 text-xs">
              <div>
                <label className="block text-slate-600 mb-1">Nama Penerima</label>
                <input 
                  type="text" 
                  required
                  value={newAddress.name} 
                  onChange={(e) => setNewAddress({...newAddress, name: e.target.value})}
                  className="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sport-red focus:outline-none" 
                />
              </div>
              <div>
                <label className="block text-slate-600 mb-1">Nomor Handphone</label>
                <input 
                  type="text" 
                  required
                  value={newAddress.phone} 
                  onChange={(e) => setNewAddress({...newAddress, phone: e.target.value})}
                  className="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sport-red focus:outline-none" 
                />
              </div>
              <div>
                <label className="block text-slate-600 mb-1">Alamat Lengkap</label>
                <textarea 
                  required
                  value={newAddress.address} 
                  onChange={(e) => setNewAddress({...newAddress, address: e.target.value})}
                  className="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sport-red focus:outline-none h-20" 
                />
              </div>
              <div className="grid grid-cols-2 gap-2">
                <div>
                  <label className="block text-slate-600 mb-1">Kota / Kabupaten</label>
                  <select 
                    value={newAddress.city} 
                    onChange={(e) => setNewAddress({...newAddress, city: e.target.value})}
                    className="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sport-red focus:outline-none"
                  >
                    <option value="Kab. Karawang">Kab. Karawang</option>
                    <option value="Kota Bekasi">Kota Bekasi</option>
                  </select>
                </div>
                <div>
                  <label className="block text-slate-600 mb-1">Kode Pos (5 Digit)</label>
                  <input 
                    type="text" 
                    maxLength={5}
                    required
                    value={newAddress.postal_code} 
                    onChange={(e) => setNewAddress({...newAddress, postal_code: e.target.value})}
                    className="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sport-red focus:outline-none" 
                  />
                </div>
              </div>
            </div>
            <div className="grid grid-cols-2 gap-3 pt-3">
              <button 
                type="button"
                onClick={() => setShowAddressModal(false)}
                className="py-2.5 px-4 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl"
              >
                Cancel
              </button>
              <button 
                type="submit"
                className="py-2.5 px-4 bg-sport-red text-white text-xs font-bold rounded-xl shadow-md"
              >
                Save
              </button>
            </div>
          </form>
        </div>
      )}
    </div>
  );
}
