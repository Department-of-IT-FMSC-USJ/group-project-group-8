<?php

define('APP_NAME', 'Debit Card Renewal System');
define('APP_URL', 'http://localhost/IT-project');
define('BASE_PATH', __DIR__ . '/..');


ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); 


date_default_timezone_set('Asia/Colombo');


error_reporting(E_ALL);
ini_set('display_errors', 1);


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
