<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'config.php';

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $author = $conn->real_escape_string($_POST['author']);
    $category_id = (int)$_POST['category'];
    $published_date = $conn->real_escape_string($_POST['published_date']);

    // Generate slug
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

    // Handle file upload for featured image
    $featured_image = '';
    if (!empty($_FILES['featured_image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["featured_image"]["name"]);
        move_uploaded_file($_FILES["featured_image"]["tmp_name"], $target_file);
        $featured_image = $target_file;
    }

    // Insert article into database
    $stmt = $conn->prepare("INSERT INTO blog_posts (title, content, author, category_id, featured_image, published_date, slug) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisss", $title, $content, $author, $category_id, $featured_image, $published_date, $slug);
    $stmt->execute();
    $stmt->close();

    header("Location: articles.php");
    exit;
}

// Fetch categories
$categories_result = $conn->query("SELECT id, name FROM categories");

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Add Article - Gacik Aleksandar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit-no">
    <link rel="shortcut icon" type="image/x-icon" href="./images/favicon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/2d8d0z568l75o82jphit2mlssygij2v5xxuk0ev3ai9lv60g/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
            valid_elements: 'p,h2,h3,h4,strong,em,ul,ol,li,a[href|target],img[src|alt|width|height],blockquote',
            valid_styles: {
                '*': 'font-size,font-weight,font-style,color,text-decoration,text-align'
            },
            height: 500,
        });
    </script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Include Navigation -->
            <?php include 'navigation.php'; ?>
            <!-- Main Content -->
            <main role="main" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Add New Article</h1>
                </div>
                <div id="main-content">
                    <form action="add_article.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" id="author" name="author" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category" required>
                                <?php while ($row = $categories_result->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="featured_image">Featured Image</label>
                            <input type="file" class="form-control" id="featured_image" name="featured_image">
                        </div>
                        <div class="form-group">
                            <label for="published_date">Published Date</label>
                            <input type="date" class="form-control" id="published_date" name="published_date" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </main>
            <!-- Main Content End -->
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        function validateForm() {
            // Ensure the content of the TinyMCE editor is synchronized with the textarea
            tinymce.triggerSave();

            // Check if the TinyMCE content is empty
            const content = tinymce.get('content').getContent();
            if (!content) {
                alert('Content is required.');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
