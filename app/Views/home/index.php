<?php
ob_start();
?>

<div class="max-w-4xl mx-auto text-center py-12">
    <h1 class="text-4xl md:text-6xl font-black mb-6 bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent italic">
        Simple, Fast, Secure Pasting.
    </h1>
    <p class="text-zinc-400 text-lg mb-10 max-w-2xl mx-auto">
        Share code, notes, and snippets instantly with our lightweight, modern pastebin platform.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-zinc-900/50 p-6 rounded-2xl border border-zinc-800 hover:border-indigo-500/50 transition-all group">
            <div class="w-12 h-12 bg-indigo-500/10 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="zap" class="text-indigo-500"></i>
            </div>
            <h3 class="font-bold mb-2">Lightning Fast</h3>
            <p class="text-sm text-zinc-500">Optimized for performance and rapid sharing.</p>
        </div>
        <div class="bg-zinc-900/50 p-6 rounded-2xl border border-zinc-800 hover:border-indigo-500/50 transition-all group">
            <div class="w-12 h-12 bg-indigo-500/10 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="shield" class="text-indigo-500"></i>
            </div>
            <h3 class="font-bold mb-2">Secure</h3>
            <p class="text-sm text-zinc-500">End-to-end encryption and private paste options.</p>
        </div>
        <div class="bg-zinc-900/50 p-6 rounded-2xl border border-zinc-800 hover:border-indigo-500/50 transition-all group">
            <div class="w-12 h-12 bg-indigo-500/10 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="code" class="text-indigo-500"></i>
            </div>
            <h3 class="font-bold mb-2">Syntax Ready</h3>
            <p class="text-sm text-zinc-500">Supports hundreds of languages with Monaco editor.</p>
        </div>
    </div>

    <a href="<?php echo $base; ?>/paste/new" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-full text-lg font-bold transition-all shadow-xl shadow-indigo-500/30">
        <i data-lucide="plus-circle"></i>
        Create Your First Paste
    </a>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
