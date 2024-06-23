<?php
require 'config.php'; // Include the config file at the very beginning

$lang = 'sr'; // Default language
if (isset($_COOKIE['lang'])) {
	$lang = $_COOKIE['lang'];
}
?>
<!doctype html>
<html lang="sr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?php echo $translations['site-title']; ?> - Gacik Aleksandar</title>
	<meta name="robots" content="noindex, follow">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
	<!-- CSS -->
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Fontawesome -->
	<link rel="stylesheet" href="css/fontawesome.css">
	<!-- Flaticon -->
	<link rel="stylesheet" href="css/flaticon.css">
	<!-- optico Icons -->
	<link rel="stylesheet" href="css/pbminfotech-base-icons.css">
	<!-- Swiper -->
	<link rel="stylesheet" href="css/swiper.min.css">
	<!-- Magnific -->
	<link rel="stylesheet" href="css/magnific-popup.css">
	<!-- Themify Icons -->
	<link rel="stylesheet" href="css/themify-icons.css">
	<!-- Shortcode CSS -->
	<link rel="stylesheet" href="css/shortcode.css">
	<!-- Base CSS -->
	<link rel="stylesheet" href="css/base.css">
	<!-- Style CSS -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Responsive CSS -->
	<link rel="stylesheet" href="css/responsive.css">
	<!-- REVOLUTION STYLE SHEETS -->
	<link rel="stylesheet" type="text/css" href="revolution/rs6.css">
</head>

<body>
	<!-- page wrapper -->
	<div class="page-wrapper">
		<!-- Header Main Area -->
		<header class="site-header header-style-1">
			<!-- Include Header -->
			<?php include 'header.php'; ?>
			<!-- Include Slider -->
			<?php include 'slider.php'; ?>
		</header>
		<!-- Header Main Area End Here -->
		<!-- Page Content -->
		<div class="page-content">
			<!-- Include Programs -->
			<?php include 'programs.php'; ?>
			<!-- Include About -->
			<?php include 'about.php'; ?>
			<!-- Include Sevices -->
			<?php include 'services.php'; ?>
			<!-- Include Pricing -->
			<?php include 'pricing.php'; ?>
			<!-- Include Testimonials -->
			<?php include 'testimonials.php'; ?>
			<!-- Include Latest Blog Posts -->
			<?php include 'blog-posts.php'; ?>
		</div>
		<!-- Page Content End -->
		<!-- Include Footer -->
		<?php include 'footer.php'; ?>
	</div>
	<!-- page wrapper End -->
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
	<!-- JS -->
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
	<!-- Revolution JS -->
	<script src="revolution/rslider.js"></script>
	<script src="revolution/rbtools.min.js"></script>
	<script src="revolution/rs6.min.js"></script>
</body>

</html>