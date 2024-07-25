<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

require '../config.php';

function generateSlug($title)
{
  return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title_sr = $_POST['title_sr'];
  $content_sr = $_POST['content_sr'];
  $title_en = $_POST['title_en'];
  $content_en = $_POST['content_en'];

  // Connect to the database
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Handle file upload
  $headerImage = null;
  if (isset($_FILES['header_image']) && $_FILES['header_image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/';
    $uploadFile = $uploadDir . basename($_FILES['header_image']['name']);

    if (move_uploaded_file($_FILES['header_image']['tmp_name'], $uploadFile)) {
      $headerImage = $_FILES['header_image']['name'];
    } else {
      echo "Error uploading file.";
    }
  }

  // Generate a unique page_group_id
  $page_group_id = uniqid();

  // Generate slugs
  $slug_sr = generateSlug($title_sr);
  $slug_en = generateSlug($title_en);

  // Insert page in Serbian
  $sql_sr = "INSERT INTO pages (page_group_id, title, content, slug, language, header_image, created_at, updated_at) 
               VALUES (?, ?, ?, ?, 'sr', ?, NOW(), NOW())";
  $stmt_sr = $conn->prepare($sql_sr);
  $stmt_sr->bind_param("sssss", $page_group_id, $title_sr, $content_sr, $slug_sr, $headerImage);
  if (!$stmt_sr->execute()) {
    echo "Error: " . $stmt_sr->error;
  }

  // Insert page in English
  $sql_en = "INSERT INTO pages (page_group_id, title, content, slug, language, header_image, created_at, updated_at) 
               VALUES (?, ?, ?, ?, 'en', ?, NOW(), NOW())";
  $stmt_en = $conn->prepare($sql_en);
  $stmt_en->bind_param("sssss", $page_group_id, $title_en, $content_en, $slug_en, $headerImage);
  if (!$stmt_en->execute()) {
    echo "Error: " . $stmt_en->error;
  }

  // Close the statements and the connection
  $stmt_sr->close();
  $stmt_en->close();
  $conn->close();

  header("Location: view_pages.php");
  exit;
}
?>

<!doctype html>
<html lang="sr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Add Page - Gacik Aleksandar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://cdn.tiny.cloud/1/2d8d0z568l75o82jphit2mlssygij2v5xxuk0ev3ai9lv60g/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'lists link image table code',
      toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor | table | code',
      menubar: false,
      branding: false,
      height: 300
    });
  </script>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Include Navigation -->
      <?php include 'navigation.php'; ?>
      <!-- Main Content -->
      <main role="main" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Add Page</h1>
        </div>
        <form method="post" action="add_page.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="header_image">Header Image</label>
            <input type="file" class="form-control" id="header_image" name="header_image">
          </div>
          <h3>Serbian</h3>
          <div class="form-group">
            <label for="title_sr">Title (Serbian)</label>
            <input type="text" class="form-control" id="title_sr" name="title_sr" required>
          </div>
          <div class="form-group">
            <label for="content_sr">Content (Serbian)</label>
            <textarea class="form-control" id="content_sr" name="content_sr" rows="10"></textarea>
          </div>

          <h3>English</h3>
          <div class="form-group">
            <label for="title_en">Title (English)</label>
            <input type="text" class="form-control" id="title_en" name="title_en" required>
          </div>
          <div class="form-group">
            <label for="content_en">Content (English)</label>
            <textarea class="form-control" id="content_en" name="content_en" rows="10"></textarea>
          </div>

          <button type="submit" class="btn btn-primary mt-4">Add</button>
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