<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'config.php';

if (isset($_GET['id'])) {
    $tag_group_id = $_GET['id'];

    // Connect to the database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete tag
    $sql = "DELETE FROM tags WHERE tag_group_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $tag_group_id);  // Corrected to use "s" for string
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();

    header("Location: tags.php");
    exit;
}
