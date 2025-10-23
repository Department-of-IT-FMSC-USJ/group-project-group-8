<?php


require_once __DIR__ . '/Model.php';

class Meeting extends Model {
    
    
    public function create($cardId, $userId, $officerId, $meetingDate, $zoomLink = null) {
        $sql = "INSERT INTO meetings (card_id, user_id, officer_id, meeting_date, zoom_link, status) 
                VALUES (:card_id, :user_id, :officer_id, :meeting_date, :zoom_link, 'scheduled')";
        
        $params = [
            ':card_id' => $cardId,
            ':user_id' => $userId,
            ':officer_id' => $officerId,
            ':meeting_date' => $meetingDate,
            ':zoom_link' => $zoomLink
        ];
        
        if ($this->execute($sql, $params)) {
            return $this->lastInsertId();
        }
        return false;
    }
    
    
    public function findById($meetingId) {
        $sql = "SELECT m.*, 
                u.full_name as user_name, u.email as user_email, u.phone as user_phone,
                o.full_name as officer_name, o.email as officer_email,
                c.card_number, c.expiry_date
                FROM meetings m
                INNER JOIN users u ON m.user_id = u.user_id
                INNER JOIN bank_officers o ON m.officer_id = o.officer_id
                INNER JOIN cards c ON m.card_id = c.card_id
                WHERE m.meeting_id = :meeting_id";
        
        return $this->fetchOne($sql, [':meeting_id' => $meetingId]);
    }
    
    
    public function getByUserId($userId) {
        $sql = "SELECT m.*, 
                o.full_name as officer_name, o.email as officer_email,
                c.card_number, c.expiry_date
                FROM meetings m
                INNER JOIN bank_officers o ON m.officer_id = o.officer_id
                INNER JOIN cards c ON m.card_id = c.card_id
                WHERE m.user_id = :user_id
                ORDER BY m.meeting_date DESC";
        
        return $this->fetchAll($sql, [':user_id' => $userId]);
    }
    
    
    public function getByOfficerId($officerId) {
        $sql = "SELECT m.*, 
                u.full_name as user_name, u.email as user_email, u.phone as user_phone,
                c.card_number, c.expiry_date
                FROM meetings m
                INNER JOIN users u ON m.user_id = u.user_id
                INNER JOIN cards c ON m.card_id = c.card_id
                WHERE m.officer_id = :officer_id
                ORDER BY m.meeting_date DESC";
        
        return $this->fetchAll($sql, [':officer_id' => $officerId]);
    }
    
    
    public function getPendingByUserId($userId) {
        $sql = "SELECT m.*, 
                o.full_name as officer_name, o.email as officer_email,
                c.card_number, c.expiry_date
                FROM meetings m
                INNER JOIN bank_officers o ON m.officer_id = o.officer_id
                INNER JOIN cards c ON m.card_id = c.card_id
                WHERE m.user_id = :user_id AND m.status IN ('scheduled', 'confirmed')
                ORDER BY m.meeting_date ASC";
        
        return $this->fetchAll($sql, [':user_id' => $userId]);
    }
    
    
    public function confirmByUser($meetingId, $userId) {
        $sql = "UPDATE meetings SET 
                user_confirmed = TRUE,
                status = 'confirmed',
                updated_at = CURRENT_TIMESTAMP
                WHERE meeting_id = :meeting_id AND user_id = :user_id";
        
        return $this->execute($sql, [
            ':meeting_id' => $meetingId,
            ':user_id' => $userId
        ]) !== false;
    }
    
    
    public function updateStatus($meetingId, $status, $notes = null) {
        $sql = "UPDATE meetings SET 
                status = :status,
                notes = :notes,
                updated_at = CURRENT_TIMESTAMP
                WHERE meeting_id = :meeting_id";
        
        return $this->execute($sql, [
            ':meeting_id' => $meetingId,
            ':status' => $status,
            ':notes' => $notes
        ]) !== false;
    }
    
    
    public function update($meetingId, $meetingDate, $zoomLink = null) {
        $sql = "UPDATE meetings SET 
                meeting_date = :meeting_date,
                zoom_link = :zoom_link,
                updated_at = CURRENT_TIMESTAMP
                WHERE meeting_id = :meeting_id";
        
        return $this->execute($sql, [
            ':meeting_id' => $meetingId,
            ':meeting_date' => $meetingDate,
            ':zoom_link' => $zoomLink
        ]) !== false;
    }
    
    
    public function delete($meetingId) {
        $sql = "DELETE FROM meetings WHERE meeting_id = :meeting_id";
        return $this->execute($sql, [':meeting_id' => $meetingId]) !== false;
    }
}
