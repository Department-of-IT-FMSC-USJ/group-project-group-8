<?php
/**
 * Admin Controller
 * Handles bank officer dashboard and operations
 */

require_once __DIR__ . '/../models/Card.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Meeting.php';
require_once __DIR__ . '/../models/CardRenewal.php';
require_once __DIR__ . '/../models/Notification.php';
require_once __DIR__ . '/AuthController.php';

class AdminController {
    
    /**
     * Show admin dashboard
     */
    public function dashboard() {
        AuthController::requireOfficer();
        
        $officerId = $_SESSION['officer_id'];
        $branch = $_SESSION['officer_branch'];
        
        $cardModel = new Card();
        $meetingModel = new Meeting();
        $renewalModel = new CardRenewal();
        
        // Get statistics
        $upcomingExpiries = $cardModel->getUpcomingExpiriesByBranch($branch, 90);
        $myMeetings = $meetingModel->getByOfficerId($officerId);
        $renewals = $renewalModel->getByBranch($branch);
        
        include __DIR__ . '/../views/admin/dashboard.php';
    }
    
    /**
     * View users list
     */
    public function viewUsers() {
        AuthController::requireOfficer();
        
        $branch = $_SESSION['officer_branch'];
        
        $userModel = new User();
        $users = $userModel->getUsersByBranch($branch);
        
        include __DIR__ . '/../views/admin/users.php';
    }
    
    /**
     * View upcoming card expiries
     */
    public function viewExpiries() {
        AuthController::requireOfficer();
        
        $branch = $_SESSION['officer_branch'];
        
        $cardModel = new Card();
        $expiries = $cardModel->getUpcomingExpiriesByBranch($branch, 90);
        
        include __DIR__ . '/../views/admin/expiries.php';
    }
    
    /**
     * Show schedule meeting page
     */
    public function scheduleMeetingPage() {
        AuthController::requireOfficer();
        
        $cardId = $_GET['card_id'] ?? 0;
        
        $cardModel = new Card();
        $card = $cardModel->findById($cardId);
        
        if (!$card) {
            $_SESSION['error'] = 'Card not found';
            header('Location: index.php?page=admin-dashboard');
            exit;
        }
        
        include __DIR__ . '/../views/admin/schedule-meeting.php';
    }
    
    /**
     * Schedule meeting
     */
    public function scheduleMeeting() {
        AuthController::requireOfficer();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin-dashboard');
            exit;
        }
        
        $cardId = $_POST['card_id'] ?? 0;
        $userId = $_POST['user_id'] ?? 0;
        $meetingDate = $_POST['meeting_date'] ?? '';
        $meetingTime = $_POST['meeting_time'] ?? '';
        $zoomLink = $_POST['zoom_link'] ?? '';
        $officerId = $_SESSION['officer_id'];
        
        // Validation
        if (empty($meetingDate) || empty($meetingTime)) {
            $_SESSION['error'] = 'Please provide meeting date and time';
            header('Location: index.php?page=schedule-meeting&card_id=' . $cardId);
            exit;
        }
        
        $meetingDateTime = $meetingDate . ' ' . $meetingTime;
        
        $meetingModel = new Meeting();
        $meetingId = $meetingModel->create($cardId, $userId, $officerId, $meetingDateTime, $zoomLink);
        
        if ($meetingId) {
            // Create notification for user
            $notificationModel = new Notification();
            $notificationModel->create(
                $userId,
                'Meeting Scheduled',
                "A meeting has been scheduled for your card renewal on " . date('F j, Y \a\t g:i A', strtotime($meetingDateTime)) . ". Please confirm your attendance.",
                $meetingId
            );
            
            $_SESSION['success'] = 'Meeting scheduled successfully';
            header('Location: index.php?page=admin-dashboard');
            exit;
        } else {
            $_SESSION['error'] = 'Failed to schedule meeting';
            header('Location: index.php?page=schedule-meeting&card_id=' . $cardId);
            exit;
        }
    }
    
    /**
     * View meetings
     */
    public function viewMeetings() {
        AuthController::requireOfficer();
        
        $officerId = $_SESSION['officer_id'];
        
        $meetingModel = new Meeting();
        $meetings = $meetingModel->getByOfficerId($officerId);
        
        include __DIR__ . '/../views/admin/meetings.php';
    }
    
    /**
     * Update meeting status
     */
    public function updateMeetingStatus() {
        AuthController::requireOfficer();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin-meetings');
            exit;
        }
        
        $meetingId = $_POST['meeting_id'] ?? 0;
        $status = $_POST['status'] ?? '';
        $notes = $_POST['notes'] ?? '';
        
        $meetingModel = new Meeting();
        $success = $meetingModel->updateStatus($meetingId, $status, $notes);
        
        if ($success) {
            $_SESSION['success'] = 'Meeting status updated';
        } else {
            $_SESSION['error'] = 'Failed to update meeting status';
        }
        
        header('Location: index.php?page=admin-meetings');
        exit;
    }
    
    /**
     * View renewals
     */
    public function viewRenewals() {
        AuthController::requireOfficer();
        
        $branch = $_SESSION['officer_branch'];
        
        $renewalModel = new CardRenewal();
        $renewals = $renewalModel->getByBranch($branch);
        
        include __DIR__ . '/../views/admin/renewals.php';
    }
    
    /**
     * Show create renewal page
     */
    public function createRenewalPage() {
        AuthController::requireOfficer();
        
        $cardId = $_GET['card_id'] ?? 0;
        $meetingId = $_GET['meeting_id'] ?? null;
        
        $cardModel = new Card();
        $card = $cardModel->findById($cardId);
        
        if (!$card) {
            $_SESSION['error'] = 'Card not found';
            header('Location: index.php?page=admin-dashboard');
            exit;
        }
        
        include __DIR__ . '/../views/admin/create-renewal.php';
    }
    
    /**
     * Create renewal request
     */
    public function createRenewal() {
        AuthController::requireOfficer();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin-dashboard');
            exit;
        }
        
        $cardId = $_POST['card_id'] ?? 0;
        $meetingId = $_POST['meeting_id'] ?? null;
        $officerId = $_SESSION['officer_id'];
        
        $renewalModel = new CardRenewal();
        $renewalId = $renewalModel->create($cardId, $officerId, $meetingId);
        
        if ($renewalId) {
            $_SESSION['success'] = 'Renewal request created';
            header('Location: index.php?page=admin-renewals');
            exit;
        } else {
            $_SESSION['error'] = 'Failed to create renewal request';
            header('Location: index.php?page=admin-dashboard');
            exit;
        }
    }
    
    /**
     * Update delivery status
     */
    public function updateDeliveryStatus() {
        AuthController::requireOfficer();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin-renewals');
            exit;
        }
        
        $renewalId = $_POST['renewal_id'] ?? 0;
        $status = $_POST['delivery_status'] ?? '';
        $trackingNumber = $_POST['tracking_number'] ?? null;
        $notes = $_POST['notes'] ?? null;
        
        $renewalModel = new CardRenewal();
        $success = $renewalModel->updateDeliveryStatus($renewalId, $status, $trackingNumber, $notes);
        
        if ($success) {
            // If status is updated, notify the user
            $renewal = $renewalModel->findById($renewalId);
            if ($renewal) {
                $notificationModel = new Notification();
                
                $statusMessage = '';
                switch ($status) {
                    case 'processing':
                        $statusMessage = 'Your card renewal is being processed.';
                        break;
                    case 'issued':
                        $statusMessage = 'Your new card has been issued.';
                        break;
                    case 'sent_for_delivery':
                        $statusMessage = 'Your new card has been sent for delivery.';
                        if ($trackingNumber) {
                            $statusMessage .= ' Tracking number: ' . $trackingNumber;
                        }
                        break;
                    case 'delivered':
                        $statusMessage = 'Your new card has been delivered. Please activate it.';
                        break;
                }
                
                $notificationModel->create(
                    $renewal['user_id'],
                    'Card Delivery Status Update',
                    $statusMessage
                );
            }
            
            $_SESSION['success'] = 'Delivery status updated';
        } else {
            $_SESSION['error'] = 'Failed to update delivery status';
        }
        
        header('Location: index.php?page=admin-renewals');
        exit;
    }
}
