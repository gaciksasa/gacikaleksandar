<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_sr = $_POST['name_sr'];
    $name_en = $_POST['name_en'];
    $featured_image = '';

    // Handle file upload
    if (!empty($_FILES['featured_image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["featured_image"]["name"]);
        if (move_uploaded_file($_FILES["featured_image"]["tmp_name"], $target_file)) {
            $featured_image = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Connect to the database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Generate a unique category_group_id
    $category_group_id = uniqid();

    // Insert category in Serbian
    $sql = "INSERT INTO categories (category_group_id, name, featured_image, language) VALUES (?, ?, ?, 'sr')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $category_group_id, $name_sr, $featured_image);
    $stmt->execute();

    // Insert category in English
    $sql = "INSERT INTO categories (category_group_id, name, featured_image, language) VALUES (?, ?, ?, 'en')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $category_group_id, $name_en, $featured_image);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: view_categories.php");
    exit;
}
?>

<!doctype html>
<html lang="sr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Add Category - Gacik Aleksandar</title>
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
                    <h1 class="h2">Add Category</h1>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name_sr">Category Name (Serbian)</label>
                        <input type="text" class="form-control" id="name_sr" name="name_sr" required>
                    </div>
                    <div class="form-group">
                        <label for="name_en">Category Name (English)</label>
                        <input type="text" class="form-control" id="name_en" name="name_en" required>
                    </div>
                    <div class="form-group">
                        <label for="featured_image">Featured Image</label>
                        <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
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