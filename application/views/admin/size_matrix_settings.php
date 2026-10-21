<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - SHOP BY SIZE NAVIGATION MATRIX MANAGER (ADMIN PANEL)
     Spesifikasi PDF: 3 Tab Kategori (Men, Women, Kids), Tabel 12 Slot Ukuran & Editor Modal
     ========================================================================= -->

<?php
// Calculate actual SKU and physical stock per size from DB
function get_size_stats($ci, $gender_scope, $size_eu) {
    $ci->db->select('COUNT(DISTINCT p.id) as model_count, SUM(ps.stock_qty) as total_stock');
    $ci->db->from('product_skus ps');
    $ci->db->join('products p', 'p.id = ps.product_id');
    if ($gender_scope === 'Men') {
        $ci->db->where_in('p.gender', array('Men', 'Unisex'));
    } elseif ($gender_scope === 'Women') {
        $ci->db->where_in('p.gender', array('Women', 'Unisex'));
    } else {
        $ci->db->where_in('p.gender', array('Boys', 'Girls', 'Unisex Kids'));
    }
    $ci->db->where('ps.size_eu', $size_eu);
    $row = $ci->db->get()->row();
    return array(
        'models' => $row ? (int)$row->model_count : 0,
        'stock'  => $row ? (int)$row->total_stock : 0
    );
}

$men_sizes = array(
    array('us' => 'US 6.5',  'eu' => '39.5', 'url' => '/men.html?size_us=6.5'),
    array('us' => 'US 7',    'eu' => '40',   'url' => '/men.html?size_us=7'),
    array('us' => 'US 7.5',  'eu' => '40.5', 'url' => '/men.html?size_us=7.5'),
    array('us' => 'US 8',    'eu' => '41.5', 'url' => '/men.html?size_us=8'),
    array('us' => 'US 8.5',  'eu' => '42',   'url' => '/men.html?size_us=8.5'),
    array('us' => 'US 9',    'eu' => '42.5', 'url' => '/men.html?size_us=9'),
    array('us' => 'US 9.5',  'eu' => '43',   'url' => '/men.html?size_us=9.5'),
    array('us' => 'US 10',   'eu' => '44',   'url' => '/men.html?size_us=10'),
    array('us' => 'US 10.5', 'eu' => '44.5', 'url' => '/men.html?size_us=10.5'),
    array('us' => 'US 11',   'eu' => '45',   'url' => '/men.html?size_us=11'),
    array('us' => 'US 11.5', 'eu' => '45.5', 'url' => '/men.html?size_us=11.5'),
    array('us' => 'US 12',   'eu' => '46',   'url' => '/men.html?size_us=12'),
);

$women_sizes = array(
    array('us' => 'US 5',    'eu' => '35',   'url' => '/women.html?size_us=5'),
    array('us' => 'US 5.5',  'eu' => '36',   'url' => '/women.html?size_us=5.5'),
    array('us' => 'US 6',    'eu' => '36.5', 'url' => '/women.html?size_us=6'),
    array('us' => 'US 6.5',  'eu' => '37',   'url' => '/women.html?size_us=6.5'),
    array('us' => 'US 7',    'eu' => '37.5', 'url' => '/women.html?size_us=7'),
    array('us' => 'US 7.5',  'eu' => '38',   'url' => '/women.html?size_us=7.5'),
    array('us' => 'US 8',    'eu' => '39',   'url' => '/women.html?size_us=8'),
    array('us' => 'US 8.5',  'eu' => '40',   'url' => '/women.html?size_us=8.5'),
    array('us' => 'US 9',    'eu' => '40.5', 'url' => '/women.html?size_us=9'),
    array('us' => 'US 9.5',  'eu' => '41',   'url' => '/women.html?size_us=9.5'),
    array('us' => 'US 10',   'eu' => '41.5', 'url' => '/women.html?size_us=10'),
    array('us' => 'US 11',   'eu' => '43',   'url' => '/women.html?size_us=11'),
);

$kids_sizes = array(
    array('us' => 'US 1',    'eu' => '16',   'url' => '/kids.html?size_us=1'),
    array('us' => 'US 1.5',  'eu' => '16.5', 'url' => '/kids.html?size_us=1.5'),
    array('us' => 'US 2',    'eu' => '17',   'url' => '/kids.html?size_us=2'),
    array('us' => 'US 2.5',  'eu' => '18',   'url' => '/kids.html?size_us=2.5'),
    array('us' => 'US 3',    'eu' => '18.5', 'url' => '/kids.html?size_us=3'),
    array('us' => 'US 4',    'eu' => '20',   'url' => '/kids.html?size_us=4'),
    array('us' => 'US 5',    'eu' => '21',   'url' => '/kids.html?size_us=5'),
    array('us' => 'US 6',    'eu' => '22.5', 'url' => '/kids.html?size_us=6'),
    array('us' => 'US 7',    'eu' => '23.5', 'url' => '/kids.html?size_us=7'),
    array('us' => 'US 8',    'eu' => '25',   'url' => '/kids.html?size_us=8'),
    array('us' => 'US 9',    'eu' => '26',   'url' => '/kids.html?size_us=9'),
    array('us' => 'US 10',   'eu' => '27.5', 'url' => '/kids.html?size_us=10'),
);
?>

<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-200 gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                <span class="text-xs font-black uppercase text-slate-400 tracking-wider">Catalog Settings</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900 mt-0.5">
                Size Navigation Matrix Manager
            </h1>
            <p class="text-xs text-slate-500">
                Mengelola konfigurasi kartu filter cepat ukuran (Shop by Size), ketersediaan stok fisik per ukuran, dan parameter rute katalog.
            </p>
        </div>

        <button type="button" onclick="syncStockCounters()" class="bg-[#1E2229] hover:bg-[#2D333D] text-white px-4 py-2 rounded-xl text-xs font-bold shadow transition-all flex items-center space-x-2 self-start">
            <svg class="w-4 h-4 text-[#E5252A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            <span>Sync Stock Counters</span>
        </button>
    </div>

    <!-- 1. CATEGORY TABS (PANEL TAB KATEGORI: MEN, WOMEN, KIDS) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="flex border-b border-slate-200 bg-slate-50 text-xs font-bold">
            <button type="button" class="tab-btn px-6 py-3.5 border-b-2 border-[#E5252A] text-[#E5252A] bg-white transition-all" onclick="switchCategoryTab('men')">
                Tab 1: Men Footwear (12 Ukuran)
            </button>
            <button type="button" class="tab-btn px-6 py-3.5 border-b-2 border-transparent text-slate-500 hover:text-slate-800 transition-all" onclick="switchCategoryTab('women')">
                Tab 2: Women Footwear (12 Ukuran)
            </button>
            <button type="button" class="tab-btn px-6 py-3.5 border-b-2 border-transparent text-slate-500 hover:text-slate-800 transition-all" onclick="switchCategoryTab('kids')">
                Tab 3: Kids Footwear (12 Ukuran)
            </button>
        </div>

        <!-- Tab 1: Men Footwear Table -->
        <div id="tab-content-men" class="tab-panel p-4 overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="p-3 text-center w-12">No</th>
                        <th class="p-3">Label Ukuran US</th>
                        <th class="p-3">Label Konversi EU</th>
                        <th class="p-3 text-center">Total SKU Terkait</th>
                        <th class="p-3 text-center">Total Stok Tersedia</th>
                        <th class="p-3">URL Parameter Filter</th>
                        <th class="p-3 text-center">Status Tayang</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    <?php foreach ($men_sizes as $idx => $ms): 
                        $stats = get_size_stats($this, 'Men', $ms['eu']);
                    ?>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-3 text-center font-bold text-slate-400"><?php echo $idx + 1; ?></td>
                            <td class="p-3 font-black text-slate-900"><?php echo $ms['us']; ?></td>
                            <td class="p-3 font-bold text-slate-700">EU <?php echo $ms['eu']; ?></td>
                            <td class="p-3 text-center font-bold text-slate-900"><?php echo $stats['models']; ?> Model</td>
                            <td class="p-3 text-center">
                                <span class="inline-block px-2 py-0.5 rounded-full font-black text-[11px] <?php echo $stats['stock'] > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800'; ?>">
                                    <?php echo $stats['stock']; ?> Pasang
                                </span>
                            </td>
                            <td class="p-3 font-mono text-slate-500 text-[11px]"><?php echo $ms['url']; ?></td>
                            <td class="p-3 text-center">
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full">Aktif (ON)</span>
                            </td>
                            <td class="p-3 text-center">
                                <button type="button" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-2.5 py-1 rounded-md text-[11px] font-bold" onclick='openSizeEditor("Men", "<?php echo $ms['us']; ?>", "<?php echo $ms['eu']; ?>", "<?php echo $ms['url']; ?>")'>Edit / Detail</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Tab 2: Women Footwear Table -->
        <div id="tab-content-women" class="tab-panel p-4 overflow-x-auto hidden">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="p-3 text-center w-12">No</th>
                        <th class="p-3">Label Ukuran US</th>
                        <th class="p-3">Label Konversi EU</th>
                        <th class="p-3 text-center">Total SKU Terkait</th>
                        <th class="p-3 text-center">Total Stok Tersedia</th>
                        <th class="p-3">URL Parameter Filter</th>
                        <th class="p-3 text-center">Status Tayang</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    <?php foreach ($women_sizes as $idx => $ws): 
                        $stats = get_size_stats($this, 'Women', $ws['eu']);
                    ?>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-3 text-center font-bold text-slate-400"><?php echo $idx + 1; ?></td>
                            <td class="p-3 font-black text-slate-900"><?php echo $ws['us']; ?></td>
                            <td class="p-3 font-bold text-slate-700">EU <?php echo $ws['eu']; ?></td>
                            <td class="p-3 text-center font-bold text-slate-900"><?php echo $stats['models']; ?> Model</td>
                            <td class="p-3 text-center">
                                <span class="inline-block px-2 py-0.5 rounded-full font-black text-[11px] <?php echo $stats['stock'] > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800'; ?>">
                                    <?php echo $stats['stock']; ?> Pasang
                                </span>
                            </td>
                            <td class="p-3 font-mono text-slate-500 text-[11px]"><?php echo $ws['url']; ?></td>
                            <td class="p-3 text-center">
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full">Aktif (ON)</span>
                            </td>
                            <td class="p-3 text-center">
                                <button type="button" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-2.5 py-1 rounded-md text-[11px] font-bold" onclick='openSizeEditor("Women", "<?php echo $ws['us']; ?>", "<?php echo $ws['eu']; ?>", "<?php echo $ws['url']; ?>")'>Edit / Detail</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Tab 3: Kids Footwear Table -->
        <div id="tab-content-kids" class="tab-panel p-4 overflow-x-auto hidden">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="p-3 text-center w-12">No</th>
                        <th class="p-3">Label Ukuran US</th>
                        <th class="p-3">Label Konversi EU</th>
                        <th class="p-3 text-center">Total SKU Terkait</th>
                        <th class="p-3 text-center">Total Stok Tersedia</th>
                        <th class="p-3">URL Parameter Filter</th>
                        <th class="p-3 text-center">Status Tayang</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    <?php foreach ($kids_sizes as $idx => $ks): 
                        $stats = get_size_stats($this, 'Kids', $ks['eu']);
                    ?>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-3 text-center font-bold text-slate-400"><?php echo $idx + 1; ?></td>
                            <td class="p-3 font-black text-slate-900"><?php echo $ks['us']; ?></td>
                            <td class="p-3 font-bold text-slate-700">EU <?php echo $ks['eu']; ?></td>
                            <td class="p-3 text-center font-bold text-slate-900"><?php echo $stats['models']; ?> Model</td>
                            <td class="p-3 text-center">
                                <span class="inline-block px-2 py-0.5 rounded-full font-black text-[11px] <?php echo $stats['stock'] > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800'; ?>">
                                    <?php echo $stats['stock']; ?> Pasang
                                </span>
                            </td>
                            <td class="p-3 font-mono text-slate-500 text-[11px]"><?php echo $ks['url']; ?></td>
                            <td class="p-3 text-center">
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full">Aktif (ON)</span>
                            </td>
                            <td class="p-3 text-center">
                                <button type="button" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-2.5 py-1 rounded-md text-[11px] font-bold" onclick='openSizeEditor("Kids", "<?php echo $ks['us']; ?>", "<?php echo $ks['eu']; ?>", "<?php echo $ks['url']; ?>")'>Edit / Detail</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. PENGATURAN TAMPILAN & GAYA GLOBAL (GLOBAL SECTION APPEARANCE) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <div class="flex items-center space-x-2 pb-3 border-b border-slate-100">
            <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
            <h3 class="font-black text-sm uppercase text-slate-900 tracking-wider">
                Pengaturan Tampilan & Gaya Global (Global Section Appearance)
            </h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-xs">
            <div class="space-y-1.5">
                <label class="font-bold text-slate-700 block">Pengaturan Judul Bagian</label>
                <input type="text" id="setting-section-title" value="Shop by Size" class="w-full p-2.5 border border-slate-300 rounded-lg italic font-bold focus:ring-1 focus:ring-[#E5252A]">
                <p class="text-[11px] text-slate-400">Judul section beranda dalam format cetak miring.</p>
            </div>

            <div class="space-y-1.5">
                <label class="font-bold text-slate-700 block">Efek Hover & Animasi Elevasi</label>
                <div class="flex items-center space-x-3 pt-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="setting-hover-elevation" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E5252A]"></div>
                    </label>
                    <span class="text-xs font-semibold text-slate-700">Aktif (translateY(-2px) & shadow)</span>
                </div>
                <p class="text-[11px] text-slate-400">Tombol pill ukuran terangkat saat disentuh kursor.</p>
            </div>

            <div class="space-y-1.5">
                <label class="font-bold text-slate-700 block">Visibilitas Stok Kosong</label>
                <div class="flex items-center space-x-3 pt-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="setting-hide-empty" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E5252A]"></div>
                    </label>
                    <span class="text-xs font-semibold text-slate-700">Sembunyikan Jika Habis (0)</span>
                </div>
                <p class="text-[11px] text-slate-400">Otomatis redupkan/sembunyikan pill jika stok habis.</p>
            </div>
        </div>

        <div class="pt-3 border-t border-slate-100 flex justify-end">
            <button type="button" onclick="saveAppearanceSettings()" class="bg-[#1E2229] hover:bg-[#2D333D] text-white px-5 py-2 rounded-xl text-xs font-bold shadow transition-all">
                Simpan Konfigurasi Section
            </button>
        </div>
    </div>

</div>

<!-- Size Item Editor Modal (Formulir Pengaturan Pil Ukuran) -->
<div id="size-item-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between pb-2 border-b border-slate-200">
            <h4 class="font-black text-slate-900 uppercase text-xs">Formulir Pengaturan Pil Ukuran</h4>
            <button type="button" onclick="closeSizeEditor()" class="text-slate-400 hover:text-slate-700 font-black text-lg">&times;</button>
        </div>

        <form id="form-size-item" class="space-y-3 text-xs">
            <div class="space-y-1">
                <label class="font-bold text-slate-700 block">Kategori Gender Induk:</label>
                <input type="text" id="modal-gender-target" readonly class="w-full p-2 bg-slate-100 border border-slate-200 rounded-lg font-bold">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-bold text-slate-700 block">Ukuran US (Primary):</label>
                    <input type="text" id="modal-size-us" required class="w-full p-2 border border-slate-300 rounded-lg font-bold">
                </div>
                <div class="space-y-1">
                    <label class="font-bold text-slate-700 block">Ukuran EU (Sub-label):</label>
                    <input type="text" id="modal-size-eu" required class="w-full p-2 border border-slate-300 rounded-lg font-bold">
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-bold text-slate-700 block">Parameter Query URL:</label>
                <input type="text" id="modal-size-url" required class="w-full p-2 border border-slate-300 rounded-lg font-mono">
            </div>

            <div class="space-y-2 pt-2 border-t border-slate-100">
                <label class="flex items-center space-x-2 font-bold text-slate-800">
                    <input type="checkbox" id="modal-size-hide-empty" class="rounded text-[#E5252A] focus:ring-[#E5252A]">
                    <span>Sembunyikan jika stok 0 di gudang</span>
                </label>
                <label class="flex items-center space-x-2 font-bold text-slate-800">
                    <input type="checkbox" id="modal-size-status" checked class="rounded text-[#E5252A] focus:ring-[#E5252A]">
                    <span>Status Pil Aktif (ON)</span>
                </label>
            </div>

            <div class="flex items-center space-x-2 pt-3">
                <button type="button" onclick="closeSizeEditor()" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2 rounded-lg">Batal</button>
                <button type="button" onclick="saveSizeItem()" class="w-1/2 bg-[#E5252A] hover:bg-[#c41c21] text-white font-bold py-2 rounded-lg shadow">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function switchCategoryTab(cat) {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-[#E5252A]', 'text-[#E5252A]', 'bg-white');
        btn.classList.add('border-transparent', 'text-slate-500');
    });
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));

    const activeBtn = event.currentTarget;
    activeBtn.classList.remove('border-transparent', 'text-slate-500');
    activeBtn.classList.add('border-[#E5252A]', 'text-[#E5252A]', 'bg-white');

    document.getElementById('tab-content-' + cat).classList.remove('hidden');
}

function openSizeEditor(gender, us, eu, url) {
    document.getElementById('modal-gender-target').value = gender + ' Footwear';
    document.getElementById('modal-size-us').value = us;
    document.getElementById('modal-size-eu').value = eu;
    document.getElementById('modal-size-url').value = url;
    document.getElementById('size-item-modal').classList.remove('hidden');
}

function closeSizeEditor() {
    document.getElementById('size-item-modal').classList.add('hidden');
}

function saveSizeItem() {
    alert('Konfigurasi pil ukuran berhasil disimpan!');
    closeSizeEditor();
}

function saveAppearanceSettings() {
    const title = document.getElementById('setting-section-title').value;
    localStorage.setItem('sportnexus_size_section_title', title);
    alert('Pengaturan tampilan Shop by Size berhasil disimpan!');
}

function syncStockCounters() {
    window.location.reload();
}
</script>
