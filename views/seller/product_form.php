<?php
/**
 * Seller Product Add/Edit Form View
 * Variables: $product (null for add), $categories
 */
$isEdit = $product !== null;
?>
<div class="mb-6">
    <a href="<?= BASE_URL ?>/seller_products.php" class="text-sm text-taupe-mid hover:text-taupe-dark transition-colors no-underline inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
        Back to Products
    </a>
</div>

<div class="max-w-2xl">
    <h1 class="font-serif text-2xl text-taupe-dark italic mb-6"><?= $isEdit ? 'Edit Product' : 'Add New Product' ?></h1>

    <form method="POST" action="<?= BASE_URL ?>/seller_products.php" enctype="multipart/form-data" class="space-y-5">
        <?= csrfField() ?>
        <input type="hidden" name="action" value="<?= $isEdit ? 'update' : 'create' ?>">
        <?php if ($isEdit): ?>
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <?php endif; ?>

        <!-- Name -->
        <div>
            <label class="block text-sm font-medium text-taupe-dark mb-1.5">Product Name <span class="text-taupe-mid">*</span></label>
            <input type="text" name="name" required value="<?= e($isEdit ? $product['name'] : ($_POST['name'] ?? '')) ?>"
                   class="w-full px-4 py-2.5 rounded-lg border border-taupe-light/50 bg-off-white text-sm text-taupe-dark placeholder-taupe-mid/50 focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/30"
                   placeholder="e.g. Vas Keramik Bali">
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-medium text-taupe-dark mb-1.5">Description <span class="text-taupe-mid">*</span></label>
            <textarea name="description" required rows="4"
                      class="w-full px-4 py-2.5 rounded-lg border border-taupe-light/50 bg-off-white text-sm text-taupe-dark placeholder-taupe-mid/50 focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/30 resize-none"
                      placeholder="Describe your product..."><?= e($isEdit ? $product['description'] : ($_POST['description'] ?? '')) ?></textarea>
        </div>

        <!-- Price + Stock Row -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-taupe-dark mb-1.5">Price (Rp) <span class="text-taupe-mid">*</span></label>
                <input type="number" name="price" required min="1000" step="1000"
                       value="<?= $isEdit ? (int)$product['price'] : ($_POST['price'] ?? '') ?>"
                       class="w-full px-4 py-2.5 rounded-lg border border-taupe-light/50 bg-off-white text-sm text-taupe-dark focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/30"
                       placeholder="450000">
            </div>
            <div>
                <label class="block text-sm font-medium text-taupe-dark mb-1.5">Stock <span class="text-taupe-mid">*</span></label>
                <input type="number" name="stock" required min="0"
                       value="<?= $isEdit ? $product['stock'] : ($_POST['stock'] ?? '') ?>"
                       class="w-full px-4 py-2.5 rounded-lg border border-taupe-light/50 bg-off-white text-sm text-taupe-dark focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/30"
                       placeholder="10">
            </div>
        </div>

        <!-- Category -->
        <div>
            <label class="block text-sm font-medium text-taupe-dark mb-1.5">Category <span class="text-taupe-mid">*</span></label>
            <select name="category_id" required
                    class="w-full px-4 py-2.5 rounded-lg border border-taupe-light/50 bg-off-white text-sm text-taupe-dark focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/30">
                <option value="">Select category...</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= ($isEdit && $product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                    <?= e($cat['name']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Image -->
        <div>
            <label class="block text-sm font-medium text-taupe-dark mb-1.5">
                Product Image <?= $isEdit ? '(leave empty to keep current)' : '' ?>
            </label>

            <?php if ($isEdit && $product['image'] !== 'default.jpg'): ?>
            <div class="mb-3 flex items-center gap-3">
                <img src="<?= BASE_URL ?>/assets/images/<?= e($product['image']) ?>" alt="Current" class="w-16 h-16 rounded-lg object-cover border border-taupe-light/30">
                <span class="text-xs text-taupe-mid">Current image</span>
            </div>
            <?php endif; ?>

            <div class="dnd-area" onclick="document.getElementById('product-image').click()" id="img-drop-zone">
                <input type="file" id="product-image" name="image" accept=".jpg,.jpeg,.png" class="hidden" onchange="previewImage(this)">
                <svg class="w-8 h-8 mx-auto text-taupe-mid mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                <p id="img-label" class="text-sm text-taupe-mid">Click to upload (JPG/PNG, max 2MB)</p>
            </div>
            <div id="img-preview-wrap" class="hidden mt-3">
                <img id="img-preview" class="w-20 h-20 rounded-lg object-cover border border-taupe-light/30" src="" alt="Preview">
            </div>
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="px-6 py-2.5 bg-taupe-dark text-off-white rounded-lg text-sm font-medium hover:bg-[#7a6a58] transition-colors">
                <?= $isEdit ? 'Update Product' : 'Create Product' ?>
            </button>
            <a href="<?= BASE_URL ?>/seller_products.php" class="px-6 py-2.5 border border-taupe-light rounded-lg text-sm text-taupe-mid hover:border-taupe-dark hover:text-taupe-dark transition-all no-underline">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const file = input.files[0];
    if (!file) return;
    if (!['image/jpeg','image/png'].includes(file.type)) { alert('JPG/PNG only'); input.value=''; return; }
    if (file.size > 2*1024*1024) { alert('Max 2MB'); input.value=''; return; }
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('img-preview').src = e.target.result;
        document.getElementById('img-preview-wrap').classList.remove('hidden');
        document.getElementById('img-label').textContent = file.name;
    };
    reader.readAsDataURL(file);
}

// Drag & drop
const zone = document.getElementById('img-drop-zone');
['dragenter','dragover'].forEach(e => zone.addEventListener(e, ev => { ev.preventDefault(); zone.classList.add('dragover'); }));
['dragleave','drop'].forEach(e => zone.addEventListener(e, ev => { ev.preventDefault(); zone.classList.remove('dragover'); }));
zone.addEventListener('drop', ev => {
    const input = document.getElementById('product-image');
    if (ev.dataTransfer.files.length) { input.files = ev.dataTransfer.files; previewImage(input); }
});
</script>
