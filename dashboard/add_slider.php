<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

require '../config.php';

// Set default language
$lang = 'sr';
if (isset($_GET['lang'])) {
  $lang = $_GET['lang'];
  $_SESSION['lang'] = $lang;
} elseif (isset($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $subtitle = $_POST['subtitle'];
  $background_image = $_FILES['background_image']['name'];
  $link = $_POST['link'];
  $language = $lang; // Use the selected language

  // Upload the image
  $target_dir = "../uploads/";
  $target_file = $target_dir . basename($_FILES["background_image"]["name"]);
  move_uploaded_file($_FILES["background_image"]["tmp_name"], $target_file);

  // Connect to the database
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Set the character set to utf8mb4
  $conn->set_charset("utf8mb4");

  // Insert new slider
  $sql = "INSERT INTO sliders (title, subtitle, background_image, link, language) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssss", $title, $subtitle, $background_image, $link, $language);
  $stmt->execute();
  $stmt->close();
  $conn->close();

  header("Location: view_sliders.php?lang=$lang");
  exit;
}
?>

<!doctype html>
<html lang="sr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Add Slider - My Website</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit-no">
  <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Include Navigation -->
      <?php include 'navigation.php'; ?>
      <!-- Main Content -->
      <main role="main" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Add Slider</h1>
          <div>
            <a href="?lang=en" class="btn <?php echo $lang === 'en' ? 'btn-primary' : 'btn-secondary'; ?>">English</a>
            <a href="?lang=sr" class="btn <?php echo $lang === 'sr' ? 'btn-primary' : 'btn-secondary'; ?>">Serbian</a>
          </div>
        </div>
        <form method="POST" action="add_slider.php?lang=<?php echo $lang; ?>" enctype="multipart/form-data">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
          </div>
          <div class="form-group">
            <label for="subtitle">Subtitle</label>
            <input type="text" class="form-control" id="subtitle" name="subtitle" required>
          </div>
          <div class="form-group">
            <label for="background_image">Background Image</label>
            <input type="file" class="form-control" id="background_image" name="background_image" required>
          </div>
          <div class="form-group">
            <label for="link">Link</label>
            <input type="text" class="form-control" id="link" name="link" required>
          </div>
          <button type="submit" class="btn btn-primary">Add Slider</button>
        </form>
      </main>
      <!-- Main Content End -->
    </div>
  </div>

  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</body>

</html>