<?php
session_start();

require 'config.php';

// Retrieve language from cookie
$lang = 'sr'; // Default language
if (isset($_COOKIE['lang'])) {
  $lang = $_COOKIE['lang'];
}

if (!isset($_GET['slug'])) {
  die('Page slug not specified.');
}

$slug = $_GET['slug'];

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch page using slug and language
$sql = "SELECT title, content FROM pages WHERE slug = ? AND language = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
  die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("ss", $slug, $lang);
$stmt->execute();
$stmt->bind_result($title, $content);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo htmlspecialchars($title); ?></title>
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
  <div class="page-wrapper">
    <!-- Header Main Area -->
    <header class="site-header header-style-1">
      <!-- Include Header -->
      <?php include 'header.php'; ?>
    </header>
    <!-- Header Main Area End Here -->

    <!-- Title Bar -->
    <div class="pbmit-title-bar-wrapper">
      <div class="container">
        <div class="pbmit-title-bar-content">
          <div class="pbmit-title-bar-content-inner">
            <div class="pbmit-tbar">
              <div class="pbmit-tbar-inner container">
                <h1 class="pbmit-tbar-title"><?php echo htmlspecialchars($title); ?></h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Title Bar End -->

    <!-- Page Content -->
    <div class="page-content">
      <div class="container">
        <?php echo $content; ?>
      </div>
    </div>
    <!-- Page Content End -->

    <!-- Include footer -->
    <?php include 'footer.php'; ?>
  </div>
  <!-- Page Wrapper End -->

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