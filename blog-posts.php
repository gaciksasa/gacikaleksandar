<?php

require 'config.php';

// Retrieve language from cookie
$lang = 'sr'; // Default language
if (isset($_COOKIE['lang'])) {
    $lang = $_COOKIE['lang'];
}

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debug: Verify the language value
error_log("Language: " . $lang);

// Fetch the latest 4 articles along with their categories
$sql = "SELECT b.title, b.slug, c.name AS category, b.featured_image, b.published_date 
        FROM blog_posts b 
        JOIN categories c ON b.category_id = c.id 
        WHERE b.language = ? AND c.language = ?
        ORDER BY b.published_date DESC LIMIT 4";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("ss", $lang, $lang);
$stmt->execute();
$result = $stmt->get_result();
$articles = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }
} else {
    // Debug: Log if no articles found
    error_log("No articles found for language: " . $lang);
}

// Fetch section details based on language
$section_sql = "SELECT section_title, section_subtitle, section_title_en, section_subtitle_en FROM blog_section WHERE id = 1";
$section_result = $conn->query($section_sql);
if (!$section_result) {
    die("Section query failed: " . $conn->error);
}
$section = $section_result->fetch_assoc();

// Determine which language to use for section titles
$section_title = $lang == 'en' ? $section['section_title_en'] : $section['section_title'];
$section_subtitle = $lang == 'en' ? $section['section_subtitle_en'] : $section['section_subtitle'];

$conn->close();
?>

<!-- Blog Start -->
<section class="section-lg pbmit-bg-color-light">
    <div class="container">
        <div class="pbmit-heading-subheading text-center">
            <h4 class="pbmit-subtitle"><?php echo htmlspecialchars($section_subtitle ?? 'LATEST BLOG POSTS'); ?></h4>
            <h2 class="pbmit-title"><?php echo htmlspecialchars($section_title ?? 'See what’s happening around Gym'); ?></h2>
        </div>
        <div class="row g-0">
            <?php foreach ($articles as $index => $article) : ?>
                <div class="col-md-6 col-lg-3">
                    <article class="pbmit-box-blog pbmit-blogbox-style-3">
                        <div class="post-item">
                            <?php if ($index % 2 == 0) : ?>
                                <div class="pbmit-blog-image-with-meta">
                                    <div class="pbmit-featured-wrapper pbmit-post-featured-wrapper">
                                        <img src="<?php echo htmlspecialchars($article['featured_image']); ?>" class="img-fluid" alt="">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="pbmit-box-content">
                                <div class="pbmit-entry-meta-wrapper">
                                    <span class="pbmit-meta-line">
                                        <span class="pbmit-avatar">
                                            <?php echo htmlspecialchars($article['category']); ?>
                                        </span>
                                    </span>
                                    <span class="pbmit-meta-line pbmit-date">
                                        <?php echo date('d M Y', strtotime($article['published_date'])); ?>
                                    </span>
                                </div>
                                <div class="pbmit-box-title">
                                    <h2 class="pbmit-title">
                                        <a href="article/<?php echo urlencode($article['slug']); ?>"><?php echo htmlspecialchars($article['title']); ?></a>
                                    </h2>
                                </div>
                                <div class="pbmit-blogbox-footer">
                                    <div class="pbmit-blogbox-readmore pbmit-vc_btn3">
                                        <div class="pbmit-blogbox-footer-left">
                                            <a href="article/<?php echo urlencode($article['slug']); ?>"><?php echo $translations['read-more']; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($index % 2 != 0) : ?>
                                <div class="pbmit-blog-image-with-meta">
                                    <div class="pbmit-featured-wrapper pbmit-post-featured-wrapper">
                                        <img src="<?php echo htmlspecialchars($article['featured_image']); ?>" class="img-fluid" alt="">
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- Blog End -->