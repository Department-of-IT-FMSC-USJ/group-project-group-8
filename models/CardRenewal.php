<?php

require_once __DIR__ . '/Model.php';

class CardRenewal extends Model {
    
   
    public function create($oldCardId, $officerId = null, $meetingId = null) {
        $sql = "INSERT INTO card_renewals (old_card_id, officer_id, meeting_id, delivery_status) 
                VALUES (:old_card_id, :officer_id, :meeting_id, 'processing')";
        
        $params = [
            ':old_card_id' => $oldCardId,
            ':officer_id' => $officerId,
            ':meeting_id' => $meetingId
        ];
        
        if ($this->execute($sql, $params)) {
            return $this->lastInsertId();
        }
        return false;
    }
    
  
    public function findById($renewalId) {
        $sql = "SELECT r.*, 
                c.card_number as old_card_number, c.cardholder_name, c.branch,
                u.user_id, u.full_name as user_name, u.email, u.phone,
                o.full_name as officer_name
                FROM card_renewals r
                INNER JOIN cards c ON r.old_card_id = c.card_id
                INNER JOIN users u ON c.user_id = u.user_id
                LEFT JOIN bank_officers o ON r.officer_id = o.officer_id
                WHERE r.renewal_id = :renewal_id";
        
        return $this->fetchOne($sql, [':renewal_id' => $renewalId]);
    }
    
    /**
     * Get renewal by card ID
     */
    public function getByCardId($cardId) {
        $sql = "SELECT * FROM card_renewals 
                WHERE old_card_id = :card_id 
                ORDER BY renewal_requested_at DESC 
                LIMIT 1";
        
        return $this->fetchOne($sql, [':card_id' => $cardId]);
    }
    
   
    public function getByOfficerId($officerId) {
        $sql = "SELECT r.*, 
                c.card_number as old_card_number, c.cardholder_name, c.branch,
                u.full_name as user_name, u.email, u.phone
                FROM card_renewals r
                INNER JOIN cards c ON r.old_card_id = c.card_id
                INNER JOIN users u ON c.user_id = u.user_id
                WHERE r.officer_id = :officer_id
                ORDER BY r.renewal_requested_at DESC";
        
        return $this->fetchAll($sql, [':officer_id' => $officerId]);
    }
    
 
    public function getByBranch($branch) {
        $sql = "SELECT r.*, 
                c.card_number as old_card_number, c.cardholder_name, c.branch,
                u.full_name as user_name, u.email, u.phone,
                o.full_name as officer_name
                FROM card_renewals r
                INNER JOIN cards c ON r.old_card_id = c.card_id
                INNER JOIN users u ON c.user_id = u.user_id
                LEFT JOIN bank_officers o ON r.officer_id = o.officer_id
                WHERE c.branch = :branch
                ORDER BY r.renewal_requested_at DESC";
        
        return $this->fetchAll($sql, [':branch' => $branch]);
    }
    
 
    public function updateDeliveryStatus($renewalId, $status, $trackingNumber = null, $notes = null) {
        $issuedAt = null;
        $deliveredAt = null;
        
        if ($status === 'issued') {
            $issuedAt = date('Y-m-d H:i:s');
        } elseif ($status === 'delivered') {
            $deliveredAt = date('Y-m-d H:i:s');
        }
        
        $sql = "UPDATE card_renewals SET 
                delivery_status = :status,
                tracking_number = :tracking_number,
                notes = :notes,
                issued_at = COALESCE(:issued_at, issued_at),
                delivered_at = COALESCE(:delivered_at, delivered_at)
                WHERE renewal_id = :renewal_id";
        
        return $this->execute($sql, [
            ':renewal_id' => $renewalId,
            ':status' => $status,
            ':tracking_number' => $trackingNumber,
            ':notes' => $notes,
            ':issued_at' => $issuedAt,
            ':delivered_at' => $deliveredAt
        ]) !== false;
    }
    
   
    public function updateNewCardDetails($renewalId, $newCardNumber, $newExpiryDate, $newPin) {
        $hashedPin = password_hash($newPin, PASSWORD_DEFAULT);
        
        $sql = "UPDATE card_renewals SET 
                new_card_number = :new_card_number,
                new_expiry_date = :new_expiry_date,
                new_pin = :new_pin
                WHERE renewal_id = :renewal_id";
        
        return $this->execute($sql, [
            ':renewal_id' => $renewalId,
            ':new_card_number' => $newCardNumber,
            ':new_expiry_date' => $newExpiryDate,
            ':new_pin' => $hashedPin
        ]) !== false;
    }
    

    public function getProcessing() {
        $sql = "SELECT r.*, 
                c.card_number as old_card_number, c.cardholder_name, c.branch,
                u.full_name as user_name, u.email, u.phone
                FROM card_renewals r
                INNER JOIN cards c ON r.old_card_id = c.card_id
                INNER JOIN users u ON c.user_id = u.user_id
                WHERE r.delivery_status = 'processing'
                ORDER BY r.renewal_requested_at ASC";
        
        return $this->fetchAll($sql);
    }
}
