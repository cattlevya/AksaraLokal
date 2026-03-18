<?php
/**
 * Home Page View — Exact match to reference template
 * Hero with real image + gradient overlay
 * Horizontal scrollable product cards with Google-hosted images
 * Variables: $products, $categories
 */

// Map product images to Google-hosted URLs for beautiful demo display
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

// Location mapping for products
$productLocations = [
    1 => 'Ubud, Bali',
    2 => 'Ubud, Bali',
    3 => 'Lombok, NTB',
    4 => 'Yogyakarta',
    5 => 'Solo, Central Java',
    6 => 'Ubud, Bali',
    7 => 'Ubud, Bali',
    8 => 'Pekalongan',
];

$heroImage = 'https://lh3.googleusercontent.com/aida-public/AB6AXuDIFtxGZQJcchaqjwxZGIDNq-dqmn1259JTU_MLpRZnECVX-XzbiD7giLbXjiPQ0G2xluWQ4Wq8IdKFvNNZVVjM0QChOIb6mIrDPIgmqIs45P6Xt1BYdkQUby68JdJl7P-ruqoocm5sFFeLPf01dN-Fd4Ak1KmFowPUuHp-m51NKPF97n5ffn-Ir6F5dkgbtCIkFpOv3M5BrRxXKIuH9rSzaVadIIl46h5zimJ5ZVVx-xxtIujB73wtRsZRsOJXNJeT-5mz4WrkvTM';
?>

<!-- ═══ Hero Section ═══ -->
<section class="relative h-[70vh] w-full overflow-hidden">
    <img src="<?= $heroImage ?>" alt="Artisan Banner" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 hero-gradient flex items-end p-8 md:p-16">
        <div class="text-white max-w-2xl">
            <span class="uppercase tracking-widest text-xs mb-2 block text-taupe-cream">Featured Artist of the Month</span>
            <h1 class="text-4xl md:text-6xl mb-4 italic">I Wayan Sudarta</h1>
            <p class="text-lg font-light leading-relaxed mb-6 text-taupe-cream/90">
                Discover the intricate wood carvings of Mas, Bali. Each piece tells a story of ancestral wisdom and timeless beauty.
            </p>
            <a href="<?= BASE_URL ?>/products.php" class="inline-block border border-white px-8 py-3 uppercase tracking-widest text-xs hover:bg-white hover:text-taupe-dark transition-colors duration-300 no-underline text-white">
                Explore Collection
            </a>
        </div>
    </div>
</section>

<!-- ═══ Flash Sale ═══ -->
<section class="pt-16 pb-8 px-4 max-w-7xl mx-auto">
    <div class="flex items-end justify-between mb-8 border-b border-taupe-light/30 pb-4">
        <div>
            <h2 class="text-3xl font-serif text-taupe-dark flex items-center gap-3">
                Flash Sale
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-red-700 animate-[pulse-flash_2s_infinite]"></span>
            </h2>
            <p class="text-taupe-mid font-light">Limited time offers. Grab them before they're gone!</p>
        </div>
    </div>

    <?php if (empty($flashSaleProducts)): ?>
        <div class="bg-taupe-cream/10 border border-taupe-light/30 rounded-xl p-8 text-center md:py-16">
            <p class="text-taupe-mid mb-2">
                <svg class="w-12 h-12 mx-auto text-taupe-light mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </p>
            <p class="text-taupe-dark italic text-lg font-serif">Tidak ada flash sale yang sedang berlangsung.</p>
            <p class="text-sm text-taupe-mid mt-1">Harap kembali lagi nanti untuk penawaran terbatas terbaik.</p>
        </div>
    <?php else: ?>
        <!-- Horizontal Scrollable Flash Sale List -->
        <div class="flex gap-6 overflow-x-auto hide-scrollbar pb-8 snap-x">
            <?php foreach ($flashSaleProducts as $fsProduct): ?>
            <a href="<?= BASE_URL ?>/product_detail.php?id=<?= $fsProduct['id'] ?>" class="w-[280px] md:w-[320px] flex-none snap-start group product-card cursor-pointer no-underline block">
                <div class="relative overflow-hidden aspect-[4/5] bg-taupe-cream/20">
                    <img src="<?= $productImages[$fsProduct['id']] ?? BASE_URL . '/assets/images/' . e($fsProduct['image']) ?>" 
                         alt="<?= e($fsProduct['name']) ?>" 
                         class="w-full h-full object-cover product-image">
                    
                    <span class="absolute top-4 right-4 flash-badge text-white px-3 py-1 text-[10px] uppercase tracking-tighter rounded-sm">Flash Sale</span>
                    
                    <!-- Countdown timer overlay -->
                    <div class="absolute bottom-0 inset-x-0 bg-black/60 backdrop-blur-sm p-3">
                        <div class="flex items-center justify-between text-white text-xs">
                            <span class="uppercase tracking-widest text-[9px] text-taupe-light">Ends in</span>
                            <span class="font-mono bg-white/20 px-2 py-0.5 rounded text-[10px]">
                                <?php
                                    $diff = max(0, strtotime($fsProduct['flash_sale_end']) - time());
                                    $h = floor($diff / 3600);
                                    $m = floor(($diff % 3600) / 60);
                                    $s = $diff % 60;
                                    echo sprintf("%02d:%02d:%02d", $h, $m, $s);
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-lg italic text-taupe-dark"><?= e($fsProduct['name']) ?></h3>
                    <p class="text-xs text-taupe-mid uppercase tracking-widest mt-1">
                        <?= $productLocations[$fsProduct['id']] ?? e($fsProduct['seller_name'] ?? '') ?>
                    </p>
                    <p class="mt-2 font-medium text-taupe-dark">
                        <span class="text-red-700"><?= formatRupiah($fsProduct['flash_sale_price']) ?></span>
                        <span class="text-taupe-mid/50 line-through text-sm ml-1"><?= formatRupiah($fsProduct['price']) ?></span>
                    </p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- ═══ Curated Collections ═══ -->
<section class="py-16 px-4 max-w-7xl mx-auto">
    <div class="flex items-end justify-between mb-8">
        <div>
            <h2 class="text-3xl font-serif text-taupe-dark">Curated Collections</h2>
            <p class="text-taupe-mid font-light">Handpicked artisanal goods from across the archipelago</p>
        </div>
        <a href="<?= BASE_URL ?>/products.php" class="text-sm border-b border-taupe-mid text-taupe-dark pb-1 hover:text-taupe-light transition-colors no-underline">View All</a>
    </div>

    <!-- Horizontal Scrollable Product List -->
    <div class="flex gap-6 overflow-x-auto hide-scrollbar pb-8 snap-x">
        <?php foreach ($products as $i => $product): ?>
        <a href="<?= BASE_URL ?>/product_detail.php?id=<?= $product['id'] ?>" class="w-[280px] md:w-[320px] flex-none snap-start group product-card cursor-pointer no-underline block">
            <div class="relative overflow-hidden aspect-[4/5] bg-taupe-cream/20">
                <img src="<?= $productImages[$product['id']] ?? BASE_URL . '/assets/images/' . e($product['image']) ?>" 
                     alt="<?= e($product['name']) ?>" 
                     class="w-full h-full object-cover product-image">
                
                <?php if ($i === 0): ?>
                <span class="absolute top-4 left-4 bg-white/80 backdrop-blur px-3 py-1 text-[10px] uppercase tracking-tighter">New Arrival</span>
                <?php endif; ?>

                <?php if ($product['flash_sale_price'] && strtotime($product['flash_sale_end']) > time()): ?>
                <span class="absolute top-4 right-4 flash-badge text-white px-3 py-1 text-[10px] uppercase tracking-tighter rounded-sm">Flash Sale</span>
                <?php endif; ?>
            </div>
            <div class="mt-4">
                <h3 class="text-lg italic text-taupe-dark"><?= e($product['name']) ?></h3>
                <p class="text-xs text-taupe-mid uppercase tracking-widest mt-1">
                    <?= $productLocations[$product['id']] ?? e($product['seller_name'] ?? '') ?>
                </p>
                <p class="mt-2 font-medium text-taupe-dark">
                    <?php if ($product['flash_sale_price'] && strtotime($product['flash_sale_end']) > time()): ?>
                        <span class="text-red-700"><?= formatRupiah($product['flash_sale_price']) ?></span>
                        <span class="text-taupe-mid/50 line-through text-sm ml-1"><?= formatRupiah($product['price']) ?></span>
                    <?php else: ?>
                        <?= formatRupiah($product['price']) ?>
                    <?php endif; ?>
                </p>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</section>
