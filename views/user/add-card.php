<?php
$pageTitle = 'Add Card';
$customCSS = 'request.css';
ob_start();
?>

<header class="flex items-center p-4 bg-white dark:bg-slate-900 shadow-sm">
    <a href="index.php?page=user-dashboard" class="text-slate-800 dark:text-white">
        <span class="material-symbols-outlined">arrow_back</span>
    </a>
    <h1 class="flex-1 text-center text-xl font-bold text-slate-900 dark:text-white pr-6">
        Add Debit Card
    </h1>
</header>

<main class="flex-grow p-4">
    <div class="max-w-2xl mx-auto">
        <form action="index.php?page=add-card&action=submit" method="POST" class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 space-y-6">
            <div>
                <label for="card_number" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Card Number *
                </label>
                <input
                    type="text"
                    id="card_number"
                    name="card_number"
                    required
                    maxlength="16"
                    pattern="\d{16}"
                    placeholder="1234567890123456"
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                />
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">16 digits without spaces</p>
            </div>
            
            <div>
                <label for="cardholder_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Cardholder Name *
                </label>
                <input
                    type="text"
                    id="cardholder_name"
                    name="cardholder_name"
                    required
                    placeholder=""
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                />
            </div>
            
            <div>
                <label for="branch" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Branch *
                </label>
                <select
                    id="branch"
                    name="branch"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                >
                    <option value="">Select Branch</option>
                    <option value="Colombo">Colombo</option>
                    <option value="Kandy">Kandy</option>
                    <option value="Galle">Galle</option>
                    <option value="Anuradhapura">Anuradhapura</option>
                    <option value="Matara">Matara</option>
                    <option value="Batticaloa">Batticaloa</option>
                </select>
            </div>
            
            <div>
                <label for="expiry_date" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Expiry Date *
                </label>
                <input
                    type="date"
                    id="expiry_date"
                    name="expiry_date"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"
                />
            </div>
            
            <div class="flex gap-4">
                <a href="index.php?page=user-dashboard" 
                   class="flex-1 bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-semibold py-3 px-6 rounded-lg text-center transition duration-200">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="flex-1 bg-primary hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200"
                >
                    Add Card
                </button>
            </div>
        </form>
    </div>
</main>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
