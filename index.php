<?php


require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/CardController.php';
require_once __DIR__ . '/controllers/AdminController.php';


$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? '';


switch ($page) {
    
    case 'home':
    case 'welcome':
        include __DIR__ . '/views/welcome.php';
        break;
    
    
    case 'user-login':
        $auth = new AuthController();
        $auth->userLoginPage();
        break;
    
    case 'user-login-submit':
        $auth = new AuthController();
        $auth->userLogin();
        break;
    
    case 'officer-login':
        $auth = new AuthController();
        $auth->officerLoginPage();
        break;
    
    case 'officer-login-submit':
        $auth = new AuthController();
        $auth->officerLogin();
        break;
    
    case 'user-register':
        $auth = new AuthController();
        $auth->userRegisterPage();
        break;
    
    case 'user-register-submit':
        $auth = new AuthController();
        $auth->userRegister();
        break;
    
    case 'officer-register':
        $auth = new AuthController();
        $auth->officerRegisterPage();
        break;
    
    case 'officer-register-submit':
        $auth = new AuthController();
        $auth->officerRegister();
        break;
    
    case 'logout':
        $auth = new AuthController();
        $auth->logout();
        break;
    
    
    case 'user-dashboard':
        $user = new UserController();
        $user->dashboard();
        break;
    
    case 'user-profile':
        $user = new UserController();
        if ($action === 'update') {
            $user->updateProfile();
        } else {
            $user->profile();
        }
        break;
    
    case 'user-notifications':
        $user = new UserController();
        $user->notifications();
        break;
    
    case 'mark-notification-read':
        $user = new UserController();
        $user->markNotificationRead();
        break;
    
    case 'view-meeting':
        $user = new UserController();
        $user->viewMeeting();
        break;
    
    case 'confirm-meeting':
        $user = new UserController();
        $user->confirmMeeting();
        break;
    
    
    case 'add-card':
        $card = new CardController();
        if ($action === 'submit') {
            $card->addCard();
        } else {
            $card->addCardPage();
        }
        break;
    
    case 'view-card':
        $card = new CardController();
        $card->viewCard();
        break;
    
    case 'renew-card':
        $card = new CardController();
        if ($action === 'submit') {
            $card->renewCard();
        } else {
            $card->renewCardPage();
        }
        break;
    
    case 'show-pin':
        $card = new CardController();
        $card->showPin();
        break;
    
    
    case 'admin-dashboard':
        $admin = new AdminController();
        $admin->dashboard();
        break;
    
    case 'admin-users':
        $admin = new AdminController();
        $admin->viewUsers();
        break;
    
    case 'admin-expiries':
        $admin = new AdminController();
        $admin->viewExpiries();
        break;
    
    case 'schedule-meeting':
        $admin = new AdminController();
        if ($action === 'submit') {
            $admin->scheduleMeeting();
        } else {
            $admin->scheduleMeetingPage();
        }
        break;
    
    case 'admin-meetings':
        $admin = new AdminController();
        $admin->viewMeetings();
        break;
    
    case 'update-meeting-status':
        $admin = new AdminController();
        $admin->updateMeetingStatus();
        break;
    
    case 'admin-renewals':
        $admin = new AdminController();
        $admin->viewRenewals();
        break;
    
    case 'create-renewal':
        $admin = new AdminController();
        if ($action === 'submit') {
            $admin->createRenewal();
        } else {
            $admin->createRenewalPage();
        }
        break;
    
    case 'update-delivery-status':
        $admin = new AdminController();
        $admin->updateDeliveryStatus();
        break;
    
    
    default:
        include __DIR__ . '/views/welcome.php';
        break;
}


if (!empty($action)) {
    switch ($action) {
        case 'register_officer':
            $auth = new AuthController();
            $auth->officerRegister();
            break;
    }
}
