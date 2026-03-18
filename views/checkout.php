<?php

$shipping = 12000;
$tax = round($subtotal * 0.08);

$discount = 0;
if (isset($_SESSION['voucher_discount'])) {
    $discount = round($subtotal * $_SESSION['voucher_discount'] / 100);
}

$total = $subtotal + $shipping + $tax - $discount;
?>

<section class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="font-serif text-3xl text-taupe-dark italic mb-1">Review Your Order</h1>
    <p class="text-sm text-taupe-mid mb-8">Carefully check your items before proceeding to payment.</p>

    <form action="<?= BASE_URL ?>/checkout.php" method="POST" enctype="multipart/form-data" id="checkout-form">
        <?= csrfField() ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2">
                <p class="text-xs tracking-[0.15em] uppercase text-taupe-mid font-medium mb-4 pb-2 border-b border-taupe-light/30">Items in Cart</p>

                <div class="space-y-6">
                    <?php foreach ($cartItems as $item): ?>
                    <div class="flex items-start gap-4 pb-6 border-b border-taupe-light/20">
                        <div class="w-20 h-20 rounded-lg overflow-hidden bg-warm-gray shrink-0">
                            <img src="<?= BASE_URL ?>/assets/images/<?= e($item['image']) ?>" alt="<?= e($item['name']) ?>"
                                 class="w-full h-full object-cover"
                                 onerror="this.src='<?= BASE_URL ?>/assets/images/default.jpg'">
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <h3 class="font-serif italic text-taupe-dark"><?= e($item['name']) ?></h3>
                                <span class="text-taupe-dark font-medium"><?= formatRupiah($item['price'] * $item['quantity']) ?></span>
                            </div>
                            <p class="text-xs text-taupe-mid mt-1">Qty: <?= $item['quantity'] ?> × <?= formatRupiah($item['price']) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                
                <div class="mt-8">
                    <p class="text-sm text-taupe-mid mb-2">Have a voucher code?</p>
                    <div class="flex gap-2">
                        <input type="text" id="voucher-input" name="voucher_code" placeholder="Enter code" 
                               value="<?= e($_SESSION['voucher_code'] ?? '') ?>"
                               class="flex-1 px-4 py-2.5 rounded-lg border border-taupe-light bg-off-white text-sm text-taupe-dark placeholder-taupe-mid/50 focus:outline-none focus:border-taupe-mid">
                        <button type="button" onclick="applyVoucher()" 
                                class="px-5 py-2.5 bg-taupe-dark text-off-white rounded-lg text-sm font-medium hover:bg-[#7a6a58] transition-colors">
                            Apply
                        </button>
                    </div>
                    <p id="voucher-msg" class="text-xs mt-2 <?= isset($_SESSION['voucher_discount']) ? 'text-taupe-dark font-medium' : 'hidden' ?>">
                        <?= isset($_SESSION['voucher_discount']) ? '✓ ' . e($_SESSION['voucher_discount']) . '% discount applied!' : '' ?>
                    </p>
                </div>
            </div>

            
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-taupe-light/30 p-6 sticky top-24">
                    <h3 class="font-serif text-xl text-taupe-dark mb-5">Order Summary</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-taupe-mid">
                            <span>Subtotal</span>
                            <span id="summary-subtotal"><?= formatRupiah($subtotal) ?></span>
                        </div>
                        <div class="flex justify-between text-taupe-mid">
                            <span>Shipping</span>
                            <span><?= formatRupiah($shipping) ?></span>
                        </div>
                        <div class="flex justify-between text-taupe-mid">
                            <span>Tax (Est.)</span>
                            <span><?= formatRupiah($tax) ?></span>
                        </div>
                        <div id="discount-row" class="flex justify-between text-taupe-dark font-medium <?= isset($_SESSION['voucher_discount']) ? '' : 'hidden' ?>">
                            <span>Discount</span>
                            <span id="discount-amount">-<?= isset($_SESSION['voucher_discount']) ? formatRupiah($subtotal * $_SESSION['voucher_discount'] / 100) : '' ?></span>
                        </div>
                        <hr class="border-taupe-light/30">
                        <div class="flex justify-between text-taupe-dark font-bold text-lg">
                            <span>Total Amount</span>
                            <span id="summary-total"><?= formatRupiah($total) ?></span>
                        </div>
                    </div>

                    
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-taupe-dark mb-1">Upload Payment Proof</h4>
                        <p class="text-xs text-taupe-mid mb-3">Please upload a screenshot or photo of your bank transfer (JPG, PNG).</p>
                        
                        <div class="dnd-area" id="dnd-area" onclick="document.getElementById('payment-proof').click()">
                            <input type="file" id="payment-proof" name="payment_proof" accept=".jpg,.jpeg,.png" class="hidden" onchange="handleFileSelect(this)">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl text-taupe-mid mb-2"></i>
                            <p id="dnd-text" class="text-sm text-taupe-mid">Click to upload or drag and drop</p>
                            <p class="text-[10px] text-taupe-mid/60 mt-1">JPG/PNG, max 2MB</p>
                        </div>
                        <div id="file-preview" class="hidden mt-3 p-2 bg-warm-gray rounded-lg flex items-center gap-2">
                            <img id="preview-img" class="w-12 h-12 object-cover rounded" src="" alt="preview">
                            <span id="preview-name" class="text-xs text-taupe-dark flex-1 truncate"></span>
                            <button type="button" onclick="clearFile()" class="text-red-400 hover:text-red-500 text-xs"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>

                    
                    <button type="submit" name="place_order" 
                            class="w-full mt-6 py-3.5 bg-taupe-dark text-off-white rounded-lg font-medium text-sm tracking-wider uppercase hover:bg-[#7a6a58] transition-colors">
                        Complete Purchase
                    </button>
                    <p class="text-center text-[10px] text-taupe-mid mt-3">
                        <i class="fa-solid fa-lock mr-1"></i> Secure Checkout
                    </p>
                </div>
            </div>
        </div>
    </form>
</section>

<?php
$pageScripts = <<<'JS'
<script>
// ── Drag & Drop Upload ──
const dndArea = document.getElementById('dnd-area');
const fileInput = document.getElementById('payment-proof');

['dragenter','dragover'].forEach(e => {
    dndArea.addEventListener(e, ev => { ev.preventDefault(); dndArea.classList.add('dragover'); });
});
['dragleave','drop'].forEach(e => {
    dndArea.addEventListener(e, ev => { ev.preventDefault(); dndArea.classList.remove('dragover'); });
});
dndArea.addEventListener('drop', ev => {
    const dt = ev.dataTransfer;
    if (dt.files.length) {
        fileInput.files = dt.files;
        handleFileSelect(fileInput);
    }
});

function handleFileSelect(input) {
    const file = input.files[0];
    if (!file) return;
    
    // Validate type
    if (!['image/jpeg', 'image/png'].includes(file.type)) {
        alert('Please upload JPG or PNG only.');
        input.value = '';
        return;
    }
    // Validate size (2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('File size must be under 2MB.');
        input.value = '';
        return;
    }
    
    // Show preview
    document.getElementById('file-preview').classList.remove('hidden');
    document.getElementById('preview-name').textContent = file.name;
    const reader = new FileReader();
    reader.onload = e => document.getElementById('preview-img').src = e.target.result;
    reader.readAsDataURL(file);
    document.getElementById('dnd-text').textContent = 'File selected!';
}

function clearFile() {
    fileInput.value = '';
    document.getElementById('file-preview').classList.add('hidden');
    document.getElementById('dnd-text').textContent = 'Click to upload or drag and drop';
}

// ── Voucher Apply ──
function applyVoucher() {
    const code = document.getElementById('voucher-input').value.trim();
    if (!code) return;
    
    fetch(window.location.pathname, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'action=apply_voucher&voucher_code=' + encodeURIComponent(code)
    })
    .then(r => r.json())
    .then(data => {
        const msg = document.getElementById('voucher-msg');
        msg.classList.remove('hidden');
        if (data.valid) {
            msg.className = 'text-xs mt-2 text-emerald-600';
            msg.textContent = data.discount_percent + '% discount applied!';
            location.reload();
        } else {
            msg.className = 'text-xs mt-2 text-red-500';
            msg.textContent = data.message;
        }
    })
    .catch(() => alert('Error applying voucher'));
}
</script>
JS;
?>
