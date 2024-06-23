<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit;
}

require '../config.php';

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch all pages
$sql = "SELECT p1.page_group_id, 
               p1.title AS title_sr, p2.title AS title_en,
               p1.slug AS slug_sr, p2.slug AS slug_en,
               p1.created_at AS created_at_sr, p2.created_at AS created_at_en
        FROM pages p1
        LEFT JOIN pages p2 ON p1.page_group_id = p2.page_group_id AND p2.language = 'en'
        WHERE p1.language = 'sr'
        ORDER BY p1.created_at DESC";
$result = $conn->query($sql);

$pages = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $pages[] = $row;
  }
}

$conn->close();
?>

<!doctype html>
<html lang="sr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>View Pages - Gacik Aleksandar</title>
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
          <h1 class="h2">View Pages</h1>
        </div>
        <div id="main-content">
          <a href="add_page.php" class="btn btn-primary mb-3 mt-4">Add Page</a>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Title (Languages)</th>
                <th>Slugs</th>
                <th>Created Dates</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($pages)) : ?>
                <?php foreach ($pages as $page) : ?>
                  <tr>
                    <td>
                      <?php echo htmlspecialchars($page['title_sr']); ?> (sr)<br>
                      <?php echo htmlspecialchars($page['title_en']); ?> (en)
                    </td>
                    <td>
                      <?php echo htmlspecialchars($page['slug_sr']); ?> (sr)<br>
                      <?php echo htmlspecialchars($page['slug_en']); ?> (en)
                    </td>
                    <td>
                      <?php echo htmlspecialchars($page['created_at_sr']); ?><br>
                      <?php echo htmlspecialchars($page['created_at_en']); ?>
                    </td>
                    <td>
                      <a href="edit_page.php?id=<?php echo $page['page_group_id']; ?>" class="btn btn-warning">Edit</a>
                      <a href="delete_page.php?id=<?php echo $page['page_group_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this page?');">Delete</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="4">No pages found</td>
                </tr>
              <?php endif; ?>
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