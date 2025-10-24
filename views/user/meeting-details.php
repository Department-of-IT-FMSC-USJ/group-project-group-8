<?php
$pageTitle = 'Meeting Details';
ob_start();
?>

<header class="bg-white dark:bg-slate-900 shadow-sm">
    <div class="px-4 py-4 flex items-center">
        <a href="index.php?page=user-dashboard" class="text-slate-800 dark:text-white mr-4">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Meeting Details</h1>
    </div>
</header>

<main class="flex-grow p-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-slate-900 dark:text-white mb-4">Meeting Information</h3>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="text-slate-600 dark:text-slate-400">Date & Time</span>
                    <span class="text-slate-900 dark:text-white"><?= date('F j, Y \a\t g:i A', strtotime($meeting['meeting_date'])) ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="text-slate-600 dark:text-slate-400">Card</span>
                    <span class="text-slate-900 dark:text-white">•••• <?= substr($meeting['card_number'], -4) ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="text-slate-600 dark:text-slate-400">Bank Officer</span>
                    <span class="text-slate-900 dark:text-white"><?= htmlspecialchars($meeting['officer_name']) ?></span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-slate-600 dark:text-slate-400">Status</span>
                    <span class="text-slate-900 dark:text-white"><?= ucfirst($meeting['status']) ?></span>
                </div>
            </div>
            <?php if ($meeting['zoom_link']): ?>
                <a href="<?= htmlspecialchars($meeting['zoom_link']) ?>" target="_blank"
                   class="mt-6 block w-full bg-primary hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg text-center">
                    Join Zoom Meeting
                </a>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
