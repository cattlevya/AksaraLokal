<?php
/**
 * Seller Orders List View
 * Variables: $sellerOrders, $statusFilter, $statusCounts
 */
$statusColors = [
    'pending'   => 'bg-taupe-cream/50 text-taupe-dark',
    'confirmed' => 'bg-taupe-cream/30 text-taupe-dark',
    'shipped'   => 'bg-taupe-light/30 text-taupe-dark',
    'delivered' => 'bg-taupe-dark/10 text-taupe-dark',
    'cancelled' => 'bg-taupe-light/20 text-taupe-mid',
];
?>
<div class="mb-6">
    <h1 class="font-serif text-2xl text-taupe-dark italic">Order Management</h1>
    <p class="text-sm text-taupe-mid mt-1">Review and process your incoming orders</p>
</div>

<!-- Status Filter Tabs -->
<div class="flex items-center gap-1 mb-6 overflow-x-auto hide-scrollbar border-b border-taupe-light/20">
    <a href="<?= BASE_URL ?>/seller_orders.php" 
       class="px-4 py-2.5 text-xs font-medium tracking-wider uppercase no-underline border-b-2 transition-colors <?= !$statusFilter ? 'border-taupe-dark text-taupe-dark' : 'border-transparent text-taupe-mid hover:text-taupe-dark' ?>">
        All <span class="ml-1 px-1.5 py-0.5 rounded-full bg-taupe-cream/50 text-[10px]"><?= $statusCounts['all'] ?></span>
    </a>
    <?php foreach (['pending' => 'Pending', 'confirmed' => 'Confirmed', 'shipped' => 'Shipped', 'delivered' => 'Delivered'] as $key => $label): ?>
    <a href="<?= BASE_URL ?>/seller_orders.php?status=<?= $key ?>" 
       class="px-4 py-2.5 text-xs font-medium tracking-wider uppercase no-underline border-b-2 transition-colors <?= $statusFilter === $key ? 'border-taupe-dark text-taupe-dark' : 'border-transparent text-taupe-mid hover:text-taupe-dark' ?>">
        <?= $label ?> 
        <?php if ($statusCounts[$key] > 0): ?>
        <span class="ml-1 px-1.5 py-0.5 rounded-full bg-taupe-cream/50 text-[10px]"><?= $statusCounts[$key] ?></span>
        <?php endif; ?>
    </a>
    <?php endforeach; ?>
</div>

<?php if (empty($sellerOrders)): ?>
<div class="bg-white rounded-xl border border-taupe-light/30 p-12 text-center">
    <svg class="w-12 h-12 mx-auto text-taupe-light mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
    <p class="text-taupe-mid">No <?= $statusFilter ? e($statusFilter) : '' ?> orders found</p>
</div>
<?php else: ?>

<div class="bg-white rounded-xl border border-taupe-light/30 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-taupe-cream/20 text-taupe-dark text-left">
            <tr>
                <th class="px-4 py-3 font-medium">Order #</th>
                <th class="px-4 py-3 font-medium">Date</th>
                <th class="px-4 py-3 font-medium">Buyer</th>
                <th class="px-4 py-3 font-medium hidden lg:table-cell">Products</th>
                <th class="px-4 py-3 font-medium">Amount</th>
                <th class="px-4 py-3 font-medium">Payment</th>
                <th class="px-4 py-3 font-medium">Status</th>
                <th class="px-4 py-3 font-medium text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-taupe-light/20">
            <?php foreach ($sellerOrders as $order): ?>
            <tr class="hover:bg-taupe-cream/10 transition-colors">
                <td class="px-4 py-3">
                    <a href="<?= BASE_URL ?>/seller_orders.php?id=<?= $order['id'] ?>" class="text-taupe-dark font-medium hover:underline no-underline">#<?= $order['id'] ?></a>
                </td>
                <td class="px-4 py-3 text-taupe-mid text-xs"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></td>
                <td class="px-4 py-3 text-taupe-dark"><?= e($order['buyer_name']) ?></td>
                <td class="px-4 py-3 text-taupe-mid text-xs hidden lg:table-cell max-w-[200px] truncate"><?= e($order['product_names'] ?? '—') ?></td>
                <td class="px-4 py-3 text-taupe-dark font-medium"><?= formatRupiah($order['total_amount']) ?></td>
                <td class="px-4 py-3">
                    <?php if ($order['payment_proof']): ?>
                    <span class="inline-flex items-center gap-1 text-taupe-dark text-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                        Uploaded
                    </span>
                    <?php else: ?>
                    <span class="text-xs text-taupe-mid/60">—</span>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase <?= $statusColors[$order['status']] ?? 'bg-gray-100 text-gray-700' ?>">
                        <?= e($order['status']) ?>
                    </span>
                </td>
                <td class="px-4 py-3 text-right">
                    <a href="<?= BASE_URL ?>/seller_orders.php?id=<?= $order['id'] ?>" class="text-xs text-taupe-dark font-medium hover:underline no-underline">View →</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
