<?php
session_start();

require 'config.php';

// Retrieve language from cookie
$lang = 'sr'; // Default language
if (isset($_COOKIE['lang'])) {
	$lang = $_COOKIE['lang'];
}

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Fetch all blog posts for the selected language
$sql = "SELECT id, title, content, featured_image, published_date, slug FROM blog_posts WHERE language = ? ORDER BY published_date DESC";
$stmt = $conn->prepare($sql);
if (!$stmt) {
	die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("s", $lang);
$stmt->execute();
$result = $stmt->get_result();

$articles = [];
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$articles[] = $row;
	}
}
$stmt->close();
$conn->close();
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Blog - Gacik Aleksandar</title>
	<meta name="robots" content="noindex, follow">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

	<!-- CSS ============================================ -->

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
			<div class="overlay"></div>
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

			<!-- Blog Classic -->
			<section class="section-md">
				<div class="container">
					<?php if (empty($articles)) : ?>
						<div class="alert alert-warning" role="alert">
							No articles found for the selected language.
						</div>
					<?php else : ?>
						<div class="row">
							<?php foreach ($articles as $article) : ?>
								<div class="col-md-6 col-lg-4">
									<article class="pbmit-box-blog pbmit-blogbox-style-1">
										<div class="post-item">
											<div class="pbmit-blog-image-with-meta" style="background-image: url('./uploads/<?php echo htmlspecialchars($article['featured_image']); ?>')">
											</div>
											<div class="pbmit-box-content">
												<div class="pbmit-entry-meta-wrapper">
													<div class="entry-meta pbmit-entry-meta pbmit-entry-meta-blogclassic">
														<span class="pbmit-meta-line posted-on">
															<span class="screen-reader-text">Posted on </span>
															<a href="<?php echo urlencode($article['slug']); ?>" rel="bookmark">
																<time class="entry-date published updated" datetime="<?php echo htmlspecialchars($article['published_date']); ?>"><?php echo date('F j, Y', strtotime($article['published_date'])); ?></time>
															</a>
														</span>
													</div>
												</div>
												<div class="pbmit-box-title">
													<h2 class="pbmit-title">
														<a href="<?php echo urlencode($article['slug']); ?>"><?php echo htmlspecialchars($article['title']); ?></a>
													</h2>
												</div>
												<div class="pbmit-blogbox-readmore pbmit-vc_btn3">
													<div class="pbmit-blogbox-footer-left">
														<a href="<?php echo urlencode($article['slug']); ?>"><?php echo $translations['read-more']; ?></a>
													</div>
												</div>
											</div>
										</div>
									</article>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
			<!-- Blog Grid End -->

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