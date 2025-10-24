<?php

function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}


function redirect($page, $params = []) {
    $url = 'index.php?page=' . $page;
    if (!empty($params)) {
        $url .= '&' . http_build_query($params);
    }
    header('Location: ' . $url);
    exit;
}


function isLoggedIn() {
    return isset($_SESSION['user_type']);
}


function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}


function getCurrentOfficerId() {
    return $_SESSION['officer_id'] ?? null;
}


function formatDate($date, $format = 'F j, Y') {
    return date($format, strtotime($date));
}

function formatDateTime($datetime, $format = 'F j, Y g:i A') {
    return date($format, strtotime($datetime));
}


function daysBetween($date1, $date2) {
    $d1 = new DateTime($date1);
    $d2 = new DateTime($date2);
    return $d1->diff($d2)->days;
}


function generatePIN($length = 4) {
    return str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
}


function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}


function isValidCardNumber($cardNumber) {
   
    $cardNumber = preg_replace('/\s|-/', '', $cardNumber);
    
    
    if (!ctype_digit($cardNumber)) {
        return false;
    }
    
   
    $length = strlen($cardNumber);
    if ($length < 13 || $length > 19) {
        return false;
    }
    
   
    $sum = 0;
    $isEven = false;
    
    for ($i = $length - 1; $i >= 0; $i--) {
        $digit = intval($cardNumber[$i]);
        
        if ($isEven) {
            $digit *= 2;
            if ($digit > 9) {
                $digit -= 9;
            }
        }
        
        $sum += $digit;
        $isEven = !$isEven;
    }
    
    return ($sum % 10) === 0;
}


function getExpiryUrgency($expiryDate) {
    $days = daysBetween(date('Y-m-d'), $expiryDate);
    
    if ($days <= 30) {
        return 'urgent'; 
    } elseif ($days <= 60) {
        return 'warning'; 
    }
    return 'normal'; 
}


function maskCardNumber($cardNumber) {
    return '•••• •••• •••• ' . substr($cardNumber, -4);
}


function getStatusColor($status) {
    $colors = [
        'processing' => 'yellow',
        'issued' => 'blue',
        'sent_for_delivery' => 'purple',
        'delivered' => 'green',
        'scheduled' => 'yellow',
        'confirmed' => 'blue',
        'completed' => 'green',
        'cancelled' => 'red'
    ];
    
    return $colors[$status] ?? 'gray';
}


function formatStatus($status) {
    return ucfirst(str_replace('_', ' ', $status));
}


function dd($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}
