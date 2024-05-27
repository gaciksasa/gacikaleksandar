<?php
// Include the configuration file
require 'config.php';

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch programs
$sql = "SELECT title, subtitle, icon, link, content FROM programs";
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
  die("Query failed: " . $conn->error);
}

$programs = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $programs[] = $row;
  }
}

$conn->close();
?>

<section class="iconbox-section-one pbmit-bg-color-blackish">
  <div class="container">
    <div class="row">
      <?php foreach ($programs as $program) : ?>
        <div class="col-md-4">
          <div class="pbmit-ihbox-style-3">
            <div class="pbmit-ihbox-inner">
              <div class="pbmit-ihbox-table">
                <div class="pbmit-ihbox-icon pbmit-icon-skincolor">
                  <div class="pbmit-ihbox-icon-wrapper">
                    <i class="pbmit-gimox-business-icon pbmit-gimox-business-icon-<?php echo htmlspecialchars($program['icon']); ?>"></i>
                  </div>
                </div>
                <div class="pbmit-vc_general pbmit-vc_cta3">
                  <div class="pbmit-vc_cta3_content-container">
                    <div class="pbmit-vc_cta3-content">
                      <div class="pbmit-vc_cta3-content-header pbmit-wrap">
                        <div class="pbmit-vc_cta3-headers pbmit-wrap-cell">
                          <h2 class="pbmit-custom-heading"><?php echo ($program['title']); ?></h2>
                          <h4 class="pbmit-custom-heading"><?php echo ($program['subtitle']); ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="pbmit-ihbox-contents">
                <div class="pbmit-cta3-content-wrapper"><?php echo ($program['content']); ?></div>
                <div class="pbmit-vc_btn3-container pbmit-vc_btn3-inline">
                  <a class="pbmit-vc_general pbmit-vc_btn3" href="<?php echo ($program['link']); ?>" title="">
                    <span>READ MORE</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>