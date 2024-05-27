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

// Fetch all services
$sql = "SELECT id, title, icon, description, image, link FROM services";
$result = $conn->query($sql);
$services = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $services[] = $row;
  }
}

// Fetch section details
$section_sql = "SELECT section_title, section_subtitle, section_content FROM services_section WHERE id = 1";
$section_result = $conn->query($section_sql);
$section = $section_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_section'])) {
  $section_title = $_POST['section_title'];
  $section_subtitle = $_POST['section_subtitle'];
  $section_content = $_POST['section_content'];

  // Update section details
  if ($section) {
    $update_section_sql = "UPDATE services_section SET section_title = ?, section_subtitle = ?, section_content = ? WHERE id = 1";
    $stmt = $conn->prepare($update_section_sql);
    $stmt->bind_param("sss", $section_title, $section_subtitle, $section_content);
  } else {
    $insert_section_sql = "INSERT INTO services_section (section_title, section_subtitle, section_content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_section_sql);
    $stmt->bind_param("sss", $section_title, $section_subtitle, $section_content);
  }
  $stmt->execute();
  $stmt->close();

  header("Location: view_services.php");
  exit;
}

$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>View Services - Gacik Aleksandar</title>
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
          <h1 class="h2">Services</h1>
        </div>

        <!-- Section Details Form -->
        <div class="mb-3">
          <form method="POST" action="view_services.php">
            <button type="submit" class="btn btn-primary mb-3" name="save_section">Save Section</button>
            <div class="form-group">
              <label for="section_subtitle">Section Subtitle</label>
              <input type="text" class="form-control" id="section_subtitle" name="section_subtitle" value="<?php echo htmlspecialchars($section['section_subtitle'] ?? ''); ?>">
            </div>
            <div class="form-group">
              <label for="section_title">Section Title</label>
              <input type="text" class="form-control" id="section_title" name="section_title" value="<?php echo htmlspecialchars($section['section_title'] ?? ''); ?>">
            </div>

            <div class="form-group">
              <label for="section_content">Section Content</label>
              <textarea class="form-control" id="section_content" name="section_content" rows="3"><?php echo htmlspecialchars($section['section_content'] ?? ''); ?></textarea>
            </div>

          </form>
        </div>

        <!-- Services Table -->
        <a href="add_service.php" class="btn btn-primary mb-3">Add Service</a>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Icon</th>
              <th>Description</th>
              <th>Image</th>
              <th>Link</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($services as $service) : ?>
              <tr>
                <td><?php echo htmlspecialchars($service['id']); ?></td>
                <td><?php echo htmlspecialchars($service['title']); ?></td>
                <td><?php echo htmlspecialchars($service['icon']); ?></td>
                <td><?php echo htmlspecialchars($service['description']); ?></td>
                <td>
                  <?php if (!empty($service['image'])) : ?>
                    <img src="<?php echo htmlspecialchars($service['image']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>" style="max-width: 100px;">
                  <?php else : ?>
                    No image
                  <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($service['link']); ?></td>
                <td>
                  <a href="edit_service.php?id=<?php echo $service['id']; ?>" class="btn btn-warning">Edit</a>
                  <a href="delete_service.php?id=<?php echo $service['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this service?');">Delete</a>
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