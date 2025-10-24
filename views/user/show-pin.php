<?php
$pageTitle = 'Your New PIN';
$customCSS = 'pin.css';
ob_start();
?>

<div class="flex flex-col h-screen justify-between">
    <div class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-md text-center">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8">
                <div class="bg-green-100 dark:bg-green-900/30 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-4xl">check_circle</span>
                </div>
                
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">
                    Card Renewed Successfully!
                </h1>
                
                <p class="text-slate-600 dark:text-slate-400 mb-6">
                    Your new 4-digit PIN has been generated. Please memorize it and keep it secure.
                </p>
                
                <div class="bg-blue-50 dark:bg-slate-900 border-2 border-primary rounded-xl p-6 mb-6">
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">Your New PIN</p>
                    <div class="text-5xl font-bold text-primary tracking-widest">
                        <?= htmlspecialchars($pin) ?>
                    </div>
                </div>
                
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6">
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-400 text-xl">warning</span>
                        <p class="text-sm text-yellow-800 dark:text-yellow-300 text-left">
                            <strong>Important:</strong> This PIN will only be shown once. Please write it down or memorize it now.
                        </p>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Card: •••• •••• •••• <?= substr($card['card_number'], -4) ?>
                    </p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Updated: <?= date('F j, Y \a\t g:i A') ?>
                    </p>
                </div>
            </div>
            
            <a href="index.php?page=user-dashboard" 
               class="mt-6 inline-block bg-primary hover:bg-blue-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-200">
                Back to Dashboard
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
