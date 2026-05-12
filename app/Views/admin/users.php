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

    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl overflow-hidden shadow-xl">
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
                                <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider <?php echo $u['role'] === 'admin' ? 'bg-amber-500/10 text-amber-500 border border-amber-500/20' : 'bg-zinc-800 text-zinc-400'; ?>">
                                    <?php echo $u['role']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-zinc-500"><?php echo date('M j, Y', strtotime($u['created_at'])); ?></td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="<?php echo $base; ?>/u/<?php echo $u['username']; ?>" class="p-2 hover:bg-zinc-800 rounded-lg text-zinc-500 hover:text-white transition-colors" title="View Profile">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                    <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                        <button class="p-2 hover:bg-red-500/10 rounded-lg text-zinc-500 hover:text-red-500 transition-colors" title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
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

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
