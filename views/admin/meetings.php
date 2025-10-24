<?php
$pageTitle = 'My Meetings';
ob_start();
?>

<header class="bg-white dark:bg-slate-900 shadow-sm">
    <div class="px-4 py-4 flex items-center">
        <a href="index.php?page=admin-dashboard" class="text-slate-800 dark:text-white mr-4">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">My Meetings</h1>
    </div>
</header>

<main class="flex-grow p-4">
    <div class="max-w-4xl mx-auto space-y-4">
        <?php if (empty($meetings)): ?>
            <p class="text-center py-8 text-slate-600 dark:text-slate-400">No meetings scheduled</p>
        <?php else: ?>
            <?php foreach ($meetings as $meeting): ?>
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-slate-900 dark:text-white mb-2">
                                <?= htmlspecialchars($meeting['user_name']) ?>
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                Card: •••• <?= substr($meeting['card_number'], -4) ?>
                            </p>
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                <?= date('F j, Y \a\t g:i A', strtotime($meeting['meeting_date'])) ?>
                            </p>
                            <?php if ($meeting['zoom_link']): ?>
                                <a href="<?= htmlspecialchars($meeting['zoom_link']) ?>" target="_blank" 
                                   class="text-primary hover:underline text-sm mt-2 inline-block">Join Meeting</a>
                            <?php endif; ?>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            <?= $meeting['status'] === 'confirmed' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 
                                ($meeting['status'] === 'completed' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300' : 
                                'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300') ?>">
                            <?= ucfirst($meeting['status']) ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
