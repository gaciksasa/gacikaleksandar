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

// Fetch all testimonials
$sql = "SELECT id, author_name, author_designation, testimonial_text, rating FROM testimonials";
$result = $conn->query($sql);
$testimonials = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $testimonials[] = $row;
  }
}

$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Testimonials - Gacik Aleksandar</title>
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
          <h1 class="h2">Testimonials</h1>
        </div>
        <a href="add_testimonial.php" class="btn btn-primary mb-3">Add Testimonial</a>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Author Name</th>
              <th>Designation</th>
              <th>Testimonial</th>
              <th>Rating</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($testimonials as $testimonial) : ?>
              <tr>
                <td><?php echo htmlspecialchars($testimonial['author_name']); ?></td>
                <td><?php echo htmlspecialchars($testimonial['author_designation']); ?></td>
                <td><?php echo ($testimonial['testimonial_text']); ?></td>
                <td><?php echo htmlspecialchars($testimonial['rating']); ?></td>
                <td>
                  <a href="edit_testimonial.php?id=<?php echo $testimonial['id']; ?>" class="btn btn-warning">Edit</a>
                  <a href="delete_testimonial.php?id=<?php echo $testimonial['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this testimonial?');">Delete</a>
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