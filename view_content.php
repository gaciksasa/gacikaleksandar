<?php
session_start();

require 'config.php';

if (!isset($_GET['slug'])) {
  die('Content slug not specified.');
}

$slug = $_GET['slug'];

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch content using slug
$sql = "
    (SELECT 'article' AS content_type, title, content, category_id, featured_image, published_date, language FROM blog_posts WHERE slug = ?)
    UNION
    (SELECT 'page' AS content_type, title, content, NULL AS category_id, header_image AS featured_image, NULL AS published_date, language FROM pages WHERE slug = ?)
";
$stmt = $conn->prepare($sql);
if (!$stmt) {
  die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("ss", $slug, $slug);
$stmt->execute();
$stmt->bind_result($content_type, $title, $content, $category_id, $featured_image, $published_date, $content_language);
$stmt->fetch();
$stmt->close();

if (!$content_language) {
  die('Content not found.');
}

// Check and set language cookie
$lang = 'sr'; // Default language
if (isset($_COOKIE['lang'])) {
  $lang = $_COOKIE['lang'];
}
if ($lang !== $content_language) {
  setcookie('lang', $content_language, time() + (86400 * 30), '/');
  header("Location: {$_SERVER['REQUEST_URI']}");
  exit();
}

$category_name = '';
if ($content_type == 'article' && $category_id !== NULL) {
  // Fetch category
  $sql = "SELECT name FROM categories WHERE id = ? AND language = ?";
  $stmt = $conn->prepare($sql);
  if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
  }
  $stmt->bind_param("is", $category_id, $lang);
  $stmt->execute();
  $stmt->bind_result($category_name);
  $stmt->fetch();
  $stmt->close();
}

// Fetch the 3 most recent articles
$recent_sql = "SELECT slug, title, featured_image, published_date FROM blog_posts WHERE language = ? ORDER BY published_date DESC LIMIT 3";
$stmt = $conn->prepare($recent_sql);
if (!$stmt) {
  die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("s", $lang);
$stmt->execute();
$stmt->bind_result($recent_slug, $recent_title, $recent_featured_image, $recent_published_date);
$recent_articles = [];
while ($stmt->fetch()) {
  $recent_articles[] = [
    'slug' => $recent_slug,
    'title' => $recent_title,
    'featured_image' => $recent_featured_image,
    'published_date' => $recent_published_date,
  ];
}
$stmt->close();

// Fetch all categories
$sql = "SELECT id, name FROM categories WHERE language = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
  die("Error preparing statement: " . $conn->error);
}
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

$conn->close();
?>

<!doctype html>
<html lang="sr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo htmlspecialchars($title); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
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
      background-image: url('<?php echo $featured_image ? './uploads/' . htmlspecialchars($featured_image) : "./images/title-bg.jpg"; ?>');
    }
  </style>
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
      <div class="overlay"></div>
      <div class="container">
        <div class="pbmit-title-bar-content">
          <div class="pbmit-title-bar-content-inner">
            <div class="pbmit-tbar">
              <div class="pbmit-tbar-inner container">
                <h1 class="pbmit-tbar-title"><?php echo htmlspecialchars($title); ?></h1>
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
                      <?php if ($content_type == 'article' && $featured_image) : ?>
                        <div class="pbmit-featured-img-wrapper">
                          <div class="pbmit-featured-wrapper">
                            <img src="./uploads/<?php echo htmlspecialchars($featured_image); ?>" class="img-fluid w-100" alt="Featured Image" style="height: auto;">
                          </div>
                        </div>
                      <?php endif; ?>
                      <div class="pbmit-blog-classic-inner">
                        <?php if ($content_type == 'article') : ?>
                          <div class="pbmit-blog-meta pbmit-blog-meta-top">
                            <div class="pbmit-entry-meta-blogclassic">
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
                        <?php endif; ?>
                        <h2 class="pbmit-post-title"><?php echo htmlspecialchars($title); ?></h2>
                      </div>
                      <div class="pbmit-entry-content">
                        <p><?php echo $content; ?></p>
                      </div>
                    </div>
                    <?php if ($content_type == 'article') : ?>
                      <div class="pbmit-blog-meta pbmit-blog-meta-bottom">
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
                    <?php endif; ?>
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
                      <li><a href="category.php?id=<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                </aside>
                <aside class="widget widget-recent-post">
                  <h2 class="widget-title"><?php echo $translations['recent-posts']; ?></h2>
                  <ul class="recent-post-list">
                    <?php foreach ($recent_articles as $article) : ?>
                      <li class="recent-post-list-li">
                        <a class="recent-post-thum" href="/<?php echo $article['slug']; ?>">
                          <img src="./uploads/<?php echo $article['featured_image']; ?>" class="img-fluid" style="width: 90px; height: 90px;" alt="Thumbnail">
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
      <!-- Blog Details End -->

    </div>
    <!-- Page Content End -->

    <!-- Footer Area -->
    <footer class="site-footer">
      <!-- Include Footer -->
      <?php include 'footer.php'; ?>
    </footer>
    <!-- Footer Area End Here -->
  </div>
  <!-- page-wrapper End -->
  <a href="#pbmit-top-anchor" class="pbmit-scroll-to-top"><i class="pbmit-base-icon-up-open-big"></i></a>

  <!-- All Js -->
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/scripts.js"></script>
</body>

</html>