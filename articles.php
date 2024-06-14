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

// Initialize variables for the section
$section_title = '';
$section_subtitle = '';
$section_title_en = '';
$section_subtitle_en = '';

// Fetch section details
$section_sql = "SELECT section_title, section_subtitle, section_title_en, section_subtitle_en FROM blog_section WHERE id = 1";
$section_result = $conn->query($section_sql);
if ($section_result && $section_result->num_rows > 0) {
    $section = $section_result->fetch_assoc();
    $section_title = $section['section_title'];
    $section_subtitle = $section['section_subtitle'];
    $section_title_en = $section['section_title_en'];
    $section_subtitle_en = $section['section_subtitle_en'];
}

// Handle form submission for updating section details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_section'])) {
    $section_title = $_POST['section_title'];
    $section_subtitle = $_POST['section_subtitle'];
    $section_title_en = $_POST['section_title_en'];
    $section_subtitle_en = $_POST['section_subtitle_en'];

    // Update section details
    if ($section_result->num_rows > 0) {
        $update_section_sql = "UPDATE blog_section SET section_title = ?, section_subtitle = ?, section_title_en = ?, section_subtitle_en = ? WHERE id = 1";
    } else {
        $update_section_sql = "INSERT INTO blog_section (section_title, section_subtitle, section_title_en, section_subtitle_en) VALUES (?, ?, ?, ?)";
    }
    $stmt = $conn->prepare($update_section_sql);
    $stmt->bind_param("ssss", $section_title, $section_subtitle, $section_title_en, $section_subtitle_en);
    $stmt->execute();
    $stmt->close();

    header("Location: articles.php");
    exit;
}

// Fetch articles
$sql = "SELECT b1.article_group_id, b1.title AS title_sr, b1.slug AS slug_sr, b1.published_date AS published_date_sr, 
               b2.title AS title_en, b2.slug AS slug_en, b2.published_date AS published_date_en, 
               c.name AS category, b1.featured_image 
        FROM blog_posts b1
        LEFT JOIN blog_posts b2 ON b1.article_group_id = b2.article_group_id AND b2.language = 'en'
        LEFT JOIN categories c ON b1.category_id = c.id
        WHERE b1.language = 'sr'";
$result = $conn->query($sql);

$articles = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }
}

$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>View All Articles</title>
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
                    <h1 class="h2">Articles</h1>
                </div>

                <!-- Section Details Form -->
                <div class="mb-3">
                    <form method="POST" action="articles.php">
                        <button type="submit" class="btn btn-primary mb-3" name="save_section">Save Section</button>
                        <div class="form-group">
                            <label for="section_subtitle">Section Subtitle (Serbian)</label>
                            <input type="text" class="form-control" id="section_subtitle" name="section_subtitle" value="<?php echo htmlspecialchars($section_subtitle); ?>">
                        </div>
                        <div class="form-group">
                            <label for="section_title">Section Title (Serbian)</label>
                            <input type="text" class="form-control" id="section_title" name="section_title" value="<?php echo htmlspecialchars($section_title); ?>">
                        </div>
                        <div class="form-group">
                            <label for="section_subtitle_en">Section Subtitle (English)</label>
                            <input type="text" class="form-control" id="section_subtitle_en" name="section_subtitle_en" value="<?php echo htmlspecialchars($section_subtitle_en); ?>">
                        </div>
                        <div class="form-group">
                            <label for="section_title_en">Section Title (English)</label>
                            <input type="text" class="form-control" id="section_title_en" name="section_title_en" value="<?php echo htmlspecialchars($section_title_en); ?>">
                        </div>
                    </form>
                </div>

                <div id="main-content">
                    <a href="add_article.php" class="btn btn-primary mb-3 mt-4">Add Article</a>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title (Languages)</th>
                                <th>Category</th>
                                <th>Featured Image</th>
                                <th>Published Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($articles)) : ?>
                                <?php foreach ($articles as $article) : ?>
                                    <tr>
                                        <td>
                                            <?php echo htmlspecialchars($article['title_sr']); ?> (sr)<br>
                                            <?php echo htmlspecialchars($article['title_en']); ?> (en)
                                        </td>
                                        <td><?php echo htmlspecialchars($article['category']) ?: 'Unknown'; ?></td>
                                        <td>
                                            <?php if ($article['featured_image']) : ?>
                                                <img src="<?php echo htmlspecialchars($article['featured_image']); ?>" alt="Featured Image" style="width: 50px; height: auto;">
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($article['published_date_sr']); ?><br>
                                            <?php echo htmlspecialchars($article['published_date_en']); ?>
                                        </td>
                                        <td>
                                            <a href="edit_article.php?id=<?php echo $article['article_group_id']; ?>" class="btn btn-warning">Edit</a>
                                            <a href="delete_article.php?id=<?php echo $article['article_group_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this article?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5">No articles found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
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