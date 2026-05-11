<?php
ob_start();
$isMarkdown = ($paste['language'] === 'markdown');
?>

<div class="max-w-6xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold mb-2"><?php echo htmlspecialchars($paste['title']); ?></h1>
            <div class="flex flex-wrap items-center gap-4 text-sm text-zinc-500">
                <span class="flex items-center gap-1"><i data-lucide="user" class="w-4 h-4"></i> <?php echo $paste['username'] ?: 'Guest'; ?></span>
                <span class="flex items-center gap-1"><i data-lucide="calendar" class="w-4 h-4"></i> <?php echo date('M j, Y', strtotime($paste['created_at'])); ?></span>
                <span class="flex items-center gap-1"><i data-lucide="eye" class="w-4 h-4"></i> <?php echo $paste['views']; ?> views</span>
                <span class="bg-zinc-800 text-zinc-300 px-2 py-0.5 rounded uppercase text-[10px] font-bold tracking-wider"><?php echo $paste['language']; ?></span>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="<?php echo $base; ?>/raw/<?php echo $paste['slug']; ?>" target="_blank" class="bg-zinc-800 hover:bg-zinc-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                <i data-lucide="file-text" class="w-4 h-4"></i> RAW
            </a>
            <button onclick="copyToClipboard()" class="bg-zinc-800 hover:bg-zinc-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                <i data-lucide="copy" class="w-4 h-4"></i> Copy
            </button>
            <a href="<?php echo $base; ?>/download/<?php echo $paste['slug']; ?>" class="bg-zinc-800 hover:bg-zinc-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Download
            </a>
            <a href="<?php echo $base; ?>/clone/<?php echo $paste['slug']; ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                <i data-lucide="copy-plus" class="w-4 h-4"></i> Clone
            </a>
        </div>
    </div>

    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-2xl">
        <?php if ($isMarkdown): ?>
            <div class="p-8 prose prose-invert max-w-none">
                <?php
                $parsedown = new Parsedown();
                $parsedown->setSafeMode(true);
                echo $parsedown->text($paste['content']);
                ?>
            </div>
        <?php else: ?>
            <div id="editor-container" class="h-[600px]"></div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/loader.min.js"></script>
<script>
    <?php if (!$isMarkdown): ?>
    require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs' }});
    require(['vs/editor/editor.main'], function() {
        monaco.editor.create(document.getElementById('editor-container'), {
            value: <?php echo json_encode($paste['content']); ?>,
            language: '<?php echo $paste['language']; ?>',
            theme: 'vs-dark',
            readOnly: true,
            automaticLayout: true,
            fontSize: 14,
            minimap: { enabled: true },
            padding: { top: 20, bottom: 20 },
            scrollBeyondLastLine: false,
            fontFamily: 'JetBrains Mono, Fira Code, monospace',
        });
    });
    <?php endif; ?>

    function copyToClipboard() {
        const content = <?php echo json_encode($paste['content']); ?>;
        navigator.clipboard.writeText(content).then(() => {
            alert('Copied to clipboard!');
        });
    }
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
