<?php
/**
 * Seller Dashboard View — Professional dashboard with stats, chart, quick actions
 * Variables: $sellerProducts, $sellerOrders, $salesData, $asciiChart, $pendingOrders, $lowStockProducts
 */
?>

<!-- Welcome + Quick Actions -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="font-serif text-2xl text-taupe-dark">Welcome back, <span class="italic"><?= e(currentUser()['username']) ?></span></h1>
        <p class="text-sm text-taupe-mid mt-1">Here's an overview of your store performance</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="<?= BASE_URL ?>/seller_products.php?action=add" class="px-4 py-2 bg-taupe-dark text-off-white rounded-lg text-sm font-medium hover:bg-[#7a6a58] transition-colors no-underline flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            Add Product
        </a>
        <a href="<?= BASE_URL ?>/seller_orders.php?status=pending" class="px-4 py-2 border border-taupe-light rounded-lg text-sm text-taupe-dark font-medium hover:border-taupe-dark transition-colors no-underline">
            View Orders
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-taupe-light/30 p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs text-taupe-mid uppercase tracking-wider font-medium">Products</p>
            <span class="w-8 h-8 rounded-lg bg-taupe-cream/30 flex items-center justify-center">
                <svg class="w-4 h-4 text-taupe-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
            </span>
        </div>
        <p class="text-3xl font-bold text-taupe-dark"><?= count($sellerProducts) ?></p>
        <p class="text-[10px] text-taupe-mid mt-1"><?= count(array_filter($sellerProducts, fn($p) => $p['is_active'])) ?> active</p>
    </div>

    <div class="bg-white rounded-xl border border-taupe-light/30 p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs text-taupe-mid uppercase tracking-wider font-medium">Orders</p>
            <span class="w-8 h-8 rounded-lg bg-taupe-cream/30 flex items-center justify-center">
                <svg class="w-4 h-4 text-taupe-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
            </span>
        </div>
        <p class="text-3xl font-bold text-taupe-dark"><?= count($sellerOrders) ?></p>
        <p class="text-[10px] text-taupe-mid mt-1">all time</p>
    </div>

    <div class="bg-white rounded-xl border border-taupe-light/30 p-5 <?= count($pendingOrders) > 0 ? 'ring-1 ring-taupe-mid' : '' ?>">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs text-taupe-mid uppercase tracking-wider font-medium">Pending</p>
            <span class="w-8 h-8 rounded-lg <?= count($pendingOrders) > 0 ? 'bg-taupe-cream/50' : 'bg-taupe-cream/30' ?> flex items-center justify-center">
                <svg class="w-4 h-4 text-taupe-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
            </span>
        </div>
        <p class="text-3xl font-bold text-taupe-dark"><?= count($pendingOrders) ?></p>
        <p class="text-[10px] text-taupe-mid mt-1"><?= count($pendingOrders) > 0 ? 'needs attention!' : 'all clear' ?></p>
    </div>

    <div class="bg-white rounded-xl border border-taupe-light/30 p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs text-taupe-mid uppercase tracking-wider font-medium">7-Day Revenue</p>
            <span class="w-8 h-8 rounded-lg bg-taupe-cream/30 flex items-center justify-center">
                <svg class="w-4 h-4 text-taupe-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
            </span>
        </div>
        <p class="text-2xl font-bold text-taupe-dark"><?= formatRupiah(array_sum(array_column($salesData, 'daily_total'))) ?></p>
        <p class="text-[10px] text-taupe-mid mt-1">last 7 days</p>
    </div>
</div>

<!-- Sales Chart -->
<div class="bg-white rounded-xl border border-taupe-light/30 p-6 mb-8 overflow-x-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-serif text-xl text-taupe-dark italic">7-Day Sales Activity</h2>
            <p class="text-xs text-taupe-mid mt-1">Daily revenue breakdown</p>
        </div>
        <div class="p-2 rounded-lg bg-taupe-cream/30 text-taupe-dark">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
        </div>
    </div>
    <div class="bg-taupe-cream/10 rounded-lg p-6 border border-taupe-light/20">
        <pre class="text-taupe-dark font-mono text-xs leading-relaxed whitespace-pre"><?= $asciiChart ?></pre>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Orders (Quick View) -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-serif text-xl text-taupe-dark italic">Recent Orders</h2>
            <a href="<?= BASE_URL ?>/seller_orders.php" class="text-xs text-taupe-mid hover:text-taupe-dark no-underline transition-colors">View All →</a>
        </div>
        <div class="bg-white rounded-xl border border-taupe-light/30 overflow-hidden">
            <?php if (empty($sellerOrders)): ?>
            <div class="p-8 text-center text-taupe-mid text-sm">No orders yet</div>
            <?php else: ?>
            <div class="divide-y divide-taupe-light/20">
                <?php foreach (array_slice($sellerOrders, 0, 5) as $order): ?>
                <a href="<?= BASE_URL ?>/seller_orders.php?id=<?= $order['id'] ?>" class="flex items-center justify-between px-4 py-3 hover:bg-taupe-cream/10 transition-colors no-underline">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-taupe-cream/30 flex items-center justify-center text-xs font-bold text-taupe-dark">#<?= $order['id'] ?></div>
                        <div>
                            <p class="text-sm text-taupe-dark font-medium"><?= e($order['buyer_name'] ?? 'N/A') ?></p>
                            <p class="text-[10px] text-taupe-mid"><?= date('d M, H:i', strtotime($order['created_at'])) ?></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-taupe-dark"><?= formatRupiah($order['total_amount']) ?></p>
                        <?php
                        $badgeColors = [
                            'pending'   => 'bg-taupe-cream/50 text-taupe-dark',
                            'confirmed' => 'bg-taupe-cream/30 text-taupe-dark',
                            'shipped'   => 'bg-taupe-light/30 text-taupe-dark',
                            'delivered' => 'bg-taupe-dark/10 text-taupe-dark',
                            'cancelled' => 'bg-taupe-light/20 text-taupe-mid',
                        ];
                        ?>
                        <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold uppercase <?= $badgeColors[$order['status']] ?? '' ?>"><?= e($order['status']) ?></span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Low Stock Alerts + Quick Product List -->
    <div>
        <?php if (!empty($lowStockProducts)): ?>
        <div class="mb-6">
            <h2 class="font-serif text-xl text-taupe-dark italic mb-4">Low Stock Alerts</h2>
            <div class="space-y-2">
                <?php foreach ($lowStockProducts as $prod): ?>
                <div class="bg-taupe-cream/20 border border-taupe-light/40 rounded-lg px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-taupe-cream/30 overflow-hidden shrink-0">
                            <img src="<?= BASE_URL ?>/assets/images/<?= e($prod['image']) ?>" class="w-full h-full object-cover" onerror="this.src='<?= BASE_URL ?>/assets/images/default.jpg'">
                        </div>
                        <span class="text-sm text-taupe-dark font-medium truncate max-w-[180px]"><?= e($prod['name']) ?></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-taupe-dark"><?= $prod['stock'] ?> left</span>
                        <a href="<?= BASE_URL ?>/seller_products.php?action=edit&id=<?= $prod['id'] ?>" class="text-xs text-taupe-dark hover:underline no-underline">Restock →</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="flex items-center justify-between mb-4">
            <h2 class="font-serif text-xl text-taupe-dark italic">My Products</h2>
            <a href="<?= BASE_URL ?>/seller_products.php" class="text-xs text-taupe-mid hover:text-taupe-dark no-underline transition-colors">Manage →</a>
        </div>
        <div class="space-y-2">
            <?php foreach (array_slice($sellerProducts, 0, 5) as $prod): ?>
            <div class="bg-white rounded-xl border border-taupe-light/30 px-4 py-3 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg overflow-hidden bg-taupe-cream/20 shrink-0">
                    <img src="<?= BASE_URL ?>/assets/images/<?= e($prod['image']) ?>" alt="<?= e($prod['name']) ?>"
                         class="w-full h-full object-cover" onerror="this.src='<?= BASE_URL ?>/assets/images/default.jpg'">
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-medium text-taupe-dark truncate"><?= e($prod['name']) ?></h3>
                    <p class="text-[10px] text-taupe-mid"><?= e($prod['category_name'] ?? '') ?> • <?= $prod['stock'] ?> in stock</p>
                </div>
                <span class="text-sm font-medium text-taupe-dark shrink-0"><?= formatRupiah($prod['price']) ?></span>
            </div>
            <?php endforeach; ?>
            <?php if (empty($sellerProducts)): ?>
            <div class="text-center py-6 text-taupe-mid text-sm">No products yet</div>
            <?php endif; ?>
        </div>
    </div>
</div>
