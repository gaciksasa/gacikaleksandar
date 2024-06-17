<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require '../config.php';

function generateSlug($title)
{
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title_sr = $_POST['title_sr'];
    $content_sr = $_POST['content_sr'];
    $category_group_id_sr = $_POST['category_group_id_sr'];

    $title_en = $_POST['title_en'];
    $content_en = $_POST['content_en'];
    $category_group_id_en = $_POST['category_group_id_en'];

    $featured_image = '';

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

    // Connect to the database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Generate a unique article_group_id
    $article_group_id = uniqid();

    // Generate slugs
    $slug_sr = generateSlug($title_sr);
    $slug_en = generateSlug($title_en);

    // Fetch category IDs based on the category_group_id
    $category_id_sr = null;
    $category_id_en = null;

    $sql = "SELECT id, language FROM categories WHERE category_group_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category_group_id_sr);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        if ($row['language'] == 'sr') {
            $category_id_sr = $row['id'];
        } elseif ($row['language'] == 'en') {
            $category_id_en = $row['id'];
        }
    }
    $stmt->close();

    // Insert article in Serbian
    $sql_sr = "INSERT INTO blog_posts (article_group_id, title, content, category_id, featured_image, language, slug, published_date, created_at) 
               VALUES (?, ?, ?, ?, ?, 'sr', ?, NOW(), NOW())";
    $stmt_sr = $conn->prepare($sql_sr);
    $stmt_sr->bind_param("sssiss", $article_group_id, $title_sr, $content_sr, $category_id_sr, $featured_image, $slug_sr);
    if (!$stmt_sr->execute()) {
        echo "Error: " . $stmt_sr->error;
    }

    // Insert article in English
    $sql_en = "INSERT INTO blog_posts (article_group_id, title, content, category_id, featured_image, language, slug, published_date, created_at) 
               VALUES (?, ?, ?, ?, ?, 'en', ?, NOW(), NOW())";
    $stmt_en = $conn->prepare($sql_en);
    $stmt_en->bind_param("sssiss", $article_group_id, $title_en, $content_en, $category_id_en, $featured_image, $slug_en);
    if (!$stmt_en->execute()) {
        echo "Error: " . $stmt_en->error;
    }

    // Close the statements and the connection
    $stmt_sr->close();
    $stmt_en->close();
    $conn->close();

    header("Location: view_articles.php");
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Add Article - Gacik Aleksandar</title>
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
                    <h1 class="h2">Add Article</h1>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <h3>Serbian</h3>
                    <div class="form-group">
                        <label for="title_sr">Title (Serbian)</label>
                        <input type="text" class="form-control" id="title_sr" name="title_sr" required>
                    </div>
                    <div class="form-group">
                        <label for="content_sr">Content (Serbian)</label>
                        <textarea class="form-control" id="content_sr" name="content_sr" rows="10" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category_group_id_sr">Category (Serbian)</label>
                        <select class="form-control" id="category_group_id_sr" name="category_group_id_sr" required>
                            <?php
                            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                            $sql = "SELECT DISTINCT category_group_id, name FROM categories WHERE language = 'sr'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['category_group_id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                                }
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>

                    <h3>English</h3>
                    <div class="form-group">
                        <label for="title_en">Title (English)</label>
                        <input type="text" class="form-control" id="title_en" name="title_en" required>
                    </div>
                    <div class="form-group">
                        <label for="content_en">Content (English)</label>
                        <textarea class="form-control" id="content_en" name="content_en" rows="10" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category_group_id_en">Category (English)</label>
                        <select class="form-control" id="category_group_id_en" name="category_group_id_en" required>
                            <?php
                            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                            $sql = "SELECT DISTINCT category_group_id, name FROM categories WHERE language = 'en'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['category_group_id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                                }
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="featured_image">Featured Image</label>
                        <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*">
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
</body>

</html>