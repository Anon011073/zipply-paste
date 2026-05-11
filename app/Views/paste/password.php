<?php
ob_start();
?>

<div class="max-w-md mx-auto py-24">
    <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-3xl shadow-2xl text-center">
        <div class="w-16 h-16 bg-amber-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i data-lucide="lock" class="text-amber-500 w-8 h-8"></i>
        </div>
        <h1 class="text-2xl font-bold mb-2">Password Protected</h1>
        <p class="text-zinc-500 text-sm mb-8">This paste is encrypted. Please enter the password to view it.</p>

        <?php if (isset($error)): ?>
            <div class="bg-red-500/10 border border-red-500/50 text-red-500 p-3 rounded-lg text-sm mb-6">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="/v/<?php echo $slug; ?>/unlock" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="password" name="password" required placeholder="Enter password..." class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-all">
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-indigo-500/20">
                Unlock Paste
            </button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
