<?php

$user = currentUser();
$flash = getFlash();
$currentPage = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="id" class="overflow-y-scroll">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Admin Center') ?> — Aksara Lokal Admin</title>

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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #FAF9F6; color: #4A3F35; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }

        /* Bottom nav active indicator */
        .admin-bnav-link { position: relative; transition: color 0.2s; }
        .admin-bnav-link.active { color: #8D7B68; }
        .admin-bnav-link.active::before {
            content: '';
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 3px;
            background: #8D7B68;
            border-radius: 999px;
        }
        .admin-bnav-link:not(.active) { color: #A4907C; }
        .admin-bnav-link:not(.active):hover { color: #8D7B68; }
    </style>
</head>
<body class="min-h-screen pb-28">

    
    <header class="bg-taupe-dark text-off-white sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="<?= BASE_URL ?>/admin_dashboard.php" class="font-serif text-lg tracking-widest uppercase no-underline text-off-white">
                    Aksara<span class="font-normal italic">Lokal</span>
                </a>
                <span class="text-taupe-light/60 text-xs">|</span>
                <span class="text-taupe-cream text-xs font-medium tracking-wider uppercase">Admin Center</span>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-taupe-cream/80 hidden sm:inline">
                    <svg class="w-4 h-4 inline mr-1 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    <?= e($user['username']) ?>
                </span>
                <a href="<?= BASE_URL ?>/logout.php" class="text-xs text-taupe-cream/60 hover:text-off-white transition-colors no-underline">Logout</a>
            </div>
        </div>
    </header>

    
    <?php if ($flash): ?>
    <div id="toast-notif" class="fixed top-16 right-4 z-[60] max-w-sm animate-[slideIn_0.3s_ease] rounded-xl px-5 py-3 text-sm font-medium shadow-lg backdrop-blur-md <?= ($flash['type'] ?? '') === 'error' ? 'bg-taupe-dark/90 text-taupe-cream border border-taupe-mid' : 'bg-white/90 text-taupe-dark border border-taupe-light/40' ?>" onclick="this.remove()">
        <?= e($flash['message']) ?>
    </div>
    <style>@keyframes slideIn { from { opacity:0; transform:translateX(40px); } to { opacity:1; transform:translateX(0); } }</style>
    <script>setTimeout(()=>{ const t=document.getElementById('toast-notif'); if(t){ t.style.transition='opacity 0.3s'; t.style.opacity='0'; setTimeout(()=>t.remove(),300); } },4000);</script>
    <?php endif; ?>

    <main class="max-w-7xl mx-auto px-4 py-8">
