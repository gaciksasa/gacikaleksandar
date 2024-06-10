<?php

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

require 'config.php';

// Set default language
$lang = 'sr';
if (isset($_GET['lang'])) {
  $lang = $_GET['lang'];
  $_SESSION['lang'] = $lang;
} elseif (isset($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch section details
$section_sql = "SELECT section_title, section_subtitle FROM testimonial_section WHERE language = ?";
$stmt = $conn->prepare($section_sql);
$stmt->bind_param("s", $lang);
$stmt->execute();
$stmt->bind_result($section_title, $section_subtitle);
$stmt->fetch();
$stmt->close();

// Fetch testimonials
$sql = "SELECT author_name, author_designation, testimonial_text, rating FROM testimonials WHERE language = ? ORDER BY created_at DESC LIMIT 3";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $lang);
$stmt->execute();
$result = $stmt->get_result();

$testimonials = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $testimonials[] = $row;
  }
}
$stmt->close();
$conn->close();
?>

<!-- Testimonial Start -->
<section class="testimonial-two">
  <div class="container">
    <div class="testimonial-two-bg">
      <div class="row">
        <div class="col-md-12 col-lg-4">
          <div class="pbmit-heading-subheading">
            <h4 class="pbmit-subtitle"><?php echo htmlspecialchars($section_subtitle); ?></h4>
            <h2 class="pbmit-title text-white"><?php echo htmlspecialchars($section_title); ?></h2>
          </div>
        </div>
        <div class="col-md-12 col-lg-8">
          <div class="swiper-slider pbmit-sep-number" data-arrows-class="testimonial-arrow" data-autoplay="true" data-loop="true" data-dots="true" data-arrows="true" data-columns="1" data-margin="30" data-effect="slide">
            <div class="swiper-wrapper">
              <?php foreach ($testimonials as $testimonial) : ?>
                <div class="swiper-slide">
                  <!-- Slide -->
                  <article class="pbmit-testimonialbox-style-2">
                    <div class="pbmit-post-item">
                      <div class="pbmit-box-content">
                        <div class="pbmit-box-star">
                          <?php for ($i = 0; $i < 5; $i++) : ?>
                            <i class="pbmit-base-icon-star <?php echo $i < $testimonial['rating'] ? 'pbmit-skincolor pbmit-active' : ''; ?>"></i>
                          <?php endfor; ?>
                        </div>
                        <div class="pbmit-box-desc">
                          <blockquote class="pbmit-testimonial-text"><?php echo htmlspecialchars($testimonial['testimonial_text']); ?></blockquote>
                        </div>
                      </div>
                      <div class="pbmit-box-author">
                        <div class="pbmit-box-title">
                          <h3 class="pbmit-author-name"><?php echo htmlspecialchars($testimonial['author_name']); ?></h3>
                          <span class="pbmit-box-footer"><?php echo htmlspecialchars($testimonial['author_designation']); ?></span>
                        </div>
                      </div>
                    </div>
                  </article>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="testimonial-arrow swiper-btn-custom d-flex flex-row-reverse"></div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Testimonial End -->