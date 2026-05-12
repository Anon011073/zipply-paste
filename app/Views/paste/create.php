<?php
ob_start();
?>

<div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-8">
    <div class="lg:col-span-3">
    <form action="<?php echo $base; ?>/paste/new" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <!-- Dummy fields to fool browser autofill -->
        <input type="text" name="prevent_autofill" style="display:none" tabindex="-1">
        <input type="password" name="password_fake" style="display:none" tabindex="-1">

        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-grow w-full">
                <label class="block text-sm font-medium text-zinc-500 mb-2">Paste Title</label>
                <input type="text" name="p_title" id="p_title" autocomplete="off" value="<?php echo isset($clone) ? htmlspecialchars($clone['title']) . ' (Clone)' : ''; ?>" placeholder="Untitled Paste" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-all text-lg font-bold">
            </div>
            <div class="flex gap-2">
                <select name="language" class="bg-zinc-900 border border-zinc-800 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-all text-sm font-medium">
                    <?php
                    $langs = ['plaintext' => 'Plain Text', 'javascript' => 'JavaScript', 'php' => 'PHP', 'python' => 'Python', 'html' => 'HTML', 'css' => 'CSS', 'markdown' => 'Markdown'];
                    foreach($langs as $val => $label): ?>
                        <option value="<?php echo $val; ?>" <?php echo (isset($clone) && $clone['language'] === $val) ? 'selected' : ''; ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="relative group z-10">
            <div id="editor-container" style="height: 500px; min-height: 500px; width: 100%;" class="rounded-2xl border border-zinc-800 overflow-hidden bg-zinc-900 shadow-2xl group-hover:border-zinc-700 transition-all"></div>
            <textarea name="content" id="content-textarea" style="display:none;"><?php echo isset($clone) ? htmlspecialchars($clone['content']) : ''; ?></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-zinc-900/50 p-6 rounded-2xl border border-zinc-800">
            <div>
                <label class="block text-sm font-medium text-zinc-500 mb-2">Expiration</label>
                <select name="expiration" class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 transition-all text-sm">
                    <option value="never">Never</option>
                    <option value="burn">Burn after read</option>
                    <option value="10m">10 Minutes</option>
                    <option value="1h">1 Hour</option>
                    <option value="1d">1 Day</option>
                    <option value="1w">1 Week</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-zinc-500 mb-2">Visibility</label>
                <select name="visibility" class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 transition-all text-sm">
                    <option value="public">Public</option>
                    <option value="unlisted">Unlisted</option>
                    <option value="private">Private</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-zinc-500 mb-2">Password (Optional)</label>
                <input type="password" name="password" placeholder="Leave empty for none" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-2 focus:outline-none focus:border-indigo-500 transition-all text-sm">
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-xl font-bold transition-all shadow-xl shadow-indigo-500/20 flex items-center gap-2">
                <i data-lucide="share-2"></i> Create Paste
            </button>
        </div>
    </form>
    </div>

    <div class="space-y-6">
        <h2 class="text-sm font-bold uppercase tracking-widest text-zinc-500 flex items-center gap-2">
            <i data-lucide="clock" class="w-4 h-4"></i> Recent Pastes
        </h2>
        <div class="space-y-3">
            <?php foreach($recent as $r): ?>
                <a href="<?php echo $base; ?>/v/<?php echo $r['slug']; ?>" class="block bg-zinc-900 border border-zinc-800 hover:border-indigo-500/50 p-4 rounded-2xl transition-all group">
                    <h3 class="text-sm font-bold truncate group-hover:text-indigo-400 transition-colors"><?php echo htmlspecialchars($r['title']); ?></h3>
                    <p class="text-[10px] text-zinc-500 mt-1 uppercase font-bold tracking-tighter"><?php echo $r['language']; ?> • <?php echo date('M j', strtotime($r['created_at'])); ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/loader.min.js"></script>
<script>
    require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs' }});
    require(['vs/editor/editor.main'], function() {
        window.editor = monaco.editor.create(document.getElementById('editor-container'), {
            value: document.getElementById('content-textarea').value,
            language: '<?php echo isset($clone) ? $clone['language'] : 'plaintext'; ?>',
            theme: 'vs-dark',
            automaticLayout: true,
            fontSize: 14,
            minimap: { enabled: false },
            padding: { top: 20, bottom: 20 },
            fontFamily: 'JetBrains Mono, Fira Code, monospace',
            lineNumbers: 'on',
            roundedSelection: true,
            scrollBeyondLastLine: false,
            readOnly: false,
            cursorStyle: 'line'
        });

        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('content-textarea').value = window.editor.getValue();
        });

        document.querySelector('select[name="language"]').addEventListener('change', function(e) {
            monaco.editor.setModelLanguage(window.editor.getModel(), e.target.value);
        });
    });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
