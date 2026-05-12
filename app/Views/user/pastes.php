<?php
ob_start();
?>

<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold">My Pastes</h1>
        <a href="<?php echo $base; ?>/dashboard" class="text-sm text-indigo-400 hover:underline flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Dashboard
        </a>
    </div>

    <div class="bg-zinc-900 border border-zinc-800 rounded-3xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <?php if (empty($pastes)): ?>
                <div class="p-24 text-center text-zinc-500">
                    <i data-lucide="file-x" class="w-16 h-16 mx-auto mb-4 opacity-10"></i>
                    <p>No pastes found.</p>
                </div>
            <?php else: ?>
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-zinc-950/50 text-zinc-500 uppercase text-[10px] font-bold tracking-widest">
                            <th class="px-6 py-4">Title</th>
                            <th class="px-6 py-4">Language</th>
                            <th class="px-6 py-4">Visibility</th>
                            <th class="px-6 py-4">Views</th>
                            <th class="px-6 py-4">Created</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800">
                        <?php foreach($pastes as $p): ?>
                            <tr class="hover:bg-zinc-800/30 transition-colors">
                                <td class="px-6 py-4 font-medium"><a href="<?php echo $base; ?>/v/<?php echo $p['slug']; ?>" class="hover:text-indigo-400"><?php echo \App\Helpers\View::e($p['title']); ?></a></td>
                                <td class="px-6 py-4 text-zinc-400 uppercase text-[10px] font-bold"><?php echo $p['language']; ?></td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase <?php echo $p['visibility'] === 'public' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-zinc-800 text-zinc-500'; ?>">
                                        <?php echo $p['visibility']; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-zinc-500"><?php echo $p['views']; ?></td>
                                <td class="px-6 py-4 text-zinc-500"><?php echo date('M j, Y', strtotime($p['created_at'])); ?></td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="<?php echo $base; ?>/clone/<?php echo $p['slug']; ?>" class="p-2 hover:bg-zinc-800 rounded-lg text-zinc-500 hover:text-white transition-colors" title="Clone">
                                            <i data-lucide="copy" class="w-4 h-4"></i>
                                        </a>
                                        <button class="p-2 hover:bg-red-500/10 rounded-lg text-zinc-500 hover:text-red-500 transition-colors" title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
