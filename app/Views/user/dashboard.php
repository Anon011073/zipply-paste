<?php
ob_start();
?>

<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold">Hello, <?php echo $user['full_name'] ?: $user['username']; ?>!</h1>
            <p class="text-zinc-500">Welcome to your dashboard.</p>
        </div>
        <a href="/paste/new" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2">
            <i data-lucide="plus"></i> New Paste
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl">
            <p class="text-zinc-500 text-sm mb-1">Total Pastes</p>
            <p class="text-2xl font-bold">0</p>
        </div>
        <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl">
            <p class="text-zinc-500 text-sm mb-1">Total Views</p>
            <p class="text-2xl font-bold">0</p>
        </div>
        <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl">
            <p class="text-zinc-500 text-sm mb-1">Public Pastes</p>
            <p class="text-2xl font-bold">0</p>
        </div>
        <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl">
            <p class="text-zinc-500 text-sm mb-1">Private Pastes</p>
            <p class="text-2xl font-bold">0</p>
        </div>
    </div>

    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-zinc-800 flex items-center justify-between">
            <h2 class="font-bold">Recent Pastes</h2>
            <a href="/user/pastes" class="text-sm text-indigo-400 hover:underline">View All</a>
        </div>
        <div class="p-12 text-center text-zinc-500">
            <i data-lucide="file-text" class="w-12 h-12 mx-auto mb-4 opacity-20"></i>
            <p>You haven't created any pastes yet.</p>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6">
            <h2 class="font-bold mb-4 flex items-center gap-2">
                <i data-lucide="key" class="text-indigo-500 w-5 h-5"></i>
                API Keys
            </h2>
            <p class="text-sm text-zinc-500 mb-6">API keys allow you to create pastes programmatically.</p>
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <input type="text" placeholder="Key Name (e.g. My Script)" class="flex-grow bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-indigo-500">
                    <button class="bg-emerald-600/10 text-emerald-500 border border-emerald-500/20 px-4 py-2 rounded-lg text-sm font-bold hover:bg-emerald-600/20 transition-all">
                        Create Key
                    </button>
                </div>
                <p class="text-[10px] text-zinc-600 italic">You can create up to 5 API keys.</p>
            </div>
        </div>

        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6">
            <h2 class="font-bold mb-4 flex items-center gap-2">
                <i data-lucide="user-cog" class="text-indigo-500 w-5 h-5"></i>
                Profile Settings
            </h2>
            <div class="space-y-4">
                <a href="/profile/edit" class="block w-full text-center bg-zinc-800 hover:bg-zinc-700 text-white py-2 rounded-lg text-sm font-medium transition-colors">
                    Edit Profile
                </a>
                <button class="block w-full text-center bg-red-600/10 hover:bg-red-600/20 text-red-500 py-2 rounded-lg text-sm font-medium transition-colors border border-red-500/20">
                    Delete My Account
                </button>
            </div>
        </div>
    </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
