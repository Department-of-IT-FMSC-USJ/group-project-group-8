<?php


require_once __DIR__ . '/Model.php';

class BankOfficer extends Model {
    
    public function create($fullName, $email, $password, $branch, $phone = null) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO bank_officers (full_name, email, password, branch, phone) 
                VALUES (:full_name, :email, :password, :branch, :phone)";
        
        $params = [
            ':full_name' => $fullName,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':branch' => $branch,
            ':phone' => $phone
        ];
        
        if ($this->execute($sql, $params)) {
            return $this->lastInsertId();
        }
        return false;
    }
    
    
    public function findByEmail($email) {
        $sql = "SELECT * FROM bank_officers WHERE email = :email";
        return $this->fetchOne($sql, [':email' => $email]);
    }
    
    
    public function findById($officerId) {
        $sql = "SELECT * FROM bank_officers WHERE officer_id = :officer_id";
        return $this->fetchOne($sql, [':officer_id' => $officerId]);
    }
    
  
    public function verifyPassword($email, $password) {
        $officer = $this->findByEmail($email);
        
        if ($officer && password_verify($password, $officer['password'])) {
            return $officer;
        }
        return false;
    }
    
   
    public function getAll() {
        $sql = "SELECT officer_id, full_name, email, branch, phone, created_at 
                FROM bank_officers 
                ORDER BY full_name";
        return $this->fetchAll($sql);
    }
    
    
    public function getByBranch($branch) {
        $sql = "SELECT officer_id, full_name, email, branch, phone 
                FROM bank_officers 
                WHERE branch = :branch
                ORDER BY full_name";
        
        return $this->fetchAll($sql, [':branch' => $branch]);
    }
}
