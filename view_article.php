<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

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
            <div class="pbmit-header-overlay">
                <div class="site-header-menu">
                    <div class="container-fluid p-0">
                        <div class="row g-0">
                            <div class="col-md-12">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="site-branding">
                                            <span class="site-title">
                                                <a href="../index.html">
                                                    <img class="logo-img" src="../images/homepage-1/logo.png" alt="Gimox">
                                                    <img class="sticky-logo" src="../images/homepage-1/logo-dark.png" alt="Gimox">
                                                </a>
                                            </span>
                                        </div>
                                        <div class="site-navigation">
                                            <nav class="main-menu navbar-expand-xl navbar-light">
                                                <div class="navbar-header">
                                                    <!-- Toggle Button --> 
                                                    <button class="navbar-toggler" type="button">
                                                        <i class="pbmit-gimox-icon-bars"></i>
                                                    </button>
                                                </div>
                                                <div class="pbmit-mobile-menu-bg"></div>
                                                <div class="collapse navbar-collapse clearfix show" id="pbmit-menu">
                                                    <div class="pbmit-menu-wrap">
                                                        <ul class="navigation clearfix">
                                                            <li class="dropdown">
                                                                <a href="../index.html">Home</a>
                                                                <ul>
                                                                    <li><a href="../index.html">Homepage 1</a></li>
                                                                    <li><a href="../homepage-2.html">Homepage 2</a></li>
                                                                    <li><a href="../homepage-3.html">Homepage 3</a></li>
                                                                </ul>
                                                            </li>
                                                            <li class="dropdown">
                                                                <a href="#">Pages</a>
                                                                <ul>
                                                                    <li><a href="../about-us.html">About us</a></li>
                                                                    <li><a href="../our-services.html">Our Services</a></li>
                                                                    <li><a href="../our-pricing.html">Our Pricing</a></li>
                                                                    <li><a href="../our-trainers.html">Our Trainers</a></li>
                                                                    <li><a href="../trainer-details.html">Trainer Details</a></li>
                                                                    <li><a href="../faq.html">Faq</a></li>
                                                                </ul>
                                                            </li>
                                                            <li class="dropdown">
                                                                <a href="#">Portfolio</a>
                                                                <ul>
                                                                    <li><a href="../portfolio-style-1.html">Portfolio Style 1</a></li>
                                                                    <li><a href="../portfolio-style-2.html">Portfolio Style 2</a></li>
                                                                    <li><a href="../portfolio-single.html">Portfolio Single</a></li>
                                                                </ul>
                                                            </li>
                                                            <li class="dropdown">
                                                                <a href="../classes.html">Classes</a>
                                                                <ul>
                                                                    <li><a href="../classes-details.html">Classes Details</a></li>
                                                                </ul>
                                                            </li>
                                                            <li class="dropdown active">
                                                                <a href="#">Blog</a>
                                                                <ul>
                                                                    <li class="active"><a href="../blog-large-image.html">Blog Large Image</a></li>
                                                                    <li><a href="../blog-grid-view.html">Blog Grid View</a></li>
                                                                    <li><a href="../blog-single-view.html">Blog Single View</a></li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="../contacts.html">Contacts</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </nav>
                                        </div>
                                    </div>
                                    <div class="pbmit-right-side">
                                        <div class="pbmit-social-links-wrapper">
                                            <ul class="social-icons">
                                                <li class="pbmit-social-facebook">
                                                    <a class=" tooltip-top" target="_blank" href="#">
                                                        <i class="pbmit-base-icon-facebook"></i>
                                                    </a>
                                                </li>
                                                <li class="pbmit-social-twitter">
                                                    <a class=" tooltip-top" target="_blank" href="#">
                                                        <i class="pbmit-base-icon-twitter"></i>
                                                    </a>
                                                </li>
                                                <li class="pbmit-social-flickr">
                                                    <a class=" tooltip-top" target="_blank" href="#">
                                                        <i class="pbmit-base-icon-flickr"></i>
                                                    </a>
                                                </li>
                                                <li class="pbmit-social-linkedin">
                                                    <a class=" tooltip-top" target="_blank" href="">
                                                        <i class="pbmit-base-icon-linkedin"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="pbmit-header-search-btn">
                                            <a href="#">
                                                <i class="pbmit-base-icon-search-2"></i>
                                            </a>
                                        </div>
                                        <div class="pbmit-header-button">
                                            <a href="../contacts.html"><span>Get a Free Pass</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                        <div class="pbmit-breadcrumb">
                            <div class="pbmit-breadcrumb-inner">
                                <span><a title="" href="#" class="home"><span>Gimox</span></a></span>
                                <span class="sep">-</span>
                                <span><a href="#" class="post-root post post-post current-item"><span><?php echo htmlspecialchars($category_name); ?></span></a></span>
                                <span class="sep">-</span>
                                <span><span class="post-root post post-post current-item"><?php echo htmlspecialchars($title); ?></span></span>
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
                                                    <?php if ($featured_image): ?>
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
                                                            <span class="screen-reader-text pbmit-hide">Categories </span>
                                                            <a href="#" rel="category tag"><?php echo htmlspecialchars($category_name); ?></a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <h2 class="pbmit-post-title"><?php echo htmlspecialchars($title); ?></h2>
                                            </div>
                                            <div class="pbmit-entry-content">
                                                <p><?php echo nl2br(htmlspecialchars($content)); ?></p>
                                            </div>
                                        </div>
                                        <div class="pbmit-blog-meta pbmit-blog-meta-bottom">
                                            <div class="pbmit-blog-meta-bottom-left">
                                                <span class="pbmit-meta pbmit-meta-tags">
                                                    <?php foreach ($tags as $tag): ?>
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
                                  <h3 class="widget-title">Categories</h3>
                                  <ul>
                                      <?php foreach ($categories as $category): ?>
                                      <li><a href="../category.php?id=<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></a></li>
                                      <?php endforeach; ?>
                                  </ul>
                                </aside>
                                <aside class="widget widget-recent-post">
                                    <h2 class="widget-title">Recent posts</h2>
                                    <ul class="recent-post-list">
                                        <?php foreach ($recent_articles as $article): ?>
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
                                    <h3 class="widget-title">Tags</h3>
                                    <div class="tagcloud">
                                        <?php foreach ($tags as $tag): ?>
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

        <!-- footer -->
        <footer class="footer site-footer">
            <div class="pbmit-footer-widget-area">
                <div class="container">
                    <div class="row">
                        <div class="footer-widget-col-1">
                            <div class="widget">
                                <div class="textwidget widget-text">
                                    <img class="pbmit-footerlogo" src="../images/footer-logo.png" alt="">
                                    <p>There are many variations of passages of lorem ipsum available, but the majority have suffered alteration in some form by injected.</p>
                                </div>
                            </div>
                        </div>
                        <div class="footer-widget-col-2">
                            <div class="widget">
                            <h3 class="widget-title">Information</h3>
                                <div class="textwidget">
                                    <ul>
                                        <li><a href="../about-us.html">About Us</a></li>
                                        <li><a href="../portfolio-style-1.html">Clients</a></li>
                                        <li><a href="../contacts.html">Privacy policy</a></li>
                                        <li><a href="../contacts.html">Customer</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="footer-widget-col-3">
                            <div class="widget">
                                <h2 class="widget-title">Our Services</h2>
                                <div class="textwidget">
                                    <ul>
                                        <li><a href="../classes-details.html">Psycho Training</a></li>
                                        <li><a href="../classes-details.html">Self Defense</a></li>
                                        <li><a href="../classes-details.html">Fitness For Man</a></li>
                                        <li><a href="../classes-details.html">Strength Training</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="footer-widget-col-4">
                            <div class="widget">
                                <h2 class="widget-title">Subscribe us</h2>
                                <div class="textwidget">
                                    <form>
                                        <input type="email" name="EMAIL" placeholder="Email address" required="">
                                        <button type="submit">Subscribe</button>
                                    </form>                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pbmit-footer-bottom">
                <div class="container">
                    <div class="pbmit-footer-text-inner">
                        <div class="row">
                            <div class="col-md-6 col-lg-3">
                                <div class="widget-as-link">
                                    <p>Copyright © 2023 All Rights<br>Reserved.</p>
                                </div>
                            </div>    
                            <div class="col-md-6 col-lg-3">
                                <div class="widget-as-link">
                                    <ul class="pbmit_contact_widget_wrapper">
                                        <li>(+01) 123 456 7890</li>
                                        <li><a href="mailto:info@example.com">info@example.com</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="widget-as-link">
                                    <ul class="pbmit_contact_widget_wrapper">
                                        <li>51 Somestreet Cambridge,<br>CB4 3AA, United Kingdom</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="widget-as-link">
                                    <div class="pbmit-social-links-wrapper">
                                        <ul class="social-icons">
                                            <li class="pbmit-social-facebook">
                                                <a class=" tooltip-top" target="_blank" href="#" data-tooltip="Facebook" rel="noopener">
                                                    <i class="pbmit-base-icon-facebook"></i>
                                                </a>
                                            </li>
                                            <li class="pbmit-social-twitter">
                                                <a class=" tooltip-top" target="_blank" href="#" data-tooltip="Twitter" rel="noopener">
                                                    <i class="pbmit-base-icon-twitter"></i>
                                                </a>
                                            </li>
                                            <li class="pbmit-social-flickr">
                                                <a class=" tooltip-top" target="_blank" href="#" data-tooltip="Flickr" rel="noopener">
                                                    <i class="pbmit-base-icon-flickr"></i>
                                                </a>
                                            </li>
                                            <li class="pbmit-social-linkedin">
                                                <a class=" tooltip-top" target="_blank" href="" data-tooltip="LinkedIn" rel="noopener">
                                                    <i class="pbmit-base-icon-linkedin"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>        
                        </div>
                    </div>    
                </div>
            </div>    
        </footer>
        <!-- footer End -->

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
