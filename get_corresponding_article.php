<?php
require 'config.php';

$lang = isset($_POST['lang']) ? $_POST['lang'] : 'sr';
$currentSlug = isset($_POST['currentSlug']) ? $_POST['currentSlug'] : '';

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
  die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Determine if the slug belongs to an article or a page
$article_query = "SELECT slug FROM blog_posts WHERE slug = ? AND language = ?";
$page_query = "SELECT slug FROM pages WHERE slug = ? AND language = ?";

$found = false;
$response = ['success' => false, 'message' => 'Content not found'];

$stmt = $conn->prepare($article_query);
$stmt->bind_param('ss', $currentSlug, $lang);
$stmt->execute();
$stmt->bind_result($newSlug);
if ($stmt->fetch()) {
  $found = true;
  $response = ['success' => true, 'slug' => '/' . $newSlug];
}
$stmt->close();

if (!$found) {
  $stmt = $conn->prepare($page_query);
  $stmt->bind_param('ss', $currentSlug, $lang);
  $stmt->execute();
  $stmt->bind_result($newSlug);
  if ($stmt->fetch()) {
    $found = true;
    $response = ['success' => true, 'slug' => '/' . $newSlug];
  }
  $stmt->close();
}

$conn->close();

echo json_encode($response);
