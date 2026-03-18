<?php
/**
 * Seller Product List View
 * Variables: $sellerProducts
 */
?>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-serif text-2xl text-taupe-dark italic">My Products</h1>
        <p class="text-sm text-taupe-mid mt-1"><?= count($sellerProducts) ?> products in your catalog</p>
    </div>
    <a href="<?= BASE_URL ?>/seller_products.php?action=add" class="px-5 py-2.5 bg-taupe-dark text-off-white rounded-lg text-sm font-medium hover:bg-[#7a6a58] transition-colors no-underline flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
        Add Product
    </a>
</div>

<?php if (empty($sellerProducts)): ?>
<div class="bg-white rounded-xl border border-taupe-light/30 p-12 text-center">
    <svg class="w-12 h-12 mx-auto text-taupe-light mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
    <p class="text-taupe-mid mb-4">No products yet. Start building your catalog!</p>
    <a href="<?= BASE_URL ?>/seller_products.php?action=add" class="inline-block px-5 py-2.5 bg-taupe-dark text-off-white rounded-lg text-sm no-underline hover:bg-[#7a6a58] transition-colors">Add First Product</a>
</div>
<?php else: ?>

<div class="bg-white rounded-xl border border-taupe-light/30 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-taupe-cream/20 text-taupe-dark text-left">
            <tr>
                <th class="px-4 py-3 font-medium">Product</th>
                <th class="px-4 py-3 font-medium hidden md:table-cell">Category</th>
                <th class="px-4 py-3 font-medium">Price</th>
                <th class="px-4 py-3 font-medium">Stock</th>
                <th class="px-4 py-3 font-medium">Status</th>
                <th class="px-4 py-3 font-medium text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-taupe-light/20">
            <?php foreach ($sellerProducts as $prod): ?>
            <tr class="hover:bg-taupe-cream/10 transition-colors">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg overflow-hidden bg-taupe-cream/20 shrink-0">
                            <img src="<?= BASE_URL ?>/assets/images/<?= e($prod['image']) ?>" alt="<?= e($prod['name']) ?>"
                                 class="w-full h-full object-cover"
                                 onerror="this.src='<?= BASE_URL ?>/assets/images/default.jpg'">
                        </div>
                        <span class="font-medium text-taupe-dark truncate max-w-[200px]"><?= e($prod['name']) ?></span>
                    </div>
                </td>
                <td class="px-4 py-3 text-taupe-mid hidden md:table-cell"><?= e($prod['category_name'] ?? '—') ?></td>
                <td class="px-4 py-3 text-taupe-dark font-medium">
                    <?= formatRupiah($prod['price']) ?>
                    <?php 
                    $hasActiveFlash = !empty($prod['flash_sale_price']) && !empty($prod['flash_sale_end']) && strtotime($prod['flash_sale_end']) > time();
                    $hasExpiredFlash = !empty($prod['flash_sale_price']) && !empty($prod['flash_sale_end']) && strtotime($prod['flash_sale_end']) <= time();
                    ?>
                    <?php if ($hasActiveFlash): ?>
                    <span class="block text-[10px] mt-0.5">
                        <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded-full bg-taupe-cream/40 text-taupe-dark font-semibold">
                            <?= formatRupiah($prod['flash_sale_price']) ?>
                        </span>
                    </span>
                    <?php elseif ($hasExpiredFlash): ?>
                    <span class="block text-[10px] mt-0.5 text-taupe-light">Flash expired</span>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3">
                    <span class="<?= $prod['stock'] <= 5 ? 'text-taupe-dark font-semibold' : 'text-taupe-dark' ?>"><?= $prod['stock'] ?></span>
                    <?php if ($prod['stock'] <= 5): ?>
                    <span class="text-[10px] text-taupe-mid block">Low stock!</span>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3">
                    <?php if ($prod['is_active']): ?>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase bg-taupe-cream/40 text-taupe-dark">
                        <span class="w-1.5 h-1.5 rounded-full bg-taupe-dark"></span> Active
                    </span>
                    <?php else: ?>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase bg-taupe-light/20 text-taupe-mid">
                        <span class="w-1.5 h-1.5 rounded-full bg-taupe-light"></span> Inactive
                    </span>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center justify-end gap-2">
                        <a href="<?= BASE_URL ?>/seller_products.php?action=edit&id=<?= $prod['id'] ?>" class="p-1.5 rounded-lg hover:bg-taupe-cream/30 transition-colors text-taupe-mid hover:text-taupe-dark no-underline" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                        </a>
                        <form method="POST" action="<?= BASE_URL ?>/seller_products.php" class="inline">
                            <?= csrfField() ?>
                            <input type="hidden" name="action" value="toggle">
                            <input type="hidden" name="product_id" value="<?= $prod['id'] ?>">
                            <button type="submit" class="p-1.5 rounded-lg hover:bg-taupe-cream/30 transition-colors text-taupe-mid hover:text-taupe-dark" title="<?= $prod['is_active'] ? 'Deactivate' : 'Activate' ?>">
                                <?php if ($prod['is_active']): ?>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878l4.242 4.242M21 21l-3.122-3.122" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                                <?php else: ?>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                                <?php endif; ?>
                            </button>
                        </form>
                        <form method="POST" action="<?= BASE_URL ?>/seller_products.php" class="inline" onsubmit="return confirm('Delete this product permanently?')">
                            <?= csrfField() ?>
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="product_id" value="<?= $prod['id'] ?>">
                            <button type="submit" class="p-1.5 rounded-lg hover:bg-taupe-cream/30 transition-colors text-taupe-mid hover:text-taupe-dark" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
