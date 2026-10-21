import React from 'react';

export default function ProductCard({ product, baseUrl = '' }) {
  if (!product) return null;

  const discount = parseInt(product.discount_percent, 10) || 0;
  const originalPrice = parseFloat(product.original_price) || 0;
  const salePrice = parseFloat(product.sale_price) || 0;
  const pdpUrl = `${baseUrl}product/${product.sku}`;

  const formatRupiah = (num) => {
    return 'Rp ' + Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  };

  return (
    <div className="group relative bg-white border border-slate-200 rounded-xl overflow-hidden hover:shadow-xl hover:border-slate-300 transition-all duration-300 flex flex-col justify-between">
      {/* Discount Badge */}
      {discount > 0 && (
        <div className="absolute top-3 left-3 z-10 bg-sport-red text-white text-[11px] font-black uppercase tracking-wider px-2 py-0.5 rounded shadow-sm">
          -{discount}%
        </div>
      )}

      {/* Brand & Gender Tag */}
      <div className="absolute top-3 right-3 z-10 flex items-center space-x-1">
        <span className="bg-slate-100/90 backdrop-blur-sm text-slate-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">
          {product.gender || 'Unisex'}
        </span>
      </div>

      {/* Image Container with Zoom */}
      <a href={pdpUrl} className="block relative aspect-square bg-slate-50 overflow-hidden p-6">
        <img 
          src={product.thumbnail || '/assets/images/placeholder-shoe.png'} 
          alt={product.name}
          loading="lazy"
          className="w-full h-full object-contain object-center transform group-hover:scale-105 transition-transform duration-500"
          onError={(e) => {
            e.target.onerror = null;
            e.target.src = 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=500&q=80';
          }}
        />
      </a>

      {/* Product Details */}
      <div className="p-4 flex flex-col flex-grow justify-between">
        <div>
          {/* Brand Name */}
          <p className="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">
            {product.brand_name || 'Sport Nexus'}
          </p>

          {/* Model Name */}
          <h3 className="font-heading font-bold text-xs sm:text-sm text-slate-900 group-hover:text-sport-red transition-colors line-clamp-2 leading-snug mb-2">
            <a href={pdpUrl}>
              {product.name}
            </a>
          </h3>
        </div>

        {/* Pricing */}
        <div className="pt-2 border-t border-slate-100 mt-2">
          {discount > 0 ? (
            <div className="flex flex-col">
              <span className="text-[11px] text-slate-400 line-through">
                {formatRupiah(originalPrice)}
              </span>
              <span className="text-sm sm:text-base font-black text-sport-red">
                {formatRupiah(salePrice)}
              </span>
            </div>
          ) : (
            <span className="text-sm sm:text-base font-black text-slate-900">
              {formatRupiah(originalPrice)}
            </span>
          )}

          {/* Action / View Detail Button */}
          <a
            href={pdpUrl}
            className="mt-3 block w-full text-center py-2 bg-slate-100 hover:bg-sport-red text-slate-800 hover:text-white text-xs font-bold uppercase rounded-lg transition-colors duration-200"
          >
            Lihat Detail
          </a>
        </div>
      </div>
    </div>
  );
}
