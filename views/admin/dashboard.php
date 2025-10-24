<?php
$pageTitle = 'Admin Dashboard';
$customCSS = 'homepage.css';
ob_start();
?>

<header class="bg-white dark:bg-slate-900 shadow-sm">
    <div class="px-4 py-4 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
                Admin Dashboard
            </h1>
            <p class="text-sm text-slate-600 dark:text-slate-400">
                <?= htmlspecialchars($_SESSION['officer_name']) ?> - <?= htmlspecialchars($_SESSION['officer_branch']) ?>
            </p>
        </div>
        <a href="index.php?page=logout" class="p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
            <span class="material-symbols-outlined">logout</span>
        </a>
    </div>
</header>

<main class="flex-grow p-4">
    <div class="max-w-6xl mx-auto space-y-6">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                <h3 class="text-sm font-medium opacity-90 mb-1">Upcoming Expiries</h3>
                <p class="text-3xl font-bold"><?= count($upcomingExpiries) ?></p>
                <p class="text-sm opacity-75">Next 90 days</p>
            </div>
            
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
                <h3 class="text-sm font-medium opacity-90 mb-1">My Meetings</h3>
                <p class="text-3xl font-bold"><?= count($myMeetings) ?></p>
                <p class="text-sm opacity-75">Scheduled</p>
            </div>
            
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white">
                <h3 class="text-sm font-medium opacity-90 mb-1">Renewals</h3>
                <p class="text-3xl font-bold"><?= count($renewals) ?></p>
                <p class="text-sm opacity-75">In progress</p>
            </div>
        </div>
        
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="index.php?page=admin-expiries" class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">event</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white text-sm">View Expiries</h3>
                    </div>
                </div>
            </a>
            
            <a href="index.php?page=admin-meetings" class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-lg">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400">video_call</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white text-sm">My Meetings</h3>
                    </div>
                </div>
            </a>
            
            <a href="index.php?page=admin-renewals" class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="bg-orange-100 dark:bg-orange-900/30 p-3 rounded-lg">
                        <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">autorenew</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white text-sm">Renewals</h3>
                    </div>
                </div>
            </a>
            
            <a href="index.php?page=admin-users" class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg">
                        <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">group</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white text-sm">Users</h3>
                    </div>
                </div>
            </a>
        </div>
        
        
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Cards Expiring Soon</h2>
            
            <?php if (empty($upcomingExpiries)): ?>
                <p class="text-center py-8 text-slate-600 dark:text-slate-400">No upcoming expiries</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-700">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Customer</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Card</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Expiry Date</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Days Left</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($upcomingExpiries, 0, 5) as $expiry): ?>
                                <tr class="border-b border-slate-100 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                    <td class="py-3 px-4">
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">
                                            <?= htmlspecialchars($expiry['user_name']) ?>
                                        </div>
                                        <div class="text-xs text-slate-600 dark:text-slate-400">
                                            <?= htmlspecialchars($expiry['email']) ?>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-slate-600 dark:text-slate-400">
                                        •••• <?= substr($expiry['card_number'], -4) ?>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-slate-600 dark:text-slate-400">
                                        <?= date('m/Y', strtotime($expiry['expiry_date'])) ?>
                                    </td>
                                    <td class="py-3 px-4">
                                        <?php
                                        $days = $expiry['days_until_expiry'];
                                        $urgency = $days <= 30 ? 'text-red-600 dark:text-red-400' : ($days <= 60 ? 'text-yellow-600 dark:text-yellow-400' : 'text-slate-600 dark:text-slate-400');
                                        ?>
                                        <span class="text-sm font-semibold <?= $urgency ?>">
                                            <?= $days ?> days
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <a href="index.php?page=schedule-meeting&card_id=<?= $expiry['card_id'] ?>" 
                                           class="text-primary hover:underline text-sm">
                                            Schedule Meeting
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if (count($upcomingExpiries) > 5): ?>
                    <div class="mt-4 text-center">
                        <a href="index.php?page=admin-expiries" class="text-primary hover:underline text-sm">
                            View all <?= count($upcomingExpiries) ?> expiring cards
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
