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

// Fetch all blog posts
$sql = "SELECT id, title, content, featured_image, author, published_date FROM blog_posts ORDER BY published_date DESC";
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
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Blog Grid View – Gimox HTML Template</title>
    <meta name="robots" content="noindex, follow">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

    <!-- CSS
        ============================================ -->

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- Fontawesome -->
      <link rel="stylesheet" href="css/fontawesome.css">
      <!-- Flaticon -->
      <link rel="stylesheet" href="css/flaticon.css">
      <!-- Base Icons -->
      <link rel="stylesheet" href="css/pbminfotech-base-icons.css"> 
      <!-- Swiper -->
      <link rel="stylesheet" href="css/swiper.min.css">
      <!-- Magnific -->
      <link rel="stylesheet" href="css/magnific-popup.css"> 
      <!-- Shortcode CSS -->
      <link rel="stylesheet" href="css/shortcode.css">
      <!-- Base CSS -->
      <link rel="stylesheet" href="css/base.css">
      <!-- Style CSS -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="css/responsive.css">
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
								<h1 class="pbmit-tbar-title">Blog</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Title Bar End-->

		<!-- Page Content -->
		<div class="page-content">   

			<!-- Blog Grid -->
			<section class="section-md">
                <div class="container">
                    <div class="row">
                        <?php foreach ($articles as $article): ?>
                        <div class="col-md-6 col-lg-4">
                            <article class="pbmit-box-blog pbmit-blogbox-style-1">
                                <div class="post-item">
                                    <div class="pbmit-blog-image-with-meta">
                                        <div class="pbmit-featured-wrapper pbmit-post-featured-wrapper">
                                            <img src="<?php echo htmlspecialchars($article['featured_image']); ?>" class="img-fluid" alt="Featured Image">
                                        </div>
                                    </div>
                                    <div class="pbmit-box-content">
                                        <div class="pbmit-entry-meta-wrapper">
                                            <div class="entry-meta pbmit-entry-meta pbmit-entry-meta-blogclassic">
                                                <span class="pbmit-meta-line byline">
                                                    <span class="author vcard">
                                                        <span class="screen-reader-text pbmit-hide">Author </span>By
                                                        <a class="url fn n" href="blog-large-image.html"><?php echo htmlspecialchars($article['author']); ?></a>
                                                    </span>
                                                </span>
                                                <span class="pbmit-meta-line posted-on">
                                                    <span class="screen-reader-text">Posted on </span>
                                                    <a href="view_article.php?id=<?php echo $article['id']; ?>" rel="bookmark">
                                                        <time class="entry-date published updated" datetime="<?php echo htmlspecialchars($article['published_date']); ?>"><?php echo date('F j, Y', strtotime($article['published_date'])); ?></time>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="pbmit-box-title">
                                            <h2 class="pbmit-title">
                                                <a href="view_article.php?id=<?php echo $article['id']; ?>"><?php echo htmlspecialchars($article['title']); ?></a>
                                            </h2>
                                        </div>
                                        <div class="pbmit-blogbox-readmore pbmit-vc_btn3">
                                            <div class="pbmit-blogbox-footer-left">
                                                <a href="view_article.php?id=<?php echo $article['id']; ?>">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <!-- Blog Grid End -->

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

     <!-- JS
         ============================================ -->
      <!-- jQuery JS -->
      <script src="js/jquery.min.js"></script>
      <!-- Popper JS -->
      <script src="js/popper.min.js"></script>
      <!-- Bootstrap JS -->
      <script src="js/bootstrap.min.js"></script> 
      <!-- jquery Waypoints JS -->
      <script src="js/jquery.waypoints.min.js"></script>
      <!-- jquery Appear JS -->
      <script src="js/jquery.appear.js"></script>
      <!-- Numinate JS -->
      <script src="js/numinate.min.js"></script>
      <!-- Swiper JS -->
      <script src="js/swiper.min.js"></script>
      <!-- Magnific JS -->
      <script src="js/jquery.magnific-popup.min.js"></script>
      <!-- Circle Progress JS -->
      <script src="js/circle-progress.js"></script>  
      <!-- Scripts JS -->
      <script src="js/scripts.js"></script>       

</body>
</html>