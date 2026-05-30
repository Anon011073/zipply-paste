<?php
ob_start();
?>

<div class="max-w-4xl mx-auto text-center py-12">
    <h1 class="text-4xl md:text-6xl font-black mb-6 bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400 bg-clip-text text-transparent italic tracking-tight">
        Simple, Fast, Secure Pasting.
    </h1>
    <p class="text-zinc-400 text-lg mb-10 max-w-2xl mx-auto leading-relaxed">
        Share code, notes, and snippets instantly with our lightweight, modern pastebin platform.
    </p>

    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-20">
        <a href="<?php echo $base; ?>/paste/new" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-5 rounded-2xl text-lg font-bold transition-all shadow-2xl shadow-indigo-500/30">
            <i data-lucide="plus-circle" class="w-6 h-6"></i>
            Create New Paste
        </a>
        <a href="#discover" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-white px-10 py-5 rounded-2xl text-lg font-bold transition-all hover:border-zinc-300 dark:hover:border-zinc-700">
            <i data-lucide="search" class="w-6 h-6"></i>
            Browse Public
        </a>
    </div>

    <div id="discover" class="text-left scroll-mt-24">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold flex items-center gap-3">
                <i data-lucide="globe" class="text-indigo-500"></i>
                Public Snippets
            </h2>
            <div class="text-xs font-bold text-zinc-500 uppercase tracking-widest bg-zinc-100 dark:bg-zinc-900 px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-800">
                Latest Activity
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach($recent as $r): ?>
                <a href="<?php echo $base; ?>/v/<?php echo $r['slug']; ?>" class="group block bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 rounded-2xl hover:border-indigo-500/50 transition-all duration-300 shadow-sm hover:shadow-xl hover:shadow-indigo-500/5">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="file-code" class="text-indigo-500 w-5 h-5"></i>
                        </div>
                        <span class="px-2 py-1 bg-zinc-100 dark:bg-zinc-950 rounded-md text-[10px] font-black uppercase tracking-tighter text-zinc-500">
                            <?php echo \App\Helpers\View::e($r['language']); ?>
                        </span>
                    </div>
                    <h3 class="font-bold text-zinc-900 dark:text-zinc-100 mb-2 truncate group-hover:text-indigo-400 transition-colors">
                        <?php echo \App\Helpers\View::e($r['title']); ?>
                    </h3>
                    <div class="flex items-center gap-4 text-[10px] font-bold text-zinc-400 uppercase tracking-widest">
                        <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3 h-3"></i> <?php echo date('M j, Y', strtotime($r['created_at'])); ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="mt-12 flex justify-center items-center gap-2">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>#discover" class="p-3 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl hover:text-indigo-500 transition-colors">
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </a>
                <?php endif; ?>

                <div class="px-6 py-3 bg-zinc-100 dark:bg-zinc-900 rounded-xl text-sm font-bold border border-zinc-200 dark:border-zinc-800">
                    Page <?php echo $page; ?> of <?php echo $totalPages; ?>
                </div>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?>#discover" class="p-3 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl hover:text-indigo-500 transition-colors">
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
