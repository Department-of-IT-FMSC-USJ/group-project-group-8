<?php



define('DB_HOST', 'localhost');
define('DB_NAME', 'debit_card_renewal');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_PORT', '3308');


$conn = null;

/**
 * 
 * @return mysqli
 */
function getConnection() {
    global $conn;
    
    if ($conn === null) {
        
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        
        
        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }
        
        
        mysqli_set_charset($conn, 'utf8mb4');
    }
    
    return $conn;
}


function closeConnection() {
    global $conn;
    
    if ($conn !== null) {
        mysqli_close($conn);
        $conn = null;
    }
}


class DatabaseConfig {
    public static function getConnection() {
        return getConnection();
    }
    
    public static function closeConnection() {
        closeConnection();
    }
}
