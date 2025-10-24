<?php
$pageTitle = 'Register';
$customCSS = 'login.css';
ob_start();
?>

<header class="flex items-center p-4">
    <a href="index.php?page=user-login" class="text-slate-800 dark:text-white">
        <span class="material-symbols-outlined">arrow_back</span>
    </a>
    <h1 class="flex-1 text-center text-xl font-bold text-slate-900 dark:text-white pr-6">
        Create Account
    </h1>
</header>

<main class="flex-grow flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md">
        <form action="index.php?page=user-register-submit" method="POST" class="space-y-4">
            <div>
                <label for="full_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Full Name *
                </label>
                <input
                    type="text"
                    id="full_name"
                    name="full_name"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                />
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Email Address *
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                />
            </div>
            
            <div>
                <label for="phone" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Phone Number
                </label>
                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                />
            </div>
            
            <div>
                <label for="address" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Address
                </label>
                <textarea
                    id="address"
                    name="address"
                    rows="2"
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                ></textarea>
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Password *
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                />
            </div>
            
            <div>
                <label for="confirm_password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Confirm Password *
                </label>
                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                />
            </div>
            
            <button
                type="submit"
                class="w-full bg-primary hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200"
            >
                Register
            </button>
            
            <div class="text-center">
                <a href="index.php?page=user-login" class="text-primary hover:underline text-sm">
                    Already have an account? Sign In
                </a>
            </div>
        </form>
    </div>
</main>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
