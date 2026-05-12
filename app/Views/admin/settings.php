<?php
ob_start();
?>

<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Site Settings</h1>
        <a href="<?php echo $base; ?>/admin" class="text-sm text-indigo-400 hover:underline flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Admin
        </a>
    </div>

    <div class="space-y-6">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8 shadow-xl">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-zinc-900 dark:text-white">
                <i data-lucide="globe" class="text-indigo-500 w-5 h-5"></i>
                General Settings
            </h2>
            <form action="<?php echo $base; ?>/admin/settings" method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-zinc-500 mb-2">Site Name</label>
                        <input type="text" name="site_name" value="<?php echo htmlspecialchars($settings['site_name'] ?? 'Zipply Paste'); ?>" class="w-full bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-white rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-500 mb-2">Site Tagline</label>
                        <input type="text" name="site_tagline" value="<?php echo htmlspecialchars($settings['site_tagline'] ?? 'Simple, Fast, Secure Pasting'); ?>" class="w-full bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-white rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-all">
                    </div>
                </div>
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="guest_posting" value="1" <?php echo ($settings['guest_posting'] ?? '1') == '1' ? 'checked' : ''; ?> class="w-5 h-5 rounded border-zinc-800 bg-zinc-950 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-zinc-300 font-medium">Allow Guest Posting</span>
                    </label>
                </div>
                <div class="pt-4">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold transition-all">Save Changes</button>
                </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8 shadow-xl">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-zinc-900 dark:text-white">
                <i data-lucide="mail" class="text-indigo-500 w-5 h-5"></i>
                SMTP Configuration
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-zinc-500 mb-2">SMTP Host</label>
                    <input type="text" name="smtp_host" value="<?php echo htmlspecialchars($settings['smtp_host'] ?? ''); ?>" placeholder="smtp.gmail.com" class="w-full bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-white rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-500 mb-2">SMTP Port</label>
                    <input type="text" name="smtp_port" value="<?php echo htmlspecialchars($settings['smtp_port'] ?? '587'); ?>" placeholder="587" class="w-full bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-white rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-500 mb-2">SMTP Username</label>
                    <input type="text" name="smtp_user" value="<?php echo htmlspecialchars($settings['smtp_user'] ?? ''); ?>" class="w-full bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-white rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-500 mb-2">SMTP Password</label>
                    <input type="password" name="smtp_pass" value="<?php echo htmlspecialchars($settings['smtp_pass'] ?? ''); ?>" class="w-full bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-white rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-all">
                </div>
            </div>
        </div>
    </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
