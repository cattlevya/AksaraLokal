<?php

?>
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="font-serif text-3xl text-taupe-dark italic">Global Orders</h1>
        <p class="text-taupe-mid text-sm mt-1">Verify payments and monitor platform transactions.</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-taupe-light/30 shadow-sm overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-taupe-cream/30 text-taupe-dark text-xs uppercase tracking-wider">
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Order ID</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Date</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Buyer</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Total Amount</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Status</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30 text-right">Payment/Verify</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-taupe-light/20">
                <?php foreach ($orders as $o): ?>
                    <tr class="hover:bg-off-white transition-colors group">
                        
                        <td class="py-4 px-6 text-taupe-dark font-mono font-medium">#<?= $o['id'] ?></td>
                        
                        
                        <td class="py-4 px-6 text-taupe-mid text-xs">
                            <?= date('d M Y', strtotime($o['created_at'])) ?><br>
                            <span class="text-[10px]"><?= date('H:i', strtotime($o['created_at'])) ?> WIB</span>
                        </td>
                        
                        
                        <td class="py-4 px-6">
                            <p class="text-taupe-dark font-medium"><?= e($o['buyer_name']) ?></p>
                            <p class="text-taupe-mid text-[10px]"><?= e($o['buyer_email']) ?></p>
                        </td>
                        
                        
                        <td class="py-4 px-6 text-taupe-dark font-medium">
                            <?= formatRupiah($o['total_amount']) ?>
                        </td>
                        
                        
                        <td class="py-4 px-6">
                            <?php 
                                $statusColors = [
                                    'pending'   => 'bg-taupe-cream/50 text-taupe-dark border-taupe-cream',
                                    'confirmed' => 'bg-taupe-light/40 text-taupe-dark border-taupe-light/60',
                                    'shipped'   => 'bg-taupe-mid/20 text-taupe-dark border-taupe-mid/40',
                                    'delivered' => 'bg-taupe-dark/10 text-taupe-dark font-bold border-taupe-dark/30',
                                    'cancelled' => 'bg-taupe-cream/30 text-taupe-mid line-through border-taupe-light/20',
                                ];
                                $color = $statusColors[$o['status']] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                            ?>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-widest border <?= $color ?>">
                                <?= e($o['status']) ?>
                            </span>
                        </td>
                        
                        
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-3">
                                
                                <?php if ($o['payment_proof']): ?>
                                    <button type="button" onclick="openProofModal('<?= BASE_URL ?>/assets/uploads/<?= e($o['payment_proof']) ?>')" class="text-xs font-medium text-taupe-mid hover:text-taupe-dark flex items-center gap-1 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Proof
                                    </button>
                                <?php else: ?>
                                    <span class="text-[10px] text-taupe-mid/60 italic">No Proof</span>
                                <?php endif; ?>
                                
                                
                                <?php if ($o['status'] === 'pending' && $o['payment_proof']): ?>
                                    <form action="<?= BASE_URL ?>/admin_orders.php" method="POST" class="inline" onsubmit="return confirm('Verify payment and mark order #<?= $o['id'] ?> as Confirmed/Paid?')">
                                        <?= csrfField() ?>
                                        <input type="hidden" name="action" value="verify_payment">
                                        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                        <button type="submit" class="text-xs font-medium px-3 py-1.5 border border-taupe-mid rounded text-taupe-dark hover:bg-taupe-cream/50 transition-colors">
                                            Verify
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($orders)): ?>
                    <tr><td colspan="6" class="py-8 text-center text-taupe-mid text-sm">No orders found on the platform yet.</td></tr>
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

<div id="proofModal" class="fixed inset-0 bg-black/80 z-[100] hidden items-center justify-center backdrop-blur-sm transition-opacity">
    <div class="relative max-w-2xl w-full mx-4" id="proofModalInner">
        <button type="button" onclick="closeProofModal()" class="absolute -top-10 right-0 text-white/70 hover:text-white transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <img id="proofImage" src="" alt="Payment Proof" class="w-full h-auto rounded-lg shadow-2xl">
    </div>
</div>

<?php
$pageScripts = <<<'JS'
<script>
    const modal = document.getElementById('proofModal');
    const img = document.getElementById('proofImage');
    
    function openProofModal(src) {
        img.src = src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeProofModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        setTimeout(() => { img.src = ''; }, 200);
    }
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeProofModal();
    });
</script>
JS;
?>
