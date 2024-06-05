<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'config.php';

$tag_name = $_GET['name'];

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch tag details including the featured image
$sql = "SELECT featured_image FROM tags WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tag_name);
$stmt->execute();
$stmt->bind_result($featured_image);
$stmt->fetch();
$stmt->close();

// Fetch articles with the tag
$sql = "SELECT b.id, b.slug, b.title, b.content, b.author, b.featured_image, b.published_date 
        FROM blog_posts b 
        JOIN blog_post_tags bpt ON b.id = bpt.blog_post_id 
        JOIN tags t ON bpt.tag_id = t.id 
        WHERE t.name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tag_name);
$stmt->execute();
$stmt->bind_result($id, $slug, $title, $content, $author, $featured_image_article, $published_date);
$articles = [];
while ($stmt->fetch()) {
    $articles[] = ['id' => $id, 'slug' => $slug, 'title' => $title, 'content' => $content, 'author' => $author, 'featured_image' => $featured_image_article, 'published_date' => $published_date];
}
$stmt->close();

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

// Function to create excerpt
function create_excerpt($content, $length = 250) {
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
    <title>Tag: <?php echo htmlspecialchars($tag_name); ?> – Gimox HTML Template</title>
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
            background-image: url('<?php echo htmlspecialchars($featured_image); ?>');
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
        <div class="pbmit-title-bar-wrapper">
            <div class="container">
                <div class="pbmit-title-bar-content">
                    <div class="pbmit-title-bar-content-inner">
                        <div class="pbmit-tbar">
                            <div class="pbmit-tbar-inner container">
                                <h1 class="pbmit-tbar-title">Tag: <?php echo htmlspecialchars($tag_name); ?></h1>
                            </div>
                        </div>
                        <div class="pbmit-breadcrumb">
                            <div class="pbmit-breadcrumb-inner">
                                <span><a title="" href="#" class="home"><span>Gimox</span></a></span>
                                <span class="sep">-</span>
                                <span><span class="post-root post post-post current-item"><?php echo htmlspecialchars($tag_name); ?></span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Title Bar End-->

        <!--Page Content -->
        <div class="page-content">
            <!-- Blog Classic  -->
            <section class="overflow-hidden">
                <div class="container">
                    <div class="row blog-section">
                        <div class="col-lg-9 blog-right-col">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php foreach ($articles as $article): ?>
                                        <article class="post blog-classic">   
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <a href="article/<?php echo $article['slug']; ?>">
                                                        <img src="<?php echo htmlspecialchars($article['featured_image']); ?>" class="img-fluid w-100" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="pbmit-blog-classic-inner">
                                                <div class="pbmit-blog-meta-wrapper">
                                                    <h2 class="pbmit-post-title">
                                                        <a href="article/<?php echo $article['slug']; ?>"><?php echo htmlspecialchars($article['title']); ?></a> 
                                                    </h2>
                                                    <div class="pbmit-classic-meta-date">
                                                        <a href="article/<?php echo $article['slug']; ?>">
                                                            <span><?php echo date('F j, Y', strtotime($article['published_date'])); ?></span>
                                                        </a>
                                                    </div>
                                                    <div class="pbmit-blog-meta pbmit-blog-meta-top">
                                                        <div class="pbmit-entry-meta-blogclassic">
                                                            <span class="pbmit-meta-line byline">  
                                                                <span class="author vcard">
                                                                    <span class="screen-reader-text pbmit-hide">Author </span>By 
                                                                    <a class="url fn n" href="article/<?php echo $article['slug']; ?>"><?php echo htmlspecialchars($article['author']); ?></a>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="pbmit-entry-content">
                                                        <p><?php echo create_excerpt($article['content']); ?></p>
                                                        <div class="pbmit-box-blog">
                                                            <div class="pbmit-blogbox-readmore pbmit-vc_btn3">
                                                                <div class="pbmit-blogbox-footer-left">
                                                                    <a href="article/<?php echo $article['slug']; ?>">Read More</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    <?php endforeach; ?>
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
                                    <h3 class="widget-title">Categories</h3>
                                    <ul>
                                        <?php foreach ($categories as $category): ?>
                                            <li><a href="category.php?id=<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </aside>
                                <aside class="widget widget-recent-post">
                                    <h2 class="widget-title">Related posts</h2>
                                    <ul class="recent-post-list">
                                        <?php foreach ($articles as $article): ?>
                                            <li class="recent-post-list-li"> 
                                                <a class="recent-post-thum" href="article/<?php echo $article['slug']; ?>">
                                                    <img src="<?php echo $article['featured_image']; ?>" class="img-fluid" alt="">
                                                </a>
                                                <span class="post-date"><?php echo date('F j, Y', strtotime($article['published_date'])); ?></span>
                                                <a href="article/<?php echo $article['slug']; ?>"><?php echo htmlspecialchars($article['title']); ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </aside>
                                <aside class="widget widget-tag-cloud">
                                    <h3 class="widget-title">Tags</h3>
                                    <div class="tagcloud">
                                        <?php foreach ($all_tags as $tag): ?>
                                            <a href="tag.php?name=<?php echo urlencode($tag); ?>" class="tag-cloud-link"><?php echo htmlspecialchars($tag); ?></a>
                                        <?php endforeach; ?>
                                    </div>
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
