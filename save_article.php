<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $tags = $_POST['tags'];
    $published_date = $_POST['published_date'];
    $featured_image = '';

    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["featured_image"]["name"]);

        // Check if directory exists and is writable
        if (!is_dir($target_dir) || !is_writable($target_dir)) {
            die("Error: Upload directory is not writable.");
        }

        if (move_uploaded_file($_FILES["featured_image"]["tmp_name"], $target_file)) {
            $featured_image = $target_file;
        } else {
            die("Error: Unable to move uploaded file.");
        }
    }

    // Connect to the database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the new article
    $stmt = $conn->prepare("INSERT INTO blog_posts (title, content, author, category_id, featured_image, published_date, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("sssiss", $title, $content, $author, $category, $featured_image, $published_date);

    if ($stmt->execute()) {
        $article_id = $stmt->insert_id;

        // Insert tags
        if (!empty($tags)) {
            foreach ($tags as $tag_id) {
                $stmt = $conn->prepare("INSERT INTO blog_post_tags (blog_post_id, tag_id) VALUES (?, ?)");
                if (!$stmt) {
                    die("Error preparing statement for tags: " . $conn->error);
                }
                $stmt->bind_param("ii", $article_id, $tag_id);
                $stmt->execute();
            }
        }

        header("Location: view_articles.php");
        exit;
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
