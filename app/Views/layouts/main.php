<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Zipply Paste'; ?></title>
    <script src="/js/tailwind.js"></script>
    <script src="/js/lucide.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-zinc-950 text-zinc-100 dark:bg-zinc-950 dark:text-zinc-100 light:bg-zinc-50 light:text-zinc-900 min-h-screen flex flex-col transition-colors duration-300">
    <nav class="border-b border-zinc-800 bg-zinc-900/50 backdrop-blur-md sticky top-0 z-50 dark:bg-zinc-900/50 dark:border-zinc-800 light:bg-white/80 light:border-zinc-200">
        <div class="container mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="/" class="flex items-center gap-2 font-bold text-xl tracking-tight">
                    <i data-lucide="layers" class="text-indigo-500 w-6 h-6"></i>
                    <span>Zipply<span class="text-indigo-500">Paste</span></span>
                </a>
                <div class="hidden md:flex items-center gap-6">
                    <a href="/search" class="text-sm font-medium text-zinc-400 hover:text-white transition-colors">Discover</a>
                    <a href="/paste/new" class="text-sm font-medium text-zinc-400 hover:text-white transition-colors">Create</a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button id="theme-toggle" class="p-2 rounded-lg hover:bg-zinc-800 transition-colors text-zinc-400">
                    <i data-lucide="moon" id="theme-icon-dark" class="w-5 h-5 hidden"></i>
                    <i data-lucide="sun" id="theme-icon-light" class="w-5 h-5 hidden"></i>
                </button>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/dashboard" class="text-sm font-medium hover:text-indigo-400 transition-colors flex items-center gap-2">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <?php echo $_SESSION['username']; ?>
                    </a>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <a href="/admin" class="text-sm font-medium text-amber-400 hover:text-amber-300 transition-colors">Admin</a>
                    <?php endif; ?>
                    <a href="/logout" class="text-sm font-medium text-zinc-500 hover:text-red-400 transition-colors">Logout</a>
                <?php else: ?>
                    <a href="/login" class="text-sm font-medium hover:text-indigo-400 transition-colors">Login</a>
                    <a href="/register" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-lg shadow-indigo-500/20">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-8">
        <?php echo $content; ?>
    </main>

    <footer class="border-t border-zinc-800 py-8 bg-zinc-900/30">
        <div class="container mx-auto px-4 text-center text-zinc-500 text-sm">
            &copy; <?php echo date('Y'); ?> Zipply Paste. All rights reserved.
        </div>
    </footer>

    <script>
        lucide.createIcons();

        // Theme Toggle Logic
        const themeToggle = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-icon-dark');
        const lightIcon = document.getElementById('theme-icon-light');

        function setTheme(isDark) {
            if (isDark) {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
                darkIcon.classList.add('hidden');
                lightIcon.classList.remove('hidden');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
                localStorage.setItem('theme', 'light');
            }
        }

        const savedTheme = localStorage.getItem('theme') || 'dark';
        setTheme(savedTheme === 'dark');

        themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.classList.contains('dark');
            setTheme(!isDark);
        });
    </script>
</body>
</html>
