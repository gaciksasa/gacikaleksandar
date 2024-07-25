<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require '../config.php';

$article_group_id = $_GET['id'];

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch article details
$sql = "SELECT id, title, content, category_id, featured_image, language, published_date FROM blog_posts WHERE article_group_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $article_group_id);
$stmt->execute();
$stmt->bind_result($id, $title, $content, $category_id, $featured_image, $language, $published_date);
$articles = [];
while ($stmt->fetch()) {
    $articles[$language] = [
        'id' => $id,
        'title' => $title,
        'content' => $content,
        'category_id' => $category_id,
        'featured_image' => $featured_image,
        'published_date' => $published_date
    ];
}
$stmt->close();

// Fetch categories for Serbian
$categories_sr_sql = "SELECT id, name FROM categories WHERE language = 'sr'";
$categories_sr_result = $conn->query($categories_sr_sql);
$categories_sr = [];
if ($categories_sr_result->num_rows > 0) {
    while ($row = $categories_sr_result->fetch_assoc()) {
        $categories_sr[$row['id']] = $row['name'];
    }
}

// Fetch categories for English
$categories_en_sql = "SELECT id, name FROM categories WHERE language = 'en'";
$categories_en_result = $conn->query($categories_en_sql);
$categories_en = [];
if ($categories_en_result->num_rows > 0) {
    while ($row = $categories_en_result->fetch_assoc()) {
        $categories_en[$row['id']] = $row['name'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title_sr = $_POST['title_sr'];
    $content_sr = $_POST['content_sr'];
    $category_id_sr = $_POST['category_id_sr'];
    $published_date_sr = $_POST['published_date_sr'];

    $title_en = $_POST['title_en'];
    $content_en = $_POST['content_en'];
    $category_id_en = $_POST['category_id_en'];
    $published_date_en = $_POST['published_date_en'];

    $featured_image = $articles['sr']['featured_image'];

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

    // Update article in Serbian
    $sql = "UPDATE blog_posts SET title = ?, content = ?, category_id = ?, featured_image = ?, published_date = ? WHERE article_group_id = ? AND language = 'sr'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisss", $title_sr, $content_sr, $category_id_sr, $featured_image, $published_date_sr, $article_group_id);
    $stmt->execute();

    // Update article in English
    $sql = "UPDATE blog_posts SET title = ?, content = ?, category_id = ?, featured_image = ?, published_date = ? WHERE article_group_id = ? AND language = 'en'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisss", $title_en, $content_en, $category_id_en, $featured_image, $published_date_en, $article_group_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: view_articles.php");
    exit;
}
?>

<!doctype html>
<html lang="sr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Edit Article - Gacik Aleksandar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit-no">
    <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.tiny.cloud/1/2d8d0z568l75o82jphit2mlssygij2v5xxuk0ev3ai9lv60g/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'lists link image table code',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor | table | code',
            menubar: false,
            branding: false,
            height: 300
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
                    <h1 class="h2">Edit Article</h1>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title_sr">Title (Serbian)</label>
                        <input type="text" class="form-control" id="title_sr" name="title_sr" value="<?php echo htmlspecialchars($articles['sr']['title']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="content_sr">Content (Serbian)</label>
                        <textarea class="form-control" id="content_sr" name="content_sr" required><?php echo htmlspecialchars($articles['sr']['content']); ?></textarea>
                    </div>
                    <div class="form-group mt-4">
                        <label for="category_id_sr">Category (Serbian)</label>
                        <select class="form-control" id="category_id_sr" name="category_id_sr" required>
                            <?php foreach ($categories_sr as $id => $name) : ?>
                                <option value="<?php echo $id; ?>" <?php echo ($articles['sr']['category_id'] == $id) ? 'selected' : ''; ?>><?php echo htmlspecialchars($name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="published_date_sr">Published Date (Serbian)</label>
                        <input type="date" class="form-control" id="published_date_sr" name="published_date_sr" value="<?php echo htmlspecialchars($articles['sr']['published_date']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="title_en">Title (English)</label>
                        <input type="text" class="form-control" id="title_en" name="title_en" value="<?php echo htmlspecialchars($articles['en']['title']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="content_en">Content (English)</label>
                        <textarea class="form-control" id="content_en" name="content_en" required><?php echo htmlspecialchars($articles['en']['content']); ?></textarea>
                    </div>
                    <div class="form-group mt-4">
                        <label for="category_id_en">Category (English)</label>
                        <select class="form-control" id="category_id_en" name="category_id_en" required>
                            <?php foreach ($categories_en as $id => $name) : ?>
                                <option value="<?php echo $id; ?>" <?php echo ($articles['en']['category_id'] == $id) ? 'selected' : ''; ?>><?php echo htmlspecialchars($name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="published_date_en">Published Date (English)</label>
                        <input type="date" class="form-control" id="published_date_en" name="published_date_en" value="<?php echo htmlspecialchars($articles['en']['published_date']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="featured_image">Featured Image (1200x1000)</label>
                        <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*">
                        <?php if ($articles['sr']['featured_image']) : ?>
                            <img src="./../uploads/<?php echo htmlspecialchars($articles['sr']['featured_image']); ?>" class="img-fluid mt-2" alt="Featured Image">
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