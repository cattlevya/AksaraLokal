<?php

?>
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="font-serif text-3xl text-taupe-dark italic">Promo Center</h1>
        <p class="text-taupe-mid text-sm mt-1">Manage platform-wide discounts and promotions.</p>
    </div>
    
    
    <button type="button" onclick="openVoucherModal('create')" class="bg-taupe-dark hover:bg-[#7a6a58] text-off-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm w-40 text-center">
        + New Voucher
    </button>
</div>

<div class="flex gap-8 mb-6 border-b border-taupe-light/30 px-1">
    <a href="<?= BASE_URL ?>/admin_vouchers.php" class="text-sm tracking-wide text-taupe-dark font-medium border-b-2 border-taupe-dark pb-3 -mb-[1px] no-underline">Vouchers</a>
    <a href="<?= BASE_URL ?>/admin_flash_sale.php" class="text-sm tracking-wide text-taupe-mid hover:text-taupe-dark transition-colors pb-3 no-underline">Flash Sale</a>
</div>

<div class="bg-white rounded-xl border border-taupe-light/30 shadow-sm overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-taupe-cream/30 text-taupe-dark text-xs uppercase tracking-wider">
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30 w-16">ID</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Code</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Discount</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Usage (Used/Max)</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Expired At</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-taupe-light/20">
                <?php foreach ($vouchers as $v): ?>
                    <?php $isExpired = strtotime($v['expired_at']) < time(); ?>
                    <tr class="hover:bg-off-white transition-colors group <?= $isExpired ? 'opacity-50' : '' ?>">
                        <td class="py-4 px-6 text-taupe-mid font-mono text-xs">#<?= $v['id'] ?></td>
                        <td class="py-4 px-6 text-taupe-dark font-mono font-bold tracking-wider">
                            <?= e($v['code']) ?>
                            <?php if ($isExpired): ?>
                                <span class="ml-2 text-[9px] px-1.5 py-0.5 uppercase tracking-widest bg-taupe-light/50 text-taupe-dark rounded-sm border border-taupe-light">Expired</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-6 text-taupe-dark font-bold"><?= $v['discount_percent'] ?>%</td>
                        <td class="py-4 px-6 text-taupe-mid">
                            <?= $v['used_count'] ?> / <?= $v['max_use'] ?>
                            <div class="w-24 h-1.5 bg-taupe-light/30 rounded-full mt-1 overflow-hidden">
                                <div class="h-full bg-taupe-dark" style="width: min(100%, <?= ($v['used_count'] / max(1, $v['max_use'])) * 100 ?>%)"></div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-taupe-mid text-xs">
                            <?= date('d M Y, H:i', strtotime($v['expired_at'])) ?>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                
                                <form action="<?= BASE_URL ?>/admin_vouchers.php" method="POST" class="inline" onsubmit="return confirm('WARNING: Are you sure you want to delete this voucher?')">
                                    <?= csrfField() ?>
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="voucher_id" value="<?= $v['id'] ?>">
                                    <button type="submit" class="p-1.5 text-taupe-mid hover:text-taupe-dark hover:bg-taupe-cream/50 rounded transition-colors" title="Delete Voucher">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($vouchers)): ?>
                    <tr><td colspan="6" class="py-8 text-center text-taupe-mid text-sm">No vouchers configured.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="voucherModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-transform" id="voucherModalInner">
        <form action="<?= BASE_URL ?>/admin_vouchers.php" method="POST">
            <?= csrfField() ?>
            <input type="hidden" name="action" value="create">
            
            <div class="px-6 py-4 border-b border-taupe-light/30 flex justify-between items-center bg-off-white">
                <h3 class="font-serif text-lg text-taupe-dark">New Voucher</h3>
                <button type="button" onclick="closeVoucherModal()" class="text-taupe-mid hover:text-taupe-dark">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-4">
                <div>
                    <label for="code" class="block text-xs font-medium text-taupe-dark mb-1 uppercase tracking-wider">Voucher Code</label>
                    <input type="text" id="code" name="code" required
                           class="w-full px-4 py-2.5 rounded-lg border border-taupe-light text-sm text-taupe-dark focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/50 uppercase font-mono"
                           placeholder="e.g. DISKON50">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="discount_percent" class="block text-xs font-medium text-taupe-dark mb-1 uppercase tracking-wider">Discount (%)</label>
                        <input type="number" id="discount_percent" name="discount_percent" min="1" max="100" required
                               class="w-full px-4 py-2.5 rounded-lg border border-taupe-light text-sm text-taupe-dark focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/50"
                               placeholder="e.g. 15">
                    </div>
                    <div>
                        <label for="max_use" class="block text-xs font-medium text-taupe-dark mb-1 uppercase tracking-wider">Max Uses</label>
                        <input type="number" id="max_use" name="max_use" min="1" required value="100"
                               class="w-full px-4 py-2.5 rounded-lg border border-taupe-light text-sm text-taupe-dark focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/50">
                    </div>
                </div>
                
                <div>
                    <label for="expired_at" class="block text-xs font-medium text-taupe-dark mb-1 uppercase tracking-wider">Expired At</label>
                    <input type="datetime-local" id="expired_at" name="expired_at" required
                           class="w-full px-4 py-2.5 rounded-lg border border-taupe-light text-sm text-taupe-dark focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/50">
                </div>
            </div>
            
            <div class="px-6 py-4 bg-taupe-cream/10 border-t border-taupe-light/30 flex justify-end gap-3">
                <button type="button" onclick="closeVoucherModal()" class="px-4 py-2 text-sm font-medium text-taupe-mid hover:text-taupe-dark transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-taupe-dark text-off-white rounded-lg text-sm font-medium hover:bg-[#7a6a58] transition-colors">Create Voucher</button>
            </div>
        </form>
    </div>
</div>

<?php
$pageScripts = <<<'JS'
<script>
    const modal = document.getElementById('voucherModal');
    const inner = document.getElementById('voucherModalInner');
    
    function openVoucherModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            inner.classList.remove('scale-95');
            inner.classList.add('scale-100');
        }, 10);
    }
    
    function closeVoucherModal() {
        inner.classList.remove('scale-100');
        inner.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeVoucherModal();
    });
</script>
JS;
?>
