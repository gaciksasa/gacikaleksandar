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

// Fetch pricing section data
$sql = "SELECT title, subtitle, content FROM pricing_section WHERE language = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $lang);
$stmt->execute();
$result = $stmt->get_result();
$pricingSection = $result->fetch_assoc();

$title = isset($pricingSection['title']) ? $pricingSection['title'] : '';
$subtitle = isset($pricingSection['subtitle']) ? $pricingSection['subtitle'] : '';
$content = isset($pricingSection['content']) ? $pricingSection['content'] : '';

// Handle form submission for pricing section
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['section'])) {
  $title = $_POST['title'];
  $subtitle = $_POST['subtitle'];
  $content = $_POST['content'];

  if ($result && $result->num_rows > 0) {
    $sql = "UPDATE pricing_section SET title=?, subtitle=?, content=? WHERE language=?";
  } else {
    $sql = "INSERT INTO pricing_section (title, subtitle, content, language) VALUES (?, ?, ?, ?)";
  }

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $title, $subtitle, $content, $lang);
  $stmt->execute();
  $stmt->close();

  header("Location: view_pricing.php?lang=$lang");
  exit;
}

// Fetch pricing plans
$sql = "SELECT id, title, price, currency_symbol, frequency, features, is_featured, link FROM pricing WHERE language = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $lang);
$stmt->execute();
$result = $stmt->get_result();
$pricingPlans = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $pricingPlans[] = $row;
  }
}

$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Pricing Management - Gacik Aleksandar</title>
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
          <h1 class="h2">Pricing</h1>
          <div>
            <a href="?lang=en" class="btn <?php echo $lang === 'en' ? 'btn-primary' : 'btn-secondary'; ?>">English</a>
            <a href="?lang=sr" class="btn <?php echo $lang === 'sr' ? 'btn-primary' : 'btn-secondary'; ?>">Serbian</a>
          </div>
        </div>

        <!-- Pricing Section Form -->
        <form method="POST" action="view_pricing.php?lang=<?php echo $lang; ?>">
          <input type="hidden" name="section" value="section">
          <button type="submit" class="btn btn-primary mb-3">Save Section</button>
          <div class="form-group">
            <label for="title">Section Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
          </div>
          <div class="form-group">
            <label for="subtitle">Section Subtitle</label>
            <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo htmlspecialchars($subtitle); ?>" required>
          </div>
          <div class="form-group">
            <label for="content">Section Content</label>
            <textarea class="form-control" id="content" name="content"><?php echo htmlspecialchars($content); ?></textarea>
          </div>
        </form>

        <!-- Pricing Plans -->
        <a href="add_pricing.php" class="btn btn-primary mt-4 mb-3">Add Pricing Plan</a>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Title</th>
              <th>Price</th>
              <th>Currency Symbol</th>
              <th>Frequency</th>
              <th>Features</th>
              <th>Featured</th>
              <th>Link</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pricingPlans as $plan) : ?>
              <tr>
                <td><?php echo htmlspecialchars($plan['title']); ?></td>
                <td><?php echo htmlspecialchars($plan['price']); ?></td>
                <td><?php echo htmlspecialchars($plan['currency_symbol']); ?></td>
                <td><?php echo htmlspecialchars($plan['frequency']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($plan['features'])); ?></td>
                <td><?php echo $plan['is_featured'] ? 'Yes' : 'No'; ?></td>
                <td><?php echo htmlspecialchars($plan['link']); ?></td>
                <td>
                  <a href="edit_pricing.php?id=<?php echo $plan['id']; ?>" class="btn btn-warning">Edit</a>
                  <a href="delete_pricing.php?id=<?php echo $plan['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pricing plan?');">Delete</a>
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