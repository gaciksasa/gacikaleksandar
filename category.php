<?php
session_start();

require 'config.php';

// Set default language
$lang = 'sr';
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    setcookie('lang', $lang, time() + (86400 * 30), "/"); // 86400 = 1 day
} elseif (isset($_COOKIE['lang'])) {
    $lang = $_COOKIE['lang'];
}

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$category_id = isset($_GET['id']) ? $_GET['id'] : 0;

// If category_id is not provided, fetch the first existing category ID for the selected language
if ($category_id == 0) {
    $sql = "SELECT id FROM categories WHERE language = ? LIMIT 1";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $lang);
        $stmt->execute();
        $stmt->bind_result($category_id);
        $stmt->fetch();
        $stmt->close();
    } else {
        die("Error preparing statement: " . $conn->error);
    }

    if ($category_id == 0) {
        die("No categories found for the selected language.");
    }
}

// Fetch category name and featured image
$category_name = '';
$category_image = '';
$sql = "SELECT name, featured_image FROM categories WHERE id = ? AND language = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("is", $category_id, $lang);
    $stmt->execute();
    $stmt->bind_result($category_name, $category_image);
    $stmt->fetch();
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}

// Fetch articles in the category
$sql = "SELECT id, title, content, featured_image, published_date, slug FROM blog_posts WHERE category_id = ? AND language = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("is", $category_id, $lang);
    $stmt->execute();
    $stmt->bind_result($id, $title, $content, $featured_image, $published_date, $slug);
    $articles = [];
    while ($stmt->fetch()) {
        $articles[] = ['id' => $id, 'title' => $title, 'content' => $content, 'featured_image' => $featured_image, 'published_date' => $published_date, 'slug' => $slug];
    }
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}

// Fetch all categories
$sql = "SELECT id, name FROM categories WHERE language = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $lang);
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}

// Function to create excerpt
function create_excerpt($content, $length = 200)
{
    if (strlen($content) <= $length) {
        return $content;
    }
    $excerpt = substr($content, 0, $length);
    return substr($excerpt, 0, strrpos($excerpt, ' ')) . '...';
}
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $translations['category']; ?>: <?php echo htmlspecialchars($category_name); ?></title>
    <meta name="robots" content="noindex, follow">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
    <!-- CSS ============================================ -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/pbminfotech-base-icons.css">
    <link rel="stylesheet" href="css/swiper.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/shortcode.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <style>
        .pbmit-title-bar-wrapper {
            background-image: url('<?php echo htmlspecialchars($category_image); ?>');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Header Main Area -->
        <header class="site-header header-style-1">
            <!-- Include Header -->
            <?php include 'header.php'; ?>
        </header>
        <!-- Header Main Area End Here -->

        <!-- Title Bar -->
        <div class="pbmit-title-bar-wrapper" style="background-image: url('<?php echo htmlspecialchars($category_image); ?>');">
            <div class="container">
                <div class="pbmit-title-bar-content">
                    <div class="pbmit-title-bar-content-inner">
                        <div class="pbmit-tbar">
                            <div class="pbmit-tbar-inner container">
                                <h1 class="pbmit-tbar-title"><?php echo $translations['category']; ?>: <?php echo htmlspecialchars($category_name); ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Title Bar End-->

        <!-- Page Content -->
        <div class="page-content">
            <!-- Blog Classic  -->
            <section class="overflow-hidden">
                <div class="container">
                    <div class="row blog-section">
                        <div class="col-lg-9 blog-right-col">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if (!empty($articles)) : ?>
                                        <?php foreach ($articles as $article) : ?>
                                            <article class="post blog-classic">
                                                <div class="pbmit-featured-img-wrapper">
                                                    <div class="pbmit-featured-wrapper">
                                                        <a href="<?php echo $article['slug']; ?>">
                                                            <img src="<?php echo htmlspecialchars($article['featured_image']); ?>" class="img-fluid w-100" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="pbmit-blog-classic-inner">
                                                    <div class="pbmit-blog-meta-wrapper">
                                                        <h2 class="pbmit-post-title">
                                                            <a href="<?php echo $article['slug']; ?>"><?php echo htmlspecialchars($article['title']); ?></a>
                                                        </h2>
                                                        <div class="pbmit-classic-meta-date">
                                                            <a href="<?php echo $article['slug']; ?>">
                                                                <span><?php echo date('F j, Y', strtotime($article['published_date'])); ?></span>
                                                            </a>
                                                        </div>
                                                        <div class="pbmit-entry-content">
                                                            <p><?php echo create_excerpt($article['content']); ?></p>
                                                            <div class="pbmit-box-blog">
                                                                <div class="pbmit-blogbox-readmore pbmit-vc_btn3">
                                                                    <div class="pbmit-blogbox-footer-left">
                                                                        <a href="<?php echo $article['slug']; ?>"><?php echo $translations['read-more']; ?></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <p>No articles found for this category.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 blog-left-col">
                            <aside class="sidebar">
                                <aside class="widget widget-search">
                                    <form class="search-form">
                                        <input type="search" class="search-field" placeholder="Search …" value="">
                                        <a href="#"><i class="pbmit-base-icon-search"></i></a>
                                    </form>
                                </aside>
                                <aside class="widget widget-categories">
                                    <h3 class="widget-title"><?php echo $translations['categories']; ?></h3>
                                    <ul>
                                        <?php foreach ($categories as $category) : ?>
                                            <li><a href="category.php?id=<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </aside>
                                <aside class="widget widget-recent-post">
                                    <h2 class="widget-title"><?php echo $translations['related-posts']; ?></h2>
                                    <ul class="recent-post-list">
                                        <?php foreach ($articles as $article) : ?>
                                            <li class="recent-post-list-li">
                                                <a class="recent-post-thum" href="<?php echo $article['slug']; ?>">
                                                    <img src="<?php echo $article['featured_image']; ?>" class="img-fluid" alt="">
                                                </a>
                                                <span class="post-date"><?php echo date('F j, Y', strtotime($article['published_date'])); ?></span>
                                                <a href="<?php echo $article['slug']; ?>"><?php echo htmlspecialchars($article['title']); ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </aside>
                            </aside>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Blog Classic  End -->
        </div>
        <!-- Page Content End -->

        <!-- Include footer -->
        <?php include 'footer.php'; ?>

        <!-- Search Box Start Here -->
        <div class="pbmit-search-overlay">
            <div class="pbmit-icon-close"></div>
            <div class="pbmit-search-outer">
                <div class="pbmit-search-logo">
                    <img src="images/logo.png" alt="">
                </div>
                <form class="pbmit-site-searchform">
                    <input type="search" class="form-control field searchform-s" name="s" placeholder="Type Word Then Press Enter">
                    <button type="submit">
                        <i class="pbmit-base-icon-search"></i>
                    </button>
                </form>
            </div>
        </div>
        <!-- Search Box End Here -->

    </div>
    <!-- Page Wrapper End -->

    <!-- JS ============================================ -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.appear.js"></script>
    <script src="js/numinate.min.js"></script>
    <script src="js/swiper.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/circle-progress.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>