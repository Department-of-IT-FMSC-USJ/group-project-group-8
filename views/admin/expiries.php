<?php
$pageTitle = 'Upcoming Expiries';
ob_start();
?>

<header class="bg-white dark:bg-slate-900 shadow-sm">
    <div class="px-4 py-4 flex items-center">
        <a href="index.php?page=admin-dashboard" class="text-slate-800 dark:text-white mr-4">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Upcoming Expiries</h1>
    </div>
</header>

<main class="flex-grow p-4">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6">
            <?php if (empty($expiries)): ?>
                <p class="text-center py-8 text-slate-600 dark:text-slate-400">No upcoming expiries</p>
            <?php else: ?>
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Customer</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Card</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Expiry</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Days Left</th>
                            <th class="text-right py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($expiries as $expiry): ?>
                            <tr class="border-b border-slate-100 dark:border-slate-700/50">
                                <td class="py-3 px-4">
                                    <div class="text-sm font-medium text-slate-900 dark:text-white"><?= htmlspecialchars($expiry['user_name']) ?></div>
                                    <div class="text-xs text-slate-600 dark:text-slate-400"><?= htmlspecialchars($expiry['email']) ?></div>
                                </td>
                                <td class="py-3 px-4 text-sm">•••• <?= substr($expiry['card_number'], -4) ?></td>
                                <td class="py-3 px-4 text-sm"><?= date('m/Y', strtotime($expiry['expiry_date'])) ?></td>
                                <td class="py-3 px-4 text-sm font-semibold <?= $expiry['days_until_expiry'] <= 30 ? 'text-red-600' : 'text-yellow-600' ?>">
                                    <?= $expiry['days_until_expiry'] ?> days
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="index.php?page=schedule-meeting&card_id=<?= $expiry['card_id'] ?>" 
                                       class="text-primary hover:underline text-sm">Schedule Meeting</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
