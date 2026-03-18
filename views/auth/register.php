<?php

?>
<section class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-2xl border border-taupe-light/30 p-8 shadow-sm">
        <div class="text-center mb-8">
            <h1 class="font-serif text-3xl text-taupe-dark italic mb-2">Join Aksara Lokal</h1>
            <p class="text-sm text-taupe-mid">Create your account to start shopping</p>
        </div>

        <?php if (!empty($error)): ?>
        <div class="bg-taupe-cream/30 border border-taupe-mid/30 text-[#7a5c3a] text-sm rounded-lg px-4 py-3 mb-6"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/register.php">
            <?= csrfField() ?>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-taupe-dark mb-1.5">Username</label>
                    <input type="text" name="username" required value="<?= e($_POST['username'] ?? '') ?>"
                           class="w-full px-4 py-3 rounded-lg border border-taupe-light bg-off-white text-sm text-taupe-dark placeholder-taupe-mid/50 focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/30 transition-all"
                           placeholder="Choose a username">
                </div>
                <div>
                    <label class="block text-sm font-medium text-taupe-dark mb-1.5">Email</label>
                    <input type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>"
                           class="w-full px-4 py-3 rounded-lg border border-taupe-light bg-off-white text-sm text-taupe-dark placeholder-taupe-mid/50 focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/30 transition-all"
                           placeholder="your@email.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-taupe-dark mb-1.5">Password</label>
                    <input type="password" name="password" required minlength="6"
                           class="w-full px-4 py-3 rounded-lg border border-taupe-light bg-off-white text-sm text-taupe-dark placeholder-taupe-mid/50 focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/30 transition-all"
                           placeholder="Minimum 6 characters">
                </div>
                <div>
                    <label class="block text-sm font-medium text-taupe-dark mb-1.5">Role</label>
                    <select name="role" class="w-full px-4 py-3 rounded-lg border border-taupe-light bg-off-white text-sm text-taupe-dark focus:outline-none focus:border-taupe-mid transition-all">
                        <option value="buyer">Buyer</option>
                        <option value="seller">Seller</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-taupe-dark mb-1.5">Phone</label>
                    <input type="text" name="phone" value="<?= e($_POST['phone'] ?? '') ?>"
                           class="w-full px-4 py-3 rounded-lg border border-taupe-light bg-off-white text-sm text-taupe-dark placeholder-taupe-mid/50 focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/30 transition-all"
                           placeholder="08xxx">
                </div>
                <div>
                    <label class="block text-sm font-medium text-taupe-dark mb-1.5">Address</label>
                    <textarea name="address" rows="2"
                              class="w-full px-4 py-3 rounded-lg border border-taupe-light bg-off-white text-sm text-taupe-dark placeholder-taupe-mid/50 focus:outline-none focus:border-taupe-mid focus:ring-1 focus:ring-taupe-mid/30 transition-all resize-none"
                              placeholder="Your shipping address"><?= e($_POST['address'] ?? '') ?></textarea>
                </div>
            </div>

            <button type="submit" name="register"
                    class="w-full mt-6 py-3 bg-taupe-dark text-off-white rounded-lg font-medium text-sm tracking-wider uppercase hover:bg-[#7a6a58] transition-colors">
                Create Account
            </button>
        </form>

        <p class="text-center text-sm text-taupe-mid mt-6">
            Already have an account? 
            <a href="<?= BASE_URL ?>/login.php" class="text-taupe-dark font-medium hover:underline">Sign in</a>
        </p>
    </div>
</section>
