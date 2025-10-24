<?php
$pageTitle = 'Card Renewals';
ob_start();
?>

<header class="bg-white dark:bg-slate-900 shadow-sm">
    <div class="px-4 py-4 flex items-center">
        <a href="index.php?page=admin-dashboard" class="text-slate-800 dark:text-white mr-4">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
            Card Renewals
        </h1>
    </div>
</header>

<main class="flex-grow p-4">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6">
            <?php if (empty($renewals)): ?>
                <p class="text-center py-8 text-slate-600 dark:text-slate-400">No renewals found</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-700">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Customer</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Card</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Requested</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Status</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($renewals as $renewal): ?>
                                <tr class="border-b border-slate-100 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                    <td class="py-3 px-4">
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">
                                            <?= htmlspecialchars($renewal['user_name']) ?>
                                        </div>
                                        <div class="text-xs text-slate-600 dark:text-slate-400">
                                            <?= htmlspecialchars($renewal['email']) ?>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-slate-600 dark:text-slate-400">
                                        •••• <?= substr($renewal['old_card_number'], -4) ?>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-slate-600 dark:text-slate-400">
                                        <?= date('M j, Y', strtotime($renewal['renewal_requested_at'])) ?>
                                    </td>
                                    <td class="py-3 px-4">
                                        <?php
                                        $statusColors = [
                                            'processing' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300',
                                            'issued' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300',
                                            'sent_for_delivery' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300',
                                            'delivered' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300'
                                        ];
                                        $statusClass = $statusColors[$renewal['delivery_status']] ?? 'bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-300';
                                        ?>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $statusClass ?>">
                                            <?= ucfirst(str_replace('_', ' ', $renewal['delivery_status'])) ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <button onclick="openUpdateModal(<?= $renewal['renewal_id'] ?>, '<?= $renewal['delivery_status'] ?>')" 
                                                class="text-primary hover:underline text-sm">
                                            Update Status
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>


<div id="updateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-xl max-w-md w-full p-6">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Update Delivery Status</h2>
        
        <form action="index.php?page=update-delivery-status" method="POST" class="space-y-4">
            <input type="hidden" id="renewal_id" name="renewal_id">
            
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Status
                </label>
                <select name="delivery_status" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                    <option value="processing">Processing</option>
                    <option value="issued">Issued</option>
                    <option value="sent_for_delivery">Sent for Delivery</option>
                    <option value="delivered">Delivered</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Tracking Number (optional)
                </label>
                <input type="text" name="tracking_number"
                       class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Notes (optional)
                </label>
                <textarea name="notes" rows="3"
                          class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white"></textarea>
            </div>
            
            <div class="flex gap-4">
                <button type="button" onclick="closeUpdateModal()"
                        class="flex-1 bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-semibold py-2 px-4 rounded-lg">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 bg-primary hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openUpdateModal(renewalId, currentStatus) {
    document.getElementById('renewal_id').value = renewalId;
    document.querySelector('[name="delivery_status"]').value = currentStatus;
    document.getElementById('updateModal').classList.remove('hidden');
}

function closeUpdateModal() {
    document.getElementById('updateModal').classList.add('hidden');
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
