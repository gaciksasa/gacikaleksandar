<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $subtitle = $_POST['subtitle'];
  $icon = $_POST['icon'];
  $link = $_POST['link'];
  $content = $_POST['content'];

  // Connect to the database
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Insert new program
  $sql = "INSERT INTO programs (title, subtitle, icon, link, content) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssss", $title, $subtitle, $icon, $link, $content);
  $stmt->execute();
  $stmt->close();
  $conn->close();

  header("Location: view_programs.php");
  exit;
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Add Program - My Website</title>
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
          <h1 class="h2">Add Program</h1>
        </div>
        <form method="POST" action="add_program.php">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
          </div>
          <div class="form-group">
            <label for="subtitle">Subtitle</label>
            <input type="text" class="form-control" id="subtitle" name="subtitle" required>
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
              foreach ($icons as $icon) {
                echo "<option value='$icon'>$icon</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="link">Link</label>
            <input type="text" class="form-control" id="link" name="link" required>
          </div>
          <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Add Program</button>
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