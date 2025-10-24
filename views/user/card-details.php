<?php
$pageTitle = 'Card Details';
$customCSS = 'card.css';
ob_start();
?>

<header class="bg-white dark:bg-slate-900 shadow-sm">
    <div class="px-4 py-4 flex items-center">
        <a href="index.php?page=user-dashboard" class="text-slate-800 dark:text-white mr-4">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
            Card Details
        </h1>
    </div>
</header>

<main class="flex-grow p-4">
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-3xl">credit_card</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                            <?= htmlspecialchars($card['cardholder_name']) ?>
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            Debit Card
                        </p>
                    </div>
                </div>
                
                <?php if ($card['is_active']): ?>
                    <span class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 px-3 py-1 rounded-full text-sm">
                        Active
                    </span>
                <?php endif; ?>
            </div>
            
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="text-slate-600 dark:text-slate-400">Card Number</span>
                    <span class="font-mono text-slate-900 dark:text-white">•••• •••• •••• <?= substr($card['card_number'], -4) ?></span>
                </div>
                
                <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="text-slate-600 dark:text-slate-400">Branch</span>
                    <span class="text-slate-900 dark:text-white"><?= htmlspecialchars($card['branch']) ?></span>
                </div>
                
                <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="text-slate-600 dark:text-slate-400">Expiry Date</span>
                    <span class="text-slate-900 dark:text-white"><?= date('m/Y', strtotime($card['expiry_date'])) ?></span>
                </div>
                
                <div class="flex justify-between py-2">
                    <span class="text-slate-600 dark:text-slate-400">Added On</span>
                    <span class="text-slate-900 dark:text-white"><?= date('M j, Y', strtotime($card['created_at'])) ?></span>
                </div>
            </div>
        </div>
        
        <?php if ($renewal): ?>
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <h3 class="font-semibold text-blue-900 dark:text-blue-300 mb-3">Renewal Status</h3>
            <div class="space-y-2">
                <p class="text-sm text-blue-800 dark:text-blue-300">
                    <strong>Status:</strong> <?= ucfirst(str_replace('_', ' ', $renewal['delivery_status'])) ?>
                </p>
                <?php if ($renewal['tracking_number']): ?>
                <p class="text-sm text-blue-800 dark:text-blue-300">
                    <strong>Tracking:</strong> <?= htmlspecialchars($renewal['tracking_number']) ?>
                </p>
                <?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        <a href="index.php?page=renew-card&id=<?= $card['card_id'] ?>" 
           class="block bg-primary hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg text-center transition duration-200">
            Renew This Card
        </a>
        <?php endif; ?>
    </div>
</main>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
