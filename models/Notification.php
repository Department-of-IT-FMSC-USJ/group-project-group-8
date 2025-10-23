<?php
/**
 * Notification Model
 */

require_once __DIR__ . '/Model.php';

class Notification extends Model {
    
    /**
     * Create a new notification
     */
    public function create($userId, $title, $message, $meetingId = null) {
        $sql = "INSERT INTO notifications (user_id, meeting_id, title, message) 
                VALUES (:user_id, :meeting_id, :title, :message)";
        
        $params = [
            ':user_id' => $userId,
            ':meeting_id' => $meetingId,
            ':title' => $title,
            ':message' => $message
        ];
        
        if ($this->execute($sql, $params)) {
            return $this->lastInsertId();
        }
        return false;
    }
    
    /**
     * Get notifications for a user
     */
    public function getByUserId($userId, $limit = 50) {
        $sql = "SELECT * FROM notifications 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC 
                LIMIT :limit";
        
        return $this->fetchAll($sql, [
            ':user_id' => $userId,
            ':limit' => $limit
        ]);
    }
    
    /**
     * Get unread notifications for a user
     */
    public function getUnreadByUserId($userId) {
        $sql = "SELECT * FROM notifications 
                WHERE user_id = :user_id AND is_read = FALSE 
                ORDER BY created_at DESC";
        
        return $this->fetchAll($sql, [':user_id' => $userId]);
    }
    
    /**
     * Get unread count for a user
     */
    public function getUnreadCount($userId) {
        $sql = "SELECT COUNT(*) as count FROM notifications 
                WHERE user_id = :user_id AND is_read = FALSE";
        
        $result = $this->fetchOne($sql, [':user_id' => $userId]);
        return $result['count'];
    }
    
    /**
     * Mark notification as read
     */
    public function markAsRead($notificationId, $userId) {
        $sql = "UPDATE notifications SET is_read = TRUE 
                WHERE notification_id = :notification_id AND user_id = :user_id";
        
        return $this->execute($sql, [
            ':notification_id' => $notificationId,
            ':user_id' => $userId
        ]) !== false;
    }
    
    /**
     * Mark all notifications as read for a user
     */
    public function markAllAsRead($userId) {
        $sql = "UPDATE notifications SET is_read = TRUE WHERE user_id = :user_id";
        return $this->execute($sql, [':user_id' => $userId]) !== false;
    }
    
    /**
     * Delete notification
     */
    public function delete($notificationId, $userId) {
        $sql = "DELETE FROM notifications 
                WHERE notification_id = :notification_id AND user_id = :user_id";
        
        return $this->execute($sql, [
            ':notification_id' => $notificationId,
            ':user_id' => $userId
        ]) !== false;
    }
}
