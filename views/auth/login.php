<?php

?>
<section class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-2xl border border-taupe-light/30 p-8 shadow-sm">
        <div class="text-center mb-8">
            <h1 class="font-serif text-3xl text-taupe-dark italic mb-2">Welcome Back</h1>
            <p class="text-sm text-taupe-mid">Sign in to your Aksara Lokal account</p>
        </div>

        <?php if (!empty($error)): ?>
        <div class="bg-taupe-cream/30 border border-taupe-mid/30 text-[#7a5c3a] text-sm rounded-lg px-4 py-3 mb-6"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/login.php">
            <?= csrfField() ?>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-taupe-dark mb-1.5">Username</label>
                    <input type="text" name="username" required autofocus
                           value="<?= e($_POST['username'] ?? '') ?>"
                           class="w-full px-4 py-3 rounded-lg border border-taupe-light bg-off-white text-sm text-taupe-dark placeholder-taupe-mid/50 focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/30 transition-all"
                           placeholder="Enter your username">
                </div>
                <div>
                    <label class="block text-sm font-medium text-taupe-dark mb-1.5">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 rounded-lg border border-taupe-light bg-off-white text-sm text-taupe-dark placeholder-taupe-mid/50 focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/30 transition-all"
                           placeholder="Enter your password">
                </div>
            </div>

            <button type="submit" name="login"
                    class="w-full mt-6 py-3 bg-taupe-dark text-off-white rounded-lg font-medium text-sm tracking-wider uppercase hover:bg-[#7a6a58] transition-colors">
                Sign In
            </button>
        </form>

        <p class="text-center text-sm text-taupe-mid mt-6">
            Don't have an account? 
            <a href="<?= BASE_URL ?>/register.php" class="text-taupe-dark font-medium hover:underline">Create one</a>
        </p>
    </div>
</section>
