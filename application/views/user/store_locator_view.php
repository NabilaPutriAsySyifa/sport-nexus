<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - STORE LOCATOR VIEW
     Split-Screen Interactive Map & Gerai Resmi Bekasi & Karawang
     ========================================================================= -->

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-6">
        <a href="<?php echo base_url(); ?>" class="hover:text-[#E5252A]">Home</a>
        <span>/</span>
        <span class="text-slate-800 font-bold">Store Location</span>
    </nav>

    <div class="border-b border-slate-200 pb-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900">
            Lokasi Gerai Resmi Sport Nexus
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Kunjungi toko fisik resmi kami di wilayah Bekasi dan Karawang untuk mencoba fitting ukuran sepatu secara langsung.
        </p>
    </div>

    <!-- Split-Screen Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Left List & Filter Panel (Col 5) -->
        <div class="lg:col-span-5 space-y-4">

            <!-- Filter Controls: City Selector Dropdown (PDF Page 13) -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-black uppercase text-slate-900 tracking-wider">Store Location</span>
                    <span id="store-count-badge" class="text-xs text-slate-500 font-semibold"><?php echo count($stores); ?> Gerai Aktif</span>
                </div>

                <!-- Interactive City Selector Dropdown -->
                <div class="space-y-1">
                    <label for="city-selector-dropdown" class="text-[11px] font-bold text-slate-600 uppercase tracking-wide block">Pilih Kota Toko Resmi</label>
                    <div class="relative">
                        <select id="city-selector-dropdown" class="w-full p-3 pr-10 border border-slate-300 rounded-xl bg-white text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#E5252A] appearance-none shadow-sm cursor-pointer">
                            <option value="">Semua Kota (Bekasi & Karawang)</option>
                            <option value="Kota Bekasi" <?php echo ($selected_city === 'Kota Bekasi') ? 'selected' : ''; ?>>Kota Bekasi (2 Gerai)</option>
                            <option value="Kab. Karawang" <?php echo ($selected_city === 'Kab. Karawang') ? 'selected' : ''; ?>>Kab. Karawang (2 Gerai)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stores List -->
            <div id="store-cards-container" class="space-y-3 max-h-[600px] overflow-y-auto pr-1">
                <?php if (!empty($stores)): ?>
                    <?php foreach ($stores as $sidx => $st): ?>
                        <div class="store-item-card bg-white p-5 rounded-2xl border-2 transition-all cursor-pointer shadow-sm <?php echo $sidx === 0 ? 'border-[#E5252A] bg-red-50/20' : 'border-slate-200 hover:border-slate-300'; ?>" 
                             data-store-id="<?php echo $st->id; ?>" 
                             data-city="<?php echo htmlspecialchars($st->city); ?>"
                             data-lat="<?php echo $st->latitude; ?>" 
                             data-lng="<?php echo $st->longitude; ?>" 
                             data-name="<?php echo htmlspecialchars($st->store_name); ?>" 
                             data-address="<?php echo htmlspecialchars($st->address); ?>" 
                             data-maps="<?php echo htmlspecialchars($st->maps_url); ?>">
                            
                            <div class="flex items-start justify-between gap-2">
                                <span class="inline-block px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider <?php echo (stripos($st->city, 'Bekasi') !== false) ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800'; ?>">
                                    <?php echo htmlspecialchars($st->city); ?>
                                </span>
                                <span class="text-[11px] text-emerald-600 font-bold flex items-center space-x-1">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>Buka Sekarang</span>
                                </span>
                            </div>

                            <h3 class="font-bold text-sm text-slate-900 mt-2 hover:text-[#E5252A] transition-colors">
                                <?php echo htmlspecialchars($st->store_name); ?>
                            </h3>

                            <p class="text-xs text-slate-600 mt-1 line-clamp-2">
                                <?php echo htmlspecialchars($st->address); ?>
                            </p>

                            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                                <div class="flex items-center space-x-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span><?php echo htmlspecialchars($st->operating_hours ?: '10:00 - 22:00 WIB'); ?></span>
                                </div>
                                <div class="flex items-center space-x-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span><?php echo htmlspecialchars($st->phone ?: '+62 857-1737-2990'); ?></span>
                                </div>
                            </div>

                            <div class="mt-3 flex items-center space-x-2">
                                <button type="button" class="btn-focus-map w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-800 text-[11px] font-bold py-1.5 rounded-lg transition-colors flex items-center justify-center space-x-1">
                                    <svg class="w-3 h-3 text-[#E5252A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    <span>Fokus Peta</span>
                                </button>
                                <a href="<?php echo htmlspecialchars($st->maps_url ?: 'https://maps.google.com/?q=' . urlencode($st->store_name)); ?>" target="_blank" rel="noopener noreferrer" class="w-1/2 bg-[#E5252A] hover:bg-[#c41c21] text-white text-[11px] font-bold py-1.5 rounded-lg shadow transition-colors flex items-center justify-center space-x-1">
                                    <span>Buka Petunjuk Arah</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>

        <!-- Right Map Display Panel (Col 7) -->
        <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden sticky top-28">
            <!-- Map Top Controls -->
            <div class="p-4 bg-slate-900 text-white flex items-center justify-between text-xs">
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                    <strong id="active-map-store-title" class="truncate max-w-xs font-bold">Sport Nexus • The Grand Outlet - Karawang</strong>
                </div>

                <div class="flex items-center space-x-1.5">
                    <button type="button" id="btn-toggle-satellite" class="bg-slate-800 hover:bg-slate-700 px-3 py-1 rounded text-[11px] font-bold border border-slate-700">
                        Satelit
                    </button>
                    <button type="button" id="btn-toggle-standard" class="bg-[#E5252A] px-3 py-1 rounded text-[11px] font-bold">
                        Peta
                    </button>
                </div>
            </div>

            <!-- Interactive Map Container (iframe with fallback) -->
            <div class="relative w-full h-[520px] bg-slate-100">
                <iframe id="google-map-frame" 
                        class="w-full h-full border-0" 
                        src="https://maps.google.com/maps?q=-6.3558048,107.2433629&hl=id&z=15&output=embed" 
                        allowfullscreen="" 
                        loading="lazy">
                </iframe>

                <!-- Active Store Pin Overlay Box -->
                <div id="map-pin-overlay" class="absolute bottom-4 left-4 right-4 bg-white/95 backdrop-blur-md p-4 rounded-xl border border-slate-200 shadow-xl space-y-1 text-xs">
                    <div class="flex items-center justify-between">
                        <strong id="overlay-name" class="font-black text-slate-900 text-sm">Sport Nexus • The Grand Outlet - Karawang</strong>
                        <span class="bg-red-50 text-[#E5252A] font-bold px-2 py-0.5 rounded text-[10px]">Official Store</span>
                    </div>
                    <p id="overlay-addr" class="text-slate-600 text-[11px]">Jalan Trans Heksa, Wanasari, Telukjambe Barat, Karawang, Jawa Barat 41361</p>
                    <div class="pt-2 flex items-center justify-between">
                        <span class="text-slate-500 text-[11px]">Buka: 10:00 - 22:00 WIB</span>
                        <a id="overlay-link" href="#" target="_blank" class="text-xs font-bold text-[#E5252A] hover:underline flex items-center space-x-1">
                            <span>Petunjuk Arah Google Maps &raquo;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const storeCards = document.querySelectorAll('.store-item-card');
    const citySelector = document.getElementById('city-selector-dropdown');
    const countBadge = document.getElementById('store-count-badge');
    const mapFrame = document.getElementById('google-map-frame');
    const mapTitle = document.getElementById('active-map-store-title');
    const overlayName = document.getElementById('overlay-name');
    const overlayAddr = document.getElementById('overlay-addr');
    const overlayLink = document.getElementById('overlay-link');
    let isSatellite = false;
    let currentLat = -6.3558048;
    let currentLng = 107.2433629;

    function updateMap(lat, lng, name, addr, mapsUrl) {
        currentLat = lat;
        currentLng = lng;
        const mapType = isSatellite ? 'k' : 'm';
        mapFrame.src = `https://maps.google.com/maps?q=${lat},${lng}&t=${mapType}&hl=id&z=15&output=embed`;
        mapTitle.textContent = name;
        overlayName.textContent = name;
        overlayAddr.textContent = addr;
        overlayLink.href = mapsUrl || `https://maps.google.com/?q=${lat},${lng}`;
    }

    function selectStore(card) {
        storeCards.forEach(c => {
            c.classList.remove('border-[#E5252A]', 'bg-red-50/20');
            c.classList.add('border-slate-200');
        });
        card.classList.remove('border-slate-200');
        card.classList.add('border-[#E5252A]', 'bg-red-50/20');

        updateMap(card.dataset.lat, card.dataset.lng, card.dataset.name, card.dataset.address, card.dataset.maps);
    }

    storeCards.forEach(card => {
        card.addEventListener('click', () => selectStore(card));
    });

    // Dropdown City Selector Filtering
    if (citySelector) {
        citySelector.addEventListener('change', function() {
            const chosenCity = this.value;
            let visibleCount = 0;
            let firstVisibleCard = null;

            storeCards.forEach(card => {
                const storeCity = card.dataset.city || '';
                if (!chosenCity || storeCity.toLowerCase().includes(chosenCity.toLowerCase())) {
                    card.style.display = 'block';
                    visibleCount++;
                    if (!firstVisibleCard) firstVisibleCard = card;
                } else {
                    card.style.display = 'none';
                }
            });

            countBadge.textContent = visibleCount + ' Gerai Aktif';

            // Pan and zoom map to chosen city / first store
            if (chosenCity === 'Kota Bekasi') {
                updateMap(-6.2520, 106.9920, 'Sport Nexus • Wilayah Kota Bekasi', 'Grand Metropolitan & Mega Bekasi Hypermall', 'https://maps.google.com/?q=Bekasi');
                if (firstVisibleCard) selectStore(firstVisibleCard);
            } else if (chosenCity === 'Kab. Karawang') {
                updateMap(-6.3558048, 107.2433629, 'Sport Nexus • Wilayah Karawang', 'The Grand Outlet & Karawang Central Plaza', 'https://maps.google.com/?q=Karawang');
                if (firstVisibleCard) selectStore(firstVisibleCard);
            } else {
                if (firstVisibleCard) selectStore(firstVisibleCard);
            }
        });
    }

    // Satellite / Standard Toggle
    const btnSat = document.getElementById('btn-toggle-satellite');
    const btnStd = document.getElementById('btn-toggle-standard');

    btnSat.addEventListener('click', () => {
        isSatellite = true;
        btnSat.className = 'bg-[#E5252A] px-3 py-1 rounded text-[11px] font-bold text-white';
        btnStd.className = 'bg-slate-800 hover:bg-slate-700 px-3 py-1 rounded text-[11px] font-bold border border-slate-700 text-white';
        mapFrame.src = `https://maps.google.com/maps?q=${currentLat},${currentLng}&t=k&hl=id&z=15&output=embed`;
    });

    btnStd.addEventListener('click', () => {
        isSatellite = false;
        btnStd.className = 'bg-[#E5252A] px-3 py-1 rounded text-[11px] font-bold text-white';
        btnSat.className = 'bg-slate-800 hover:bg-slate-700 px-3 py-1 rounded text-[11px] font-bold border border-slate-700 text-white';
        mapFrame.src = `https://maps.google.com/maps?q=${currentLat},${currentLng}&t=m&hl=id&z=15&output=embed`;
    });
});
</script>
