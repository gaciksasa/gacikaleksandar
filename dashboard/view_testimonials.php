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

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for the section
$section_title = '';
$section_subtitle = '';

// Fetch section details
$section_sql = "SELECT section_title, section_subtitle FROM testimonial_section WHERE language = ?";
$stmt = $conn->prepare($section_sql);
$stmt->bind_param("s", $lang);
$stmt->execute();
$stmt->bind_result($section_title, $section_subtitle);
$stmt->fetch();
$stmt->close();

// Handle form submission for updating section details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_section'])) {
  $section_title = $_POST['section_title'];
  $section_subtitle = $_POST['section_subtitle'];

  // Check if the record already exists
  $check_sql = "SELECT COUNT(*) FROM testimonial_section WHERE language = ?";
  $stmt = $conn->prepare($check_sql);
  $stmt->bind_param("s", $lang);
  $stmt->execute();
  $stmt->bind_result($count);
  $stmt->fetch();
  $stmt->close();

  if ($count > 0) {
    // Update existing record
    $update_section_sql = "UPDATE testimonial_section SET section_title = ?, section_subtitle = ? WHERE language = ?";
    $stmt = $conn->prepare($update_section_sql);
    $stmt->bind_param("sss", $section_title, $section_subtitle, $lang);
  } else {
    // Insert new record
    $insert_section_sql = "INSERT INTO testimonial_section (section_title, section_subtitle, language) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_section_sql);
    $stmt->bind_param("sss", $section_title, $section_subtitle, $lang);
  }
  $stmt->execute();
  $stmt->close();

  header("Location: view_testimonials.php?lang=$lang");
  exit;
}

// Fetch testimonials
$sql = "SELECT id, author_name, author_designation, testimonial_text, rating FROM testimonials WHERE language = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $lang);
$stmt->execute();
$result = $stmt->get_result();
$testimonials = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $testimonials[] = $row;
  }
}
$stmt->close();

$conn->close();
?>

<!doctype html>
<html lang="sr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Testimonials - Gacik Aleksandar</title>
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
          <h1 class="h2">Testimonials</h1>
          <div>
            <a href="?lang=en" class="btn <?php echo $lang === 'en' ? 'btn-primary' : 'btn-secondary'; ?>">English</a>
            <a href="?lang=sr" class="btn <?php echo $lang === 'sr' ? 'btn-primary' : 'btn-secondary'; ?>">Serbian</a>
          </div>
        </div>

        <!-- Section Details Form -->
        <div class="mb-3">
          <form method="POST" action="view_testimonials.php?lang=<?php echo $lang; ?>">
            <button type="submit" class="btn btn-primary mb-3" name="save_section">Save Section</button>

            <div class="form-group">
              <label for="section_subtitle">Section Subtitle</label>
              <input type="text" class="form-control" id="section_subtitle" name="section_subtitle" value="<?php echo htmlspecialchars($section_subtitle); ?>">
            </div>
            <div class="form-group">
              <label for="section_title">Section Title</label>
              <input type="text" class="form-control" id="section_title" name="section_title" value="<?php echo htmlspecialchars($section_title); ?>">
            </div>
          </form>
        </div>

        <a href="add_testimonial.php?lang=<?php echo $lang; ?>" class="btn btn-primary mb-3 mt-4">Add Testimonial</a>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Author</th>
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
                <td><?php echo htmlspecialchars($testimonial['testimonial_text']); ?></td>
                <td><?php echo htmlspecialchars($testimonial['rating']); ?></td>
                <td>
                  <a href="edit_testimonial.php?id=<?php echo $testimonial['id']; ?>&lang=<?php echo $lang; ?>" class="btn btn-warning">Edit</a>
                  <a href="delete_testimonial.php?id=<?php echo $testimonial['id']; ?>&lang=<?php echo $lang; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this testimonial?');">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </main>
      <!-- Main Content End -->
    </div>
  </div>

  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</body>

</html>