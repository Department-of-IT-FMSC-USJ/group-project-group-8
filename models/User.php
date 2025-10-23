<?php


require_once __DIR__ . '/Model.php';

class User extends Model {
    
    
    public function create($fullName, $email, $password, $phone = null, $address = null) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (full_name, email, password, phone, address) 
                VALUES (:full_name, :email, :password, :phone, :address)";
        
        $params = [
            ':full_name' => $fullName,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':phone' => $phone,
            ':address' => $address
        ];
        
        if ($this->execute($sql, $params)) {
            return $this->lastInsertId();
        }
        return false;
    }
    
   
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        return $this->fetchOne($sql, [':email' => $email]);
    }
    
 
    public function findById($userId) {
        $sql = "SELECT * FROM users WHERE user_id = :user_id";
        return $this->fetchOne($sql, [':user_id' => $userId]);
    }
    
 
    public function verifyPassword($email, $password) {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    

    public function update($userId, $data) {
        $sql = "UPDATE users SET 
                full_name = :full_name,
                phone = :phone,
                address = :address,
                updated_at = CURRENT_TIMESTAMP
                WHERE user_id = :user_id";
        
        $params = [
            ':user_id' => $userId,
            ':full_name' => $data['full_name'],
            ':phone' => $data['phone'],
            ':address' => $data['address']
        ];
        
        return $this->execute($sql, $params) !== false;
    }
    
   
    public function getAll() {
        $sql = "SELECT user_id, full_name, email, phone, address, created_at FROM users ORDER BY created_at DESC";
        return $this->fetchAll($sql);
    }
    
  
    public function getUsersByBranch($branch) {
        $sql = "SELECT DISTINCT u.* 
                FROM users u
                INNER JOIN cards c ON u.user_id = c.user_id
                WHERE c.branch = :branch
                ORDER BY u.full_name";
        
        return $this->fetchAll($sql, [':branch' => $branch]);
    }
}
