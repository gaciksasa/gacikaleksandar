<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

require '../config.php';

$page_group_id = isset($_GET['id']) ? $_GET['id'] : '';

if ($page_group_id) {
  // Connect to the database
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Delete pages
  $sql = "DELETE FROM pages WHERE page_group_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $page_group_id);
  if ($stmt->execute()) {
    header("Location: view_pages.php");
    exit;
  } else {
    echo "Error: " . $stmt->error;
  }

  // Close the statement and the connection
  $stmt->close();
  $conn->close();
} else {
  header("Location: view_pages.php");
  exit;
}
