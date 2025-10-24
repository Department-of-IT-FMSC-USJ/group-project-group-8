<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/BankOfficer.php';

class AuthController {
    
    public function userLoginPage() {
        include __DIR__ . '/../views/auth/user-login.php';
    }
    
    public function officerLoginPage() {
        include __DIR__ . '/../views/auth/officer-login.php';
    }
    
  
    public function userLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=user-login');
            exit;
        }
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Please provide email and password';
            header('Location: index.php?page=user-login');
            exit;
        }
        
        $userModel = new User();
        $user = $userModel->verifyPassword($email, $password);
        
        if ($user) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_type'] = 'user';
            
            header('Location: index.php?page=user-dashboard');
            exit;
        } else {
            $_SESSION['error'] = 'Invalid email or password';
            header('Location: index.php?page=user-login');
            exit;
        }
    }
    
    public function officerLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=officer-login');
            exit;
        }
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Please provide email and password';
            header('Location: index.php?page=officer-login');
            exit;
        }
        
        $officerModel = new BankOfficer();
        $officer = $officerModel->verifyPassword($email, $password);
        
        if ($officer) {
            $_SESSION['officer_id'] = $officer['officer_id'];
            $_SESSION['officer_name'] = $officer['full_name'];
            $_SESSION['officer_email'] = $officer['email'];
            $_SESSION['officer_branch'] = $officer['branch'];
            $_SESSION['user_type'] = 'officer';
            
            header('Location: index.php?page=admin-dashboard');
            exit;
        } else {
            $_SESSION['error'] = 'Invalid email or password';
            header('Location: index.php?page=officer-login');
            exit;
        }
    }
    
 
    public function userRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=user-register');
            exit;
        }
        
        $fullName = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        
        // Validation
        if (empty($fullName) || empty($email) || empty($password)) {
            $_SESSION['error'] = 'Please fill in all required fields';
            header('Location: index.php?page=user-register');
            exit;
        }
        
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match';
            header('Location: index.php?page=user-register');
            exit;
        }
        
        $userModel = new User();
        
        // Check if email already exists
        if ($userModel->findByEmail($email)) {
            $_SESSION['error'] = 'Email already registered';
            header('Location: index.php?page=user-register');
            exit;
        }
        
        $userId = $userModel->create($fullName, $email, $password, $phone, $address);
        
        if ($userId) {
            $_SESSION['success'] = 'Registration successful! Please login.';
            header('Location: index.php?page=user-login');
            exit;
        } else {
            $_SESSION['error'] = 'Registration failed. Please try again.';
            header('Location: index.php?page=user-register');
            exit;
        }
    }
    

    public function userRegisterPage() {
        include __DIR__ . '/../views/auth/user-register.php';
    }
    
    
    public function officerRegisterPage() {
        include __DIR__ . '/../views/auth/officer-register.php';
    }
    
    
    public function officerRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=officer-register');
            exit;
        }
        
        $fullName = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $branch = $_POST['branch'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $accessCode = $_POST['access_code'] ?? '';
        
        // Validate access code
        define('OFFICER_ACCESS_CODE', 'BANK2025SECRET');
        
        if ($accessCode !== OFFICER_ACCESS_CODE) {
            $_SESSION['error'] = 'Invalid access code';
            header('Location: index.php?page=officer-register');
            exit;
        }
        
        // Validation
        if (empty($fullName) || empty($email) || empty($password) || empty($branch)) {
            $_SESSION['error'] = 'Please fill in all required fields';
            header('Location: index.php?page=officer-register');
            exit;
        }
        
        if (strlen($password) < 8) {
            $_SESSION['error'] = 'Password must be at least 8 characters';
            header('Location: index.php?page=officer-register');
            exit;
        }
        
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match';
            header('Location: index.php?page=officer-register');
            exit;
        }
        
        $officerModel = new BankOfficer();
        
        // Check if email already exists
        if ($officerModel->findByEmail($email)) {
            $_SESSION['error'] = 'Email already registered';
            header('Location: index.php?page=officer-register');
            exit;
        }
        
        $officerId = $officerModel->create($fullName, $email, $password, $branch, $phone);
        
        if ($officerId) {
            $_SESSION['success'] = 'Officer account created successfully! Please login.';
            header('Location: index.php?page=officer-login');
            exit;
        } else {
            $_SESSION['error'] = 'Registration failed. Please try again.';
            header('Location: index.php?page=officer-register');
            exit;
        }
    }
    

    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }
    
    public static function isUserLoggedIn() {
        return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'user';
    }
    
  
    public static function isOfficerLoggedIn() {
        return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'officer';
    }
    
    
    public static function requireUser() {
        if (!self::isUserLoggedIn()) {
            header('Location: index.php?page=user-login');
            exit;
        }
    }
    
    
    public static function requireOfficer() {
        if (!self::isOfficerLoggedIn()) {
            header('Location: index.php?page=officer-login');
            exit;
        }
    }
}
