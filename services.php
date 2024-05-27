<?php
require 'config.php';

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch services
$sql = "SELECT title, description, image, icon, link FROM services";
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
<section class="service-two pbmit-bg-color-blackish">
  <div class="container">
    <div class="pbmit-heading-subheading text-center">
      <h4 class="pbmit-subtitle">OUR CLASSES</h4>
      <h2 class="pbmit-title text-white">OUR FEATURED CLASSES</h2>
      <div class="pbmit-content-wrapper">
        <p>Fitness is not about being better than someone. Fitness is about being better than the person you were yesterday. Whether you are there to burn off some calories or are training.</p>
      </div>
    </div>
    <div class="row">
      <?php foreach ($services as $service) : ?>
        <div class="col-md-6 col-lg-4">
          <article class="pbmit-box-service pbmit-servicebox-style-2">
            <div class="pbmit-post-item">
              <div class="pbmit-overlay">
                <a href="<?php echo htmlspecialchars($service['link']); ?>">
                  <span class="pbmit-item-thumbnail">
                    <span class="pbmit-item-thumbnail-inner">
                      <img src="<?php echo htmlspecialchars($service['image']); ?>" class="img-fluid" alt="">
                    </span>
                  </span>
                </a>
              </div>
              <div class="pbmit-box-content">
                <div class="pbmit-box-content-inner">
                  <div class="pbmit-pf-box-title">
                    <div class="pbmit-ihbox-icon pbmit-icon-skincolor">
                      <i class="pbmit-gimox-business-icon-<?php echo htmlspecialchars($service['icon']); ?>"></i>
                    </div>
                  </div>
                  <div class="pbmit-des">
                    <h3><a href="<?php echo htmlspecialchars($service['link']); ?>"><?php echo htmlspecialchars($service['title']); ?></a></h3>
                    <div class="pbmit-service-content">
                      <p><?php echo htmlspecialchars($service['description']); ?></p>
                    </div>
                    <div class="pbmit-box-link pbmit-vc_btn3">
                      <a href="<?php echo htmlspecialchars($service['link']); ?>">READ MORE</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- Service End -->