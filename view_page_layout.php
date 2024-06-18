<!doctype html>
<html lang="en">

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
</head>

<body>
  <div class="page-wrapper">
    <header class="site-header header-style-1">
      <?php include 'header.php'; ?>
    </header>
    <div class="pbmit-title-bar-wrapper">
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
    <div class="page-content">
      <section class="overflow-hidden">
        <div class="container">
          <div class="row blog-section">
            <div class="col-lg-9 blog-right-col">
              <div class="row">
                <div class="col-md-12">
                  <article class="post blog-details">
                    <div class="blog-classic">
                      <div class="pbmit-entry-content">
                        <p><?php echo $content; ?></p>
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
                          <img src="<?php echo $article['featured_image']; ?>" class="img-fluid" style="width: 90px; height: 90px;" alt="Thumbnail">
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
    </div>
    <?php include 'footer.php'; ?>
  </div>
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