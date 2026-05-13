<?php
ob_start();
?>

<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold">Hello, <?php echo \App\Helpers\View::e($user['full_name'] ?: $user['username']); ?>!</h1>
            <p class="text-zinc-500">Welcome to your dashboard.</p>
        </div>
        <a href="<?php echo $base; ?>/paste/new" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2">
            <i data-lucide="plus"></i> New Paste
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 rounded-2xl shadow-sm">
            <p class="text-zinc-500 text-sm mb-1 font-medium">Total Pastes</p>
            <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100"><?php echo $stats['total']; ?></p>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 rounded-2xl shadow-sm">
            <p class="text-zinc-500 text-sm mb-1 font-medium">Total Views</p>
            <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100"><?php echo $stats['views']; ?></p>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 rounded-2xl shadow-sm">
            <p class="text-zinc-500 text-sm mb-1 font-medium">Public Pastes</p>
            <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100"><?php echo $stats['public']; ?></p>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 rounded-2xl shadow-sm">
            <p class="text-zinc-500 text-sm mb-1 font-medium">Private Pastes</p>
            <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100"><?php echo $stats['private']; ?></p>
        </div>
    </div>

    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
            <h2 class="font-bold text-zinc-900 dark:text-zinc-100">Recent Pastes</h2>
            <a href="<?php echo $base; ?>/user/pastes" class="text-sm text-indigo-400 hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
            <?php if (empty($recentPastes)): ?>
                <div class="p-12 text-center text-zinc-500">
                    <i data-lucide="file-text" class="w-12 h-12 mx-auto mb-4 opacity-20"></i>
                    <p>You haven't created any pastes yet.</p>
                </div>
            <?php else: ?>
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-zinc-950/50 text-zinc-500 uppercase text-[10px] font-bold tracking-widest">
                            <th class="px-6 py-4">Title</th>
                            <th class="px-6 py-4">Visibility</th>
                            <th class="px-6 py-4">Views</th>
                            <th class="px-6 py-4">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        <?php foreach($recentPastes as $p): ?>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors">
                                <td class="px-6 py-4 font-medium italic text-zinc-900 dark:text-zinc-100"><a href="<?php echo $base; ?>/v/<?php echo $p['slug']; ?>" class="hover:text-indigo-400"><?php echo htmlspecialchars($p['title']); ?></a></td>
                                <td class="px-6 py-4"><span class="px-2 py-0.5 bg-zinc-800 rounded text-[10px] uppercase font-bold text-zinc-400"><?php echo $p['visibility']; ?></span></td>
                                <td class="px-6 py-4 text-zinc-500"><?php echo $p['views']; ?></td>
                                <td class="px-6 py-4 text-zinc-500"><?php echo date('M j, Y', strtotime($p['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6">
            <h2 class="font-bold mb-4 flex items-center gap-2 text-zinc-900 dark:text-zinc-100">
                <i data-lucide="key" class="text-indigo-500 w-5 h-5"></i>
                API Keys
            </h2>
            <p class="text-sm text-zinc-500 mb-6">API keys allow you to create pastes programmatically.</p>
            <div class="space-y-4">
                <form action="<?php echo $base; ?>/api/keys" method="POST" class="flex items-center gap-2">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="text" name="key_name" required placeholder="Key Name (e.g. My Script)" class="flex-grow bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-indigo-500 text-zinc-900 dark:text-white">
                    <button type="submit" class="bg-emerald-600/10 text-emerald-500 border border-emerald-500/20 px-4 py-2 rounded-lg text-sm font-bold hover:bg-emerald-600/20 transition-all">
                        Create Key
                    </button>
                </form>
                <div class="space-y-2">
                    <?php foreach($apiKeys as $key): ?>
                        <div class="flex items-center justify-between bg-zinc-50 dark:bg-zinc-950 p-3 rounded-xl border border-zinc-200 dark:border-zinc-800">
                            <div>
                                <p class="text-xs font-bold text-zinc-900 dark:text-zinc-100"><?php echo htmlspecialchars($key['key_name']); ?></p>
                                <code class="text-[10px] text-zinc-500"><?php echo $key['api_key']; ?></code>
                            </div>
                            <button class="text-red-500 hover:text-red-400 p-1"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p class="text-[10px] text-zinc-600 italic">You can create up to 5 API keys.</p>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6">
            <h2 class="font-bold mb-4 flex items-center gap-2 text-zinc-900 dark:text-zinc-100">
                <i data-lucide="user-cog" class="text-indigo-500 w-5 h-5"></i>
                Profile Settings
            </h2>
            <div class="space-y-4">
                <a href="<?php echo $base; ?>/profile/edit" class="block w-full text-center bg-indigo-600/10 hover:bg-indigo-600/20 text-indigo-400 py-2 rounded-lg text-sm font-medium transition-colors border border-indigo-500/20">
                    Edit Profile / BIO
                </a>
                <a href="<?php echo $base; ?>/u/<?php echo $user['username']; ?>" class="block w-full text-center bg-zinc-800 hover:bg-zinc-700 text-white py-2 rounded-lg text-sm font-medium transition-colors">
                    View Public Profile
                </a>
                <form action="<?php echo $base; ?>/profile/delete" method="POST" onsubmit="return confirm('Are you absolutely sure? All your pastes will be permanently deleted.');">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <button type="submit" class="block w-full text-center bg-red-600/10 hover:bg-red-600/20 text-red-500 py-2 rounded-lg text-sm font-medium transition-colors border border-red-500/20">
                        Delete My Account
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
