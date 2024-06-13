<?php
session_start();

require 'config.php';

if (!isset($_GET['slug'])) {
    die('Article slug not specified.');
}

$slug = $_GET['slug'];

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch article using slug
$sql = "SELECT title, content, author, category_id, featured_image, published_date FROM blog_posts WHERE slug = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$stmt->bind_result($title, $content, $author, $category_id, $featured_image, $published_date);
$stmt->fetch();
$stmt->close();

// Fetch category
$category_name = '';
$sql = "SELECT name FROM categories WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$stmt->bind_result($category_name);
$stmt->fetch();
$stmt->close();

// Fetch article tags
$sql = "SELECT t.name FROM tags t JOIN blog_post_tags bpt ON t.id = bpt.tag_id WHERE bpt.blog_post_id = (SELECT id FROM blog_posts WHERE slug = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$stmt->bind_result($tag_name);
$tags = [];
while ($stmt->fetch()) {
    $tags[] = $tag_name;
}
$stmt->close();

// Fetch the 3 most recent articles
$recent_sql = "SELECT slug, title, featured_image, published_date FROM blog_posts ORDER BY published_date DESC LIMIT 3";
$recent_result = $conn->query($recent_sql);
$recent_articles = [];
if ($recent_result->num_rows > 0) {
    while ($row = $recent_result->fetch_assoc()) {
        $recent_articles[] = $row;
    }
}

// Fetch all categories
$sql = "SELECT id, name FROM categories";
$result = $conn->query($sql);
$categories = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Fetch all tags
$sql = "SELECT name FROM tags";
$result = $conn->query($sql);
$all_tags = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $all_tags[] = $row['name'];
    }
}

$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo htmlspecialchars($title); ?> - Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome.css">
    <link rel="stylesheet" href="../css/flaticon.css">
    <link rel="stylesheet" href="../css/pbminfotech-base-icons.css">
    <link rel="stylesheet" href="../css/swiper.min.css">
    <link rel="stylesheet" href="../css/magnific-popup.css">
    <link rel="stylesheet" href="../css/shortcode.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
</head>

<body>
    <div class="page-wrapper">
        <!-- Header Main Area -->
        <header class="site-header header-style-1">
            <!-- Include Header -->
            <?php include 'header.php'; ?>
        </header>
        <!-- Header Main Area End Here -->

        <!-- Title Bar -->
        <div class="pbmit-title-bar-wrapper">
            <div class="container">
                <div class="pbmit-title-bar-content">
                    <div class="pbmit-title-bar-content-inner">
                        <div class="pbmit-tbar">
                            <div class="pbmit-tbar-inner container">
                                <h1 class="pbmit-tbar-title">Blog</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Title Bar End -->

        <!-- Page Content -->
        <div class="page-content">

            <!-- Blog Details -->
            <section class="overflow-hidden">
                <div class="container">
                    <div class="row blog-section">
                        <div class="col-lg-9 blog-right-col">
                            <div class="row">
                                <div class="col-md-12">
                                    <article class="post blog-details">
                                        <div class="blog-classic">
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <?php if ($featured_image) : ?>
                                                        <img src="../<?php echo htmlspecialchars($featured_image); ?>" class="img-fluid w-100" alt="Featured Image" style="height: auto;">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="pbmit-blog-classic-inner">
                                                <div class="pbmit-blog-meta pbmit-blog-meta-top">
                                                    <div class="pbmit-entry-meta-blogclassic">
                                                        <span class="pbmit-meta-line byline">
                                                            <span class="author vcard">
                                                                <span class="screen-reader-text pbmit-hide">Author </span>By
                                                                <a class="url fn n" href="#"><?php echo htmlspecialchars($author); ?></a>
                                                            </span>
                                                        </span>
                                                        <span class="pbmit-meta-line posted-on">
                                                            <span class="screen-reader-text">Posted on </span>
                                                            <a href="#" rel="bookmark">
                                                                <time class="entry-date published updated" datetime="<?php echo htmlspecialchars($published_date); ?>"><?php echo htmlspecialchars($published_date); ?></time>
                                                            </a>
                                                        </span>
                                                        <span class="pbmit-meta-line cat-links">
                                                            <span class="screen-reader-text pbmit-hide"><?php echo $translations['categories']; ?> </span>
                                                            <a href="#" rel="category tag"><?php echo htmlspecialchars($category_name); ?></a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <h2 class="pbmit-post-title"><?php echo htmlspecialchars($title); ?></h2>
                                            </div>
                                            <div class="pbmit-entry-content">
                                                <p><?php echo $content; ?></p>
                                            </div>
                                        </div>
                                        <div class="pbmit-blog-meta pbmit-blog-meta-bottom">
                                            <div class="pbmit-blog-meta-bottom-left">
                                                <span class="pbmit-meta pbmit-meta-tags">
                                                    <?php foreach ($tags as $tag) : ?>
                                                        <a href="../tag.php?name=<?php echo urlencode($tag); ?>" rel="tag"><?php echo htmlspecialchars($tag); ?></a>
                                                    <?php endforeach; ?>
                                                </span>
                                            </div>
                                            <div class="pbmit-blog-meta-bottom-right">
                                                <div class="pbmit-social-share">
                                                    <ul>
                                                        <li class="pbmit-social-li pbmit-social-li-facebook">
                                                            <a class="pbmit-popup" href="#">
                                                                <i class="pbmit-base-icon-facebook"></i>
                                                            </a>
                                                        </li>
                                                        <li class="pbmit-social-li pbmit-social-li-twitter">
                                                            <a class="pbmit-popup" href="#">
                                                                <i class="pbmit-base-icon-twitter"></i>
                                                            </a>
                                                        </li>
                                                        <li class="pbmit-social-li pbmit-social-li-reddit">
                                                            <a class="pbmit-popup" href="#">
                                                                <i class="pbmit-base-icon-reddit"></i>
                                                            </a>
                                                        </li>
                                                        <li class="pbmit-social-li pbmit-social-li-digg">
                                                            <a class="pbmit-popup" href="#">
                                                                <i class="pbmit-base-icon-digg"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pbmit-author-box">
                                            <div class="pbmit-author-image">
                                                <img alt="" src="../images/img-01.png" class="img-fluid">
                                            </div>
                                            <div class="pbmit-author-content">
                                                <h2 class="author-title"><span class="author-heading">Author:</span> <?php echo htmlspecialchars($author); ?></h2>
                                                <p class="pbmit-author-bio">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                                                    <a href="#">View all posts by <?php echo htmlspecialchars($author); ?></a>
                                                </p>
                                            </div>
                                        </div>
                                    </article>
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
                                            <li><a href="../category.php?id=<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </aside>
                                <aside class="widget widget-recent-post">
                                    <h2 class="widget-title"><?php echo $translations['recent-posts']; ?></h2>
                                    <ul class="recent-post-list">
                                        <?php foreach ($recent_articles as $article) : ?>
                                            <li class="recent-post-list-li">
                                                <a class="recent-post-thum" href="../article/<?php echo $article['slug']; ?>">
                                                    <img src="../<?php echo $article['featured_image']; ?>" class="img-fluid" style="width: 90px; height: 90px;" alt="Thumbnail">
                                                </a>
                                                <span class="post-date"><?php echo date('F j, Y', strtotime($article['published_date'])); ?></span>
                                                <a href="../article/<?php echo $article['slug']; ?>"><?php echo htmlspecialchars($article['title']); ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </aside>
                                <aside class="widget widget-tag-cloud">
                                    <h3 class="widget-title"><?php echo $translations['tags']; ?></h3>
                                    <div class="tagcloud">
                                        <?php foreach ($all_tags as $tag) : ?>
                                            <a href="../tag.php?name=<?php echo urlencode($tag); ?>" class="tag-cloud-link"><?php echo htmlspecialchars($tag); ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </aside>
                            </aside>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Blog Details End -->

        </div>
        <!-- Page Content End -->

        <!-- Include footer -->
        <?php include 'footer.php'; ?>

    </div>
    <!-- Page Wrapper End -->

    <!-- Search Box Start Here -->
    <div class="pbmit-search-overlay">
        <div class="pbmit-icon-close"></div>
        <div class="pbmit-search-outer">
            <div class="pbmit-search-logo">
                <img src="../images/logo.png" alt="">
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

    <!-- JS ============================================ -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.waypoints.min.js"></script>
    <script src="../js/jquery.appear.js"></script>
    <script src="../js/numinate.min.js"></script>
    <script src="../js/swiper.min.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/circle-progress.js"></script>
    <script src="../js/scripts.js"></script>
</body>

</html>