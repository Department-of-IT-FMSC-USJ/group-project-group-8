<?php
$pageTitle = 'Renew Card';
ob_start();
?>

<header class="bg-white dark:bg-slate-900 shadow-sm">
    <div class="px-4 py-4 flex items-center">
        <a href="index.php?page=view-card&id=<?= $card['card_id'] ?>" class="text-slate-800 dark:text-white mr-4">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
            Renew Card
        </h1>
    </div>
</header>

<main class="flex-grow p-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 mb-6">
            <h3 class="font-semibold text-slate-900 dark:text-white mb-2">Current Card</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400">
                •••• •••• •••• <?= substr($card['card_number'], -4) ?>
            </p>
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Expires: <?= date('m/Y', strtotime($card['expiry_date'])) ?>
            </p>
        </div>
        
        <form action="index.php?page=renew-card&action=submit" method="POST" class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 space-y-6">
            <input type="hidden" name="card_id" value="<?= $card['card_id'] ?>">
            
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800 dark:text-blue-300">
                    <strong>Note:</strong> After submitting, a random 4-digit PIN will be generated and shown to you once. Please save it securely.
                </p>
            </div>
            
            <div>
                <label for="new_card_number" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    New Card Number *
                </label>
                <input
                    type="text"
                    id="new_card_number"
                    name="new_card_number"
                    required
                    maxlength="16"
                    pattern="\d{16}"
                    placeholder="1234567890123456"
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                />
            </div>
            
            <div>
                <label for="new_expiry_date" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    New Expiry Date *
                </label>
                <input
                    type="date"
                    id="new_expiry_date"
                    name="new_expiry_date"
                    required
                    min="<?= date('Y-m-d') ?>"
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                />
            </div>
            
            <div class="flex gap-4">
                <a href="index.php?page=view-card&id=<?= $card['card_id'] ?>" 
                   class="flex-1 bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-semibold py-3 px-6 rounded-lg text-center transition duration-200">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="flex-1 bg-primary hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200"
                >
                    Renew Card
                </button>
            </div>
        </form>
    </div>
</main>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
