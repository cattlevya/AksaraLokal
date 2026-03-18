<?php

$isFlashSale = $product['flash_sale_price'] && strtotime($product['flash_sale_end']) > time();
$currentPrice = $isFlashSale ? $product['flash_sale_price'] : $product['price'];

$productImages = [
    1 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC27s3SVeZloGg3xQwglafaNxuqvozAfCTexXmg8m5O2--W994rsaSs7SdcskpmKkaS93nBw8sJzsO-d_a5UAq1Z_nJ4qqXU0xD_l99UyO5054T8TQimbCNQFGRHT7NJD3gNUSbFFaihD2InCrm0I_vvhh-5NlbFptKrObCztB0Qko1kknEwzIPWdnn2OxFxi7f4grNnFIpRELd_9m9Fiy8nok7YCvJCQkKkQQ5Z9rGAhd15Kkzt-GUOYNXdfV42wyOac7Otu0KDmY',
    2 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBn_qx-kqHtIPv-V5zoUDrABWCFUwMXRtEKLToZ5GdRdG-yRhxo04r8Sw6HnhJSQu1o1NaRwmaFDCRSjog14XJ-CvMfDKqriKLjV1m3LirEaAz2VfubXJfifOXEEYsuKHhzSUo0SYasiZAahUdMw6pE2CK9DQTn1yvhR-BYUpTV5rLiM4SRyjt5DqvuoWqi6hTtnUdYZTLcmi3wLix2IgVxF0i6_bZ6kykAOjeAH14lZf98qbBH9M0Fj2z3GqgGXiw0HnaOfr8IKEM',
    3 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB_Lm4SC7jgvOhX65Abbf1oZYv2xsPrLOO80RJRDMN3GGeTEeUT0XFvbz2w33XFOMgliJZZoa9lLTmuXW3i-4PEQYwHKw_EQwrmX0rPyr8yUnua5p5KAq-VoFKY6Godk_25LcsmBjsmY-jHD306ux1mIaEk_n-hGwkeJtvyKP1Mbn2_4GdT-DmZV9NnAhYoL4BfHurl-oGpUUtlYJWnCv6AfsZ9NxpdBrGn5fv6GwcQN_tLmk1vIOQavaivJ0QEYhQYcsVtvtRWIew',
    4 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC27s3SVeZloGg3xQwglafaNxuqvozAfCTexXmg8m5O2--W994rsaSs7SdcskpmKkaS93nBw8sJzsO-d_a5UAq1Z_nJ4qqXU0xD_l99UyO5054T8TQimbCNQFGRHT7NJD3gNUSbFFaihD2InCrm0I_vvhh-5NlbFptKrObCztB0Qko1kknEwzIPWdnn2OxFxi7f4grNnFIpRELd_9m9Fiy8nok7YCvJCQkKkQQ5Z9rGAhd15Kkzt-GUOYNXdfV42wyOac7Otu0KDmY',
    5 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDrUi6cJbmKmcdQC5Np-H3OF_Vvtpqn22p4aO0mgwZ-0iBeMzsTq0dSJZ43n_u0NVHLs4mgdPlpEdmgOUIhSqC97tW-cT_s8K3VbBw71kH9Be3GNMMapoqbz-7ANICsfFfmuSydD1r1bDeB2W0RkP2aKUn388PWzAD7jWv6wh3iq_k3qyP-O1MME93uft6wODTEXMDhtUeALA6zgaunArulMLOs491zVs5ojv8yVJerVSiCORtTlOHcljGlarXXV1ECJOwteO58RCw',
    6 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC27s3SVeZloGg3xQwglafaNxuqvozAfCTexXmg8m5O2--W994rsaSs7SdcskpmKkaS93nBw8sJzsO-d_a5UAq1Z_nJ4qqXU0xD_l99UyO5054T8TQimbCNQFGRHT7NJD3gNUSbFFaihD2InCrm0I_vvhh-5NlbFptKrObCztB0Qko1kknEwzIPWdnn2OxFxi7f4grNnFIpRELd_9m9Fiy8nok7YCvJCQkKkQQ5Z9rGAhd15Kkzt-GUOYNXdfV42wyOac7Otu0KDmY',
    7 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBn_qx-kqHtIPv-V5zoUDrABWCFUwMXRtEKLToZ5GdRdG-yRhxo04r8Sw6HnhJSQu1o1NaRwmaFDCRSjog14XJ-CvMfDKqriKLjV1m3LirEaAz2VfubXJfifOXEEYsuKHhzSUo0SYasiZAahUdMw6pE2CK9DQTn1yvhR-BYUpTV5rLiM4SRyjt5DqvuoWqi6hTtnUdYZTLcmi3wLix2IgVxF0i6_bZ6kykAOjeAH14lZf98qbBH9M0Fj2z3GqgGXiw0HnaOfr8IKEM',
    8 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDrUi6cJbmKmcdQC5Np-H3OF_Vvtpqn22p4aO0mgwZ-0iBeMzsTq0dSJZ43n_u0NVHLs4mgdPlpEdmgOUIhSqC97tW-cT_s8K3VbBw71kH9Be3GNMMapoqbz-7ANICsfFfmuSydD1r1bDeB2W0RkP2aKUn388PWzAD7jWv6wh3iq_k3qyP-O1MME93uft6wODTEXMDhtUeALA6zgaunArulMLOs491zVs5ojv8yVJerVSiCORtTlOHcljGlarXXV1ECJOwteO58RCw',
];
$imgSrc = $productImages[$product['id']] ?? BASE_URL . '/assets/images/' . e($product['image']);
?>

<section class="max-w-7xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-14">

        
        <div>
            <div class="aspect-square overflow-hidden bg-taupe-cream/20">
                <img src="<?= $imgSrc ?>" alt="<?= e($product['name']) ?>" class="w-full h-full object-cover">
            </div>
        </div>

        
        <div class="flex flex-col">
            <?php if ($isFlashSale): ?>
            
            <div class="flash-badge rounded-lg px-5 py-3 mb-5 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-taupe-cream rounded-full animate-pulse"></span>
                    <span class="text-white text-xs font-semibold tracking-wider uppercase">Flash Sale Ending In:</span>
                </div>
                <div id="countdown" class="flex items-center gap-1 text-white font-mono"
                     data-end="<?= e($product['flash_sale_end']) ?>">
                    <span id="cd-hours" class="bg-white/20 rounded px-2 py-1 text-sm font-bold">00</span>
                    <span class="text-xs font-bold">:</span>
                    <span id="cd-minutes" class="bg-white/20 rounded px-2 py-1 text-sm font-bold">00</span>
                    <span class="text-xs font-bold">:</span>
                    <span id="cd-seconds" class="bg-white/20 rounded px-2 py-1 text-sm font-bold">00</span>
                </div>
            </div>
            <?php endif; ?>

            
            <p class="text-xs tracking-[0.2em] uppercase text-taupe-mid mb-2"><?= e($product['category_name']) ?> Collection</p>

            
            <h1 class="font-serif text-3xl md:text-4xl text-taupe-dark italic leading-tight mb-3">
                <?= e($product['name']) ?>
            </h1>

            
            <div class="flex items-baseline gap-3 mb-4">
                <span class="text-2xl font-medium text-taupe-dark"><?= formatRupiah($currentPrice) ?></span>
                <?php if ($isFlashSale): ?>
                    <span class="text-lg text-taupe-mid/50 line-through"><?= formatRupiah($product['price']) ?></span>
                <?php endif; ?>
            </div>

            
            <div class="flex items-center gap-2 mb-6 pb-6 border-b border-taupe-light/30">
                <?php
                $c1 = $product['stock'] <= 5 ? 'bg-taupe-dark' : 'bg-taupe-mid';
                $c2 = $product['stock'] <= 5 ? 'bg-taupe-mid' : 'bg-taupe-light';
                $c3 = $product['stock'] <= 5 ? 'bg-taupe-light' : 'bg-taupe-cream';
                ?>
                <span class="w-3 h-1.5 rounded-full <?= $c1 ?>"></span>
                <span class="w-3 h-1.5 rounded-full <?= $c2 ?>"></span>
                <span class="w-3 h-1.5 rounded-full <?= $c3 ?>"></span>
                <span class="text-sm text-taupe-mid ml-1">
                    Only <strong class="text-taupe-dark"><?= $product['stock'] ?> items</strong> left in stock
                </span>
            </div>

            
            <div class="mb-6">
                <h3 class="font-semibold text-taupe-dark mb-2">The Artisan Story</h3>
                <p class="text-sm text-taupe-mid leading-relaxed font-serif italic mb-3">
                    "Each piece is a dialogue between the clay and the coastal winds of our local studio."
                </p>
                <p class="text-sm text-taupe-mid/80 leading-relaxed"><?= e($product['description']) ?></p>
            </div>

            
            <form id="add-to-cart-form" class="mt-auto">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <div class="flex items-center gap-3 mb-4">
                    <button type="button" onclick="changeQty(-1)" class="w-10 h-10 rounded-lg border border-taupe-light text-taupe-dark flex items-center justify-center hover:bg-taupe-cream/30 transition-colors text-lg">−</button>
                    <input type="number" id="qty-input" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>"
                           class="w-14 h-10 text-center border border-taupe-light rounded-lg bg-off-white text-taupe-dark focus:outline-none focus:ring-1 focus:ring-taupe-mid">
                    <button type="button" onclick="changeQty(1)" class="w-10 h-10 rounded-lg border border-taupe-light text-taupe-dark flex items-center justify-center hover:bg-taupe-cream/30 transition-colors text-lg">+</button>
                </div>

                <button type="button" onclick="addToCart()"
                        class="w-full py-3.5 rounded-lg bg-taupe-dark text-off-white font-medium text-sm tracking-wider uppercase flex items-center justify-center gap-2 hover:bg-[#7a6a58] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                    Add to Bag
                </button>
            </form>

            
            <div class="flex items-center justify-between mt-4 text-xs text-taupe-mid">
                <span>✓ Free Local Shipping</span>
                <span>🛡 Authenticity Guaranteed</span>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($relatedProducts)): ?>
<section class="max-w-7xl mx-auto px-4 py-10 border-t border-taupe-light/30">
    <h2 class="text-2xl font-serif text-taupe-dark italic mb-6">Complements the Collection</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        <?php foreach ($relatedProducts as $rp): ?>
        <a href="<?= BASE_URL ?>/product_detail.php?id=<?= $rp['id'] ?>" class="product-card group block no-underline">
            <div class="aspect-square overflow-hidden bg-taupe-cream/20 mb-2">
                <img src="<?= $productImages[$rp['id']] ?? BASE_URL . '/assets/images/' . e($rp['image']) ?>" alt="<?= e($rp['name']) ?>"
                     class="w-full h-full object-cover product-image">
            </div>
            <h3 class="font-serif text-sm italic text-taupe-dark"><?= e($rp['name']) ?></h3>
            <p class="text-sm text-taupe-mid"><?= formatRupiah($rp['price']) ?></p>
        </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php
$baseUrl = BASE_URL;
$pageScripts = <<<JS
<script>
// ── Flash Sale Countdown (synced with server) ──
(function() {
    const el = document.getElementById('countdown');
    if (!el) return;
    const endStr = el.dataset.end;
    const endTime = new Date(endStr.replace(' ', 'T') + '+07:00').getTime();

    function tick() {
        const now = Date.now();
        let diff = Math.max(0, Math.floor((endTime - now) / 1000));

        document.getElementById('cd-hours').textContent = String(Math.floor(diff / 3600)).padStart(2, '0');
        document.getElementById('cd-minutes').textContent = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
        document.getElementById('cd-seconds').textContent = String(diff % 60).padStart(2, '0');

        if (diff > 0) setTimeout(tick, 1000);
    }
    tick();
})();

function changeQty(delta) {
    const input = document.getElementById('qty-input');
    input.value = Math.max(1, Math.min(parseInt(input.max), parseInt(input.value) + delta));
}

function addToCart() {
    const productId = document.querySelector('[name="product_id"]').value;
    const quantity = document.getElementById('qty-input').value;

    fetch('{$baseUrl}/cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'action=add&product_id=' + productId + '&quantity=' + quantity
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const btn = document.querySelector('#add-to-cart-form button[onclick="addToCart()"]');
            const orig = btn.innerHTML;
            btn.innerHTML = '✓ Added!';
            btn.classList.replace('bg-taupe-dark', 'bg-taupe-mid');
            setTimeout(() => { btn.innerHTML = orig; btn.classList.replace('bg-taupe-mid', 'bg-taupe-dark'); location.reload(); }, 1000);
        } else {
            alert(data.message || 'Failed to add item');
        }
    })
    .catch(() => alert('Error adding to cart'));
}
</script>
JS;
?>
