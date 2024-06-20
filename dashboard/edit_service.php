<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

require '../config.php';

$id = $_GET['id'];
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'sr';
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

// Fetch service details
$sql = "SELECT title, icon, description, image, link, language FROM services WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($title, $icon, $description, $image, $link, $service_lang);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $icon = $_POST['icon'];
  $description = $_POST['description'];
  $link = $_POST['link'];
  $service_lang = $lang;

  // Handle file upload
  if ($_FILES['image']['name']) {
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    $image = $target_file;
  }

  // Update service details
  $sql = "UPDATE services SET title = ?, icon = ?, description = ?, image = ?, link = ?, language = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssssi", $title, $icon, $description, $image, $link, $service_lang, $id);
  $stmt->execute();
  $stmt->close();
  $conn->close();

  header("Location: view_services.php?lang=$service_lang");
  exit;
}

$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Edit Service - Gacik Aleksandar</title>
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
          <h1 class="h2">Edit Service</h1>
        </div>
        <form method="POST" action="edit_service.php?id=<?php echo $id; ?>&lang=<?php echo $lang; ?>" enctype="multipart/form-data">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
          </div>
          <div class="form-group">
            <label for="icon">Icon</label>
            <select class="form-control" id="icon" name="icon" required>
              <?php
              $icons = [
                "diet", "dumbbell", "fruits", "wheel", "juice", "heart-rate",
                "medal", "muscle", "rowing-machine", "diet-1", "water-bottle",
                "weightlift", "no-smoking", "stationary-bike", "treadmill",
                "weightlifter", "gym", "barbell", "woman", "bike", "meditation",
                "dumbbell-1", "weight", "yoga", "weight-lifting", "phone-call",
                "wellness", "gym-1", "wellness-1", "run", "sports-and-competition",
                "running-man", "oil", "placeholder", "placeholder-1", "mail",
                "weight-1", "workout", "gym-2", "sports-and-competition-1",
                "weightlifter-1"
              ];
              foreach ($icons as $iconOption) {
                $selected = $iconOption == str_replace("pbmit-gimox-business-icon-", "", $icon) ? "selected" : "";
                echo "<option value='$iconOption' $selected>$iconOption</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($description); ?></textarea>
          </div>
          <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <?php if ($image) : ?>
              <img src="../<?php echo htmlspecialchars($image); ?>" alt="Service Image" style="max-width: 200px;">
            <?php endif; ?>
          </div>
          <div class="form-group">
            <label for="link">Link</label>
            <input type="text" class="form-control" id="link" name="link" value="<?php echo htmlspecialchars($link); ?>" required>
          </div>
          <button type="submit" class="btn btn-primary">Update Service</button>
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