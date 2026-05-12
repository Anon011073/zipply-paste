<?php
ob_start();
?>

<div class="max-w-2xl mx-auto py-12">
    <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-3xl shadow-2xl">
        <h1 class="text-2xl font-bold mb-6">Edit Profile</h1>

        <form action="<?php echo $base; ?>/profile/edit" method="POST" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <div>
                <label class="block text-sm font-medium text-zinc-500 mb-2">Display Name</label>
                <input type="text" name="full_name" value="<?php echo \App\Helpers\View::e($user['full_name']); ?>" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-zinc-500 mb-2">Bio / About Me</label>
                <textarea name="bio" rows="4" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-all"><?php echo \App\Helpers\View::e($user['bio']); ?></textarea>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl font-bold transition-all">
                    Save Changes
                </button>
                <a href="<?php echo $base; ?>/dashboard" class="bg-zinc-800 hover:bg-zinc-700 text-white px-8 py-3 rounded-xl font-bold transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
