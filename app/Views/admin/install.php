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
document.getElementById('installForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const statusDiv = document.getElementById('status');
    const statusText = statusDiv.querySelector('p');

    statusDiv.classList.remove('hidden');
    statusText.innerText = 'Installing...';
    statusText.className = 'text-sm font-medium text-indigo-400';

    try {
        const response = await fetch('/install', {
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
