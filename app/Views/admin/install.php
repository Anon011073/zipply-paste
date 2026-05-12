<?php
ob_start();
?>

<div class="max-w-md mx-auto py-12">
    <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-2xl shadow-2xl">
        <div class="text-center mb-8">
            <i data-lucide="settings" class="w-12 h-12 text-indigo-500 mx-auto mb-4 animate-spin-slow"></i>
            <h1 class="text-2xl font-bold">Installation</h1>
            <p class="text-zinc-500 text-sm">Set up your Zipply Paste instance</p>
        </div>

        <form id="installForm" class="space-y-4">
            <div class="bg-zinc-950/50 p-4 rounded-xl border border-zinc-800 mb-6">
                <label class="block text-xs font-bold uppercase tracking-widest text-zinc-500 mb-3">Database Type</label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="cursor-pointer group">
                        <input type="radio" name="db_driver" value="sqlite" checked class="hidden peer">
                        <div class="p-3 text-center border border-zinc-800 rounded-lg peer-checked:border-indigo-500 peer-checked:bg-indigo-500/10 transition-all text-sm text-zinc-400 group-hover:text-zinc-200 peer-checked:text-white font-bold">SQLite</div>
                    </label>
                    <label class="cursor-pointer group">
                        <input type="radio" name="db_driver" value="mysql" class="hidden peer">
                        <div class="p-3 text-center border border-zinc-800 rounded-lg peer-checked:border-indigo-500 peer-checked:bg-indigo-500/10 transition-all text-sm text-zinc-400 group-hover:text-zinc-200 peer-checked:text-white font-bold">MySQL</div>
                    </label>
                </div>
            </div>

            <div id="mysql-fields" class="hidden space-y-4 bg-zinc-950/30 p-4 rounded-xl border border-zinc-800/50 mb-6">
                <input type="text" name="db_host" placeholder="MySQL Host (localhost)" class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 text-sm">
                <input type="text" name="db_name" placeholder="Database Name" class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 text-sm">
                <input type="text" name="db_user" placeholder="Database User" class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 text-sm">
                <input type="password" name="db_pass" placeholder="Database Password" class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 text-sm">
            </div>

            <div class="border-t border-zinc-800 pt-4 mt-4"></div>

            <div>
                <label class="block text-sm font-medium text-zinc-400 mb-1">Admin Username</label>
                <input type="text" name="admin_user" required class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 transition-colors">
            </div>
            <div>
                <label class="block text-sm font-medium text-zinc-400 mb-1">Admin Email</label>
                <input type="email" name="admin_email" required class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 transition-colors">
            </div>
            <div>
                <label class="block text-sm font-medium text-zinc-400 mb-1">Admin Password</label>
                <input type="password" name="admin_pass" required class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 transition-colors">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition-all shadow-lg shadow-indigo-500/20 mt-4">
                Complete Installation
            </button>
        </form>

        <div id="status" class="mt-4 text-center hidden">
            <p class="text-sm font-medium"></p>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('input[name="db_driver"]').forEach(radio => {
    radio.addEventListener('change', (e) => {
        document.getElementById('mysql-fields').classList.toggle('hidden', e.target.value === 'sqlite');
    });
});

document.getElementById('installForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const statusDiv = document.getElementById('status');
    const statusText = statusDiv.querySelector('p');

    statusDiv.classList.remove('hidden');
    statusText.innerText = 'Installing...';
    statusText.className = 'text-sm font-medium text-indigo-400';

    const base = '<?php echo $base; ?>';
    try {
        const response = await fetch(base + '/install', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (result.success) {
            statusText.innerText = result.message + ' Redirecting...';
            statusText.className = 'text-sm font-medium text-green-400';
            setTimeout(() => window.location.href = '/', 2000);
        } else {
            statusText.innerText = 'Error: ' + result.message;
            statusText.className = 'text-sm font-medium text-red-400';
        }
    } catch (err) {
        statusText.innerText = 'An error occurred.';
        statusText.className = 'text-sm font-medium text-red-400';
    }
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
