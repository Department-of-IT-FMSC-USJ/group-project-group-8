<?php
$pageTitle = 'Customer Login';
$customCSS = 'login.css';
ob_start();
?>

<header class="flex items-center p-4">
    <a href="index.php" class="text-slate-800 dark:text-white">
        <span class="material-symbols-outlined">arrow_back</span>
    </a>
    <h1 class="flex-1 text-center text-xl font-bold text-slate-900 dark:text-white pr-6">
        Customer Sign In
    </h1>
</header>

<main class="flex-grow flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <form action="index.php?page=user-login-submit" method="POST" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Email Address
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                    placeholder="your.email@example.com"
                />
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Password
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                    placeholder="••••••••"
                />
            </div>
            
            <button
                type="submit"
                class="w-full bg-primary hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200"
            >
                Sign In
            </button>
            
            <div class="text-center">
                <a href="index.php?page=user-register" class="text-primary hover:underline text-sm">
                    Don't have an account? Register
                </a>
            </div>
        </form>
        
        <div class="mt-6 p-4 bg-blue-50 dark:bg-slate-800 rounded-lg">
            <p class="text-sm text-slate-600 dark:text-slate-400">
                <strong>Demo Account:</strong><br>
                Email: alice@example.com<br>
                Password: password123
            </p>
        </div>
    </div>
</main>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
