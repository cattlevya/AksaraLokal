<?php

?>
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="font-serif text-3xl text-taupe-dark italic">Manage Users</h1>
        <p class="text-taupe-mid text-sm mt-1">Total network identities: <?= $totalUsers ?></p>
    </div>
</div>

<div class="bg-white rounded-xl border border-taupe-light/30 shadow-sm overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-taupe-cream/30 text-taupe-dark text-xs uppercase tracking-wider">
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">ID</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Username</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Email</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Role</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30">Joined</th>
                    <th class="py-4 px-6 font-medium border-b border-taupe-light/30 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-taupe-light/20">
                <?php foreach ($users as $u): ?>
                    <tr class="hover:bg-off-white transition-colors group">
                        <td class="py-4 px-6 text-taupe-mid font-mono text-xs">#<?= $u['id'] ?></td>
                        <td class="py-4 px-6 text-taupe-dark font-medium"><?= e($u['username']) ?></td>
                        <td class="py-4 px-6 text-taupe-mid"><?= e($u['email']) ?></td>
                        <td class="py-4 px-6">
                            <?php 
                                $bgClass = $u['role'] === 'admin' ? 'bg-taupe-dark text-off-white' : ($u['role'] === 'seller' ? 'bg-taupe-mid text-off-white' : 'bg-taupe-cream/60 text-taupe-dark border border-taupe-light/30');
                            ?>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest <?= $bgClass ?>">
                                <?= e($u['role']) ?>
                            </span>
                        </td>
                        <td class="py-4 px-6 text-taupe-mid text-xs"><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <?php if ((int)$u['id'] !== (int)$_SESSION['user_id']): ?>
                                    
                                    <form action="<?= BASE_URL ?>/admin_users.php" method="POST" class="inline">
                                        <?= csrfField() ?>
                                        <input type="hidden" name="action" value="update_role">
                                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                        <select name="role" class="text-xs p-1 border border-taupe-light rounded" onchange="this.form.submit()">
                                            <option value="buyer" <?= $u['role'] === 'buyer' ? 'selected' : '' ?>>Buyer</option>
                                            <option value="seller" <?= $u['role'] === 'seller' ? 'selected' : '' ?>>Seller</option>
                                            <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                        </select>
                                    </form>

                                    
                                    <form action="<?= BASE_URL ?>/admin_users.php" method="POST" class="inline" onsubmit="return confirm('WARNING: Permanently delete this user? This cannot be undone.')">
                                        <?= csrfField() ?>
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                        <button type="submit" class="p-1.5 text-taupe-mid hover:text-taupe-dark hover:bg-taupe-cream/50 rounded transition-colors" title="Delete User">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-xs text-taupe-mid italic">You (Current Session)</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($users)): ?>
                    <tr><td colspan="6" class="py-8 text-center text-taupe-mid text-sm">No users found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    
    <?php if ($totalPages > 1): ?>
    <div class="px-6 py-4 border-t border-taupe-light/30 bg-off-white flex justify-between items-center">
        <span class="text-xs text-taupe-mid uppercase tracking-wide">
            Page <?= $page ?> of <?= $totalPages ?>
        </span>
        <div class="flex items-center gap-2">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="px-3 py-1.5 text-xs font-medium bg-white border border-taupe-light rounded text-taupe-dark hover:bg-taupe-cream/30 transition-colors no-underline">Prev</a>
            <?php else: ?>
                <button disabled class="px-3 py-1.5 text-xs font-medium bg-off-white border border-taupe-light/50 rounded text-taupe-mid/50 cursor-not-allowed">Prev</button>
            <?php endif; ?>
            
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>" class="px-3 py-1.5 text-xs font-medium bg-white border border-taupe-light rounded text-taupe-dark hover:bg-taupe-cream/30 transition-colors no-underline">Next</a>
            <?php else: ?>
                <button disabled class="px-3 py-1.5 text-xs font-medium bg-off-white border border-taupe-light/50 rounded text-taupe-mid/50 cursor-not-allowed">Next</button>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
