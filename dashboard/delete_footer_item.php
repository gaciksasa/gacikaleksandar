<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

require '../config.php';

if (!isset($_GET['id'])) {
  die('Footer item ID not specified.');
}

$id = $_GET['id'];

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Delete the footer item
$sql = "DELETE FROM footer_items WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
  die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
  die("Error executing statement: " . $stmt->error);
}

// Close the statement and the connection
$stmt->close();
$conn->close();

header("Location: view_footer_items.php");
exit;
