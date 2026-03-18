    </main>

    <!-- ═══ Brand Philosophy ═══ -->
    <section class="bg-taupe-cream/20 py-20 px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-2xl md:text-3xl font-serif text-taupe-dark mb-6 italic">Sustainable. Ethical. Indonesian.</h2>
            <p class="text-taupe-mid leading-relaxed font-light">
                We bridge the gap between traditional Indonesian artisans and the modern home. Every purchase directly supports local communities and ensures the preservation of cultural heritage.
            </p>
        </div>
    </section>

    <!-- ═══ Footer ═══ -->
    <footer class="bg-taupe-dark text-taupe-light/80 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="font-serif italic text-off-white tracking-wider mb-3">Aksara Lokal &copy; <?= date('Y') ?></p>
            <div class="flex justify-center gap-6 text-xs tracking-widest uppercase">
                <a href="#" class="hover:text-off-white transition-colors">Instagram</a>
                <a href="#" class="hover:text-off-white transition-colors">Shipping Policy</a>
                <a href="#" class="hover:text-off-white transition-colors">Contact</a>
            </div>
        </div>
    </footer>

    <!-- ═══ Sticky Bottom Navigation (Capsule on Desktop, Full-width on Mobile) ═══ -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-lg border-t border-taupe-light/30 h-16 flex items-center justify-around px-6 z-50 md:max-w-md md:mx-auto md:bottom-6 md:rounded-full md:shadow-xl md:border">
        <!-- Home -->
        <a href="<?= BASE_URL ?>/" class="flex flex-col items-center gap-1 <?= basename($_SERVER['SCRIPT_NAME']) === 'index.php' ? 'text-taupe-dark' : 'text-taupe-mid hover:text-taupe-dark' ?> no-underline">
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"></path>
            </svg>
            <span class="text-[10px] uppercase font-medium tracking-tighter">Home</span>
        </a>

        <!-- Search → Products -->
        <a href="<?= BASE_URL ?>/products.php" class="flex flex-col items-center gap-1 <?= basename($_SERVER['SCRIPT_NAME']) === 'products.php' ? 'text-taupe-dark' : 'text-taupe-mid hover:text-taupe-dark' ?> no-underline">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <span class="text-[10px] uppercase font-medium tracking-tighter">Search</span>
        </a>

        <!-- Cart -->
        <a href="<?= BASE_URL ?>/cart.php" class="flex flex-col items-center gap-1 relative <?= basename($_SERVER['SCRIPT_NAME']) === 'cart.php' ? 'text-taupe-dark' : 'text-taupe-mid hover:text-taupe-dark' ?> no-underline">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <?php if (getCartCount() > 0): ?>
            <span class="absolute -top-1 -right-1 bg-taupe-dark text-white text-[8px] w-4 h-4 rounded-full flex items-center justify-center"><?= getCartCount() ?></span>
            <?php endif; ?>
            <span class="text-[10px] uppercase font-medium tracking-tighter">Cart</span>
        </a>

        <!-- Profile -->
        <a href="<?= isLoggedIn() ? BASE_URL . '/profile.php' : BASE_URL . '/login.php' ?>" class="flex flex-col items-center gap-1 <?= in_array(basename($_SERVER['SCRIPT_NAME']), ['profile.php', 'login.php', 'register.php']) ? 'text-taupe-dark' : 'text-taupe-mid hover:text-taupe-dark' ?> no-underline">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <span class="text-[10px] uppercase font-medium tracking-tighter">Profile</span>
        </a>
    </nav>

    <!-- Page-specific JS -->
    <?php if (isset($pageScripts)) echo $pageScripts; ?>

</body>
</html>
