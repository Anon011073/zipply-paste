<?php
ob_start();
?>

<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold">Admin Dashboard</h1>
        <div class="flex gap-4">
            <a href="<?php echo $base; ?>/admin/users" class="bg-zinc-800 hover:bg-zinc-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Users</a>
            <a href="<?php echo $base; ?>/admin/settings" class="bg-zinc-800 hover:bg-zinc-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Settings</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-indigo-600 p-6 rounded-3xl text-white shadow-xl shadow-indigo-500/20">
            <div class="flex items-center justify-between mb-4">
                <i data-lucide="users" class="w-8 h-8 opacity-50"></i>
                <span class="text-xs font-bold uppercase tracking-widest opacity-70">Total Users</span>
            </div>
            <p class="text-4xl font-black"><?php echo $stats['users']; ?></p>
        </div>
        <div class="bg-purple-600 p-6 rounded-3xl text-white shadow-xl shadow-purple-500/20">
            <div class="flex items-center justify-between mb-4">
                <i data-lucide="file-text" class="w-8 h-8 opacity-50"></i>
                <span class="text-xs font-bold uppercase tracking-widest opacity-70">Total Pastes</span>
            </div>
            <p class="text-4xl font-black"><?php echo $stats['pastes']; ?></p>
        </div>
        <div class="bg-emerald-600 p-6 rounded-3xl text-white shadow-xl shadow-emerald-500/20">
            <div class="flex items-center justify-between mb-4">
                <i data-lucide="eye" class="w-8 h-8 opacity-50"></i>
                <span class="text-xs font-bold uppercase tracking-widest opacity-70">Total Views</span>
            </div>
            <p class="text-4xl font-black"><?php echo $stats['views']; ?></p>
        </div>
    </div>

    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl overflow-hidden shadow-xl">
        <div class="p-6 border-b border-zinc-200 dark:border-zinc-800">
            <h2 class="font-bold text-zinc-900 dark:text-zinc-100">Recent Activity</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-950/50 text-zinc-500 uppercase text-[10px] font-bold tracking-widest">
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Language</th>
                        <th class="px-6 py-4">Created</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    <?php foreach ($recentPastes as $p): ?>
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100"><?php echo htmlspecialchars($p['title']); ?></td>
                            <td class="px-6 py-4 text-zinc-500"><?php echo $p['language']; ?></td>
                            <td class="px-6 py-4 text-zinc-500"><?php echo date('M j, Y', strtotime($p['created_at'])); ?></td>
                            <td class="px-6 py-4">
                                <a href="<?php echo $base; ?>/v/<?php echo $p['slug']; ?>" class="text-indigo-400 hover:underline">View</a>
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
