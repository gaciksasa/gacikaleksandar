<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

require '../config.php';

// Fetch pages from the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT slug, title FROM pages WHERE language = 'sr'";
$result = $conn->query($sql);
$pages_sr = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $pages_sr[] = $row;
  }
}

$sql = "SELECT slug, title FROM pages WHERE language = 'en'";
$result = $conn->query($sql);
$pages_en = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $pages_en[] = $row;
  }
}

// Fetch all menu items for parent selection
$sql = "SELECT id, title_sr FROM menu_items";
$result = $conn->query($sql);
$menu_items = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $menu_items[] = $row;
  }
}

$conn->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title_sr = $_POST['title_sr'];
  $title_en = $_POST['title_en'];
  $link_sr = $_POST['link_sr'];
  $link_en = $_POST['link_en'];
  $order = $_POST['order'];
  $parent_id = $_POST['parent_id'] ? $_POST['parent_id'] : NULL;
  $is_custom = isset($_POST['is_custom']) ? 1 : 0;

  // Connect to the database
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Insert menu item
  $sql = "INSERT INTO menu_items (title_sr, title_en, link_sr, link_en, `order`, parent_id, is_custom) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssiii", $title_sr, $title_en, $link_sr, $link_en, $order, $parent_id, $is_custom);
  if (!$stmt->execute()) {
    echo "Error: " . $stmt->error;
  }

  // Close the statement and the connection
  $stmt->close();
  $conn->close();

  header("Location: view_menu_items.php");
  exit;
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Add Menu Item - Gacik Aleksandar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
          <h1 class="h2">Add Menu Item</h1>
        </div>
        <form method="post">
          <div class="form-group">
            <label for="title_sr">Title (Serbian)</label>
            <input type="text" class="form-control" id="title_sr" name="title_sr" required>
          </div>
          <div class="form-group">
            <label for="title_en">Title (English)</label>
            <input type="text" class="form-control" id="title_en" name="title_en" required>
          </div>
          <div class="form-group">
            <label for="is_custom">Is Custom Link</label>
            <input type="checkbox" id="is_custom" name="is_custom" value="1">
          </div>
          <div class="form-group">
            <label for="link_sr">Link (Serbian)</label>
            <select class="form-control" id="link_sr" name="link_sr" required>
              <option value="">Select Page</option>
              <option value="index.php">Home</option>
              <option value="contact.php">Contact</option>
              <option value="blog.php">Blog</option>
              <?php foreach ($pages_sr as $page) : ?>
                <option value="<?php echo htmlspecialchars($page['slug']); ?>"><?php echo htmlspecialchars($page['title']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="link_en">Link (English)</label>
            <select class="form-control" id="link_en" name="link_en" required>
              <option value="">Select Page</option>
              <option value="index.php">Home</option>
              <option value="contact.php">Contact</option>
              <option value="blog.php">Blog</option>
              <?php foreach ($pages_en as $page) : ?>
                <option value="<?php echo htmlspecialchars($page['slug']); ?>"><?php echo htmlspecialchars($page['title']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="parent_id">Parent Menu Item</label>
            <select class="form-control" id="parent_id" name="parent_id">
              <option value="">None</option>
              <?php foreach ($menu_items as $item) : ?>
                <option value="<?php echo $item['id']; ?>"><?php echo htmlspecialchars($item['title_sr']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="order">Order</label>
            <input type="number" class="form-control" id="order" name="order" required>
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
  <script>
    document.getElementById('is_custom').addEventListener('change', function() {
      const linkSr = document.getElementById('link_sr');
      const linkEn = document.getElementById('link_en');
      if (this.checked) {
        linkSr.innerHTML = '<option value="index.php">Home</option><option value="contact.php">Contact</option><option value="blog.php">Blog</option>';
        linkEn.innerHTML = '<option value="index.php">Home</option><option value="contact.php">Contact</option><option value="blog.php">Blog</option>';
      } else {
        linkSr.innerHTML = '<?php foreach ($pages_sr as $page) : ?><option value="<?php echo htmlspecialchars($page['slug']); ?>"><?php echo htmlspecialchars($page['title']); ?></option><?php endforeach; ?>';
        linkEn.innerHTML = '<?php foreach ($pages_en as $page) : ?><option value="<?php echo htmlspecialchars($page['slug']); ?>"><?php echo htmlspecialchars($page['title']); ?></option><?php endforeach; ?>';
      }
    });
  </script>
</body>

</html>