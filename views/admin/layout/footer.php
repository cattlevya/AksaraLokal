<?php

?>
    </main>

    
    <footer class="border-t border-taupe-light/20 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-xs text-taupe-mid">Aksara Lokal Admin Center &copy; <?= date('Y') ?></p>
        </div>
    </footer>

    
    <?php $currentPage = basename($_SERVER['SCRIPT_NAME']); ?>
    <nav class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-lg border-t border-taupe-light/30 h-16 flex items-center justify-around px-2 z-50 md:max-w-3xl md:mx-auto md:bottom-6 md:rounded-full md:shadow-xl md:border">
        
        <a href="<?= BASE_URL ?>/admin_dashboard.php" class="admin-bnav-link flex flex-col items-center gap-1 no-underline <?= $currentPage === 'admin_dashboard.php' ? 'active' : '' ?>">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
            <span class="text-[9px] sm:text-[10px] uppercase font-medium tracking-tighter">Dash</span>
        </a>

        
        <a href="<?= BASE_URL ?>/admin_users.php" class="admin-bnav-link flex flex-col items-center gap-1 no-underline <?= $currentPage === 'admin_users.php' ? 'active' : '' ?>">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
            <span class="text-[9px] sm:text-[10px] uppercase font-medium tracking-tighter">Users</span>
        </a>

        
        <a href="<?= BASE_URL ?>/admin_categories.php" class="admin-bnav-link flex flex-col items-center gap-1 no-underline <?= $currentPage === 'admin_categories.php' ? 'active' : '' ?>">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
            <span class="text-[9px] sm:text-[10px] uppercase font-medium tracking-tighter">Cats</span>
        </a>

        
        <a href="<?= BASE_URL ?>/admin_products.php" class="admin-bnav-link flex flex-col items-center gap-1 no-underline <?= $currentPage === 'admin_products.php' ? 'active' : '' ?>">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
            <span class="text-[9px] sm:text-[10px] uppercase font-medium tracking-tighter">Prods</span>
        </a>

        
        <a href="<?= BASE_URL ?>/admin_orders.php" class="admin-bnav-link flex flex-col items-center gap-1 no-underline <?= $currentPage === 'admin_orders.php' ? 'active' : '' ?>">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
            <span class="text-[9px] sm:text-[10px] uppercase font-medium tracking-tighter">Verify</span>
        </a>

        
        <a href="<?= BASE_URL ?>/admin_vouchers.php" class="admin-bnav-link flex flex-col items-center gap-1 no-underline <?= in_array($currentPage, ['admin_vouchers.php', 'admin_flash_sale.php']) ? 'active' : '' ?>">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
            <span class="text-[9px] sm:text-[10px] uppercase font-medium tracking-tighter">Promo</span>
        </a>
    </nav>

    
    <?php if (isset($pageScripts)) echo $pageScripts; ?>

</body>
</html>
