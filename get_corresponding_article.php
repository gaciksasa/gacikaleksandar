<?php
require 'config.php';

if (!isset($_POST['currentSlug']) || !isset($_POST['lang'])) {
  echo json_encode(['success' => false]);
  exit;
}

$currentSlug = $_POST['currentSlug'];
$newLang = $_POST['lang'];

// Fetch the article group ID for the current article
$sql = "SELECT article_group_id FROM blog_posts WHERE slug = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $currentSlug);
$stmt->execute();
$stmt->bind_result($articleGroupId);
$stmt->fetch();
$stmt->close();

if (!$articleGroupId) {
  echo json_encode(['success' => false, 'error' => 'Article group ID not found']);
  exit;
}

// Fetch the corresponding article slug for the new language
$sql = "SELECT slug FROM blog_posts WHERE article_group_id = ? AND language = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $articleGroupId, $newLang);
$stmt->execute();
$stmt->bind_result($newSlug);
$stmt->fetch();
$stmt->close();

if ($newSlug) {
  echo json_encode(['success' => true, 'slug' => $newSlug]);
} else {
  echo json_encode(['success' => false, 'error' => 'Corresponding article not found']);
}
