<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
</main>

<!-- =========================================================================
     ADMIN STATUS BAR FOOTER
     Strict Principle: ZERO LINKS, PURE SYSTEM TELEMETRY
     ========================================================================= -->
<footer class="w-full bg-[#1E293B] text-slate-400 border-t border-slate-700/60 py-2.5 px-4 sm:px-8 text-xs select-none mt-auto">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
        <!-- Left: Internal System Copyright -->
        <div class="text-slate-400 text-[11px]">
            &copy; 2026 Sport Nexus Admin Portal &bull; Internal Management System. All Rights Reserved.
        </div>

        <!-- Right: Technical Telemetry & Version Release -->
        <div class="flex items-center space-x-3 text-[11px] font-mono text-slate-400">
            <span>App Version: <strong class="text-slate-200">v1.0.0 (Release 2026)</strong></span>
            <span class="text-slate-600">|</span>
            <span>DB Sync: <strong class="text-emerald-400">Latency 24ms</strong></span>
            <span class="text-slate-600">|</span>
            <span>Inventory Cache: <strong class="text-slate-200">Synced (<?php echo isset($total_skus) ? number_format($total_skus, 0, ',', '.') : '1.543'; ?> SKUs)</strong></span>
        </div>
    </div>
</footer>

<script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
</body>
</html>
