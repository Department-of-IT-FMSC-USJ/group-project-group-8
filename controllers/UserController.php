<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Card.php';
require_once __DIR__ . '/../models/Meeting.php';
require_once __DIR__ . '/../models/Notification.php';
require_once __DIR__ . '/AuthController.php';

class UserController {
    
    
    public function dashboard() {
        AuthController::requireUser();
        
        $userId = $_SESSION['user_id'];
        
        $cardModel = new Card();
        $meetingModel = new Meeting();
        $notificationModel = new Notification();
        
        $cards = $cardModel->getActiveByUserId($userId);
        $meetings = $meetingModel->getPendingByUserId($userId);
        $notifications = $notificationModel->getUnreadByUserId($userId);
        $unreadCount = $notificationModel->getUnreadCount($userId);
        
        include __DIR__ . '/../views/user/dashboard.php';
    }
    
    
    public function profile() {
        AuthController::requireUser();
        
        $userId = $_SESSION['user_id'];
        $userModel = new User();
        $user = $userModel->findById($userId);
        
        include __DIR__ . '/../views/user/profile.php';
    }
    
    
    public function updateProfile() {
        AuthController::requireUser();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=user-profile');
            exit;
        }
        
        $userId = $_SESSION['user_id'];
        $fullName = $_POST['full_name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        
        $userModel = new User();
        $success = $userModel->update($userId, [
            'full_name' => $fullName,
            'phone' => $phone,
            'address' => $address
        ]);
        
        if ($success) {
            $_SESSION['user_name'] = $fullName;
            $_SESSION['success'] = 'Profile updated successfully';
        } else {
            $_SESSION['error'] = 'Failed to update profile';
        }
        
        header('Location: index.php?page=user-profile');
        exit;
    }
    
    
    public function notifications() {
        AuthController::requireUser();
        
        $userId = $_SESSION['user_id'];
        $notificationModel = new Notification();
        $notifications = $notificationModel->getByUserId($userId);
        
        include __DIR__ . '/../views/user/notifications.php';
    }
    
    
    public function markNotificationRead() {
        AuthController::requireUser();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false]);
            exit;
        }
        
        $userId = $_SESSION['user_id'];
        $notificationId = $_POST['notification_id'] ?? 0;
        
        $notificationModel = new Notification();
        $success = $notificationModel->markAsRead($notificationId, $userId);
        
        echo json_encode(['success' => $success]);
        exit;
    }
    
    
    public function viewMeeting() {
        AuthController::requireUser();
        
        $meetingId = $_GET['id'] ?? 0;
        $userId = $_SESSION['user_id'];
        
        $meetingModel = new Meeting();
        $meeting = $meetingModel->findById($meetingId);
        
        
        if (!$meeting || $meeting['user_id'] != $userId) {
            $_SESSION['error'] = 'Meeting not found';
            header('Location: index.php?page=user-dashboard');
            exit;
        }
        
        include __DIR__ . '/../views/user/meeting-details.php';
    }
    
    
    public function confirmMeeting() {
        AuthController::requireUser();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=user-dashboard');
            exit;
        }
        
        $meetingId = $_POST['meeting_id'] ?? 0;
        $userId = $_SESSION['user_id'];
        
        $meetingModel = new Meeting();
        $success = $meetingModel->confirmByUser($meetingId, $userId);
        
        if ($success) {
            $_SESSION['success'] = 'Meeting confirmed successfully';
        } else {
            $_SESSION['error'] = 'Failed to confirm meeting';
        }
        
        header('Location: index.php?page=user-dashboard');
        exit;
    }
}
