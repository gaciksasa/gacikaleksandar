<?php
// Include the configuration file
require 'config.php';

// Set default language
$lang = 'sr';
if (isset($_GET['lang'])) {
  $lang = $_GET['lang'];
}

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch about section data
$sql = "SELECT title, subtitle, content, link, image FROM about WHERE language = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $lang);
$stmt->execute();
$result = $stmt->get_result();

// Initialize variables
$title = '';
$subtitle = '';
$content = '';
$link = '';
$image = '';

if ($result && $result->num_rows > 0) {
  $about = $result->fetch_assoc();
  $title = isset($about['title']) ? $about['title'] : '';
  $subtitle = isset($about['subtitle']) ? $about['subtitle'] : '';
  $content = isset($about['content']) ? $about['content'] : '';
  $link = isset($about['link']) ? $about['link'] : '';
  $image = isset($about['image']) ? $about['image'] : '';
}

$conn->close();
?>

<!-- About Us Start -->
<section class="about-us-section-one">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-6">
        <div class="about-us-one-content">
          <div class="pbmit-heading-subheading">
            <h4 class="pbmit-subtitle"><?php echo htmlspecialchars($subtitle); ?></h4>
            <h2 class="pbmit-title"><?php echo htmlspecialchars($title); ?></h2>
          </div>
          <div><?php echo ($content); ?></div>
          <a href="<?php echo htmlspecialchars($link); ?>" class="pbmit-btn">
            <span><?php echo $translations['read-more']; ?></span>
          </a>
        </div>
      </div>
      <div class="col-md-12 col-lg-6">
        <div class="about-us-one-img">
          <img src="uploads/<?php echo htmlspecialchars($image); ?>" class="img-fluid" alt="">
        </div>
      </div>
    </div>
  </div>
</section>
<!-- About Us End -->
