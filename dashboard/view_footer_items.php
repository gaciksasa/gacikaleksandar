<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

require '../config.php';

// Fetch footer items from the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT * FROM footer_items ORDER BY `order`";
$result = $conn->query($sql);
$footer_items = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $footer_items[] = $row;
  }
}
$conn->close();
?>

<!doctype html>
<html lang="sr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>View Footer Items - Gacik Aleksandar</title>
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
          <h1 class="h2">View Footer Items</h1>
          <a href="add_footer_item.php" class="btn btn-primary">Add Menu Item</a>
        </div>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title (Serbian)</th>
              <th>Title (English)</th>
              <th>Link (Serbian)</th>
              <th>Link (English)</th>
              <th>Order</th>
              <th>Menu</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($footer_items as $item) : ?>
              <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo htmlspecialchars($item['title_sr']); ?></td>
                <td><?php echo htmlspecialchars($item['title_en']); ?></td>
                <td><?php echo htmlspecialchars($item['link_sr']); ?></td>
                <td><?php echo htmlspecialchars($item['link_en']); ?></td>
                <td><?php echo htmlspecialchars($item['order']); ?></td>
                <td><?php echo htmlspecialchars($item['menu']); ?></td>
                <td>
                  <a href="edit_footer_item.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                  <a href="delete_footer_item.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
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