<?php
ob_start();
?>

<div class="max-w-5xl mx-auto">
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl overflow-hidden mb-8">
        <div class="h-32 bg-gradient-to-r from-indigo-600 to-purple-600"></div>
        <div class="px-8 pb-8 -mt-12">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="flex items-end gap-6">
                    <div class="w-32 h-32 bg-zinc-200 dark:bg-zinc-800 rounded-2xl border-4 border-white dark:border-zinc-900 shadow-xl flex items-center justify-center overflow-hidden">
                        <?php
                            $hash = md5(strtolower(trim($user['email'])));
                            $avatar = $user['avatar'] ?: "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
                        ?>
                        <img src="<?php echo \App\Helpers\View::e($avatar); ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="mb-2">
                        <div class="flex items-center gap-2">
                            <h1 class="text-3xl font-bold"><?php echo \App\Helpers\View::e($user['full_name'] ?: $user['username']); ?></h1>
                            <?php if ($user['role'] === 'admin'): ?>
                                <span class="bg-amber-500/10 text-amber-500 text-[10px] font-bold uppercase px-2 py-0.5 rounded-full border border-amber-500/20">Admin</span>
                            <?php endif; ?>
                        </div>
                        <p class="text-zinc-500">@<?php echo \App\Helpers\View::e($user['username']); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-4 mb-2">
                    <div class="flex gap-2">
                        <div class="bg-zinc-50 dark:bg-zinc-950/50 border border-zinc-200 dark:border-zinc-800 px-4 py-2 rounded-xl text-center">
                            <p class="text-xs text-zinc-500 uppercase font-bold tracking-wider">Pastes</p>
                            <p class="text-xl font-bold dark:text-white text-zinc-900"><?php echo count($pastes); ?></p>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-950/50 border border-zinc-200 dark:border-zinc-800 px-4 py-2 rounded-xl text-center">
                            <p class="text-xs text-zinc-500 uppercase font-bold tracking-wider">Joined</p>
                            <p class="text-xl font-bold dark:text-white text-zinc-900"><?php echo date('M Y', strtotime($user['created_at'])); ?></p>
                        </div>
                    </div>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user['id']): ?>
                        <a href="<?php echo $base; ?>/profile/edit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                            <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Profile
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold flex items-center gap-2">
                            <i data-lucide="layers" class="text-indigo-500 w-5 h-5"></i>
                            Public Pastes
                        </h2>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user['id']): ?>
                            <a href="<?php echo $base; ?>/user/pastes" class="text-xs font-bold text-indigo-400 hover:underline">Manage All</a>
                        <?php endif; ?>
                    </div>

                    <div class="space-y-3">
                        <?php if (empty($pastes)): ?>
                            <p class="text-zinc-500 italic">No public pastes yet.</p>
                        <?php else: ?>
                            <?php foreach ($pastes as $p): ?>
                                <a href="<?php echo $base; ?>/v/<?php echo $p['slug']; ?>" class="block bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-indigo-500/50 p-4 rounded-2xl transition-all group">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-bold group-hover:text-indigo-400 transition-colors text-zinc-900 dark:text-zinc-100"><?php echo htmlspecialchars($p['title']); ?></h3>
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
                    <div class="bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 p-6 rounded-2xl text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        <?php echo \App\Helpers\View::e($user['bio'] ?: 'No bio provided.'); ?>
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
