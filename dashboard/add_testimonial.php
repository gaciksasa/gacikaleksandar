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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $author_name = $_POST['author_name'];
  $author_designation = $_POST['author_designation'];
  $testimonial_text = $_POST['testimonial_text'];
  $rating = intval($_POST['rating']); // Ensure rating is an integer
  $language = $lang; // Use the selected language

  // Connect to the database
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Insert testimonial
  $sql = "INSERT INTO testimonials (author_name, author_designation, testimonial_text, rating, language) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssds", $author_name, $author_designation, $testimonial_text, $rating, $language); // 'd' for double
  $stmt->execute();
  $stmt->close();

  $conn->close();

  header("Location: view_testimonials.php?lang=$lang");
  exit;
}
?>

<!doctype html>
<html lang="sr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Add Testimonial - Gacik Aleksandar</title>
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
          <h1 class="h2">Add Testimonial</h1>
        </div>
        <form method="post" action="add_testimonial.php?lang=<?php echo $lang; ?>">
          <div class="mb-3">
            <label for="author_name" class="form-label">Author Name</label>
            <input type="text" class="form-control" id="author_name" name="author_name" required>
          </div>
          <div class="mb-3">
            <label for="author_designation" class="form-label">Author Designation</label>
            <input type="text" class="form-control" id="author_designation" name="author_designation" required>
          </div>
          <div class="mb-3">
            <label for="testimonial_text" class="form-label">Testimonial</label>
            <textarea class="form-control" id="testimonial_text" name="testimonial_text" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="rating" class="form-label">Rating</label>
            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
          </div>
          <button type="submit" class="btn btn-primary">Add Testimonial</button>
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