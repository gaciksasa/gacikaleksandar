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

$id = $_GET['id'];

// Fetch pricing plan data
$sql = "SELECT title, price, currency_symbol, frequency, features, is_featured, link FROM pricing WHERE id = ? AND language = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $id, $lang);
$stmt->execute();
$result = $stmt->get_result();
$plan = $result->fetch_assoc();
$stmt->close();

$title = $plan['title'];
$price = $plan['price'];
$currency_symbol = $plan['currency_symbol'];
$frequency = $plan['frequency'];
$features = $plan['features'];
$is_featured = $plan['is_featured'];
$link = $plan['link'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $price = intval($_POST['price']); // Ensure price is an integer
  $currency_symbol = $_POST['currency_symbol'];
  $frequency = $_POST['frequency'];
  $features = $_POST['features'];
  $is_featured = isset($_POST['is_featured']) ? 1 : 0;
  $link = $_POST['link'];

  $sql = "UPDATE pricing SET title = ?, price = ?, currency_symbol = ?, frequency = ?, features = ?, is_featured = ?, link = ? WHERE id = ? AND language = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sisssisis", $title, $price, $currency_symbol, $frequency, $features, $is_featured, $link, $id, $lang);
  $stmt->execute();
  $stmt->close();

  header("Location: view_pricing.php?lang=$lang");
  exit;
}

$conn->close();
?>

<!doctype html>
<html lang="sr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Edit Pricing Plan - Gacik Aleksandar</title>
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
          <h1 class="h2">Edit Pricing Plan</h1>
        </div>
        <form method="POST" action="edit_pricing.php?id=<?php echo $id; ?>&lang=<?php echo $lang; ?>">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
          </div>
          <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" required>
          </div>
          <div class="form-group">
            <label for="currency_symbol">Currency Symbol</label>
            <input type="text" class="form-control" id="currency_symbol" name="currency_symbol" value="<?php echo htmlspecialchars($currency_symbol); ?>" required>
          </div>
          <div class="form-group">
            <label for="frequency">Frequency</label>
            <input type="text" class="form-control" id="frequency" name="frequency" value="<?php echo htmlspecialchars($frequency); ?>" required>
          </div>
          <div class="form-group">
            <label for="features">Features</label>
            <textarea class="form-control" id="features" name="features"><?php echo htmlspecialchars($features); ?></textarea>
          </div>
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" <?php echo $is_featured ? 'checked' : ''; ?>>
            <label class="form-check-label" for="is_featured">Featured</label>
          </div>
          <div class="form-group">
            <label for="link">Link</label>
            <input type="text" class="form-control" id="link" name="link" value="<?php echo htmlspecialchars($link); ?>" required>
          </div>
          <button type="submit" class="btn btn-primary">Update Pricing Plan</button>
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