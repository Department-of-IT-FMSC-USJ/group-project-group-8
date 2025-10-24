<?php
$pageTitle = 'Welcome - Debit Card Renewal System';
$customCSS = 'welcome.css';
ob_start();
?>

<div class="welcome-container flex items-center justify-center min-h-screen p-4">
    <div class="text-center">
        <img
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuC6TX5p1UzP7NRvJCHRqZKpCQ4ewCzlBuwjmzydSSgjGyQgcvZCnj6FBY6G9snePTucO7Nx_g85xJ4YtMjCRB-gUIy4z5pYY8mbwqK4JAjYNrVeJv_Z3TuB2dnoJmbIRARwuLCSyt5gYstmkzokxNRYUcPfEiDw6V0cGmn123WKsR69XvXshr0YEJo_NBEdx1VFE0GJhLcV4g8X-BHTHlpo5gV9tQR24uK-J4pK5GW4Z9xy1sYCzpeq8W0IYeqD1LZv7q37-QPR_OZX"
            alt="Debit Card Renewal System"
            class="welcome-logo mx-auto mb-8"
        />
        
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">
            Debit Card Renewal System
        </h1>
        
        <p class="text-lg text-slate-600 dark:text-slate-300 mb-8">
            Easy and convenient debit card renewal process
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="index.php?page=user-login" 
               class="bg-primary hover:bg-blue-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-200">
                Customer Login
            </a>
            
            <a href="index.php?page=officer-login" 
               class="bg-slate-700 hover:bg-slate-800 text-white font-semibold py-3 px-8 rounded-lg transition duration-200">
                Bank Officer Login
            </a>
        </div>
        
        <div class="mt-6">
            <a href="index.php?page=user-register" 
               class="text-primary hover:underline">
                Don't have an account? Register here
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
