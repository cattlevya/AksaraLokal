<?php

?>
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="font-serif text-3xl text-taupe-dark italic">Product Approvals</h1>
        <p class="text-taupe-mid text-sm mt-1">Review seller products and manage public visibility.</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-taupe-light/30 shadow-sm overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-taupe-cream/30 text-taupe-dark text-xs uppercase tracking-wider">
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Item</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Category</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Seller</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Price/Stock</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Status</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-taupe-light/20">
                <?php foreach ($products as $p): ?>
                    <tr class="hover:bg-off-white transition-colors group">
                        
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded overflow-hidden shrink-0 border border-taupe-light/20">
                                    <img src="<?= BASE_URL ?>/assets/images/<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-taupe-dark font-medium line-clamp-1"><?= e($p['name']) ?></p>
                                    <p class="text-taupe-mid text-[10px] font-mono mt-0.5">#<?= $p['id'] ?></p>
                                </div>
                            </div>
                        </td>
                        
                        <td class="py-4 px-6 text-taupe-mid"><?= e($p['category_name']) ?></td>
                        
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-taupe-cream/20 text-taupe-dark text-xs font-medium border border-taupe-cream/50">
                                <svg class="w-3.5 h-3.5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <?= e($p['seller_name']) ?>
                            </span>
                        </td>
                        
                        <td class="py-4 px-6">
                            <p class="text-taupe-dark font-medium"><?= formatRupiah($p['price']) ?></p>
                            <p class="text-xs mt-0.5 <?= $p['stock'] <= 5 ? 'text-taupe-dark font-bold' : 'text-taupe-mid' ?>">Stock: <?= $p['stock'] ?></p>
                        </td>
                        
                        <td class="py-4 px-6">
                            <?php if ($p['is_active']): ?>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-widest bg-taupe-dark text-off-white border border-taupe-dark">Active</span>
                            <?php else: ?>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-widest bg-taupe-light/50 text-taupe-dark border border-taupe-light">Inactive</span>
                            <?php endif; ?>
                        </td>
                        
                        <td class="py-4 px-6 text-right">
                            <form action="<?= BASE_URL ?>/admin_products.php" method="POST" class="inline">
                                <?= csrfField() ?>
                                <input type="hidden" name="action" value="toggle_status">
                                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                
                                <button type="submit" class="text-xs font-medium px-3 py-1.5 border rounded transition-colors <?= $p['is_active'] ? 'border-taupe-light text-taupe-mid hover:bg-taupe-cream/50' : 'border-taupe-mid text-taupe-dark hover:bg-taupe-cream/50' ?>">
                                    <?= $p['is_active'] ? 'Deactivate' : 'Activate' ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($products)): ?>
                    <tr><td colspan="6" class="py-8 text-center text-taupe-mid text-sm">No products found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    
    <?php if ($totalPages > 1): ?>
    <div class="px-6 py-4 border-t border-taupe-light/30 bg-off-white flex justify-between items-center">
        <span class="text-xs text-taupe-mid uppercase tracking-wide">
            Page <?= $page ?> of <?= $totalPages ?>
        </span>
        <div class="flex items-center gap-2">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="px-3 py-1.5 text-xs font-medium bg-white border border-taupe-light rounded text-taupe-dark hover:bg-taupe-cream/30 transition-colors no-underline">Prev</a>
            <?php else: ?>
                <button disabled class="px-3 py-1.5 text-xs font-medium bg-off-white border border-taupe-light/50 rounded text-taupe-mid/50 cursor-not-allowed">Prev</button>
            <?php endif; ?>
            
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>" class="px-3 py-1.5 text-xs font-medium bg-white border border-taupe-light rounded text-taupe-dark hover:bg-taupe-cream/30 transition-colors no-underline">Next</a>
            <?php else: ?>
                <button disabled class="px-3 py-1.5 text-xs font-medium bg-off-white border border-taupe-light/50 rounded text-taupe-mid/50 cursor-not-allowed">Next</button>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
