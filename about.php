<?php
// Include the configuration file
require 'config.php';

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch about section data
$sql = "SELECT title, subtitle, content, link, image FROM about LIMIT 1";
$result = $conn->query($sql);

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
            <h4 class="pbmit-subtitle"><?php echo ($subtitle); ?></h4>
            <h2 class="pbmit-title"><?php echo ($title); ?></h2>
          </div>
          <div><?php echo ($content); ?></div>
          <ul class="list-group list-group-borderless">
            <li class="list-group-item">
              <i class="themifyicon ti-check"></i>Train with the best experts in bodybuilding field.
            </li>
            <li class="list-group-item">
              <i class="themifyicon ti-check"></i>Our personal trainers will help you find a perfect workout.
            </li>
          </ul>
          <a href="<?php echo ($link); ?>" class="pbmit-btn">
            <span>READ MORE</span>
          </a>
        </div>
      </div>
      <div class="col-md-12 col-lg-6">
        <div class="about-us-one-img">
          <img src="uploads/<?php echo ($image); ?>" class="img-fluid" alt="">
        </div>
      </div>
    </div>
  </div>
</section>
<!-- About Us End -->