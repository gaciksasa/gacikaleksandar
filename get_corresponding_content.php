<?php
require 'config.php';

// Retrieve language and current slug from the request
$lang = $_POST['lang'];
$currentSlug = $_POST['currentSlug'];

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
  die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Fetch the corresponding content slug
$sql = "SELECT slug FROM blog_posts WHERE article_group_id = (SELECT article_group_id FROM blog_posts WHERE slug = ?) AND language = ?
        UNION
        SELECT slug FROM pages WHERE page_group_id = (SELECT page_group_id FROM pages WHERE slug = ?) AND language = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
  die(json_encode(['success' => false, 'message' => 'Error preparing statement: ' . $conn->error]));
}
$stmt->bind_param("ssss", $currentSlug, $lang, $currentSlug, $lang);
$stmt->execute();
$stmt->bind_result($slug);
$stmt->fetch();
$stmt->close();
$conn->close();

if ($slug) {
  echo json_encode(['success' => true, 'slug' => $slug]);
} else {
  echo json_encode(['success' => false, 'message' => 'Content not found']);
}
