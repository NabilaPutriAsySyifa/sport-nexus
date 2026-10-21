<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - SPORTS & ACTIVITY MATRIX
     Sport Allocation KPI Cards & Activity Tag Re-assignment
     ========================================================================= -->

<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-200 gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#E5252A]"></span>
                <span class="text-xs font-black uppercase text-slate-400 tracking-wider">Activity Allocation</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900 mt-0.5">
                Sports & Activity Management
            </h1>
            <p class="text-xs text-slate-500">
                Alokasi cabang olahraga spesifik untuk katalog sepatu Sport Nexus (Lifestyle, Running, Fitness, Soccer, Tennis, Badminton, Golf, Swimming).
            </p>
        </div>

        <span class="text-xs bg-slate-900 text-white font-mono font-bold px-3 py-1.5 rounded-lg shadow-sm">
            Total: <?php echo number_format($total_products, 0, ',', '.'); ?> Produk
        </span>
    </div>

    <!-- 1. 8 SPORTS ALLOCATION KPI CARDS -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        <?php 
        $sports_kpis = array(
            'Lifestyle' => array('val' => $kpi_lifestyle, 'color' => 'hover:border-red-400'),
            'Running' => array('val' => $kpi_running, 'color' => 'hover:border-blue-400'),
            'Fitness' => array('val' => $kpi_fitness, 'color' => 'hover:border-amber-400'),
            'Soccer' => array('val' => $kpi_soccer, 'color' => 'hover:border-emerald-400'),
            'Tennis' => array('val' => $kpi_tennis, 'color' => 'hover:border-indigo-400'),
            'Badminton' => array('val' => $kpi_badminton, 'color' => 'hover:border-purple-400'),
            'Golf' => array('val' => $kpi_golf, 'color' => 'hover:border-green-400'),
            'Swimming' => array('val' => $kpi_swimming, 'color' => 'hover:border-cyan-400')
        );
        foreach ($sports_kpis as $sname => $sinfo): 
            $is_active = ($selected_sport === $sname);
        ?>
            <a href="<?php echo base_url('admin/sports?sport=' . urlencode($sname)); ?>" class="p-3 rounded-xl border shadow-sm transition-all text-center group <?php echo $is_active ? 'bg-red-50 border-[#E5252A]' : 'bg-white border-slate-200 ' . $sinfo['color']; ?>">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block truncate"><?php echo $sname; ?></span>
                <span class="text-lg font-black text-slate-900 group-hover:text-[#E5252A]"><?php echo $sinfo['val']; ?></span>
                <span class="text-[10px] text-slate-500 block">Model</span>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- 2. FILTER & TOOLBAR -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between text-xs">
        <div class="flex items-center space-x-2">
            <span class="font-bold text-slate-700">Filter Aktif:</span>
            <span class="bg-[#1E2229] text-white font-bold px-3 py-1 rounded-lg">
                <?php echo htmlspecialchars($selected_sport ?: 'Semua Cabang Olahraga'); ?>
            </span>
        </div>
        <a href="<?php echo base_url('admin/sports'); ?>" class="text-xs text-[#E5252A] font-bold hover:underline">
            Tampilkan Semua &raquo;
        </a>
    </div>

    <!-- 3. SPORTS ALLOCATION TABLE -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="p-3.5">Sepatu / Model</th>
                        <th class="p-3.5">Brand</th>
                        <th class="p-3.5">Gender</th>
                        <th class="p-3.5">Cabang Olahraga Saat Ini</th>
                        <th class="p-3.5">Tipe Footwear</th>
                        <th class="p-3.5 text-center">Aksi Re-assign</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $p): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-3.5">
                                    <div class="flex items-center space-x-3">
                                        <?php $sp_img = !empty($p->thumbnail) ? $p->thumbnail : (!empty($p->image_url) ? $p->image_url : base_url('assets/images/placeholder-shoe.png')); ?>
                                        <img src="<?php echo htmlspecialchars($sp_img); ?>" alt="shoe" class="w-10 h-10 object-contain bg-slate-50 rounded border border-slate-200 p-1 flex-shrink-0">
                                        <div>
                                            <strong class="font-bold text-slate-900 block"><?php echo htmlspecialchars($p->name); ?></strong>
                                            <span class="text-[11px] font-mono text-slate-400"><?php echo htmlspecialchars($p->sku); ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-3.5 font-bold text-slate-800"><?php echo htmlspecialchars($p->brand_name); ?></td>
                                <td class="p-3.5"><?php echo htmlspecialchars($p->gender); ?></td>
                                <td class="p-3.5">
                                    <span class="inline-block bg-red-50 text-[#E5252A] border border-red-200 px-2.5 py-1 rounded-md font-black text-xs uppercase tracking-wide">
                                        <?php echo htmlspecialchars($p->primary_sport); ?>
                                    </span>
                                </td>
                                <td class="p-3.5 text-slate-600"><?php echo htmlspecialchars($p->footwear_type); ?></td>
                                <td class="p-3.5 text-center">
                                    <button type="button" 
                                            class="bg-slate-100 hover:bg-[#E5252A] hover:text-white text-slate-700 text-xs font-bold px-3 py-1.5 rounded-lg transition-colors shadow-sm" 
                                            onclick='openSportModal(<?php echo $p->id; ?>, "<?php echo addslashes($p->name); ?>", "<?php echo htmlspecialchars($p->primary_sport); ?>")'>
                                        Ganti Aktivitas
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="p-8 text-center text-slate-400">Tidak ada produk untuk cabang olahraga ini.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="p-4 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
                <span>Halaman <?php echo $current_page; ?> dari <?php echo $total_pages; ?></span>
                <div class="flex items-center space-x-1">
                    <?php if ($current_page > 1): ?>
                        <a href="<?php $params = $_GET; $params['p'] = $current_page - 1; echo current_url() . '?' . http_build_query($params); ?>" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded font-bold text-slate-700">Prev</a>
                    <?php endif; ?>
                    <span class="px-3 py-1.5 bg-[#E5252A] text-white rounded font-bold"><?php echo $current_page; ?></span>
                    <?php if ($current_page < $total_pages): ?>
                        <a href="<?php $params = $_GET; $params['p'] = $current_page + 1; echo current_url() . '?' . http_build_query($params); ?>" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded font-bold text-slate-700">Next</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- Re-assign Activity Modal -->
<div id="sport-assign-modal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between pb-2 border-b border-slate-200">
            <h4 class="font-black text-slate-900 uppercase text-xs">Ubah Alokasi Cabang Olahraga</h4>
            <button type="button" onclick="closeSportModal()" class="text-slate-400 hover:text-slate-700 font-black text-lg">&times;</button>
        </div>

        <p id="modal-sport-title" class="text-xs font-bold text-slate-800 line-clamp-1">Model Sepatu</p>

        <form id="form-sport-assign" class="space-y-4 text-xs">
            <input type="hidden" id="modal-sport-pid" name="product_id">

            <div class="space-y-1">
                <label for="modal-sport-select" class="font-bold text-slate-700 block">Pilih Cabang Olahraga Baru *</label>
                <select id="modal-sport-select" name="primary_sport" class="w-full p-2.5 border border-slate-300 rounded-lg font-bold bg-white focus:ring-1 focus:ring-[#E5252A] focus:outline-none">
                    <option value="Lifestyle">Lifestyle</option>
                    <option value="Running">Running</option>
                    <option value="Fitness">Fitness</option>
                    <option value="Soccer">Soccer</option>
                    <option value="Tennis">Tennis</option>
                    <option value="Badminton">Badminton</option>
                    <option value="Golf">Golf</option>
                    <option value="Swimming">Swimming</option>
                </select>
            </div>

            <div class="flex items-center space-x-2 pt-2">
                <button type="button" onclick="closeSportModal()" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 rounded-lg">Batal</button>
                <button type="submit" class="w-1/2 bg-[#E5252A] hover:bg-[#c41c21] text-white font-bold py-2.5 rounded-lg shadow">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openSportModal(pid, name, currSport) {
    document.getElementById('modal-sport-pid').value = pid;
    document.getElementById('modal-sport-title').textContent = name;
    document.getElementById('modal-sport-select').value = currSport;
    document.getElementById('sport-assign-modal').classList.remove('hidden');
}
function closeSportModal() {
    document.getElementById('sport-assign-modal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
    const assignForm = document.getElementById('form-sport-assign');
    if (assignForm) {
        assignForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const pid = document.getElementById('modal-sport-pid').value;
            const sport = document.getElementById('modal-sport-select').value;

            const formData = new FormData();
            formData.append('product_id', pid);
            formData.append('primary_sport', sport);

            fetch('<?php echo base_url("admin/sports/assign_activity"); ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                closeSportModal();
                if (data.status === 'success') {
                    window.location.reload();
                } else {
                    alert(data.message || 'Gagal mengubah olahraga');
                }
            });
        });
    }
});
</script>
