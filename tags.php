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

// Fetch all tags with their translations
$sql = "SELECT t1.tag_group_id, t1.name AS name_sr, t2.name AS name_en, t1.featured_image 
        FROM tags t1
        LEFT JOIN tags t2 ON t1.tag_group_id = t2.tag_group_id AND t2.language = 'en'
        WHERE t1.language = 'sr'";
$result = $conn->query($sql);
$tags = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tags[] = $row;
    }
}
$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Tags - Gacik Aleksandar</title>
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
                    <h1 class="h2">Tags</h1>
                </div>
                <a href="add_tag.php" class="btn btn-primary mb-3">Add Tag</a>
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
                        <?php foreach ($tags as $tag) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($tag['name_sr']); ?></td>
                                <td><?php echo htmlspecialchars($tag['name_en']); ?></td>
                                <td>
                                    <?php if ($tag['featured_image']) : ?>
                                        <img src="<?php echo htmlspecialchars($tag['featured_image']); ?>" alt="Featured Image" style="width: 50px; height: auto;">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_tag.php?id=<?php echo $tag['tag_group_id']; ?>" class="btn btn-warning">Edit</a>
                                    <a href="delete_tag.php?id=<?php echo $tag['tag_group_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this tag?');">Delete</a>
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