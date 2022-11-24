<?php
$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
// App Root
define('APPROOT', dirname(dirname(__FILE__)));

// URL Root
define('URLROOT', $protocol.'://'.$_SERVER['HTTP_HOST'].'/WBSProject/MVC');

// Site Name
define('SITENAME', 'Blood Donation');

// Database Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'mvc_client');
?>
