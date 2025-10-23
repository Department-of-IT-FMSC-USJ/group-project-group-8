<?php

require_once __DIR__ . '/Model.php';

class Card extends Model {
    
   
    public function create($userId, $cardNumber, $cardholderName, $branch, $expiryDate, $pin = null) {
        $hashedPin = $pin ? password_hash($pin, PASSWORD_DEFAULT) : null;
        
        $sql = "INSERT INTO cards (user_id, card_number, cardholder_name, branch, expiry_date, card_pin) 
                VALUES (:user_id, :card_number, :cardholder_name, :branch, :expiry_date, :card_pin)";
        
        $params = [
            ':user_id' => $userId,
            ':card_number' => $cardNumber,
            ':cardholder_name' => $cardholderName,
            ':branch' => $branch,
            ':expiry_date' => $expiryDate,
            ':card_pin' => $hashedPin
        ];
        
        if ($this->execute($sql, $params)) {
            return $this->lastInsertId();
        }
        return false;
    }
    
   
    public function findById($cardId) {
        $sql = "SELECT c.*, u.full_name as user_name, u.email, u.phone 
                FROM cards c
                INNER JOIN users u ON c.user_id = u.user_id
                WHERE c.card_id = :card_id";
        
        return $this->fetchOne($sql, [':card_id' => $cardId]);
    }
    
    
    public function getByUserId($userId) {
        $sql = "SELECT * FROM cards WHERE user_id = :user_id ORDER BY created_at DESC";
        return $this->fetchAll($sql, [':user_id' => $userId]);
    }
    
    
    public function getActiveByUserId($userId) {
        $sql = "SELECT * FROM cards WHERE user_id = :user_id AND is_active = TRUE ORDER BY expiry_date ASC";
        return $this->fetchAll($sql, [':user_id' => $userId]);
    }
    
  
    public function getUpcomingExpiries($days = 90) {
        $sql = "SELECT * FROM upcoming_expiries WHERE days_until_expiry <= :days";
        return $this->fetchAll($sql, [':days' => $days]);
    }
    
   
    public function getUpcomingExpiriesByBranch($branch, $days = 90) {
        $sql = "SELECT * FROM upcoming_expiries WHERE branch = :branch AND days_until_expiry <= :days";
        return $this->fetchAll($sql, [':branch' => $branch, ':days' => $days]);
    }
  
    public function updateCardDetails($cardId, $newCardNumber, $newExpiryDate, $newPin) {
        $hashedPin = password_hash($newPin, PASSWORD_DEFAULT);
        
        $sql = "UPDATE cards SET 
                card_number = :card_number,
                expiry_date = :expiry_date,
                card_pin = :card_pin,
                updated_at = CURRENT_TIMESTAMP
                WHERE card_id = :card_id";
        
        $params = [
            ':card_id' => $cardId,
            ':card_number' => $newCardNumber,
            ':expiry_date' => $newExpiryDate,
            ':card_pin' => $hashedPin
        ];
        
        return $this->execute($sql, $params) !== false;
    }
    
   
    public function deactivate($cardId) {
        $sql = "UPDATE cards SET is_active = FALSE WHERE card_id = :card_id";
        return $this->execute($sql, [':card_id' => $cardId]) !== false;
    }
    
   
    public function getByBranch($branch) {
        $sql = "SELECT c.*, u.full_name as user_name, u.email, u.phone 
                FROM cards c
                INNER JOIN users u ON c.user_id = u.user_id
                WHERE c.branch = :branch AND c.is_active = TRUE
                ORDER BY c.expiry_date ASC";
        
        return $this->fetchAll($sql, [':branch' => $branch]);
    }
    
   
    public function cardNumberExists($cardNumber, $excludeCardId = null) {
        if ($excludeCardId) {
            $sql = "SELECT COUNT(*) as count FROM cards WHERE card_number = :card_number AND card_id != :card_id";
            $result = $this->fetchOne($sql, [':card_number' => $cardNumber, ':card_id' => $excludeCardId]);
        } else {
            $sql = "SELECT COUNT(*) as count FROM cards WHERE card_number = :card_number";
            $result = $this->fetchOne($sql, [':card_number' => $cardNumber]);
        }
        
        return $result['count'] > 0;
    }
}
