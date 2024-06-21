<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

require '../config.php';

if (!isset($_GET['id'])) {
  header("Location: view_menu_items.php");
  exit;
}

$id = $_GET['id'];

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Delete menu item
$sql = "DELETE FROM menu_items WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
  echo "Error: " . $stmt->error;
}

// Close the statement and the connection
$stmt->close();
$conn->close();

header("Location: view_menu_items.php");
exit;
