<?php
/**
 * Admin Dashboard View
 * Variables: $globalRevenue, $totalUsers, $totalProducts, $totalOrders, $totalCategories
 */
?>
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="font-serif text-3xl text-taupe-dark italic">Platform Overview</h1>
        <p class="text-taupe-mid text-sm mt-1">Monitor Aksara Lokal's global performance.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="<?= BASE_URL ?>/admin_vouchers.php" class="px-4 py-2 bg-taupe-dark text-off-white rounded-lg text-sm font-medium hover:bg-[#7a6a58] transition-colors no-underline">
            Manage Vouchers
        </a>
        <a href="<?= BASE_URL ?>/admin_flash_sale.php" class="px-4 py-2 border border-taupe-light rounded-lg text-sm text-taupe-dark font-medium hover:border-taupe-dark transition-colors no-underline">
            Flash Sale
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Revenue Card (Prominent) -->
    <div class="lg:col-span-1 bg-white rounded-xl border border-taupe-light/30 p-6 flex flex-col justify-center shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-serif text-xl text-taupe-dark">Total Revenue</h2>
            <div class="p-2 rounded-lg bg-taupe-cream/30 text-taupe-dark">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <p class="text-4xl font-serif text-taupe-dark mb-1"><?= formatRupiah($globalRevenue) ?></p>
        <p class="text-xs text-taupe-mid">From all confirmed & shipped orders</p>
    </div>

    <!-- 4 Metrics Grid -->
    <div class="lg:col-span-2 grid grid-cols-2 gap-4">
        <!-- Users -->
        <a href="<?= BASE_URL ?>/admin_users.php" class="bg-white rounded-xl border border-taupe-light/30 p-5 hover:border-taupe-mid transition-all no-underline group block shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs text-taupe-mid uppercase tracking-wider font-medium group-hover:text-taupe-dark transition-colors">Users</p>
                <span class="w-8 h-8 rounded-lg bg-taupe-cream/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-taupe-dark group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </span>
            </div>
            <p class="text-3xl font-bold text-taupe-dark"><?= number_format($totalUsers) ?></p>
            <p class="text-[10px] text-taupe-mid mt-1">Platform-wide</p>
        </a>

        <!-- Categories -->
        <a href="<?= BASE_URL ?>/admin_categories.php" class="bg-white rounded-xl border border-taupe-light/30 p-5 hover:border-taupe-mid transition-all no-underline group block shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs text-taupe-mid uppercase tracking-wider font-medium group-hover:text-taupe-dark transition-colors">Categories</p>
                <span class="w-8 h-8 rounded-lg bg-taupe-cream/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-taupe-dark group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </span>
            </div>
            <p class="text-3xl font-bold text-taupe-dark"><?= number_format($totalCategories) ?></p>
            <p class="text-[10px] text-taupe-mid mt-1">Product taxonomy</p>
        </a>

        <!-- Products -->
        <a href="<?= BASE_URL ?>/admin_products.php" class="bg-white rounded-xl border border-taupe-light/30 p-5 hover:border-taupe-mid transition-all no-underline group block shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs text-taupe-mid uppercase tracking-wider font-medium group-hover:text-taupe-dark transition-colors">Products</p>
                <span class="w-8 h-8 rounded-lg bg-taupe-cream/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-taupe-dark group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </span>
            </div>
            <p class="text-3xl font-bold text-taupe-dark"><?= number_format($totalProducts) ?></p>
            <p class="text-[10px] text-taupe-mid mt-1">Total listings</p>
        </a>

        <!-- Orders -->
        <a href="<?= BASE_URL ?>/admin_orders.php" class="bg-white rounded-xl border border-taupe-light/30 p-5 hover:border-taupe-mid transition-all no-underline group block shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs text-taupe-mid uppercase tracking-wider font-medium group-hover:text-taupe-dark transition-colors">Orders</p>
                <span class="w-8 h-8 rounded-lg bg-taupe-cream/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-taupe-dark group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <p class="text-3xl font-bold text-taupe-dark"><?= number_format($totalOrders) ?></p>
            <p class="text-[10px] text-taupe-mid mt-1">Global transactions</p>
        </a>
    </div>
</div>
