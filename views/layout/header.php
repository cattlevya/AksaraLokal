<?php

$cartCount = getCartCount();
$user = currentUser();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Aksara Lokal') ?> — Aksara Lokal</title>
    <meta name="description" content="<?= e($pageDesc ?? 'Handpicked artisanal goods from across the Indonesian archipelago.') ?>">

    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'taupe-dark': '#8D7B68',
                        'taupe-mid': '#A4907C',
                        'taupe-light': '#C8B6A6',
                        'taupe-cream': '#F1DEC9',
                        'off-white': '#FAF9F6',
                    },
                    fontFamily: {
                        serif: ['Playfair Display', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #FAF9F6;
            color: #4A3F35;
        }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }

        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        .hero-gradient {
            background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.4));
        }

        .product-card:hover .product-image { transform: scale(1.02); }
        .product-image { transition: transform 0.5s ease; }

        /* DND Upload Area */
        .dnd-area {
            border: 2px dashed #C8B6A6;
            border-radius: 12px;
            padding: 32px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
        }
        .dnd-area:hover, .dnd-area.dragover {
            border-color: #8D7B68;
            background: rgba(241, 222, 201, 0.2);
        }

        /* Flash sale badge */
        .flash-badge {
            background: linear-gradient(135deg, #8D7B68, #6b5b4e);
            animation: pulse-flash 2s infinite;
        }
        @keyframes pulse-flash {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.85; }
        }
    </style>
</head>
<body class="pb-24">

    
    <header class="sticky top-0 z-50 bg-off-white/90 backdrop-blur-md border-b border-taupe-light/20">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col md:flex-row items-center justify-between gap-4">
            
            <a href="<?= BASE_URL ?>/" class="text-2xl font-serif tracking-widest uppercase text-taupe-dark no-underline">
                Aksara<span class="font-normal italic">Lokal</span>
            </a>

            
            <form action="<?= BASE_URL ?>/products.php" method="GET" class="relative w-full md:w-96">
                <input type="text" name="q" placeholder="Cari kerajinan tangan..."
                       value="<?= e($_GET['q'] ?? '') ?>"
                       class="w-full bg-taupe-cream/30 border-none rounded-full py-2 px-10 text-sm focus:ring-1 focus:ring-taupe-mid transition-all">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-taupe-mid">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </div>
            </form>
        </div>
    </header>

    
    <?php if ($flash): ?>
    <div id="toast-notif" class="fixed top-20 right-4 z-[60] max-w-sm animate-[slideIn_0.3s_ease] rounded-xl px-5 py-3 text-sm font-medium shadow-lg backdrop-blur-md bg-white/90 text-taupe-dark border border-taupe-light/40" onclick="this.remove()">
        <?= e($flash['message']) ?>
    </div>
    <style>
        @keyframes slideIn { from { opacity:0; transform:translateX(40px); } to { opacity:1; transform:translateX(0); } }
    </style>
    <script>setTimeout(()=>{ const t=document.getElementById('toast-notif'); if(t){ t.style.transition='opacity 0.3s'; t.style.opacity='0'; setTimeout(()=>t.remove(),300); } },3000);</script>
    <?php endif; ?>

    <main>
