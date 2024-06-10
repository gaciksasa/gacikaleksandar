<?php
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

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch section details
$section_sql = "SELECT section_title, section_subtitle, section_content FROM services_section WHERE id = 1";
$section_result = $conn->query($section_sql);
$section = $section_result->fetch_assoc();

// Fetch services for the selected language
$sql = "SELECT title, icon, description, image, link FROM services WHERE language = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $lang);
$stmt->execute();
$result = $stmt->get_result();
$services = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $services[] = $row;
  }
}
$stmt->close();
$conn->close();

function getExcerpt($str, $length = 70)
{
  return strlen($str) > $length ? substr($str, 0, $length) . '...' : $str;
}
?>

<!-- Service Start -->
<section class="service-two pbmit-bg-color-blackish">
  <div class="container">
    <div class="pbmit-heading-subheading text-center">
      <h4 class="pbmit-subtitle"><?php echo htmlspecialchars($section['section_subtitle'] ?? 'OUR CLASSES'); ?></h4>
      <h2 class="pbmit-title text-white"><?php echo htmlspecialchars($section['section_title'] ?? 'OUR FEATURED CLASSES'); ?></h2>
      <div class="pbmit-content-wrapper">
        <p><?php echo htmlspecialchars($section['section_content'] ?? 'Fitness is not about being better than someone. Fitness is about being better than the person you were yesterday. Whether you are there to burn off some calories or are training.'); ?></p>
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
                      <img src="<?php echo htmlspecialchars($service['image']); ?>" class="img-fluid" width="100%" alt="">
                    </span>
                  </span>
                </a>
              </div>
              <div class="pbmit-box-content">
                <div class="pbmit-box-content-inner">
                  <div class="pbmit-pf-box-title">
                    <div class="pbmit-ihbox-icon  pbmit-icon-skincolor">
                      <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                    </div>
                  </div>
                  <div class="pbmit-des">
                    <h3><a href="<?php echo htmlspecialchars($service['link']); ?>"><?php echo htmlspecialchars($service['title']); ?></a></h3>
                    <div class="pbmit-service-content">
                      <p><?php echo htmlspecialchars(getExcerpt($service['description'])); ?></p>
                    </div>
                    <div class="pbmit-box-link pbmit-vc_btn3">
                      <a href="<?php echo htmlspecialchars($service['link']); ?>"><?php echo $translations['read-more']; ?></a>
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