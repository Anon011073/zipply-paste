<?php
ob_start();
?>

<div class="max-w-md mx-auto py-24">
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-8 rounded-3xl shadow-2xl">
        <h1 class="text-2xl font-bold mb-2 text-zinc-900 dark:text-white">Set New Password</h1>
        <p class="text-zinc-500 text-sm mb-8">Please enter your new password below.</p>

        <?php if (isset($error)): ?>
            <div class="bg-red-500/10 border border-red-500/50 text-red-500 p-3 rounded-lg text-sm mb-6">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo $base; ?>/reset-password" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="token" value="<?php echo \App\Helpers\View::e($token); ?>">

            <div>
                <label class="block text-xs font-bold text-zinc-500 uppercase tracking-widest mb-2 ml-1">New Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-white rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-zinc-500 uppercase tracking-widest mb-2 ml-1">Confirm Password</label>
                <input type="password" name="confirm_password" required placeholder="••••••••" class="w-full bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-white rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-all">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-indigo-500/20 mt-4">
                Update Password
            </button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
