<?php
$pageTitle = 'Notifications';
ob_start();
?>

<header class="bg-white dark:bg-slate-900 shadow-sm">
    <div class="px-4 py-4 flex items-center">
        <a href="index.php?page=user-dashboard" class="text-slate-800 dark:text-white mr-4">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Notifications</h1>
    </div>
</header>

<main class="flex-grow p-4">
    <div class="max-w-2xl mx-auto space-y-4">
        <?php if (empty($notifications)): ?>
            <p class="text-center py-8 text-slate-600 dark:text-slate-400">No notifications</p>
        <?php else: ?>
            <?php foreach ($notifications as $notification): ?>
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-4 <?= !$notification['is_read'] ? 'border-l-4 border-primary' : '' ?>">
                    <h3 class="font-semibold text-slate-900 dark:text-white"><?= htmlspecialchars($notification['title']) ?></h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1"><?= htmlspecialchars($notification['message']) ?></p>
                    <p class="text-xs text-slate-500 dark:text-slate-500 mt-2"><?= date('M j, Y g:i A', strtotime($notification['created_at'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
