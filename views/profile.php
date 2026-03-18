<?php
/**
 * Profile View
 * Variables: $userData, $userOrders
 */
?>
<section class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="font-serif text-3xl text-taupe-dark italic mb-8">My Profile</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Profile Card -->
        <div class="bg-white rounded-xl border border-taupe-light/30 p-6 text-center">
            <div class="w-20 h-20 bg-taupe-light rounded-full mx-auto flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-taupe-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                </svg>
            </div>
            <h2 class="font-serif text-xl text-taupe-dark italic"><?= e($userData['username']) ?></h2>
            <p class="text-xs text-taupe-mid uppercase tracking-wider mt-1 mb-3"><?= e($userData['role']) ?></p>
            <div class="text-left text-sm space-y-2 border-t border-taupe-light/30 pt-4">
                <p class="text-taupe-mid flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                    <?= e($userData['email']) ?>
                </p>
                <p class="text-taupe-mid flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                    <?= e($userData['phone'] ?? 'Not set') ?>
                </p>
                <p class="text-taupe-mid flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                    <?= e($userData['address'] ?? 'Not set') ?>
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="mt-5 pt-4 border-t border-taupe-light/30 space-y-2">
                <?php if ($userData['role'] === 'admin'): ?>
                <a href="<?= BASE_URL ?>/admin_dashboard.php" class="flex items-center justify-center w-full py-2.5 rounded-lg bg-taupe-dark text-off-white text-sm font-medium hover:bg-[#7a6a58] transition-colors no-underline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Admin Dashboard
                </a>
                <?php endif; ?>
                <?php if ($userData['role'] === 'seller'): ?>
                <a href="<?= BASE_URL ?>/seller_dashboard.php" class="flex items-center justify-center w-full py-2.5 rounded-lg bg-taupe-cream/40 text-taupe-dark text-sm font-medium hover:bg-taupe-cream/70 transition-colors no-underline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Seller Dashboard
                </a>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>/logout.php" class="block w-full py-2.5 rounded-lg bg-taupe-dark text-off-white text-sm font-medium hover:bg-[#7a6a58] transition-colors no-underline">
                    Logout / Ganti Akun
                </a>
            </div>
        </div>

        <!-- Order History -->
        <div class="md:col-span-2">
            <h2 class="font-serif text-xl text-taupe-dark italic mb-4">Order History</h2>
            <?php if (empty($userOrders)): ?>
            <div class="text-center py-12 bg-white rounded-xl border border-taupe-light/30">
                <i class="fa-solid fa-receipt text-3xl text-taupe-light mb-3"></i>
                <p class="text-taupe-mid text-sm">No orders yet.</p>
                <a href="<?= BASE_URL ?>/products.php" class="inline-block mt-3 text-sm text-taupe-dark hover:underline">Start Shopping →</a>
            </div>
            <?php else: ?>
            <div class="space-y-3">
                <?php foreach ($userOrders as $order): ?>
                <div class="bg-white rounded-xl border border-taupe-light/30 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-taupe-dark">Order #<?= $order['id'] ?></span>
                        <?php
                        $sc = [
                            'pending'   => 'bg-taupe-cream/50 text-taupe-dark',
                            'confirmed' => 'bg-taupe-light/40 text-taupe-dark',
                            'shipped'   => 'bg-taupe-mid/20 text-taupe-dark',
                            'delivered' => 'bg-taupe-dark/10 text-taupe-dark font-bold',
                            'cancelled' => 'bg-taupe-cream/30 text-taupe-mid line-through',
                        ];
                        ?>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase <?= $sc[$order['status']] ?? '' ?>">
                            <?= e($order['status']) ?>
                        </span>
                    </div>
                    <p class="text-xs text-taupe-mid"><?= e($order['product_names'] ?? '') ?></p>
                    <div class="flex items-center justify-between mt-2 pt-2 border-t border-taupe-light/20">
                        <span class="text-xs text-taupe-mid"><?= date('d M Y', strtotime($order['created_at'])) ?></span>
                        <span class="text-sm font-medium text-taupe-dark"><?= formatRupiah($order['total_amount']) ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
