<?php
/**
 * Products Listing View
 * Variables: $products, $categories, $filters, $page, $totalPages, $totalData, $pageTitle
 */
?>
<section class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex flex-col md:flex-row gap-8">
        
        <!-- Sidebar: Filters -->
        <aside class="md:w-[280px] shrink-0 self-start sticky top-24 z-10">
            <style>
                /* Hide scrollbar for Sidebar */
                .filter-sidebar::-webkit-scrollbar { display: none; }
                .filter-sidebar { -ms-overflow-style: none; scrollbar-width: none; }
            </style>
            
            <form action="<?= BASE_URL ?>/products.php" method="GET" id="filter-form" 
                  class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-sm border border-taupe-light/30 p-6 filter-sidebar max-h-[calc(100vh-8rem)] overflow-y-auto overscroll-y-contain">
                
                <!-- Retain search query if exists -->
                <?php if (!empty($filters['keyword'])): ?>
                    <input type="hidden" name="q" value="<?= e($filters['keyword']) ?>">
                <?php endif; ?>

                <div class="flex items-center justify-between mb-8">
                    <h3 class="font-serif text-xl italic text-taupe-dark">Refine By</h3>
                    <?php if (array_filter($filters)): ?>
                        <a href="<?= BASE_URL ?>/products.php" class="text-xs uppercase tracking-wider font-semibold text-taupe-mid hover:text-taupe-dark transition-colors">Clear All</a>
                    <?php endif; ?>
                </div>

                <!-- Sort -->
                <div class="mb-8">
                    <label class="block text-xs uppercase tracking-widest font-semibold text-taupe-mid mb-3">Sort Order</label>
                    <div class="relative">
                        <select name="sort" class="w-full appearance-none rounded-xl border-dashed border-2 border-taupe-light/50 bg-transparent text-sm text-taupe-dark focus:ring-0 focus:border-taupe-mid h-11 pl-4 pr-10 outline-none transition-colors cursor-pointer" onchange="this.form.submit()">
                            <option value="newest" <?= $filters['sort'] === 'newest' ? 'selected' : '' ?>>Newest First</option>
                            <option value="price_asc" <?= $filters['sort'] === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                            <option value="price_desc" <?= $filters['sort'] === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-taupe-mid">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div class="mb-8">
                    <label class="block text-xs uppercase tracking-widest font-semibold text-taupe-mid mb-4">Collection</label>
                    <div class="space-y-1">
                        <!-- All Products Option -->
                        <label class="block relative cursor-pointer group">
                            <input type="radio" name="category" value="" class="peer sr-only" <?= empty($filters['category']) ? 'checked' : '' ?> onchange="this.form.submit()">
                            <div class="flex items-center gap-3 p-2.5 rounded-xl transition-all peer-checked:bg-taupe-cream/50 peer-checked:text-taupe-dark text-taupe-mid hover:bg-neutral-50">
                                <span class="w-4 h-4 shrink-0 rounded-full border border-taupe-mid/40 flex items-center justify-center peer-checked:border-taupe-dark transition-colors">
                                    <span class="w-2 h-2 rounded-full bg-taupe-dark opacity-0 peer-checked:opacity-100 transition-opacity"></span>
                                </span>
                                <span class="text-sm font-medium tracking-wide">All Artworks</span>
                            </div>
                        </label>
                        
                        <?php foreach ($categories as $cat): ?>
                        <label class="block relative cursor-pointer group">
                            <input type="radio" name="category" value="<?= $cat['id'] ?>" class="peer sr-only" <?= $filters['category'] == $cat['id'] ? 'checked' : '' ?> onchange="this.form.submit()">
                            <div class="flex items-center gap-3 p-2.5 rounded-xl transition-all peer-checked:bg-taupe-cream/50 peer-checked:text-taupe-dark text-taupe-mid hover:bg-neutral-50">
                                <span class="w-4 h-4 shrink-0 rounded-full border border-taupe-mid/40 flex items-center justify-center peer-checked:border-taupe-dark transition-colors">
                                    <span class="w-2 h-2 rounded-full bg-taupe-dark opacity-0 peer-checked:opacity-100 transition-opacity"></span>
                                </span>
                                <span class="text-sm font-medium tracking-wide"><?= e($cat['name']) ?></span>
                            </div>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Price Range -->
                <div class="mb-8">
                    <label class="block text-xs uppercase tracking-widest font-semibold text-taupe-mid mb-4">Price Range</label>
                    <div class="flex items-center gap-3">
                        <div class="relative flex-1 group">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-taupe-mid/60 font-medium group-focus-within:text-taupe-dark transition-colors">Rp</span>
                            <input type="number" name="min_price" placeholder="Min" min="0" 
                                   value="<?= $filters['min_price'] !== null ? e($filters['min_price']) : '' ?>"
                                   class="w-full bg-neutral-50 border border-transparent rounded-xl h-11 pl-8 pr-2 text-sm text-taupe-dark focus:bg-white focus:border-taupe-light focus:ring-4 focus:ring-taupe-cream transition-all placeholder-taupe-light/70 outline-none">
                        </div>
                        <span class="text-taupe-light/50 font-light">—</span>
                        <div class="relative flex-1 group">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-taupe-mid/60 font-medium group-focus-within:text-taupe-dark transition-colors">Rp</span>
                            <input type="number" name="max_price" placeholder="Max" min="0" 
                                   value="<?= $filters['max_price'] !== null ? e($filters['max_price']) : '' ?>"
                                   class="w-full bg-neutral-50 border border-transparent rounded-xl h-11 pl-8 pr-2 text-sm text-taupe-dark focus:bg-white focus:border-taupe-light focus:ring-4 focus:ring-taupe-cream transition-all placeholder-taupe-light/70 outline-none">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-taupe-dark hover:bg-[#7a6a58] text-white rounded-xl py-3.5 text-sm font-medium tracking-wide transition-all shadow-md hover:shadow-lg active:scale-[0.98]">
                    Apply Refinements
                </button>
            </form>
        </aside>

        <!-- Product Grid -->
        <div class="flex-1 flex flex-col justify-between">
            <div>
                <div class="flex items-end justify-between mb-6 pb-4 border-b border-taupe-light/30">
                    <h2 class="font-serif text-3xl text-taupe-dark italic">
                        <?= e($pageTitle) ?>
                    </h2>
                    <span class="text-sm text-taupe-mid mb-1">Showing <?= count($products) ?> of <?= $totalData ?> items</span>
                </div>

                <?php if (empty($products)): ?>
                <div class="text-center py-20 bg-white rounded-xl border border-taupe-light/30">
                    <svg class="w-12 h-12 mx-auto text-taupe-light mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <h3 class="text-lg font-serif italic text-taupe-dark mb-2">No products found</h3>
                    <p class="text-sm text-taupe-mid">Try adjusting your filters or search query.</p>
                </div>
                <?php else: ?>
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-10">
                    <?php foreach ($products as $product): ?>
                    <a href="<?= BASE_URL ?>/product_detail.php?id=<?= $product['id'] ?>" class="product-card group block">
                        <div class="relative aspect-[3/4] rounded-lg overflow-hidden bg-warm-gray mb-3 border border-taupe-light/20">
                            <img src="<?= BASE_URL ?>/assets/images/<?= e($product['image']) ?>" 
                                 alt="<?= e($product['name']) ?>"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 onerror="this.src='<?= BASE_URL ?>/assets/images/default.jpg'">
                            
                            <?php if ($product['flash_sale_price'] && strtotime($product['flash_sale_end']) > time()): ?>
                            <div class="absolute top-2 right-2 flash-badge flex items-center gap-1.5 px-2 py-1 rounded shadow-sm">
                                <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                <span class="text-[9px] tracking-wider uppercase text-white font-medium">Flash Sale</span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <h3 class="font-serif text-sm italic text-taupe-dark leading-snug group-hover:underline underline-offset-4 decoration-taupe-light/50"><?= e($product['name']) ?></h3>
                        <p class="text-[10px] tracking-wide uppercase text-taupe-mid/60 mt-0.5"><?= e($product['category_name'] ?? '') ?></p>
                        <p class="text-sm font-medium text-taupe-dark mt-1">
                            <?php if ($product['flash_sale_price'] && strtotime($product['flash_sale_end']) > time()): ?>
                                <span class="text-red-700"><?= formatRupiah($product['flash_sale_price']) ?></span>
                                <span class="text-taupe-mid/50 line-through text-xs ml-1"><?= formatRupiah($product['price']) ?></span>
                            <?php else: ?>
                                <?= formatRupiah($product['price']) ?>
                            <?php endif; ?>
                        </p>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Pagination Controls -->
            <?php if ($totalPages > 1): ?>
            <div class="mt-8 flex items-center justify-center gap-2">
                <?php 
                // Build current query params to preserve filters on page links
                $params = $_GET;
                unset($params['page']);
                $queryString = http_build_query($params);
                $queryPrefix = $queryString ? '&' . $queryString : '';
                ?>
                
                <!-- Prev Button -->
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?><?= $queryPrefix ?>" class="w-10 h-10 flex items-center justify-center rounded-full border border-taupe-light text-taupe-dark hover:bg-taupe-cream transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                <?php else: ?>
                    <span class="w-10 h-10 flex items-center justify-center rounded-full border border-taupe-light/50 text-taupe-light cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </span>
                <?php endif; ?>

                <!-- Page Numbers -->
                <div class="flex items-center gap-1 mx-2">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?><?= $queryPrefix ?>" class="w-10 h-10 flex items-center justify-center rounded-full text-sm <?= $i === $page ? 'bg-taupe-dark text-white font-medium shadow-md' : 'text-taupe-mid hover:bg-taupe-cream hover:text-taupe-dark transition-colors' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>

                <!-- Next Button -->
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?><?= $queryPrefix ?>" class="w-10 h-10 flex items-center justify-center rounded-full border border-taupe-light text-taupe-dark hover:bg-taupe-cream transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                <?php else: ?>
                    <span class="w-10 h-10 flex items-center justify-center rounded-full border border-taupe-light/50 text-taupe-light cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>
