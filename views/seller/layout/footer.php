    </main>

    
    <footer class="border-t border-taupe-light/20 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-xs text-taupe-mid">Aksara Lokal Seller Center &copy; <?= date('Y') ?></p>
        </div>
    </footer>

    
    <?php $currentPage = basename($_SERVER['SCRIPT_NAME']); ?>
    <nav class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-lg border-t border-taupe-light/30 h-16 flex items-center justify-around px-6 z-50 md:max-w-lg md:mx-auto md:bottom-6 md:rounded-full md:shadow-xl md:border">
        
        <a href="<?= BASE_URL ?>/seller_dashboard.php" class="seller-bnav-link flex flex-col items-center gap-1 no-underline <?= $currentPage === 'seller_dashboard.php' ? 'active' : '' ?>">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
            <span class="text-[10px] uppercase font-medium tracking-tighter">Dashboard</span>
        </a>

        
        <a href="<?= BASE_URL ?>/seller_products.php" class="seller-bnav-link flex flex-col items-center gap-1 no-underline <?= $currentPage === 'seller_products.php' ? 'active' : '' ?>">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
            <span class="text-[10px] uppercase font-medium tracking-tighter">Products</span>
        </a>

        
        <a href="<?= BASE_URL ?>/seller_orders.php" class="seller-bnav-link flex flex-col items-center gap-1 no-underline <?= $currentPage === 'seller_orders.php' ? 'active' : '' ?>">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
            <span class="text-[10px] uppercase font-medium tracking-tighter">Orders</span>
        </a>
    </nav>

    
    <?php if (isset($pageScripts)) echo $pageScripts; ?>

</body>
</html>
