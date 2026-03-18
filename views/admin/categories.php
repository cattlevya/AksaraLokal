<?php
/**
 * Admin Categories View
 * Variables: $categories
 */
?>
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="font-serif text-3xl text-taupe-dark italic">Manage Categories</h1>
        <p class="text-taupe-mid text-sm mt-1">Organize the platform's product taxonomy.</p>
    </div>
    
    <!-- Button to trigger Add Modal -->
    <button type="button" onclick="openCatModal('create')" class="bg-taupe-dark hover:bg-[#7a6a58] text-off-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm">
        + New Category
    </button>
</div>

<div class="bg-white rounded-xl border border-taupe-light/30 shadow-sm overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-taupe-cream/30 text-taupe-dark text-xs uppercase tracking-wider">
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30 w-20">ID</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Category Name</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Total Products</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-taupe-light/20">
                <?php foreach ($categories as $c): ?>
                    <tr class="hover:bg-off-white transition-colors group">
                        <td class="py-4 px-6 text-taupe-mid font-mono text-xs">#<?= $c['id'] ?></td>
                        <td class="py-4 px-6 text-taupe-dark font-medium"><?= e($c['name']) ?></td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center justify-center px-2 py-1 bg-taupe-cream/40 text-taupe-dark rounded-full text-xs font-bold w-10">
                                <?= $c['product_count'] ?>
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <!-- Edit Button -->
                                <button type="button" onclick="openCatModal('update', <?= $c['id'] ?>, '<?= htmlspecialchars(addslashes($c['name'])) ?>')" class="p-1.5 text-taupe-mid hover:text-taupe-dark hover:bg-taupe-cream/50 rounded transition-colors" title="Edit Category">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                
                                <!-- Delete Button -->
                                <form action="<?= BASE_URL ?>/admin_categories.php" method="POST" class="inline" onsubmit="return confirm('WARNING: Deleting a category will fail if products still exist in it. Proceed?')">
                                    <?= csrfField() ?>
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="category_id" value="<?= $c['id'] ?>">
                                    <button type="submit" class="p-1.5 text-taupe-mid hover:text-taupe-dark hover:bg-taupe-cream/50 rounded transition-colors" title="Delete Category">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($categories)): ?>
                    <tr><td colspan="4" class="py-8 text-center text-taupe-mid text-sm">No categories found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Overlay -->
<div id="catModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-transform" id="catModalInner">
        <form action="<?= BASE_URL ?>/admin_categories.php" method="POST">
            <?= csrfField() ?>
            <input type="hidden" name="action" id="modalAction" value="create">
            <input type="hidden" name="category_id" id="modalCatId" value="">
            
            <div class="px-6 py-4 border-b border-taupe-light/30 flex justify-between items-center bg-off-white">
                <h3 class="font-serif text-lg text-taupe-dark" id="modalTitle">New Category</h3>
                <button type="button" onclick="closeCatModal()" class="text-taupe-mid hover:text-taupe-dark">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6">
                <label for="catName" class="block text-sm font-medium text-taupe-dark mb-1">Category Name</label>
                <input type="text" id="catName" name="name" required
                       class="w-full px-4 py-2.5 rounded-lg border border-taupe-light text-sm text-taupe-dark focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/50 mb-4"
                       placeholder="e.g. Keramik, Kayu, Rotan">
            </div>
            
            <div class="px-6 py-4 bg-taupe-cream/10 border-t border-taupe-light/30 flex justify-end gap-3">
                <button type="button" onclick="closeCatModal()" class="px-4 py-2 text-sm font-medium text-taupe-mid hover:text-taupe-dark transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-taupe-dark text-off-white rounded-lg text-sm font-medium hover:bg-[#7a6a58] transition-colors">Save Category</button>
            </div>
        </form>
    </div>
</div>

<?php
$pageScripts = <<<'JS'
<script>
    const modal = document.getElementById('catModal');
    const inner = document.getElementById('catModalInner');
    
    function openCatModal(action, id = '', name = '') {
        document.getElementById('modalAction').value = action;
        document.getElementById('modalCatId').value = id;
        document.getElementById('catName').value = name;
        document.getElementById('modalTitle').textContent = action === 'create' ? 'New Category' : 'Edit Category';
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        // trigger animation
        setTimeout(() => {
            inner.classList.remove('scale-95');
            inner.classList.add('scale-100');
        }, 10);
    }
    
    function closeCatModal() {
        inner.classList.remove('scale-100');
        inner.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }
    
    // Close modal if clicked outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeCatModal();
    });
</script>
JS;
?>
