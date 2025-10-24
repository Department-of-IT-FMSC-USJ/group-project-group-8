<?php
$pageTitle = 'Schedule Meeting';
ob_start();
?>

<header class="bg-white dark:bg-slate-900 shadow-sm">
    <div class="px-4 py-4 flex items-center">
        <a href="index.php?page=admin-dashboard" class="text-slate-800 dark:text-white mr-4">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
            Schedule Meeting
        </h1>
    </div>
</header>

<main class="flex-grow p-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 mb-6">
            <h3 class="font-semibold text-slate-900 dark:text-white mb-2">Card Details</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Customer: <?= htmlspecialchars($card['user_name']) ?>
            </p>
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Card: •••• <?= substr($card['card_number'], -4) ?>
            </p>
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Expires: <?= date('m/Y', strtotime($card['expiry_date'])) ?>
            </p>
        </div>
        
        <form action="index.php?page=schedule-meeting&action=submit" method="POST" class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 space-y-6">
            <input type="hidden" name="card_id" value="<?= $card['card_id'] ?>">
            <input type="hidden" name="user_id" value="<?= $card['user_id'] ?>">
            
            <div>
                <label for="meeting_date" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Meeting Date *
                </label>
                <input
                    type="date"
                    id="meeting_date"
                    name="meeting_date"
                    required
                    min="<?= date('Y-m-d') ?>"
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                />
            </div>
            
            <div>
                <label for="meeting_time" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Meeting Time *
                </label>
                <input
                    type="time"
                    id="meeting_time"
                    name="meeting_time"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                />
            </div>
            
            <div>
                <label for="zoom_link" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Zoom Meeting Link (optional)
                </label>
                <input
                    type="url"
                    id="zoom_link"
                    name="zoom_link"
                    placeholder="https://zoom.us/j/..."
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                />
            </div>
            
            <div class="flex gap-4">
                <a href="index.php?page=admin-dashboard" 
                   class="flex-1 bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-semibold py-3 px-6 rounded-lg text-center transition duration-200">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="flex-1 bg-primary hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200"
                >
                    Schedule Meeting
                </button>
            </div>
        </form>
    </div>
</main>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
