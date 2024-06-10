<?php

require 'config.php';

// Set default language
$lang = 'sr';
if (isset($_GET['lang'])) {
  $lang = $_GET['lang'];
}

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch pricing section data
$sql = "SELECT title, subtitle, content FROM pricing_section WHERE language = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $lang);
$stmt->execute();
$result = $stmt->get_result();
$pricingSection = $result->fetch_assoc();

$title = isset($pricingSection['title']) ? $pricingSection['title'] : '';
$subtitle = isset($pricingSection['subtitle']) ? $pricingSection['subtitle'] : '';
$content = isset($pricingSection['content']) ? $pricingSection['content'] : '';

// Fetch pricing plans data
$sql = "SELECT title, price, currency_symbol, frequency, features, is_featured, link FROM pricing WHERE language = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $lang);
$stmt->execute();
$result = $stmt->get_result();

$pricingPlans = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $pricingPlans[] = $row;
  }
}

$stmt->close();
$conn->close();
?>

<!-- Our Pricing -->
<section class="section-md">
  <div class="container">
    <div class="pbmit-heading-subheading text-center">
      <h4 class="pbmit-subtitle"><?php echo htmlspecialchars($subtitle); ?></h4>
      <h2 class="pbmit-title"><?php echo htmlspecialchars($title); ?></h2>
      <div class="pbmit-content-wrapper">
        <p><?php echo htmlspecialchars($content); ?></p>
      </div>
    </div>
    <div class="pbmit-ptables-w wpb_content_element">
      <div class="row">
        <?php foreach ($pricingPlans as $plan) : ?>
          <div class="pbmit-ptable-column-w col-md-4 <?php echo $plan['is_featured'] ? 'pbmit-ptablebox-featured-col' : ''; ?>">
            <div class="pbmit-ptable-column-inner">
              <div class="pbmit-ptablebox pbmit-ptablebox-style-1">
                <?php if ($plan['is_featured']) : ?>
                  <div class="pbmit-ptablebox-featured-w pbmit-bgcolor-skincolor pbmit-white">Featured</div>
                <?php endif; ?>
                <div class="pbmit-ptable-main">
                  <h3 class="pbmit-ptable-heading"><?php echo htmlspecialchars($plan['title']); ?></h3>
                  <div class="pbmit-des"></div>
                  <div class="pbmit-sep"></div>
                  <div class="pbmit-ptable-price-w">
                    <div class="pbmit-ptable-price"><?php echo htmlspecialchars($plan['price']); ?></div>
                    <div class="pbmit-ptable-cur-symbol-after"><?php echo htmlspecialchars($plan['currency_symbol']); ?></div>
                    <div class="pbmit-ptable-frequency"><?php echo htmlspecialchars($plan['frequency']); ?></div>
                  </div>
                </div>
                <div class="pbmit-ptablebox-colum pbmit-ptablebox-featurebox">
                  <div class="pbmit-ptable-lines-w">
                    <?php foreach (explode("\n", $plan['features']) as $feature) : ?>
                      <div class="pbmit-ptable-line">
                        <div class="pbmit-vc_icon_element pbmit-vc_icon_element-outer pbmit-vc_icon_element-align-left">
                          <div class="pbmit-vc_icon_element-inner">
                            <span class="pbmit-vc_icon_element-icon fa fa-check"></span>
                          </div>
                        </div>
                        <?php echo htmlspecialchars($feature); ?>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
                <div class="pbmit-vc_btn3-container pbmit-vc_btn3-inline">
                  <a class="pbmit-vc_general pbmit-vc_btn3" href="<?php echo htmlspecialchars($plan['link']); ?>" title="">
                    <span><?php echo $translations['read-more']; ?></span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<!-- Our Pricing End -->