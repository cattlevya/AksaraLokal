<?php
/**
 * Cart View
 * Variables: $cartItems, $subtotal
 */
?>
<section class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="font-serif text-3xl text-taupe-dark italic mb-2">Your Cart</h1>
    <p class="text-sm text-taupe-mid mb-8"><?= count($cartItems) ?> items in your bag</p>

    <?php if (empty($cartItems)): ?>
    <div class="text-center py-20">
        <i class="fa-solid fa-bag-shopping text-5xl text-taupe-light mb-4"></i>
        <p class="text-taupe-mid mb-4">Your cart is empty</p>
        <a href="<?= BASE_URL ?>/products.php" class="inline-block px-6 py-2.5 bg-taupe-dark text-off-white rounded-lg text-sm hover:bg-[#7a6a58] transition-colors">
            Continue Shopping
        </a>
    </div>
    <?php else: ?>

    <div class="space-y-6">
        <?php foreach ($cartItems as $item): ?>
        <div class="flex items-start gap-4 pb-6 border-b border-taupe-light/30" id="cart-item-<?= $item['product_id'] ?>">
            <!-- Image -->
            <div class="w-20 h-20 rounded-lg overflow-hidden bg-warm-gray shrink-0">
                <img src="<?= BASE_URL ?>/assets/images/<?= e($item['image']) ?>" alt="<?= e($item['name']) ?>"
                     class="w-full h-full object-cover"
                     onerror="this.src='<?= BASE_URL ?>/assets/images/default.jpg'">
            </div>

            <!-- Info -->
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between">
                    <h3 class="font-serif italic text-taupe-dark text-base"><?= e($item['name']) ?></h3>
                    <span class="text-taupe-dark font-medium text-sm ml-4 shrink-0"><?= formatRupiah($item['price']) ?></span>
                </div>

                <div class="flex items-center justify-between mt-3">
                    <!-- Qty controls -->
                    <div class="flex items-center gap-2">
                        <button onclick="updateCartQty(<?= $item['product_id'] ?>, <?= $item['quantity'] - 1 ?>)" 
                                class="w-8 h-8 rounded-md border border-taupe-light text-taupe-dark flex items-center justify-center hover:bg-warm-gray transition-colors text-sm">−</button>
                        <span class="w-8 text-center text-sm text-taupe-dark font-medium"><?= $item['quantity'] ?></span>
                        <button onclick="updateCartQty(<?= $item['product_id'] ?>, <?= $item['quantity'] + 1 ?>)" 
                                class="w-8 h-8 rounded-md border border-taupe-light text-taupe-dark flex items-center justify-center hover:bg-warm-gray transition-colors text-sm">+</button>
                    </div>
                    <!-- Remove -->
                    <button onclick="removeCartItem(<?= $item['product_id'] ?>)" class="text-xs text-taupe-mid hover:text-red-500 transition-colors">Remove</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Subtotal & Checkout -->
    <div class="mt-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <p class="text-taupe-mid text-sm">
            Subtotal: <span class="text-xl font-semibold text-taupe-dark"><?= formatRupiah($subtotal) ?></span>
        </p>
        <div class="flex gap-3">
            <a href="<?= BASE_URL ?>/products.php" class="px-5 py-2.5 border border-taupe-light rounded-lg text-sm text-taupe-mid hover:border-taupe-dark hover:text-taupe-dark transition-all">
                Continue Shopping
            </a>
            <a href="<?= BASE_URL ?>/checkout.php" class="px-6 py-2.5 bg-taupe-dark text-off-white rounded-lg text-sm font-medium hover:bg-[#7a6a58] transition-colors">
                Proceed to Checkout
            </a>
        </div>
    </div>
    <?php endif; ?>
</section>

<?php
$baseUrl = BASE_URL;
$pageScripts = <<<JS
<script>
function updateCartQty(productId, newQty) {
    fetch('{$baseUrl}/cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'action=update&product_id=' + productId + '&quantity=' + newQty
    })
    .then(r => r.json())
    .then(data => { if (data.success) location.reload(); })
    .catch(() => alert('Error updating cart'));
}

function removeCartItem(productId) {
    fetch('{$baseUrl}/cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'action=remove&product_id=' + productId
    })
    .then(r => r.json())
    .then(data => { if (data.success) location.reload(); })
    .catch(() => alert('Error removing item'));
}
</script>
JS;
?>
