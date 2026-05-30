<?php
ob_start();
?>

<div class="max-w-md mx-auto py-24">
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-8 rounded-3xl shadow-2xl">
        <h1 class="text-2xl font-bold mb-2 text-zinc-900 dark:text-white">Reset Password</h1>
        <p class="text-zinc-500 text-sm mb-8">Enter your email address and we'll send you a link to reset your password.</p>

        <?php if (isset($success)): ?>
            <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-500 p-3 rounded-lg text-sm mb-6">
                If an account exists for that email, a reset link has been sent.
            </div>
        <?php endif; ?>

        <form action="<?php echo $base; ?>/forgot-password" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="email" name="email" required placeholder="Email Address" class="w-full bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-white rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-all">
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-all">
                Send Reset Link
            </button>
        </form>

        <a href="<?php echo $base; ?>/login" class="block text-center mt-6 text-sm text-zinc-500 hover:text-white transition-colors flex items-center justify-center gap-1">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Login
        </a>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
