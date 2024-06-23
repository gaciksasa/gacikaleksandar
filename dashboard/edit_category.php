<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require '../config.php';

$category_group_id = $_GET['id'];

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch category details
$sql = "SELECT name, featured_image, language FROM categories WHERE category_group_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $category_group_id);
$stmt->execute();
$stmt->bind_result($name, $featured_image, $language);
$categories = [];
while ($stmt->fetch()) {
    $categories[$language] = ['name' => $name, 'featured_image' => $featured_image];
}
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_sr = $_POST['name_sr'];
    $name_en = $_POST['name_en'];
    $featured_image = $categories['sr']['featured_image']; // Assuming both languages use the same image

    // Handle file upload
    if (!empty($_FILES['featured_image']['name'])) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["featured_image"]["name"]);
        if (move_uploaded_file($_FILES["featured_image"]["tmp_name"], $target_file)) {
            $featured_image = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Update category in Serbian
    $sql = "UPDATE categories SET name = ?, featured_image = ? WHERE category_group_id = ? AND language = 'sr'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name_sr, $featured_image, $category_group_id);
    $stmt->execute();

    // Update category in English
    $sql = "UPDATE categories SET name = ?, featured_image = ? WHERE category_group_id = ? AND language = 'en'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name_en, $featured_image, $category_group_id);
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
    <title>Edit Category - Gacik Aleksandar</title>
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
                    <h1 class="h2">Edit Category</h1>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name_sr">Category Name (Serbian)</label>
                        <input type="text" class="form-control" id="name_sr" name="name_sr" value="<?php echo htmlspecialchars($categories['sr']['name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="name_en">Category Name (English)</label>
                        <input type="text" class="form-control" id="name_en" name="name_en" value="<?php echo htmlspecialchars($categories['en']['name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="featured_image">Featured Image</label>
                        <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*">
                        <?php if ($categories['sr']['featured_image']) : ?>
                            <img src="../<?php echo htmlspecialchars($categories['sr']['featured_image']); ?>" class="img-fluid mt-2" alt="Featured Image">
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Update</button>
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