<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'config.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $tags = $_POST['tags'];
    $published_date = $_POST['published_date'];

    // Connect to the database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . lbasename($_FILES["featured_image"]["name"]);

        // Check if directory exists and is writable
        if (!is_dir($target_dir) || !is_writable($target_dir)) {
            die("Error: Upload directory is not writable.");
        }

        if (move_uploaded_file($_FILES["featured_image"]["tmp_name"], $target_file)) {
            $featured_image = $target_file;
            $sql = "UPDATE blog_posts SET title = ?, content = ?, author = ?, category_id = ?, featured_image = ?, published_date = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Error preparing statement: " . $conn->error);
            }
            $stmt->bind_param("sssissi", $title, $content, $author, $category, $featured_image, $published_date, $id);
        } else {
            die("Error: Unable to move uploaded file.");
        }
    } else {
        $sql = "UPDATE blog_posts SET title = ?, content = ?, author = ?, category_id = ?, published_date = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("sssisi", $title, $content, $author, $category, $published_date, $id);
    }

    // Execute the query
    if ($stmt->execute()) {
        // Update tags
        $stmt = $conn->prepare("DELETE FROM blog_post_tags WHERE blog_post_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if (!empty($tags)) {
            foreach ($tags as $tag_id) {
                $stmt = $conn->prepare("INSERT INTO blog_post_tags (blog_post_id, tag_id) VALUES (?, ?)");
                if (!$stmt) {
                    die("Error preparing statement for tags: " . $conn->error);
                }
                $stmt->bind_param("ii", $id, $tag_id);
                $stmt->execute();
            }
        }

        header("Location: view_all_articles.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Connect to the database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch article
    $sql = "SELECT title, content, author, category_id, featured_image, published_date FROM blog_posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($title, $content, $author, $category_id, $featured_image, $published_date);
    $stmt->fetch();
    $stmt->close();

    // Fetch categories
    $categories_result = $conn->query("SELECT id, name FROM categories");
    if (!$categories_result) {
        die("Error fetching categories: " . $conn->error);
    }

    // Fetch tags
    $tags_result = $conn->query("SELECT id, name FROM tags");
    if (!$tags_result) {
        die("Error fetching tags: " . $conn->error);
    }

    // Fetch article tags
    $article_tags_result = $conn->query("SELECT tag_id FROM blog_post_tags WHERE blog_post_id = $id");
    $article_tags = [];
    while ($row = $article_tags_result->fetch_assoc()) {
        $article_tags[] = $row['tag_id'];
    }

    $conn->close();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Edit Article</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit-no">
    <link rel="shortcut icon" type="image/x-icon" href="./images/favicon.png">
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
                    <h1 class="h2">Edit Article</h1>
                </div>
                <div id="main-content">
                    <form action="edit_article.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="10" required><?php echo $content; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" id="author" name="author" value="<?php echo $author; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category" required>
                                <?php while ($row = $categories_result->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $category_id) echo 'selected'; ?>><?php echo $row['name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <select class="form-control" id="tags" name="tags[]" multiple>
                                <?php while ($row = $tags_result->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>" <?php if (in_array($row['id'], $article_tags)) echo 'selected'; ?>><?php echo $row['name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="featured_image">Featured Image</label>
                            <input type="file" class="form-control" id="featured_image" name="featured_image">
                            <?php if (!empty($featured_image)): ?>
                                <img src="<?php echo $featured_image; ?>" alt="Featured Image" class="img-thumbnail mt-2">
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="published_date">Published Date</label>
                            <input type="date" class="form-control" id="published_date" name="published_date" value="<?php echo $published_date; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="view_all_articles.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </main>
            <!-- Main Content End -->
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
