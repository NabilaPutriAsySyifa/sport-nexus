import React, { useState, useEffect } from 'react';

export default function FacetedFilterSidebar({ 
  initialFilters = {}, 
  availableFacets = {}, 
  onFilterChange,
  currentCategory = 'all'
}) {
  const [selectedBrands, setSelectedBrands] = useState(initialFilters.brand ? (Array.isArray(initialFilters.brand) ? initialFilters.brand : [initialFilters.brand]) : []);
  const [selectedGenders, setSelectedGenders] = useState(initialFilters.gender ? [initialFilters.gender] : []);
  const [selectedActivities, setSelectedActivities] = useState(initialFilters.activity ? [initialFilters.activity] : []);
  const [selectedSizes, setSelectedSizes] = useState(initialFilters.size ? [initialFilters.size] : []);
  const [selectedDiscounts, setSelectedDiscounts] = useState(initialFilters.discount ? [initialFilters.discount] : []);
  const [minPrice, setMinPrice] = useState(initialFilters.min_price || '');
  const [maxPrice, setMaxPrice] = useState(initialFilters.max_price || '');

  // Toggle helper for multi-selection
  const toggleItem = (list, setList, item) => {
    const updated = list.includes(item) 
      ? list.filter(i => i !== item)
      : [...list, item];
    setList(updated);
    if (onFilterChange) {
      onFilterChange({
        brands: updated,
        genders: selectedGenders,
        activities: selectedActivities,
        sizes: selectedSizes,
        discounts: selectedDiscounts,
        minPrice,
        maxPrice
      });
    }
  };

  const handlePriceApply = () => {
    if (onFilterChange) {
      onFilterChange({
        brands: selectedBrands,
        genders: selectedGenders,
        activities: selectedActivities,
        sizes: selectedSizes,
        discounts: selectedDiscounts,
        minPrice,
        maxPrice
      });
    }
  };

  const handleReset = () => {
    setSelectedBrands([]);
    setSelectedGenders([]);
    setSelectedActivities([]);
    setSelectedSizes([]);
    setSelectedDiscounts([]);
    setMinPrice('');
    setMaxPrice('');
    if (onFilterChange) {
      onFilterChange({});
    }
  };

  return (
    <aside className="w-full bg-white rounded-xl border border-slate-200 p-5 shadow-sm space-y-6">
      <div className="flex items-center justify-between border-b border-slate-100 pb-3">
        <h3 className="font-heading font-black text-sm uppercase tracking-wide text-slate-900 flex items-center space-x-2">
          <svg className="w-4 h-4 text-sport-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
          </svg>
          <span>Filter Sepatu</span>
        </h3>
        <button 
          onClick={handleReset}
          className="text-xs text-slate-400 hover:text-sport-red font-semibold transition-colors"
        >
          Reset All
        </button>
      </div>

      {/* Brand Filter */}
      <div>
        <h4 className="font-heading font-bold text-xs uppercase text-slate-800 mb-3 tracking-wider">Brand</h4>
        <div className="space-y-2 max-h-48 overflow-y-auto pr-1">
          {[
            { name: 'Diadora', count: 500 },
            { name: 'Airwalk', count: 400 },
            { name: 'New Balance', count: 200 },
            { name: 'Converse', count: 150 },
            { name: 'Converse Kids', count: 90 },
            { name: 'Nike', count: 100 },
            { name: 'Puma', count: 80 },
            { name: 'Nike Young Athletes', count: 20 },
            { name: 'Puma Golf', count: 2 },
            { name: 'Nike Golf', count: 1 }
          ].map((b) => (
            <label key={b.name} className="flex items-center justify-between text-xs text-slate-700 hover:text-slate-900 cursor-pointer select-none group">
              <div className="flex items-center space-x-2.5">
                <input 
                  type="checkbox"
                  checked={selectedBrands.includes(b.name)}
                  onChange={() => toggleItem(selectedBrands, setSelectedBrands, b.name)}
                  className="w-4 h-4 rounded border-slate-300 text-sport-red focus:ring-sport-red accent-sport-red"
                />
                <span className={selectedBrands.includes(b.name) ? 'font-bold text-slate-900' : 'group-hover:text-slate-900'}>
                  {b.name}
                </span>
              </div>
              <span className="text-[11px] text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded font-mono">
                {b.count}
              </span>
            </label>
          ))}
        </div>
      </div>

      {/* Gender Filter */}
      <div className="border-t border-slate-100 pt-5">
        <h4 className="font-heading font-bold text-xs uppercase text-slate-800 mb-3 tracking-wider">Gender</h4>
        <div className="space-y-2">
          {['Men', 'Women', 'Unisex', 'Boys', 'Girls', 'Unisex Kids'].map((g) => (
            <label key={g} className="flex items-center space-x-2.5 text-xs text-slate-700 hover:text-slate-900 cursor-pointer select-none">
              <input 
                type="checkbox"
                checked={selectedGenders.includes(g)}
                onChange={() => toggleItem(selectedGenders, setSelectedGenders, g)}
                className="w-4 h-4 rounded border-slate-300 text-sport-red focus:ring-sport-red accent-sport-red"
              />
              <span className={selectedGenders.includes(g) ? 'font-bold text-slate-900' : ''}>{g}</span>
            </label>
          ))}
        </div>
      </div>

      {/* Activity Filter */}
      <div className="border-t border-slate-100 pt-5">
        <h4 className="font-heading font-bold text-xs uppercase text-slate-800 mb-3 tracking-wider">Aktivitas Olahraga</h4>
        <div className="space-y-2 max-h-40 overflow-y-auto pr-1">
          {['Running', 'Lifestyle', 'Fitness', 'Soccer', 'Tennis', 'Badminton', 'Golf', 'Walking'].map((act) => (
            <label key={act} className="flex items-center space-x-2.5 text-xs text-slate-700 hover:text-slate-900 cursor-pointer select-none">
              <input 
                type="checkbox"
                checked={selectedActivities.includes(act)}
                onChange={() => toggleItem(selectedActivities, setSelectedActivities, act)}
                className="w-4 h-4 rounded border-slate-300 text-sport-red focus:ring-sport-red accent-sport-red"
              />
              <span className={selectedActivities.includes(act) ? 'font-bold text-slate-900' : ''}>{act}</span>
            </label>
          ))}
        </div>
      </div>

      {/* Size Pill Grid Filter */}
      <div className="border-t border-slate-100 pt-5">
        <h4 className="font-heading font-bold text-xs uppercase text-slate-800 mb-3 tracking-wider">Ukuran Sepatu (EUR)</h4>
        <div className="grid grid-cols-4 gap-1.5">
          {['36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46'].map((sz) => {
            const isSelected = selectedSizes.includes(sz);
            return (
              <button
                key={sz}
                type="button"
                onClick={() => toggleItem(selectedSizes, setSelectedSizes, sz)}
                className={`py-1.5 text-xs font-semibold rounded-lg border transition-all text-center ${
                  isSelected 
                    ? 'bg-sport-red text-white border-sport-red shadow-sm'
                    : 'bg-slate-50 text-slate-700 border-slate-200 hover:border-slate-400 hover:bg-white'
                }`}
              >
                EU {sz}
              </button>
            );
          })}
        </div>
      </div>

      {/* Price Range Filter */}
      <div className="border-t border-slate-100 pt-5">
        <h4 className="font-heading font-bold text-xs uppercase text-slate-800 mb-3 tracking-wider">Rentang Harga (Rp)</h4>
        <div className="space-y-2">
          <input 
            type="number"
            placeholder="Min Rp (cth: 200.000)"
            value={minPrice}
            onChange={(e) => setMinPrice(e.target.value)}
            className="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sport-red"
          />
          <input 
            type="number"
            placeholder="Maks Rp (cth: 1.500.000)"
            value={maxPrice}
            onChange={(e) => setMaxPrice(e.target.value)}
            className="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sport-red"
          />
          <button 
            type="button"
            onClick={handlePriceApply}
            className="w-full py-2 bg-charcoal text-white text-xs font-bold uppercase rounded-lg hover:bg-black transition-colors"
          >
            Terapkan Harga
          </button>
        </div>
      </div>
    </aside>
  );
}
