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

// Fetch all categories with their translations
$sql = "SELECT c1.category_group_id, c1.name AS name_sr, c2.name AS name_en, c1.featured_image 
        FROM categories c1
        LEFT JOIN categories c2 ON c1.category_group_id = c2.category_group_id AND c2.language = 'en'
        WHERE c1.language = 'sr'";
$result = $conn->query($sql);
$categories = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}
$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Categories - Gacik Aleksandar</title>
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
                    <h1 class="h2">Categories</h1>
                </div>
                <a href="add_category.php" class="btn btn-primary mb-3">Add Category</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name (SR)</th>
                            <th>Name (EN)</th>
                            <th>Featured Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($category['name_sr']); ?></td>
                                <td><?php echo htmlspecialchars($category['name_en']); ?></td>
                                <td>
                                    <?php if ($category['featured_image']) : ?>
                                        <img src="<?php echo htmlspecialchars($category['featured_image']); ?>" alt="Featured Image" style="width: 50px; height: auto;">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_category.php?id=<?php echo $category['category_group_id']; ?>" class="btn btn-warning">Edit</a>
                                    <a href="delete_category.php?id=<?php echo $category['category_group_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
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