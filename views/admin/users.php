<?php
$pageTitle = 'Users';
ob_start();
?>

<header class="bg-white dark:bg-slate-900 shadow-sm">
    <div class="px-4 py-4 flex items-center">
        <a href="index.php?page=admin-dashboard" class="text-slate-800 dark:text-white mr-4">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Users</h1>
    </div>
</header>

<main class="flex-grow p-4">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6">
            <?php if (empty($users)): ?>
                <p class="text-center py-8 text-slate-600 dark:text-slate-400">No users found</p>
            <?php else: ?>
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Name</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Email</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Phone</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr class="border-b border-slate-100 dark:border-slate-700/50">
                                <td class="py-3 px-4 text-sm font-medium text-slate-900 dark:text-white"><?= htmlspecialchars($user['full_name']) ?></td>
                                <td class="py-3 px-4 text-sm text-slate-600 dark:text-slate-400"><?= htmlspecialchars($user['email']) ?></td>
                                <td class="py-3 px-4 text-sm text-slate-600 dark:text-slate-400"><?= htmlspecialchars($user['phone'] ?? 'N/A') ?></td>
                                <td class="py-3 px-4 text-sm text-slate-600 dark:text-slate-400"><?= date('M j, Y', strtotime($user['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
