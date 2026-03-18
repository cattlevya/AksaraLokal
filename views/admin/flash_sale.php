<?php

?>
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="font-serif text-3xl text-taupe-dark italic">Promo Center</h1>
        <p class="text-taupe-mid text-sm mt-1">Manage platform-wide discounts and promotions.</p>
    </div>
    
    
    <button type="button" onclick="openFsModal()" class="bg-taupe-dark hover:bg-[#7a6a58] text-off-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm w-40 text-center">
        + Add Flash Sale
    </button>
</div>

<div class="flex gap-8 mb-6 border-b border-taupe-light/30 px-1">
    <a href="<?= BASE_URL ?>/admin_vouchers.php" class="text-sm tracking-wide text-taupe-mid hover:text-taupe-dark transition-colors pb-3 no-underline">Vouchers</a>
    <a href="<?= BASE_URL ?>/admin_flash_sale.php" class="text-sm tracking-wide text-taupe-dark font-medium border-b-2 border-taupe-dark pb-3 -mb-[1px] no-underline">Flash Sale</a>
</div>

<div class="bg-white rounded-xl border border-taupe-light/30 shadow-sm overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-taupe-cream/30 text-taupe-dark text-xs uppercase tracking-wider">
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Product</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Seller</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Prices (Normal ➔ Flash)</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Ends At</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-taupe-light/20">
                <?php foreach ($flashSales as $fs): ?>
                    <tr class="hover:bg-off-white transition-colors group">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded overflow-hidden shrink-0 border border-taupe-light/20">
                                    <img src="<?= BASE_URL ?>/assets/images/<?= e($fs['image']) ?>" alt="<?= e($fs['name']) ?>" class="w-full h-full object-cover">
                                </div>
                                <p class="text-taupe-dark font-medium line-clamp-1"><?= e($fs['name']) ?></p>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-taupe-cream/20 text-taupe-dark text-xs font-medium border border-taupe-cream/50">
                                <svg class="w-3.5 h-3.5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <?= e($fs['seller_name']) ?>
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="line-through text-taupe-mid/60 text-xs block"><?= formatRupiah($fs['price']) ?></span>
                            <span class="text-taupe-dark font-bold block"><?= formatRupiah($fs['flash_sale_price']) ?></span>
                        </td>
                        <td class="py-4 px-6 text-taupe-dark font-mono text-xs">
                            <?= date('d M Y, H:i:s', strtotime($fs['flash_sale_end'])) ?>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <form action="<?= BASE_URL ?>/admin_flash_sale.php" method="POST" class="inline" onsubmit="return confirm('Remove flash sale from this product?')">
                                    <?= csrfField() ?>
                                    <input type="hidden" name="action" value="remove_flash_sale">
                                    <input type="hidden" name="product_id" value="<?= $fs['id'] ?>">
                                    <button type="submit" class="p-1.5 text-taupe-mid hover:text-taupe-dark hover:bg-taupe-cream/50 rounded transition-colors" title="Remove Flash Sale">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($flashSales)): ?>
                    <tr><td colspan="5" class="py-8 text-center text-taupe-mid text-sm">No active flash sales right now.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="fsModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform" id="fsModalInner">
        <form action="<?= BASE_URL ?>/admin_flash_sale.php" method="POST">
            <?= csrfField() ?>
            <input type="hidden" name="action" value="set_flash_sale">
            
            <div class="px-6 py-4 border-b border-taupe-light/30 flex justify-between items-center bg-off-white">
                <h3 class="font-serif text-lg text-taupe-dark">Add Flash Sale to Product</h3>
                <button type="button" onclick="closeFsModal()" class="text-taupe-mid hover:text-taupe-dark">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-4">
                <div>
                    <label for="product_id" class="block text-xs font-medium text-taupe-dark mb-1 uppercase tracking-wider">Select Product</label>
                    <select id="product_id" name="product_id" required onchange="updatePriceHint()"
                            class="w-full px-4 py-2.5 rounded-lg border border-taupe-light text-sm text-taupe-dark focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/50">
                        <option value="">-- Choose a product --</option>
                        <?php foreach ($allProducts as $p): ?>
                            <option value="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>">
                                <?= e($p['name']) ?> (Seller: <?= e($p['seller_name']) ?>) — Normal: <?= formatRupiah($p['price']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="flash_sale_price" class="block text-xs font-medium text-taupe-dark mb-1 uppercase tracking-wider">Flash Sale Price (Rp)</label>
                    <input type="number" id="flash_sale_price" name="flash_sale_price" required min="1"
                           class="w-full px-4 py-2.5 rounded-lg border border-taupe-light text-sm text-taupe-dark focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/50">
                    <p id="priceHint" class="text-[10px] text-taupe-mid mt-1 italic"></p>
                </div>
                
                <div>
                    <label for="flash_sale_end" class="block text-xs font-medium text-taupe-dark mb-1 uppercase tracking-wider">Ends At</label>
                    <input type="datetime-local" id="flash_sale_end" name="flash_sale_end" required
                           class="w-full px-4 py-2.5 rounded-lg border border-taupe-light text-sm text-taupe-dark focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/50">
                </div>
            </div>
            
            <div class="px-6 py-4 bg-taupe-cream/10 border-t border-taupe-light/30 flex justify-end gap-3">
                <button type="button" onclick="closeFsModal()" class="px-4 py-2 text-sm font-medium text-taupe-mid hover:text-taupe-dark transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-taupe-dark text-off-white rounded-lg text-sm font-medium hover:bg-[#7a6a58] transition-colors">Save Flash Sale</button>
            </div>
        </form>
    </div>
</div>

<?php
$pageScripts = <<<'JS'
<script>
    const modal = document.getElementById('fsModal');
    const inner = document.getElementById('fsModalInner');
    const select = document.getElementById('product_id');
    const hint = document.getElementById('priceHint');
    
    function openFsModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            inner.classList.remove('scale-95');
            inner.classList.add('scale-100');
        }, 10);
    }
    
    function closeFsModal() {
        inner.classList.remove('scale-100');
        inner.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }
    
    function updatePriceHint() {
        const option = select.options[select.selectedIndex];
        if (option && option.value) {
            const price = parseInt(option.getAttribute('data-price'));
            hint.textContent = `Must be strictly lower than normal price (Rp ${price.toLocaleString('id-ID')})`;
            document.getElementById('flash_sale_price').max = price - 1;
        } else {
            hint.textContent = '';
            document.getElementById('flash_sale_price').max = '';
        }
    }
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeFsModal();
    });
</script>
JS;
?>
