<?php
ob_start();
?>

<div class="max-w-md mx-auto py-12">
    <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-2xl shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold">Welcome Back</h1>
            <p class="text-zinc-500 text-sm">Login to your account</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-500/10 border border-red-500/50 text-red-500 p-3 rounded-lg text-sm mb-6">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div>
                <label class="block text-sm font-medium text-zinc-400 mb-1">Username</label>
                <input type="text" name="username" required class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 transition-colors">
            </div>
            <div>
                <label class="block text-sm font-medium text-zinc-400 mb-1">Password</label>
                <input type="password" name="password" required class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 transition-colors">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition-all shadow-lg shadow-indigo-500/20 mt-4">
                Login
            </button>
        </form>

        <p class="text-center mt-6 text-sm text-zinc-500">
            Don't have an account? <a href="/register" class="text-indigo-400 hover:underline">Sign up</a>
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
