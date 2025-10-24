<?php
$pageTitle = 'My Profile';
ob_start();
?>

<header class="bg-white dark:bg-slate-900 shadow-sm">
    <div class="px-4 py-4 flex items-center">
        <a href="index.php?page=user-dashboard" class="text-slate-800 dark:text-white mr-4">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">My Profile</h1>
    </div>
</header>

<main class="flex-grow p-4">
    <div class="max-w-2xl mx-auto">
        <form action="index.php?page=user-profile&action=update" method="POST" class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 space-y-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Full Name *</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required
                       class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent" />
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Email</label>
                <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled
                       class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-900 text-slate-500 dark:text-slate-400" />
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Phone</label>
                <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
                       class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent" />
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Address</label>
                <textarea name="address" rows="3"
                          class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
            </div>
            
            <button type="submit" class="w-full bg-primary hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                Update Profile
            </button>
        </form>
    </div>
</main>

<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
