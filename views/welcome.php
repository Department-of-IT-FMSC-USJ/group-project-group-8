<?php
$pageTitle = 'Welcome - Debit Card Renewal System';
$customCSS = 'welcome.css';
ob_start();
?>

<div class="welcome-container flex items-center justify-center min-h-screen p-4">
    <div class="text-center">
        <img
            src="https://png.pngtree.com/png-vector/20220706/ourmid/pngtree-debit-card-payment-png-image_5705181.png"
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
