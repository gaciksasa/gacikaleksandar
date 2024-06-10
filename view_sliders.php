<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

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

// Fetch sliders for the selected language
$sql = "SELECT id, title, subtitle, background_image, link FROM sliders WHERE language = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $lang);
$stmt->execute();
$result = $stmt->get_result();
$sliders = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $sliders[] = $row;
  }
}
$stmt->close();
$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Sliders - My Website</title>
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
          <h1 class="h2">Sliders</h1>
          <div>
            <a href="?lang=en" class="btn <?php echo $lang === 'en' ? 'btn-primary' : 'btn-secondary'; ?>">English</a>
            <a href="?lang=sr" class="btn <?php echo $lang === 'sr' ? 'btn-primary' : 'btn-secondary'; ?>">Serbian</a>
          </div>
        </div>
        <a href="add_slider.php?lang=<?php echo $lang; ?>" class="btn btn-primary mb-3">Add Slider</a>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Title</th>
              <th>Subtitle</th>
              <th>Background Image (1900x900)</th>
              <th>Link</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sliders as $slider) : ?>
              <tr>
                <td><?php echo htmlspecialchars($slider['title']); ?></td>
                <td><?php echo htmlspecialchars($slider['subtitle']); ?></td>
                <td><img src="uploads/<?php echo htmlspecialchars($slider['background_image']); ?>" alt="" style="width: 100px;"></td>
                <td><?php echo htmlspecialchars($slider['link']); ?></td>
                <td>
                  <a href="edit_slider.php?id=<?php echo $slider['id']; ?>&lang=<?php echo $lang; ?>" class="btn btn-warning">Edit</a>
                  <a href="delete_slider.php?id=<?php echo $slider['id']; ?>&lang=<?php echo $lang; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this slider?');">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </main>
      <!-- Main Content End -->
    </div>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>