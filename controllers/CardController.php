<?php


require_once __DIR__ . '/../models/Card.php';
require_once __DIR__ . '/../models/CardRenewal.php';
require_once __DIR__ . '/AuthController.php';

class CardController {
    
   
    public function addCardPage() {
        AuthController::requireUser();
        include __DIR__ . '/../views/user/add-card.php';
    }
    
   
    public function addCard() {
        AuthController::requireUser();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=add-card');
            exit;
        }
        
        $userId = $_SESSION['user_id'];
        $cardNumber = $_POST['card_number'] ?? '';
        $cardholderName = $_POST['cardholder_name'] ?? '';
        $branch = $_POST['branch'] ?? '';
        $expiryDate = $_POST['expiry_date'] ?? '';
        
       
        if (empty($cardNumber) || empty($cardholderName) || empty($branch) || empty($expiryDate)) {
            $_SESSION['error'] = 'Please fill in all fields';
            header('Location: index.php?page=add-card');
            exit;
        }
        
       
        if (!preg_match('/^\d{16}$/', $cardNumber)) {
            $_SESSION['error'] = 'Card number must be 16 digits';
            header('Location: index.php?page=add-card');
            exit;
        }
        
        $cardModel = new Card();
        
      
        if ($cardModel->cardNumberExists($cardNumber)) {
            $_SESSION['error'] = 'Card number already registered';
            header('Location: index.php?page=add-card');
            exit;
        }
        
        $cardId = $cardModel->create($userId, $cardNumber, $cardholderName, $branch, $expiryDate);
        
        if ($cardId) {
            $_SESSION['success'] = 'Card added successfully';
            header('Location: index.php?page=user-dashboard');
            exit;
        } else {
            $_SESSION['error'] = 'Failed to add card';
            header('Location: index.php?page=add-card');
            exit;
        }
    }
    
  
    public function viewCard() {
        AuthController::requireUser();
        
        $cardId = $_GET['id'] ?? 0;
        $userId = $_SESSION['user_id'];
        
        $cardModel = new Card();
        $card = $cardModel->findById($cardId);
        
       
        if (!$card || $card['user_id'] != $userId) {
            $_SESSION['error'] = 'Card not found';
            header('Location: index.php?page=user-dashboard');
            exit;
        }
        
        $renewalModel = new CardRenewal();
        $renewal = $renewalModel->getByCardId($cardId);
        
        include __DIR__ . '/../views/user/card-details.php';
    }
    
   
    public function renewCardPage() {
        AuthController::requireUser();
        
        $cardId = $_GET['id'] ?? 0;
        $userId = $_SESSION['user_id'];
        
        $cardModel = new Card();
        $card = $cardModel->findById($cardId);
        
       
        if (!$card || $card['user_id'] != $userId) {
            $_SESSION['error'] = 'Card not found';
            header('Location: index.php?page=user-dashboard');
            exit;
        }
        
        
        $renewalModel = new CardRenewal();
        $existingRenewal = $renewalModel->getByCardId($cardId);
        
        if ($existingRenewal && $existingRenewal['delivery_status'] !== 'delivered') {
            $_SESSION['error'] = 'Card renewal already in progress';
            header('Location: index.php?page=view-card&id=' . $cardId);
            exit;
        }
        
        include __DIR__ . '/../views/user/renew-card.php';
    }
    

    public function renewCard() {
        AuthController::requireUser();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=user-dashboard');
            exit;
        }
        
        $userId = $_SESSION['user_id'];
        $cardId = $_POST['card_id'] ?? 0;
        $newCardNumber = $_POST['new_card_number'] ?? '';
        $newExpiryDate = $_POST['new_expiry_date'] ?? '';
        
     
        if (empty($newCardNumber) || empty($newExpiryDate)) {
            $_SESSION['error'] = 'Please fill in all fields';
            header('Location: index.php?page=renew-card&id=' . $cardId);
            exit;
        }
        
        
        if (!preg_match('/^\d{16}$/', $newCardNumber)) {
            $_SESSION['error'] = 'Card number must be 16 digits';
            header('Location: index.php?page=renew-card&id=' . $cardId);
            exit;
        }
        
        $cardModel = new Card();
        $card = $cardModel->findById($cardId);
        
        
        if (!$card || $card['user_id'] != $userId) {
            $_SESSION['error'] = 'Card not found';
            header('Location: index.php?page=user-dashboard');
            exit;
        }
        
        
        $newPin = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        
        
        $success = $cardModel->updateCardDetails($cardId, $newCardNumber, $newExpiryDate, $newPin);
        
        if ($success) {
            
            $_SESSION['new_pin'] = $newPin;
            $_SESSION['success'] = 'Card renewed successfully';
            header('Location: index.php?page=show-pin&card_id=' . $cardId);
            exit;
        } else {
            $_SESSION['error'] = 'Failed to renew card';
            header('Location: index.php?page=renew-card&id=' . $cardId);
            exit;
        }
    }
    
 
    public function showPin() {
        AuthController::requireUser();
        
        $cardId = $_GET['card_id'] ?? 0;
        
      
        if (!isset($_SESSION['new_pin'])) {
            $_SESSION['error'] = 'PIN not available';
            header('Location: index.php?page=user-dashboard');
            exit;
        }
        
        $pin = $_SESSION['new_pin'];
        
        $cardModel = new Card();
        $card = $cardModel->findById($cardId);
        
        include __DIR__ . '/../views/user/show-pin.php';
        
        
        unset($_SESSION['new_pin']);
    }
}
