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

// Fetch articles with the tag
$sql = "SELECT b.id, b.slug, b.title, b.content, b.author, b.featured_image, b.published_date 
        FROM blog_posts b 
        JOIN blog_post_tags bpt ON b.id = bpt.blog_post_id 
        JOIN tags t ON bpt.tag_id = t.id 
        WHERE t.name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tag_name);
$stmt->execute();
$stmt->bind_result($id, $slug, $title, $content, $author, $featured_image, $published_date);
$articles = [];
while ($stmt->fetch()) {
    $articles[] = ['id' => $id, 'slug' => $slug, 'title' => $title, 'content' => $content, 'author' => $author, 'featured_image' => $featured_image, 'published_date' => $published_date];
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
</head>

<body>
    <!-- Page Wrapper -->
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
                                                <a href="index.html">
                                                    <img class="logo-img" src="images/homepage-1/logo.png" alt="Gimox">
                                                    <img class="sticky-logo" src="images/homepage-1/logo-dark.png" alt="Gimox">
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
                                                                <a href="index.html">Home</a>
                                                                <ul>
                                                                    <li><a href="index.html">Homepage 1</a></li>
                                                                    <li><a href="homepage-2.html">Homepage 2</a></li>
                                                                    <li><a href="homepage-3.html">Homepage 3</a></li>
                                                                </ul>
                                                            </li>
                                                            <li class="dropdown">
                                                                <a href="#">Pages</a>
                                                                <ul>
                                                                    <li><a href="about-us.html">About us</a></li>
                                                                    <li><a href="our-services.html">Our Services</a></li>
                                                                    <li><a href="our-pricing.html">Our Pricing</a></li>
                                                                    <li><a href="our-trainers.html">Our Trainers</a></li>
                                                                    <li><a href="trainer-details.html">Trainer Details</a></li>
                                                                    <li><a href="faq.html">Faq</a></li>
                                                                </ul>
                                                            </li>
                                                            <li class="dropdown">
                                                                <a href="#">Portfolio</a>
                                                                <ul>
                                                                    <li><a href="portfolio-style-1.html">Portfolio Style 1</a></li>
                                                                    <li><a href="portfolio-style-2.html">Portfolio Style 2</a></li>
                                                                    <li><a href="portfolio-single.html">Portfolio Single</a></li>
                                                                </ul>
                                                            </li>
                                                            <li class="dropdown">
                                                                <a href="classes.html">Classes</a>
                                                                <ul>
                                                                    <li><a href="classes-details.html">Classes Details</a></li>
                                                                </ul>
                                                            </li>
                                                            <li class="dropdown active">
                                                                <a href="#">Blog</a>
                                                                <ul>
                                                                    <li class="active"><a href="blog-large-image.html">Blog Large Image</a></li>
                                                                    <li><a href="blog-grid-view.html">Blog Grid View</a></li>
                                                                    <li><a href="blog-single-view.html">Blog Single View</a></li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="contacts.html">Contacts</a></li>
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
                                                    <a class="tooltip-top" target="_blank" href="#">
                                                        <i class="pbmit-base-icon-facebook"></i>
                                                    </a>
                                                </li>
                                                <li class="pbmit-social-twitter">
                                                    <a class="tooltip-top" target="_blank" href="#">
                                                        <i class="pbmit-base-icon-twitter"></i>
                                                    </a>
                                                </li>
                                                <li class="pbmit-social-flickr">
                                                    <a class="tooltip-top" target="_blank" href="#">
                                                        <i class="pbmit-base-icon-flickr"></i>
                                                    </a>
                                                </li>
                                                <li class="pbmit-social-linkedin">
                                                    <a class="tooltip-top" target="_blank" href="">
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
                                            <a href="contacts.html"><span>Get a Free Pass</span></a>
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
                                                        <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
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
                                    <h2 class="widget-title">Recent posts</h2>
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

        <!-- footer -->
        <footer class="footer site-footer">
            <div class="pbmit-footer-widget-area">
                <div class="container">
                    <div class="row">
                        <div class="footer-widget-col-1">
                            <div class="widget">
                                <div class="textwidget widget-text">
                                    <img class="pbmit-footerlogo" src="images/footer-logo.png" alt="">
                                    <p>There are many variations of passages of lorem ipsum available, but the majority have suffered alteration in some form by injected.</p>
                                </div>
                            </div>
                        </div>
                        <div class="footer-widget-col-2">
                            <div class="widget">
                            <h3 class="widget-title">Information</h3>
                                <div class="textwidget">
                                    <ul>
                                        <li><a href="about-us.html">About Us</a></li>
                                        <li><a href="portfolio-style-1.html">Clients</a></li>
                                        <li><a href="contacts.html">Privacy policy</a></li>
                                        <li><a href="contacts.html">Customer</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="footer-widget-col-3">
                            <div class="widget">
                                <h2 class="widget-title">Our Services</h2>
                                <div class="textwidget">
                                    <ul>
                                        <li><a href="classes-details.html">Psycho Training</a></li>
                                        <li><a href="classes-details.html">Self Defense</a></li>
                                        <li><a href="classes-details.html">Fitness For Man</a></li>
                                        <li><a href="classes-details.html">Strength Training</a></li>
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
                                                <a class="tooltip-top" target="_blank" href="#" data-tooltip="Facebook" rel="noopener">
                                                    <i class="pbmit-base-icon-facebook"></i>
                                                </a>
                                            </li>
                                            <li class="pbmit-social-twitter">
                                                <a class="tooltip-top" target="_blank" href="#" data-tooltip="Twitter" rel="noopener">
                                                    <i class="pbmit-base-icon-twitter"></i>
                                                </a>
                                            </li>
                                            <li class="pbmit-social-flickr">
                                                <a class="tooltip-top" target="_blank" href="#" data-tooltip="Flickr" rel="noopener">
                                                    <i class="pbmit-base-icon-flickr"></i>
                                                </a>
                                            </li>
                                            <li class="pbmit-social-linkedin">
                                                <a class="tooltip-top" target="_blank" href="" data-tooltip="LinkedIn" rel="noopener">
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
