<?php
ob_start();
?>

<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold">Manage Users</h1>
        <a href="<?php echo $base; ?>/admin" class="text-sm text-indigo-400 hover:underline flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Admin
        </a>
    </div>

    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl overflow-hidden shadow-xl mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-950/50 text-zinc-500 uppercase text-[10px] font-bold tracking-widest">
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Joined</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    <?php foreach ($users as $u): ?>
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-zinc-200 dark:bg-zinc-800 rounded-lg flex items-center justify-center font-bold text-xs text-indigo-400 overflow-hidden">
                                        <?php
                                            $avatar = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($u['email']))) . '?d=mp&s=40';
                                        ?>
                                        <img src="<?php echo $avatar; ?>" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <div class="font-medium text-zinc-900 dark:text-zinc-200"><?php echo \App\Helpers\View::e($u['username']); ?></div>
                                        <div class="text-[10px] text-zinc-500"><?php echo \App\Helpers\View::e($u['full_name']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-zinc-400"><?php echo htmlspecialchars($u['email']); ?></td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider <?php echo $u['role'] === 'admin' ? 'bg-amber-500/10 text-amber-500 border border-amber-500/20' : ($u['role'] === 'moderator' ? 'bg-blue-500/10 text-blue-500 border border-blue-500/20' : 'bg-zinc-800 text-zinc-400'); ?>">
                                    <?php echo $u['role']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-zinc-500"><?php echo date('M j, Y', strtotime($u['created_at'])); ?></td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="<?php echo $base; ?>/u/<?php echo $u['username']; ?>" class="p-2 hover:bg-zinc-800 rounded-lg text-zinc-500 hover:text-white transition-colors" title="View Profile">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                    <?php if ($u['id'] != $_SESSION['user_id'] && $_SESSION['role'] === 'admin'): ?>
                                        <form action="<?php echo $base; ?>/admin/users/delete/<?php echo $u['id']; ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this user and all their pastes?')">
                                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                            <button class="p-2 hover:bg-red-500/10 rounded-lg text-zinc-500 hover:text-red-500 transition-colors" title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (isset($totalPages) && $totalPages > 1): ?>
    <div class="flex justify-center items-center gap-2 mt-8">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>" class="p-2 bg-zinc-900 border border-zinc-800 rounded-lg hover:text-indigo-400">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </a>
        <?php endif; ?>
        <span class="text-xs font-bold px-4 py-2 bg-zinc-950 border border-zinc-800 rounded-lg">Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>
        <?php if ($page < $totalPages): ?>
            <a href="?page=<?php echo $page + 1; ?>" class="p-2 bg-zinc-900 border border-zinc-800 rounded-lg hover:text-indigo-400">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
