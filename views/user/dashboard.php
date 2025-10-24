<?php
$pageTitle = 'My Dashboard';
$customCSS = 'homepage.css';
ob_start();
?>

<header class="bg-white dark:bg-slate-900 shadow-sm">
    <div class="px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
            My Dashboard
        </h1>
        <div class="flex gap-2">
            <a href="index.php?page=user-notifications" class="relative p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
                <span class="material-symbols-outlined">notifications</span>
                <?php if ($unreadCount > 0): ?>
                    <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                        <?= $unreadCount ?>
                    </span>
                <?php endif; ?>
            </a>
            <a href="index.php?page=logout" class="p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
                <span class="material-symbols-outlined">logout</span>
            </a>
        </div>
    </div>
</header>

<main class="flex-grow p-4">
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
            <h2 class="text-2xl font-bold mb-2">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h2>
            <p>Manage your debit cards and renewals easily</p>
        </div>
        
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="index.php?page=add-card" class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="bg-primary/10 p-3 rounded-lg">
                        <span class="material-symbols-outlined text-primary text-3xl">add_card</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white">Add New Card</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Register a debit card</p>
                    </div>
                </div>
            </a>
            
            <a href="index.php?page=user-profile" class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-lg">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-3xl">person</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white">My Profile</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Update your information</p>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- My Cards -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">My Cards</h2>
            
            <?php if (empty($cards)): ?>
                <div class="text-center py-8 text-slate-600 dark:text-slate-400">
                    <span class="material-symbols-outlined text-6xl mb-4 opacity-30">credit_card_off</span>
                    <p>No cards registered yet</p>
                    <a href="index.php?page=add-card" class="text-primary hover:underline mt-2 inline-block">
                        Add your first card
                    </a>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($cards as $card): ?>
                        <?php
                        $expiryDate = new DateTime($card['expiry_date']);
                        $today = new DateTime();
                        $daysUntilExpiry = $today->diff($expiryDate)->days;
                        $isExpiring = $daysUntilExpiry <= 90;
                        ?>
                        <div class="border border-slate-200 dark:border-slate-700 rounded-lg p-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                            <div class="flex justify-between items-start">
                                <div class="flex-grow">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="material-symbols-outlined text-blue-500">credit_card</span>
                                        <h3 class="font-semibold text-slate-900 dark:text-white">
                                            <?= htmlspecialchars($card['cardholder_name']) ?>
                                        </h3>
                                    </div>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">
                                        •••• •••• •••• <?= substr($card['card_number'], -4) ?>
                                    </p>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">
                                        Branch: <?= htmlspecialchars($card['branch']) ?>
                                    </p>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">
                                        Expires: <?= $expiryDate->format('m/Y') ?>
                                    </p>
                                    
                                    <?php if ($isExpiring): ?>
                                        <div class="mt-2 inline-flex items-center gap-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 text-xs px-3 py-1 rounded-full">
                                            <span class="material-symbols-outlined text-sm">warning</span>
                                            Expires in <?= $daysUntilExpiry ?> days
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <a href="index.php?page=view-card&id=<?= $card['card_id'] ?>" 
                                   class="text-primary hover:underline text-sm">
                                    View Details
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Upcoming Meetings -->
        <?php if (!empty($meetings)): ?>
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Upcoming Meetings</h2>
            <div class="space-y-4">
                <?php foreach ($meetings as $meeting): ?>
                    <?php
                    $meetingDate = new DateTime($meeting['meeting_date']);
                    ?>
                    <div class="border border-slate-200 dark:border-slate-700 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-slate-900 dark:text-white mb-1">
                                    Card Renewal Meeting
                                </h3>
                                <p class="text-sm text-slate-600 dark:text-slate-400">
                                    <span class="material-symbols-outlined text-xs">calendar_today</span>
                                    <?= $meetingDate->format('F j, Y \a\t g:i A') ?>
                                </p>
                                <p class="text-sm text-slate-600 dark:text-slate-400">
                                    Card: •••• <?= substr($meeting['card_number'], -4) ?>
                                </p>
                                <p class="text-sm text-slate-600 dark:text-slate-400">
                                    Officer: <?= htmlspecialchars($meeting['officer_name']) ?>
                                </p>
                                
                                <?php if ($meeting['zoom_link']): ?>
                                    <a href="<?= htmlspecialchars($meeting['zoom_link']) ?>" 
                                       target="_blank"
                                       class="text-primary hover:underline text-sm mt-2 inline-block">
                                        Join Zoom Meeting
                                    </a>
                                <?php endif; ?>
                            </div>
                            
                            <?php if (!$meeting['user_confirmed']): ?>
                                <form action="index.php?page=confirm-meeting" method="POST">
                                    <input type="hidden" name="meeting_id" value="<?= $meeting['meeting_id'] ?>">
                                    <button type="submit" 
                                            class="bg-primary hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                                        Confirm
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 px-3 py-1 rounded-full text-sm">
                                    Confirmed
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
