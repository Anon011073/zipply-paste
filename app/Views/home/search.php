<?php
ob_start();
?>

<div class="max-w-4xl mx-auto">
    <div class="mb-12">
        <h1 class="text-3xl font-bold mb-6">Discover Pastes</h1>
        <form action="<?php echo $base; ?>/search" method="GET" class="relative">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-500 w-5 h-5"></i>
            <input type="text" name="q" value="<?php echo htmlspecialchars($query); ?>" placeholder="Search public pastes..." class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-white rounded-2xl pl-12 pr-4 py-4 focus:outline-none focus:border-indigo-500 transition-all text-lg shadow-xl">
        </form>
    </div>

    <div class="space-y-4">
        <h2 class="text-xl font-bold flex items-center gap-2 mb-4">
            <i data-lucide="trending-up" class="text-indigo-500 w-5 h-5"></i>
            <?php echo empty($query) ? 'Recent Public Pastes' : 'Search Results'; ?>
        </h2>

        <?php if (empty($pastes)): ?>
            <div class="bg-white dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 p-12 rounded-3xl text-center">
                <i data-lucide="file-x" class="w-12 h-12 text-zinc-700 mx-auto mb-4"></i>
                <p class="text-zinc-500">No pastes found.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($pastes as $p): ?>
                    <a href="<?php echo $base; ?>/v/<?php echo $p['slug']; ?>" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-indigo-500/50 p-5 rounded-2xl transition-all group shadow-sm">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="font-bold group-hover:text-indigo-400 transition-colors truncate pr-4 text-zinc-900 dark:text-zinc-100"><?php echo htmlspecialchars($p['title']); ?></h3>
                            <span class="bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider"><?php echo $p['language']; ?></span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-zinc-500">
                            <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3 h-3"></i> <?php echo date('M j', strtotime($p['created_at'])); ?></span>
                            <span class="flex items-center gap-1"><i data-lucide="eye" class="w-3 h-3"></i> <?php echo $p['views'] ?? 0; ?> views</span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
