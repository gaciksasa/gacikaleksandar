<?php
// Include the configuration file
require 'config.php';

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch testimonials
$sql = "SELECT author_name, author_designation, testimonial_text, rating FROM testimonials ORDER BY created_at DESC LIMIT 3";
$result = $conn->query($sql);

$testimonials = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {

    $testimonials[] = $row;
  }
} else {
  echo "No testimonials found.<br>";
}

$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Testimonials</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/fontawesome.css">
  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/pbminfotech-base-icons.css">
  <link rel="stylesheet" href="css/swiper.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/shortcode.css">
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">
</head>

<body>
  <!-- Testimonial Start -->
  <section class="testimonial-two">
    <div class="container">
      <div class="testimonial-two-bg">
        <div class="row">
          <div class="col-md-12 col-lg-4">
            <div class="pbmit-heading-subheading">
              <h4 class="pbmit-subtitle">Our Testimonial</h4>
              <h2 class="pbmit-title text-white">What our<br> clients<br> say About us</h2>
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
                            <blockquote class="pbmit-testimonial-text"><?php echo ($testimonial['testimonial_text']); ?></blockquote>
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


  <!-- JS ============================================ -->
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.appear.js"></script>
  <script src="js/numinate.min.js"></script>
  <script src="js/swiper.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/circle-progress.js"></script>
  <script src="js/scripts.js"></script>
</body>

</html>