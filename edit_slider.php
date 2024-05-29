<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

require 'config.php';

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $subtitle = $_POST['subtitle'];
  $link = $_POST['link'];

  // Handle background image upload
  if ($_FILES['background_image']['name']) {
    $background_image = $_FILES['background_image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["background_image"]["name"]);
    move_uploaded_file($_FILES["background_image"]["tmp_name"], $target_file);

    // Update slider with new image
    $sql = "UPDATE sliders SET title = ?, subtitle = ?, background_image = ?, link = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $subtitle, $background_image, $link, $id);
  } else {
    // Update slider without new image
    $sql = "UPDATE sliders SET title = ?, subtitle = ?, link = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $subtitle, $link, $id);
  }

  $stmt->execute();
  $stmt->close();
  $conn->close();

  header("Location: view_sliders.php");
  exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM sliders WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$slider = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Edit Slider - My Website</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit-no">
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Include Navigation -->
      <?php include 'navigation.php'; ?>
      <!-- Main Content -->
      <main role="main" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Edit Slider</h1>
        </div>
        <form method="POST" action="edit_slider.php" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?php echo $slider['id']; ?>">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($slider['title']); ?>" required>
          </div>
          <div class="form-group">
            <label for="subtitle">Subtitle</label>
            <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo htmlspecialchars($slider['subtitle']); ?>" required>
          </div>
          <div class="form-group">
            <label for="background_image">Background Image (1900 x 900)</label>
            <input type="file" class="form-control" id="background_image" name="background_image">
            <img src="uploads/<?php echo htmlspecialchars($slider['background_image']); ?>" alt="" style="width: 100px;">
          </div>
          <div class="form-group">
            <label for="link">Link</label>
            <input type="text" class="form-control" id="link" name="link" value="<?php echo htmlspecialchars($slider['link']); ?>" required>
          </div>
          <button type="submit" class="btn btn-primary">Update Slider</button>
        </form>
      </main>
      <!-- Main Content End -->
    </div>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>