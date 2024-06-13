<?php
// Handle language selection
if (isset($_GET['lang'])) {
  $lang = $_GET['lang'];
  setcookie('lang', $lang, time() + (86400 * 30), "/"); // 86400 = 1 day
} elseif (!isset($_COOKIE['lang'])) {
  setcookie('lang', 'sr', time() + (86400 * 30), "/"); // Set default language to Serbian
}

$lang = $_COOKIE['lang'] ?? 'sr'; // Default to Serbian if cookie is not set
$translations = include "languages/$lang.php";

// Database configuration
if (!defined('DB_HOST')) {
  define('DB_HOST', 'localhost');
}

if (!defined('DB_USER')) {
  define('DB_USER', 'root');
}

if (!defined('DB_PASS')) {
  define('DB_PASS', '');
}

if (!defined('DB_NAME')) {
  define('DB_NAME', 'gacikaleksandar');
}

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Set the charset to utf8mb4
$conn->set_charset("utf8mb4");
