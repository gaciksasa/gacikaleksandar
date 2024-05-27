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

// Fetch section details
$section_sql = "SELECT section_title, section_subtitle FROM blog_section WHERE id = 1";
$section_result = $conn->query($section_sql);
if ($section_result && $section_result->num_rows > 0) {
    $section = $section_result->fetch_assoc();
    $section_title = $section['section_title'];
    $section_subtitle = $section['section_subtitle'];
}

// Handle form submission for updating section details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_section'])) {
    $section_title = $_POST['section_title'];
    $section_subtitle = $_POST['section_subtitle'];

    // Update section details
    if ($section_result->num_rows > 0) {
        $update_section_sql = "UPDATE blog_section SET section_title = ?, section_subtitle = ? WHERE id = 1";
    } else {
        $update_section_sql = "INSERT INTO blog_section (section_title, section_subtitle) VALUES (?, ?)";
    }
    $stmt = $conn->prepare($update_section_sql);
    $stmt->bind_param("ss", $section_title, $section_subtitle);
    $stmt->execute();
    $stmt->close();

    header("Location: articles.php");
    exit;
}

// Fetch articles
$sql = "SELECT id, title, slug, created_at FROM blog_posts";
$result = $conn->query($sql);
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
                            <label for="section_subtitle">Section Subtitle</label>
                            <input type="text" class="form-control" id="section_subtitle" name="section_subtitle" value="<?php echo htmlspecialchars($section_subtitle); ?>">
                        </div>
                        <div class="form-group">
                            <label for="section_title">Section Title</label>
                            <input type="text" class="form-control" id="section_title" name="section_title" value="<?php echo htmlspecialchars($section_title); ?>">
                        </div>

                    </form>
                </div>

                <div id="main-content">
                    <a href="add_article.php" class="btn btn-primary mb-3">Add Article</a>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0) : ?>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                        <td>
                                            <a href="article/<?php echo htmlspecialchars($row['slug']); ?>" class="btn btn-info btn-sm">View</a>
                                            <a href="edit_article.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="delete_article.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this article?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4">No articles found</td>
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

<?php
$conn->close();
?>