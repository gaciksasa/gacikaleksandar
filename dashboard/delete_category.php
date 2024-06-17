<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require '../config.php';

if (isset($_GET['id'])) {
    $category_group_id = $_GET['id'];

    // Connect to the database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete category
    $sql = "DELETE FROM categories WHERE category_group_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $category_group_id);  // Corrected to use "s" for string
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();

    header("Location: view_categories.php");
    exit;
}
