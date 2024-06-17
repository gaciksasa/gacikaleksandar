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
}

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch about section data
$sql = "SELECT title, subtitle, content, link, image FROM about WHERE language = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $lang);
$stmt->execute();
$result = $stmt->get_result();

// Initialize variables
$title = '';
$subtitle = '';
$content = '';
$link = '';
$image = '';

if ($result && $result->num_rows > 0) {
  $about = $result->fetch_assoc();
  $title = $about['title'] ?? '';
  $subtitle = $about['subtitle'] ?? '';
  $content = $about['content'] ?? '';
  $link = $about['link'] ?? '';
  $image = $about['image'] ?? '';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $subtitle = $_POST['subtitle'];
  $content = $_POST['content'];
  $link = $_POST['link'];
  $newImage = $_FILES['image']['name'];

  // Handle image upload
  if (!empty($newImage)) {
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($newImage);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    $image = $newImage; // Update the image field if a new image is uploaded
  }

  // Insert or update the about section data
  if ($result && $result->num_rows > 0) {
    $sql = "UPDATE about SET title=?, subtitle=?, content=?, link=?, image=? WHERE language=?";
  } else {
    $sql = "INSERT INTO about (title, subtitle, content, link, image, language) VALUES (?, ?, ?, ?, ?, ?)";
  }

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssss", $title, $subtitle, $content, $link, $image, $lang);
  $stmt->execute();
  $stmt->close();

  header("Location: view_about.php?lang=$lang");
  exit;
}

$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>About - Gacik Aleksandar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://cdn.tiny.cloud/1/2d8d0z568l75o82jphit2mlssygij2v5xxuk0ev3ai9lv60g/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: 'textarea#content',
      menubar: false,
      setup: function(editor) {
        editor.on('change', function() {
          editor.save();
          enableSaveButton();
        });
      }
    });

    function syncEditorContent() {
      tinymce.triggerSave();
    }

    function enableSaveButton() {
      document.getElementById('saveButton').disabled = false;
    }

    document.addEventListener("DOMContentLoaded", function() {
      const formElements = document.querySelectorAll("input, textarea");
      formElements.forEach(element => {
        element.addEventListener("change", enableSaveButton);
      });
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
          <h1 class="h2">About</h1>
          <div>
            <a href="?lang=en" class="btn <?php echo $lang === 'en' ? 'btn-primary' : 'btn-secondary'; ?>">English</a>
            <a href="?lang=sr" class="btn <?php echo $lang === 'sr' ? 'btn-primary' : 'btn-secondary'; ?>">Serbian</a>
          </div>
        </div>
        <form method="POST" action="view_about.php?lang=<?php echo $lang; ?>" enctype="multipart/form-data" onsubmit="syncEditorContent()">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
          </div>
          <div class="form-group">
            <label for="subtitle">Subtitle</label>
            <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo htmlspecialchars($subtitle); ?>" required>
          </div>
          <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" required><?php echo htmlspecialchars($content); ?></textarea>
          </div>
          <div class="form-group">
            <label for="link">Link</label>
            <input type="text" class="form-control" id="link" name="link" value="<?php echo htmlspecialchars($link); ?>" required>
          </div>
          <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <?php if ($image) : ?>
              <img src="../uploads/<?php echo htmlspecialchars($image); ?>" alt="Current Image" style="max-width: 200px; margin-top: 10px;">
            <?php endif; ?>
          </div>
          <button type="submit" class="btn btn-primary mt-3" id="saveButton" disabled>Save</button>
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