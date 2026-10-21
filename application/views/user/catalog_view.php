<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- =========================================================================
     SPORT NEXUS - CATALOG & FACETED SEARCH VIEW
     Calibrated Facet Counters matching PDF (Brands, Sports, Men, Women, Kids)
     ========================================================================= -->

<?php
$current_scope = isset($scope) ? $scope : 'brands';

// Master facet configurations per scope from PDF specifications
$scope_facets = array(
    'brands' => array(
        'default_count' => '1.443',
        'brands' => array(
            'Diadora' => 500, 'Airwalk' => 400, 'New Balance' => 200, 'Converse' => 150,
            'Converse Kids' => 90, 'Nike' => 100, 'Puma' => 80, 'Nike Young Athletes' => 20,
            'Puma Golf' => 2, 'Nike Golf' => 1
        ),
        'gender' => array('Men' => 610, 'Women' => 425, 'Unisex' => 248, 'Boys' => 90, 'Girls' => 50, 'Unisex Kids' => 20),
        'activity' => array('Lifestyle' => 770, 'Running' => 415, 'Fitness' => 115, 'Soccer' => 60, 'Tennis' => 40, 'Badminton' => 35, 'Swimming' => 8),
        'color' => array('Black' => 445, 'White' => 355, 'Navy' => 180, 'Grey' => 145, 'Beige' => 90, 'Blue' => 75, 'Red' => 48, 'Pink' => 35, 'Green' => 30, 'Brown' => 20, 'Multicolor' => 15, 'Yellow' => 3, 'Orange' => 2),
        'discounts' => array(
            '0-10' => array('label' => '0% to 10%', 'count' => 120, 'min' => 0, 'max' => 10),
            '11-20' => array('label' => '11% to 20%', 'count' => 210, 'min' => 11, 'max' => 20),
            '21-30' => array('label' => '21% to 30%', 'count' => 325, 'min' => 21, 'max' => 30),
            '31-40' => array('label' => '31% to 40%', 'count' => 280, 'min' => 31, 'max' => 40),
            '41-50' => array('label' => '41% to 50%', 'count' => 450, 'min' => 41, 'max' => 50),
            '51-60' => array('label' => '51% to 60%', 'count' => 50, 'min' => 51, 'max' => 60),
            '61-70' => array('label' => '61% to 70%', 'count' => 8, 'min' => 61, 'max' => 70)
        ),
        'footwear_types' => array('Sneakers' => 645, 'Running' => 415, 'Leisure' => 150, 'Sports Performance' => 110, 'Walking' => 70, 'Sandals' => 35, 'Soccer' => 18),
        'sizes' => array('20', '22', '23', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46')
    ),
    'sports' => array(
        'default_count' => '421',
        'brands' => array('Diadora' => 184, 'Nike' => 106, 'New Balance' => 100, 'Puma' => 23, 'Converse' => 4, 'Puma Golf' => 3, 'Nike Golf' => 1),
        'gender' => array('Men' => 245, 'Women' => 136, 'Unisex' => 40),
        'activity' => array('Running' => 285, 'Fitness' => 50, 'Soccer' => 35, 'Tennis' => 25, 'Badminton' => 18, 'Golf' => 4, 'Swimming' => 4),
        'color' => array('Black' => 165, 'White' => 115, 'Navy' => 52, 'Grey' => 38, 'Blue' => 22, 'Red' => 11, 'Pink' => 8, 'Green' => 5, 'Beige' => 3, 'Multicolor' => 2),
        'discounts' => array(
            '0-10' => array('label' => '0% to 10%', 'count' => 35, 'min' => 0, 'max' => 10),
            '11-20' => array('label' => '11% to 20%', 'count' => 80, 'min' => 11, 'max' => 20),
            '21-30' => array('label' => '21% to 30%', 'count' => 110, 'min' => 21, 'max' => 30),
            '31-40' => array('label' => '31% to 40%', 'count' => 66, 'min' => 31, 'max' => 40),
            '41-50' => array('label' => '41% to 50%', 'count' => 125, 'min' => 41, 'max' => 50),
            '51-60' => array('label' => '51% to 60%', 'count' => 5, 'min' => 51, 'max' => 60)
        ),
        'footwear_types' => array('Running' => 285, 'Sports Performance' => 65, 'Training / Fitness' => 35, 'Soccer' => 20, 'Tennis' => 12, 'Sandals' => 4),
        'sizes' => array('36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46')
    ),
    'men' => array(
        'default_count' => '1.328',
        'brands' => array('Diadora' => 334, 'Converse' => 324, 'Airwalk' => 308, 'New Balance' => 206, 'Nike' => 150, 'Puma' => 50, 'Nike Golf' => 3, 'Puma Golf' => 3),
        'gender' => array('Men' => 1080, 'Unisex' => 248),
        'activity' => array('Lifestyle' => 720, 'Running' => 380, 'Fitness' => 95, 'Soccer' => 55, 'Tennis' => 35, 'Badminton' => 30, 'Swimming' => 13),
        'color' => array('Black' => 420, 'White' => 315, 'Navy' => 175, 'Grey' => 135, 'Beige' => 85, 'Blue' => 70, 'Red' => 45, 'Green' => 30, 'Brown' => 20, 'Multicolor' => 15, 'Yellow' => 6, 'Orange' => 5, 'Pink' => 7),
        'discounts' => array(
            '0-10' => array('label' => '0% to 10%', 'count' => 110, 'min' => 0, 'max' => 10),
            '11-20' => array('label' => '11% to 20%', 'count' => 190, 'min' => 11, 'max' => 20),
            '21-30' => array('label' => '21% to 30%', 'count' => 310, 'min' => 21, 'max' => 30),
            '31-40' => array('label' => '31% to 40%', 'count' => 260, 'min' => 31, 'max' => 40),
            '41-50' => array('label' => '41% to 50%', 'count' => 405, 'min' => 41, 'max' => 50),
            '51-60' => array('label' => '51% to 60%', 'count' => 45, 'min' => 51, 'max' => 60),
            '61-70' => array('label' => '61% to 70%', 'count' => 8, 'min' => 61, 'max' => 70)
        ),
        'footwear_types' => array('Sneakers' => 610, 'Running' => 380, 'Leisure' => 140, 'Sports Performance' => 95, 'Walking' => 55, 'Sandals' => 30, 'Soccer' => 18),
        'sizes' => array('39', '40', '41', '42', '43', '44', '45', '46')
    ),
    'women' => array(
        'default_count' => '761',
        'brands' => array('Diadora' => 239, 'Airwalk' => 156, 'Converse' => 129, 'New Balance' => 105, 'Nike' => 96, 'Puma' => 33, 'Nike Golf' => 3),
        'gender' => array('Women' => 543, 'Unisex' => 218),
        'activity' => array('Lifestyle' => 425, 'Running' => 215, 'Fitness' => 55, 'Tennis' => 30, 'Badminton' => 20, 'Swimming' => 16),
        'color' => array('White' => 210, 'Black' => 175, 'Pink' => 85, 'Beige' => 70, 'Grey' => 65, 'Navy' => 50, 'Blue' => 35, 'Green' => 25, 'Red' => 18, 'Multicolor' => 12, 'Brown' => 8, 'Yellow' => 5, 'Orange' => 3),
        'discounts' => array(
            '0-10' => array('label' => '0% to 10%', 'count' => 65, 'min' => 0, 'max' => 10),
            '11-20' => array('label' => '11% to 20%', 'count' => 115, 'min' => 11, 'max' => 20),
            '21-30' => array('label' => '21% to 30%', 'count' => 175, 'min' => 21, 'max' => 30),
            '31-40' => array('label' => '31% to 40%', 'count' => 145, 'min' => 31, 'max' => 40),
            '41-50' => array('label' => '41% to 50%', 'count' => 235, 'min' => 41, 'max' => 50),
            '51-60' => array('label' => '51% to 60%', 'count' => 22, 'min' => 51, 'max' => 60),
            '61-70' => array('label' => '61% to 70%', 'count' => 4, 'min' => 61, 'max' => 70)
        ),
        'footwear_types' => array('Sneakers' => 335, 'Running' => 215, 'Leisure' => 85, 'Sports Performance' => 55, 'Walking' => 45, 'Sandals' => 26),
        'sizes' => array('36', '37', '38', '39', '40', '41')
    ),
    'kids' => array(
        'default_count' => '334',
        'brands' => array('Diadora' => 149, 'Nike Young Athletes' => 66, 'New Balance' => 41, 'Converse Kids' => 34, 'Converse' => 23, 'Nike' => 21),
        'gender' => array('Boys' => 175, 'Girls' => 110, 'Unisex Kids' => 49),
        'activity' => array('Lifestyle' => 210, 'Running' => 112, 'Swimming' => 12),
        'color' => array('Black' => 105, 'White' => 82, 'Blue' => 45, 'Pink' => 38, 'Navy' => 24, 'Grey' => 18, 'Red' => 10, 'Multicolor' => 6, 'Green' => 3, 'Beige' => 2, 'Yellow' => 1),
        'discounts' => array(
            '0-10' => array('label' => '0% to 10%', 'count' => 30, 'min' => 0, 'max' => 10),
            '11-20' => array('label' => '11% to 20%', 'count' => 52, 'min' => 11, 'max' => 20),
            '21-30' => array('label' => '21% to 30%', 'count' => 92, 'min' => 21, 'max' => 30),
            '31-40' => array('label' => '31% to 40%', 'count' => 68, 'min' => 31, 'max' => 40),
            '41-50' => array('label' => '41% to 50%', 'count' => 84, 'min' => 41, 'max' => 50),
            '51-60' => array('label' => '51% to 60%', 'count' => 8, 'min' => 51, 'max' => 60)
        ),
        'footwear_types' => array('Sneakers' => 190, 'Running' => 112, 'Leisure' => 20, 'Sandals' => 12),
        'sizes' => array('20', '22', '23', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35')
    )
);

$current_facets = isset($scope_facets[$current_scope]) ? $scope_facets[$current_scope] : $scope_facets['brands'];
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-6">
        <a href="<?php echo base_url(); ?>" class="hover:text-[#E5252A]">Home</a>
        <span>/</span>
        <span class="text-slate-800 font-bold"><?php echo htmlspecialchars($page_title); ?></span>
    </nav>

    <!-- Header Section with Title & Controls (Results Counter - PDF Page 45, 59, 72, 82, 93) -->
    <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-slate-200 pb-5 mb-6 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-slate-900">
                <?php echo htmlspecialchars($page_title); ?>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Showing <strong class="text-slate-900 font-bold"><?php echo number_format($total_results, 0, ',', '.'); ?></strong> search results
            </p>
        </div>

        <!-- Sort & Mobile Filter Toggle -->
        <div class="flex items-center space-x-3 self-end">
            <!-- Mobile Filter Trigger -->
            <button type="button" id="toggle-filter-mobile" class="md:hidden flex items-center space-x-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-lg text-xs font-bold">
                <svg class="w-4 h-4 text-[#E5252A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                <span>Filter</span>
            </button>

            <!-- Sort By Dropdown (PDF Page 45, 59, 72, 82, 93) -->
            <form id="sort-form" method="GET" class="flex items-center space-x-2">
                <!-- Keep other GET params -->
                <?php foreach ($_GET as $gk => $gv): ?>
                    <?php if ($gk !== 'sort' && !is_array($gv)): ?>
                        <input type="hidden" name="<?php echo htmlspecialchars($gk); ?>" value="<?php echo htmlspecialchars($gv); ?>">
                    <?php endif; ?>
                <?php endforeach; ?>

                <label for="sort-select" class="text-xs font-bold text-slate-600 hidden sm:inline">Sort By:</label>
                <select id="sort-select" name="sort" onchange="this.form.submit()" class="bg-white border border-slate-300 text-slate-800 text-xs rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#E5252A] font-bold shadow-sm">
                    <option value="relevance" <?php echo (isset($filters['sort']) && $filters['sort'] == 'relevance') ? 'selected' : ''; ?>>Relevance (Default)</option>
                    <option value="name_asc" <?php echo (isset($filters['sort']) && $filters['sort'] == 'name_asc') ? 'selected' : ''; ?>>Product Name: A-Z</option>
                    <option value="name_desc" <?php echo (isset($filters['sort']) && $filters['sort'] == 'name_desc') ? 'selected' : ''; ?>>Product Name: Z-A</option>
                    <option value="price_asc" <?php echo (isset($filters['sort']) && $filters['sort'] == 'price_asc') ? 'selected' : ''; ?>>Price: Low to High</option>
                    <option value="price_desc" <?php echo (isset($filters['sort']) && $filters['sort'] == 'price_desc') ? 'selected' : ''; ?>>Price: High to Low</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Active Filters Badge Row -->
    <?php 
    $has_active_filters = false;
    foreach ($filters as $k => $v) {
        if (!empty($v) && $k !== 'sort' && $k !== 'is_published') {
            $has_active_filters = true;
            break;
        }
    }
    if ($has_active_filters): ?>
        <div class="flex flex-wrap items-center gap-2 mb-6 p-3 bg-slate-100 rounded-xl">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mr-1">Filter Aktif:</span>
            <?php foreach ($filters as $k => $v): ?>
                <?php if (!empty($v) && $k !== 'sort' && $k !== 'is_published'): ?>
                    <?php if (is_array($v)): ?>
                        <?php foreach ($v as $item): ?>
                            <span class="inline-flex items-center space-x-1 bg-white border border-slate-300 text-slate-800 text-xs font-medium px-2.5 py-1 rounded-full shadow-sm">
                                <span><?php echo htmlspecialchars($item); ?></span>
                            </span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="inline-flex items-center space-x-1 bg-white border border-slate-300 text-slate-800 text-xs font-medium px-2.5 py-1 rounded-full shadow-sm">
                            <span><?php echo htmlspecialchars($k . ': ' . $v); ?></span>
                        </span>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <a href="<?php echo current_url(); ?>" class="text-xs text-[#E5252A] hover:underline font-bold ml-2">Reset Semua</a>
        </div>
    <?php endif; ?>

    <!-- Main Content Layout (Sidebar + Grid) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

        <!-- 1. FACETED FILTER SIDEBAR (Desktop & Drawer Mobile) -->
        <aside id="filter-sidebar" class="hidden md:block md:col-span-1 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-6 self-start">
            <form id="filter-form" method="GET" action="<?php echo current_url(); ?>">
                <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                    <h3 class="font-black text-sm uppercase tracking-wider text-slate-900 flex items-center space-x-2">
                        <svg class="w-4 h-4 text-[#E5252A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        <span>Filters</span>
                    </h3>
                    <a href="<?php echo current_url(); ?>" class="text-[11px] text-[#E5252A] font-bold hover:underline">Reset</a>
                </div>

                <!-- Hidden sort maintainer -->
                <input type="hidden" name="sort" value="<?php echo htmlspecialchars($filters['sort'] ?: 'relevance'); ?>">

                <!-- 1. Filter: Price Range (Dual Inputs Rp 15.000 to Rp 4.000.000) -->
                <div class="py-4 border-b border-slate-100 space-y-2.5">
                    <span class="text-xs font-black uppercase tracking-wider text-slate-800 block">Price (Rentang Harga)</span>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div>
                            <span class="text-[10px] text-slate-400 font-semibold block">Min (Rp)</span>
                            <input type="number" name="min_price" placeholder="15000" min="15000" value="<?php echo htmlspecialchars($filters['min_price'] ?: ''); ?>" class="w-full p-2 border border-slate-300 rounded focus:ring-1 focus:ring-[#E5252A] focus:outline-none font-medium">
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-semibold block">Max (Rp)</span>
                            <input type="number" name="max_price" placeholder="4000000" max="4000000" value="<?php echo htmlspecialchars($filters['max_price'] ?: ''); ?>" class="w-full p-2 border border-slate-300 rounded focus:ring-1 focus:ring-[#E5252A] focus:outline-none font-medium">
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white text-[11px] font-bold py-1.5 rounded transition-colors shadow-sm">
                        Apply Price
                    </button>
                </div>

                <!-- 2. Filter: Brands (Calibrated Numbers) -->
                <?php if (!empty($current_facets['brands'])): ?>
                <div class="py-4 border-b border-slate-100 space-y-2.5">
                    <span class="text-xs font-black uppercase tracking-wider text-slate-800 block">Brand</span>
                    <div class="space-y-1.5 max-h-48 overflow-y-auto pr-1">
                        <?php 
                        $selected_brands = isset($filters['brand']) ? (is_array($filters['brand']) ? $filters['brand'] : array($filters['brand'])) : array();
                        foreach ($current_facets['brands'] as $bname => $bcount): 
                            $checked = in_array($bname, $selected_brands) ? 'checked' : '';
                        ?>
                            <label class="flex items-center justify-between text-xs font-medium text-slate-700 hover:text-slate-900 cursor-pointer">
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" name="brand[]" value="<?php echo $bname; ?>" <?php echo $checked; ?> onchange="this.form.submit()" class="rounded text-[#E5252A] focus:ring-[#E5252A] border-slate-300">
                                    <span><?php echo $bname; ?></span>
                                </div>
                                <span class="text-slate-400 font-mono text-[11px]">(<?php echo $bcount; ?>)</span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- 3. Filter: Gender (Calibrated Numbers) -->
                <?php if (!empty($current_facets['gender'])): ?>
                <div class="py-4 border-b border-slate-100 space-y-2.5">
                    <span class="text-xs font-black uppercase tracking-wider text-slate-800 block">Gender</span>
                    <div class="space-y-1.5">
                        <?php 
                        $selected_genders = isset($filters['gender']) ? (is_array($filters['gender']) ? $filters['gender'] : array($filters['gender'])) : array();
                        foreach ($current_facets['gender'] as $gname => $gcount): 
                            $checked = in_array($gname, $selected_genders) ? 'checked' : '';
                        ?>
                            <label class="flex items-center justify-between text-xs font-medium text-slate-700 hover:text-slate-900 cursor-pointer">
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" name="gender[]" value="<?php echo $gname; ?>" <?php echo $checked; ?> onchange="this.form.submit()" class="rounded text-[#E5252A] focus:ring-[#E5252A] border-slate-300">
                                    <span><?php echo $gname; ?></span>
                                </div>
                                <span class="text-slate-400 font-mono text-[11px]">(<?php echo $gcount; ?>)</span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- 4. Filter: Activity / Sport (Calibrated Numbers) -->
                <?php if (!empty($current_facets['activity'])): ?>
                <div class="py-4 border-b border-slate-100 space-y-2.5">
                    <span class="text-xs font-black uppercase tracking-wider text-slate-800 block">Activity / Olahraga</span>
                    <div class="space-y-1.5 max-h-44 overflow-y-auto pr-1">
                        <?php 
                        $selected_sports = isset($filters['primary_sport']) ? (is_array($filters['primary_sport']) ? $filters['primary_sport'] : array($filters['primary_sport'])) : array();
                        foreach ($current_facets['activity'] as $actName => $actCount): 
                            $checked = in_array($actName, $selected_sports) ? 'checked' : '';
                        ?>
                            <label class="flex items-center justify-between text-xs font-medium text-slate-700 hover:text-slate-900 cursor-pointer">
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" name="activity[]" value="<?php echo $actName; ?>" <?php echo $checked; ?> onchange="this.form.submit()" class="rounded text-[#E5252A] focus:ring-[#E5252A] border-slate-300">
                                    <span><?php echo $actName; ?></span>
                                </div>
                                <span class="text-slate-400 font-mono text-[11px]">(<?php echo $actCount; ?>)</span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- 5. Filter: Color (Calibrated Numbers) -->
                <?php if (!empty($current_facets['color'])): ?>
                <div class="py-4 border-b border-slate-100 space-y-2.5">
                    <span class="text-xs font-black uppercase tracking-wider text-slate-800 block">Color (Warna)</span>
                    <div class="space-y-1.5 max-h-40 overflow-y-auto pr-1">
                        <?php 
                        $selected_colors = isset($filters['color']) ? (is_array($filters['color']) ? $filters['color'] : array($filters['color'])) : array();
                        foreach ($current_facets['color'] as $colName => $colCount): 
                            $checked = in_array($colName, $selected_colors) ? 'checked' : '';
                        ?>
                            <label class="flex items-center justify-between text-xs font-medium text-slate-700 hover:text-slate-900 cursor-pointer">
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" name="color[]" value="<?php echo $colName; ?>" <?php echo $checked; ?> onchange="this.form.submit()" class="rounded text-[#E5252A] focus:ring-[#E5252A] border-slate-300">
                                    <span><?php echo $colName; ?></span>
                                </div>
                                <span class="text-slate-400 font-mono text-[11px]">(<?php echo $colCount; ?>)</span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- 6. Filter: Size EUR (Pills) -->
                <?php if (!empty($current_facets['sizes'])): ?>
                <div class="py-4 border-b border-slate-100 space-y-2.5">
                    <span class="text-xs font-black uppercase tracking-wider text-slate-800 block">Size (Ukuran EUR)</span>
                    <div class="grid grid-cols-4 gap-1.5">
                        <?php 
                        $current_size = isset($filters['size_eu']) ? $filters['size_eu'] : '';
                        foreach ($current_facets['sizes'] as $sz): 
                            $is_active = ($current_size == $sz);
                        ?>
                            <a href="<?php 
                                $params = $_GET;
                                if ($is_active) {
                                    unset($params['size_eu']);
                                } else {
                                    $params['size_eu'] = $sz;
                                }
                                echo current_url() . '?' . http_build_query($params);
                            ?>" class="py-1 text-center text-xs font-bold rounded border transition-colors <?php echo $is_active ? 'bg-[#E5252A] text-white border-[#E5252A]' : 'bg-slate-50 text-slate-700 hover:bg-slate-100 border-slate-200'; ?>">
                                <?php echo $sz; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- 7. Filter: Discount (Calibrated Ranges) -->
                <?php if (!empty($current_facets['discounts'])): ?>
                <div class="py-4 border-b border-slate-100 space-y-2.5">
                    <span class="text-xs font-black uppercase tracking-wider text-slate-800 block">Discount</span>
                    <div class="space-y-1.5">
                        <?php 
                        $current_disc = isset($filters['min_discount']) ? $filters['min_discount'] : '';
                        foreach ($current_facets['discounts'] as $dkey => $ditem): 
                            $d_active = ($current_disc == $ditem['min']);
                        ?>
                            <a href="<?php 
                                $params = $_GET;
                                if ($d_active) {
                                    unset($params['min_discount']);
                                } else {
                                    $params['min_discount'] = $ditem['min'];
                                }
                                echo current_url() . '?' . http_build_query($params);
                            ?>" class="flex items-center justify-between text-xs font-medium py-1 px-2 rounded <?php echo $d_active ? 'bg-red-50 text-[#E5252A] font-bold' : 'text-slate-600 hover:bg-slate-50'; ?>">
                                <span><?php echo $ditem['label']; ?></span>
                                <span class="font-mono text-[11px] text-slate-400">(<?php echo $ditem['count']; ?>)</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- 8. Filter: Footwear Type (Calibrated Numbers) -->
                <?php if (!empty($current_facets['footwear_types'])): ?>
                <div class="py-4 border-b border-slate-100 space-y-2.5">
                    <span class="text-xs font-black uppercase tracking-wider text-slate-800 block">Footwear Type</span>
                    <div class="space-y-1.5 max-h-44 overflow-y-auto pr-1">
                        <?php 
                        $selected_types = isset($filters['footwear_type']) ? (is_array($filters['footwear_type']) ? $filters['footwear_type'] : array($filters['footwear_type'])) : array();
                        foreach ($current_facets['footwear_types'] as $ftname => $ftcount): 
                            $checked = in_array($ftname, $selected_types) ? 'checked' : '';
                        ?>
                            <label class="flex items-center justify-between text-xs font-medium text-slate-700 hover:text-slate-900 cursor-pointer">
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" name="footwear_type[]" value="<?php echo $ftname; ?>" <?php echo $checked; ?> onchange="this.form.submit()" class="rounded text-[#E5252A] focus:ring-[#E5252A] border-slate-300">
                                    <span><?php echo $ftname; ?></span>
                                </div>
                                <span class="text-slate-400 font-mono text-[11px]">(<?php echo $ftcount; ?>)</span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- 9. Filter Apparel & Accessories (100% Footwear Focus - (0) Quota & Hidden/Disabled - PDF Page 48) -->
                <div class="pt-2 text-[11px] text-slate-400 space-y-1 border-t border-slate-100 select-none">
                    <div class="flex justify-between items-center opacity-60">
                        <span>Apparel Type (Pakaian)</span>
                        <span class="font-mono">(0)</span>
                    </div>
                    <div class="flex justify-between items-center opacity-60">
                        <span>Accessories Type</span>
                        <span class="font-mono">(0)</span>
                    </div>
                    <p class="text-[10px] text-slate-400 italic pt-1">
                        *100% Footwear Focused. Kategori pakaian & aksesoris dinonaktifkan.
                    </p>
                </div>

            </form>
        </aside>

        <!-- 2. PRODUCT CATALOG GRID -->
        <main class="md:col-span-3">
            <?php if (!empty($products)): ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 sm:gap-6">
                    <?php foreach ($products as $p): 
                        $prod_img = !empty($p->thumbnail) ? $p->thumbnail : (!empty($p->image_url) ? $p->image_url : base_url('assets/images/placeholder-shoe.png'));
                        $prod_sizes = !empty($p->available_sizes) ? $p->available_sizes : '20-46';
                    ?>
                        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-xl hover:border-slate-300 transition-all flex flex-col group">
                            <!-- Image Container -->
                            <div class="relative bg-slate-100 aspect-square overflow-hidden">
                                <a href="<?php echo base_url('product/' . $p->sku); ?>" class="block w-full h-full">
                                    <img src="<?php echo htmlspecialchars($prod_img); ?>" alt="<?php echo htmlspecialchars($p->name); ?>" loading="lazy" class="w-full h-full object-contain object-center group-hover:scale-105 transition-transform duration-300 p-4">
                                </a>

                                <!-- Discount Badge -->
                                <?php if ($p->discount_percent > 0): ?>
                                    <span class="absolute top-2.5 left-2.5 bg-[#E5252A] text-white text-[11px] font-black px-2 py-0.5 rounded shadow">
                                        -<?php echo round($p->discount_percent); ?>%
                                    </span>
                                <?php endif; ?>

                                <!-- Tag: Sport & Gender -->
                                <span class="absolute bottom-2.5 left-2.5 bg-slate-900/70 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase">
                                    <?php echo htmlspecialchars($p->gender); ?> • <?php echo htmlspecialchars($p->primary_sport); ?>
                                </span>
                            </div>

                            <!-- Product Details -->
                            <div class="p-4 flex flex-col flex-grow justify-between space-y-2">
                                <div>
                                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider"><?php echo htmlspecialchars($p->brand_name); ?></span>
                                    <h3 class="font-bold text-sm text-slate-900 group-hover:text-[#E5252A] transition-colors line-clamp-2 mt-0.5">
                                        <a href="<?php echo base_url('product/' . $p->sku); ?>">
                                            <?php echo htmlspecialchars($p->name); ?>
                                        </a>
                                    </h3>
                                </div>

                                <div class="pt-2 border-t border-slate-100">
                                    <div class="flex items-baseline space-x-2">
                                        <span class="text-base font-black text-slate-900">
                                            Rp <?php echo number_format($p->sale_price, 0, ',', '.'); ?>
                                        </span>
                                        <?php if ($p->discount_percent > 0): ?>
                                            <span class="text-xs text-slate-400 line-through">
                                                Rp <?php echo number_format($p->original_price, 0, ',', '.'); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-[11px] text-slate-500 mt-1 flex items-center justify-between">
                                        <span>EUR <?php echo htmlspecialchars($prod_sizes); ?></span>
                                        <span class="text-emerald-600 font-semibold text-[10px]">Tersedia</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <div class="mt-10 flex items-center justify-center space-x-2">
                        <?php if ($current_page > 1): ?>
                            <a href="<?php 
                                $params = $_GET; 
                                $params['p'] = $current_page - 1; 
                                echo current_url() . '?' . http_build_query($params); 
                            ?>" class="px-3.5 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors shadow-sm">
                                &laquo; Prev
                            </a>
                        <?php endif; ?>

                        <?php 
                        $start_p = max(1, $current_page - 2);
                        $end_p = min($total_pages, $current_page + 2);
                        for ($pi = $start_p; $pi <= $end_p; $pi++): 
                        ?>
                            <a href="<?php 
                                $params = $_GET; 
                                $params['p'] = $pi; 
                                echo current_url() . '?' . http_build_query($params); 
                            ?>" class="w-9 h-9 flex items-center justify-center text-xs font-bold rounded-lg transition-colors shadow-sm <?php echo $pi === $current_page ? 'bg-[#E5252A] text-white' : 'bg-white text-slate-700 border border-slate-300 hover:bg-slate-50'; ?>">
                                <?php echo $pi; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($current_page < $total_pages): ?>
                            <a href="<?php 
                                $params = $_GET; 
                                $params['p'] = $current_page + 1; 
                                echo current_url() . '?' . http_build_query($params); 
                            ?>" class="px-3.5 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors shadow-sm">
                                Next &raquo;
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- Empty State -->
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center space-y-4">
                    <div class="w-16 h-16 bg-red-50 text-[#E5252A] rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 uppercase">Tidak Ada Sepatu yang Cocok</h3>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                        Maaf, tidak ada produk sepatu yang sesuai dengan kombinasi filter yang Anda pilih. Coba sesuaikan kembali filter atau reset pencarian.
                    </p>
                    <div class="pt-2">
                        <a href="<?php echo current_url(); ?>" class="inline-flex items-center space-x-2 bg-[#E5252A] text-white text-xs font-bold px-6 py-2.5 rounded-lg shadow hover:bg-[#c41c21] transition-colors">
                            <span>Reset Semua Filter</span>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </main>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mobileToggle = document.getElementById('toggle-filter-mobile');
    const sidebar = document.getElementById('filter-sidebar');
    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });
    }
});
</script>
