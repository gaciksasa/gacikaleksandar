<?php
require 'config.php';

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch services
$sql = "SELECT title, description, image, icon FROM services";
$result = $conn->query($sql);
$services = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $services[] = $row;
  }
}
$conn->close();
?>



<!-- Service Start -->
<section class="section-lgb pbmit-bg-color-blackish">
  <div class="container">
    <div class="row g-0">
      <div class="col-md-12 col-xl-2">
        <div class="service-one-img">
          <div class="video-one-btn-bg">
            <div class="video-one-play-btn">
              <span><i class="fa fa-play"></i></span>
              <a href="https://www.youtube.com/watch?v=j6UyNq_TwGA" class="pbmin-lightbox-video"></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-xl-10">
        <div class="service-one-box">
          <div class="row">
            <div class="col-8">
              <div class="pbmit-heading-subheading">
                <h4 class="pbmit-subtitle">OUR CLASSES</h4>
                <h2 class="pbmit-title text-white">OUR FEATURED CLASSES</h2>
              </div>
            </div>
            <div class="col-4">
              <div class="service-one-arrow swiper-btn-custom d-flex flex-row-reverse"></div>
            </div>
          </div>
          <div class="swiper-slider" data-arrows-class="service-one-arrow" data-autoplay="true" data-loop="true" data-dots="false" data-arrows="true" data-columns="3" data-margin="30" data-effect="slide">
            <div class="swiper-wrapper">
              <?php foreach ($services as $service) : ?>
                <div class="swiper-slide">
                  <!-- Slide -->
                  <article class="pbmit-box-service pbmit-servicebox-style-3">
                    <div class="pbmit-post-item">
                      <span class="pbmit-item-thumbnail">
                        <span class="pbmit-item-thumbnail-inner">
                          <img src="<?php echo htmlspecialchars($service['image']); ?>" class="img-fluid" alt="">
                        </span>
                      </span>
                      <div class="pbmit-box-content">
                        <div class="pbmit-ihbox-icon">
                          <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                        </div>
                        <div class="pbmit-box-content-inner">
                          <div class="pbmit-pf-box-title">
                            <h3><a href="classes-details.html"><?php echo htmlspecialchars($service['title']); ?></a></h3>
                            <div class="pbmit-service-content">
                              <p><?php echo htmlspecialchars($service['description']); ?></p>
                            </div>
                          </div>
                          <div class="pbmit-box-link pbmit-vc_btn3">
                            <a href="classes-details.html">READ MORE</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </article>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Service End -->