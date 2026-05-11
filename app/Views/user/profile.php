<?php
ob_start();
?>

<div class="max-w-5xl mx-auto">
    <div class="bg-zinc-900 border border-zinc-800 rounded-3xl overflow-hidden mb-8">
        <div class="h-32 bg-gradient-to-r from-indigo-600 to-purple-600"></div>
        <div class="px-8 pb-8 -mt-12">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="flex items-end gap-6">
                    <div class="w-32 h-32 bg-zinc-800 rounded-2xl border-4 border-zinc-900 shadow-xl flex items-center justify-center">
                        <i data-lucide="user" class="w-16 h-16 text-zinc-600"></i>
                    </div>
                    <div class="mb-2">
                        <h1 class="text-3xl font-bold"><?php echo $user['full_name'] ?: $user['username']; ?></h1>
                        <p class="text-zinc-500">@<?php echo $user['username']; ?></p>
                    </div>
                </div>
                <div class="flex gap-2 mb-2">
                    <div class="bg-zinc-950/50 border border-zinc-800 px-4 py-2 rounded-xl text-center">
                        <p class="text-xs text-zinc-500 uppercase font-bold tracking-wider">Pastes</p>
                        <p class="text-xl font-bold"><?php echo count($pastes); ?></p>
                    </div>
                    <div class="bg-zinc-950/50 border border-zinc-800 px-4 py-2 rounded-xl text-center">
                        <p class="text-xs text-zinc-500 uppercase font-bold tracking-wider">Joined</p>
                        <p class="text-xl font-bold"><?php echo date('M Y', strtotime($user['created_at'])); ?></p>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2">
                    <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                        <i data-lucide="layers" class="text-indigo-500 w-5 h-5"></i>
                        Public Pastes
                    </h2>

                    <div class="space-y-3">
                        <?php if (empty($pastes)): ?>
                            <p class="text-zinc-500 italic">No public pastes yet.</p>
                        <?php else: ?>
                            <?php foreach ($pastes as $p): ?>
                                <a href="/v/<?php echo $p['slug']; ?>" class="block bg-zinc-950 border border-zinc-800 hover:border-indigo-500/50 p-4 rounded-2xl transition-all group">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-bold group-hover:text-indigo-400 transition-colors"><?php echo htmlspecialchars($p['title']); ?></h3>
                                            <p class="text-xs text-zinc-500 mt-1"><?php echo $p['language']; ?> • <?php echo date('M j, Y', strtotime($p['created_at'])); ?></p>
                                        </div>
                                        <i data-lucide="chevron-right" class="w-5 h-5 text-zinc-700 group-hover:text-indigo-500 transition-colors"></i>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                        <i data-lucide="info" class="text-indigo-500 w-5 h-5"></i>
                        About
                    </h2>
                    <div class="bg-zinc-950 border border-zinc-800 p-6 rounded-2xl text-sm text-zinc-400 leading-relaxed">
                        <?php echo $user['bio'] ?: 'No bio provided.'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
