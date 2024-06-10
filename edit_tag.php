<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'config.php';

// Set default language
$lang = 'sr';
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
} elseif (isset($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $featured_image = '';
    $language = $lang; // Use the selected language

    // Handle file upload
    if (!empty($_FILES['featured_image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["featured_image"]["name"]);
        if (move_uploaded_file($_FILES["featured_image"]["tmp_name"], $target_file)) {
            $featured_image = $target_file;
        }
    }

    // Connect to the database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update tag
    if ($featured_image) {
        $sql = "UPDATE tags SET name = ?, featured_image = ?, language = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $featured_image, $language, $id);
    } else {
        $sql = "UPDATE tags SET name = ?, language = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $language, $id);
    }

    $stmt->execute();
    $stmt->close();

    $conn->close();

    header("Location: tags.php?lang=$lang");
    exit;
} else {
    // Fetch tag details
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " .
            $conn->connect_error);
    }

    $sql = "SELECT name, featured_image FROM tags WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name, $featured_image);
    $stmt->fetch();
    $stmt->close();

    $conn->close();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Edit Tag - Gacik Aleksandar</title>
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
                    <h1 class="h2">Edit Tag</h1>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Tag Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="featured_image">Featured Image</label>
                        <input type="file" class="form-control" id="featured_image" name="featured_image">
                        <?php if ($featured_image) : ?>
                            <img src="<?php echo htmlspecialchars($featured_image); ?>" alt="Featured Image" style="width: 100px; height: auto;">
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Update tag</button>
                </form>
            </main>
            <!-- Main Content End -->
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>