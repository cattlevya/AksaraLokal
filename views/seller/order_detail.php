<?php

$statusColors = [
    'pending'   => 'bg-taupe-cream/50 text-taupe-dark border-taupe-light',
    'confirmed' => 'bg-taupe-cream/30 text-taupe-dark border-taupe-light/50',
    'shipped'   => 'bg-taupe-light/30 text-taupe-dark border-taupe-light/50',
    'delivered' => 'bg-taupe-dark/10 text-taupe-dark border-taupe-dark/20',
    'cancelled' => 'bg-taupe-light/20 text-taupe-mid border-taupe-light/30',
];
$statusIcons = [
    'pending'   => '<svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>',
    'confirmed' => '<svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>',
    'shipped'   => '<svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>',
    'delivered' => '<svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>',
    'cancelled' => '<svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>',
];
?>

<div class="mb-6">
    <a href="<?= BASE_URL ?>/seller_orders.php" class="text-sm text-taupe-mid hover:text-taupe-dark transition-colors no-underline inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
        Back to Orders
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="lg:col-span-2 space-y-6">
        
        <div class="bg-white rounded-xl border border-taupe-light/30 p-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h1 class="font-serif text-2xl text-taupe-dark">Order #<?= $order['id'] ?></h1>
                    <p class="text-sm text-taupe-mid mt-1"><?= date('d F Y, H:i WIB', strtotime($order['created_at'])) ?></p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase border <?= $statusColors[$order['status']] ?? '' ?>">
                    <?= $statusIcons[$order['status']] ?? '' ?> <?= e(ucfirst($order['status'])) ?>
                </span>
            </div>

            
            <div class="bg-taupe-cream/15 rounded-lg p-4">
                <h3 class="text-xs font-medium text-taupe-dark uppercase tracking-wider mb-2">Customer Details</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div>
                        <span class="text-taupe-mid">Name:</span>
                        <span class="text-taupe-dark font-medium ml-1"><?= e($order['buyer_name']) ?></span>
                    </div>
                    <div>
                        <span class="text-taupe-mid">Email:</span>
                        <span class="text-taupe-dark ml-1"><?= e($order['buyer_email'] ?? '—') ?></span>
                    </div>
                    <div>
                        <span class="text-taupe-mid">Phone:</span>
                        <span class="text-taupe-dark ml-1"><?= e($order['buyer_phone'] ?? '—') ?></span>
                    </div>
                    <div>
                        <span class="text-taupe-mid">Address:</span>
                        <span class="text-taupe-dark ml-1"><?= e($order['buyer_address'] ?? '—') ?></span>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-xl border border-taupe-light/30 p-6">
            <h3 class="text-xs font-medium text-taupe-dark uppercase tracking-wider mb-4">Ordered Items</h3>
            <div class="space-y-4">
                <?php $itemsTotal = 0; foreach ($order['items'] as $item): ?>
                <?php $lineTotal = $item['unit_price'] * $item['quantity']; $itemsTotal += $lineTotal; ?>
                <div class="flex items-center gap-4 pb-4 border-b border-taupe-light/20 last:border-0 last:pb-0">
                    <div class="w-14 h-14 rounded-lg overflow-hidden bg-taupe-cream/20 shrink-0">
                        <img src="<?= BASE_URL ?>/assets/images/<?= e($item['product_image']) ?>" alt="<?= e($item['product_name']) ?>"
                             class="w-full h-full object-cover" onerror="this.src='<?= BASE_URL ?>/assets/images/default.jpg'">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-medium text-taupe-dark truncate"><?= e($item['product_name']) ?></h4>
                        <p class="text-xs text-taupe-mid"><?= $item['quantity'] ?> × <?= formatRupiah($item['unit_price']) ?></p>
                    </div>
                    <span class="text-sm font-medium text-taupe-dark shrink-0"><?= formatRupiah($lineTotal) ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-4 pt-4 border-t border-taupe-light/30 flex justify-between text-sm">
                <span class="text-taupe-mid">Items Subtotal</span>
                <span class="text-taupe-dark font-bold text-lg"><?= formatRupiah($itemsTotal) ?></span>
            </div>
            <div class="flex justify-between text-sm mt-1">
                <span class="text-taupe-mid">Order Total (incl. shipping & tax)</span>
                <span class="text-taupe-dark font-bold text-lg"><?= formatRupiah($order['total_amount']) ?></span>
            </div>
        </div>
    </div>

    
    <div class="space-y-6">
        
        <div class="bg-white rounded-xl border border-taupe-light/30 p-6">
            <h3 class="text-xs font-medium text-taupe-dark uppercase tracking-wider mb-4">Payment Proof</h3>

            <?php if ($order['payment_proof']): ?>
            <div class="rounded-lg overflow-hidden border border-taupe-light/30 mb-3 cursor-pointer" onclick="document.getElementById('proof-modal').classList.remove('hidden')">
                <img src="<?= BASE_URL ?>/assets/uploads/<?= e($order['payment_proof']) ?>" alt="Payment Proof"
                     class="w-full h-auto object-contain max-h-[300px] bg-gray-50"
                     onerror="this.parentElement.innerHTML='<div class=\'p-6 text-center text-sm text-taupe-mid\'>Image not found</div>'">
            </div>
            <p class="text-[10px] text-taupe-mid text-center">Click image to enlarge</p>

            
            <div id="proof-modal" class="hidden fixed inset-0 z-[100] bg-black/80 flex items-center justify-center p-4" onclick="this.classList.add('hidden')">
                <div class="max-w-3xl max-h-[90vh] overflow-auto">
                    <img src="<?= BASE_URL ?>/assets/uploads/<?= e($order['payment_proof']) ?>" alt="Payment Proof Full" class="max-w-full h-auto rounded-lg">
                </div>
                <button class="absolute top-4 right-4 text-white text-2xl hover:text-taupe-cream" onclick="document.getElementById('proof-modal').classList.add('hidden')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                </button>
            </div>
            <?php else: ?>
            <div class="bg-taupe-cream/15 rounded-lg p-6 text-center">
                <svg class="w-8 h-8 mx-auto text-taupe-light mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                <p class="text-sm text-taupe-mid">No payment proof uploaded</p>
                <p class="text-[10px] text-taupe-mid/60 mt-1">Buyer has not submitted proof yet</p>
            </div>
            <?php endif; ?>
        </div>

        
        <div class="bg-white rounded-xl border border-taupe-light/30 p-6">
            <h3 class="text-xs font-medium text-taupe-dark uppercase tracking-wider mb-4">Actions</h3>

            <?php if ($order['status'] === 'pending'): ?>
                <div class="space-y-3">
                    <form method="POST" action="<?= BASE_URL ?>/seller_orders.php">
                        <?= csrfField() ?>
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <input type="hidden" name="return_detail" value="1">
                        <button name="confirm_payment" class="w-full py-2.5 rounded-lg bg-taupe-dark text-off-white text-sm font-medium hover:bg-[#7a6a58] transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                            Accept Payment
                        </button>
                    </form>
                    <form method="POST" action="<?= BASE_URL ?>/seller_orders.php" onsubmit="return confirm('Reject this payment? The order will be cancelled.')">
                        <?= csrfField() ?>
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <input type="hidden" name="return_detail" value="1">
                        <button name="reject_payment" class="w-full py-2.5 rounded-lg border border-taupe-light text-taupe-mid text-sm font-medium hover:bg-taupe-cream/20 hover:text-taupe-dark transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                            Reject Payment
                        </button>
                    </form>
                </div>

            <?php elseif ($order['status'] === 'confirmed'): ?>
                <form method="POST" action="<?= BASE_URL ?>/seller_orders.php">
                    <?= csrfField() ?>
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    <input type="hidden" name="return_detail" value="1">
                    <button name="ship_order" class="w-full py-2.5 rounded-lg bg-taupe-dark text-off-white text-sm font-medium hover:bg-[#7a6a58] transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                        Mark as Shipped
                    </button>
                </form>

            <?php else: ?>
                <p class="text-sm text-taupe-mid text-center py-3">
                    <?php if ($order['status'] === 'shipped'): ?>
                        This order has been shipped. Waiting for delivery confirmation.
                    <?php elseif ($order['status'] === 'delivered'): ?>
                        This order has been delivered successfully.
                    <?php elseif ($order['status'] === 'cancelled'): ?>
                        This order has been cancelled.
                    <?php endif; ?>
                </p>
            <?php endif; ?>
        </div>

        
        <div class="bg-white rounded-xl border border-taupe-light/30 p-6">
            <h3 class="text-xs font-medium text-taupe-dark uppercase tracking-wider mb-4">Status Timeline</h3>
            <div class="space-y-3">
                <?php
                $steps = [
                    'pending'   => ['label' => 'Order Placed', 'icon' => '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>'],
                    'confirmed' => ['label' => 'Payment Verified', 'icon' => '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>'],
                    'shipped'   => ['label' => 'Shipped', 'icon' => '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>'],
                    'delivered' => ['label' => 'Delivered', 'icon' => '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>'],
                ];
                $orderStatusIndex = array_search($order['status'], array_keys($steps));
                if ($order['status'] === 'cancelled') $orderStatusIndex = -1;
                $i = 0;
                foreach ($steps as $key => $step):
                    $isActive = $i <= $orderStatusIndex;
                ?>
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs shrink-0 <?= $isActive ? 'bg-taupe-dark text-white' : 'bg-taupe-cream/30 text-taupe-mid' ?>">
                        <?= $isActive ? $step['icon'] : ($i + 1) ?>
                    </div>
                    <span class="text-sm <?= $isActive ? 'text-taupe-dark font-medium' : 'text-taupe-mid' ?>"><?= $step['label'] ?></span>
                </div>
                <?php if ($i < count($steps) - 1): ?>
                <div class="ml-3.5 w-px h-3 <?= $isActive && $i < $orderStatusIndex ? 'bg-taupe-dark' : 'bg-taupe-light/30' ?>"></div>
                <?php endif; ?>
                <?php $i++; endforeach; ?>

                <?php if ($order['status'] === 'cancelled'): ?>
                <div class="flex items-center gap-3 mt-2">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs shrink-0 bg-taupe-light/30 text-taupe-mid">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                    </div>
                    <span class="text-sm text-taupe-mid font-medium">Cancelled</span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
