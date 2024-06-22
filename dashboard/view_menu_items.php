<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

require '../config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Fetch all menu items
$sql = "SELECT id, title_sr, title_en, link_sr, link_en, `order`, parent_id FROM menu_items ORDER BY parent_id, `order`";
$result = $conn->query($sql);
$menu_items = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $menu_items[] = $row;
  }
}
$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>View Header Items - Gacik Aleksandar</title>
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
          <h1 class="h2">View Header Items</h1>
          <a href="add_menu_item.php" class="btn btn-primary">Add Menu Item</a>
        </div>

        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>ID</th>
                <th>Title (Serbian)</th>
                <th>Title (English)</th>
                <th>Link (Serbian)</th>
                <th>Link (English)</th>
                <th>Order</th>
                <th>Parent ID</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($menu_items as $item) : ?>
                <tr>
                  <td><?php echo htmlspecialchars($item['id'] ?? ''); ?></td>
                  <td><?php echo htmlspecialchars($item['title_sr'] ?? ''); ?></td>
                  <td><?php echo htmlspecialchars($item['title_en'] ?? ''); ?></td>
                  <td><?php echo htmlspecialchars($item['link_sr'] ?? ''); ?></td>
                  <td><?php echo htmlspecialchars($item['link_en'] ?? ''); ?></td>
                  <td><?php echo htmlspecialchars($item['order'] ?? ''); ?></td>
                  <td><?php echo htmlspecialchars($item['parent_id'] ?? ''); ?></td>
                  <td>
                    <a href="edit_menu_item.php?id=<?php echo htmlspecialchars($item['id']); ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="delete_menu_item.php?id=<?php echo htmlspecialchars($item['id']); ?>" class="btn btn-sm btn-danger">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </main>
      <!-- Main Content End -->
    </div>
  </div>

  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</body>

</html>