<div class="pbmit-header-overlay">
    <div class="site-header-menu">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-md-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="site-branding">
                                <span class="site-title">
                                    <a href="index.php">
                                        <img class="logo-img" src="http://localhost/gacikaleksandar/images/homepage-1/logo.png" alt="Gacik Aleksandar logo">
                                        <img class="sticky-logo" src="http://localhost/gacikaleksandar/images/homepage-1/logo-dark.png" alt="Gacik Aleksandar logo">
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
                                                <li class="dropdown active">
                                                    <a href="index.php"><?php echo $translations['home']; ?></a>
                                                </li>
                                                <li class="dropdown">
                                                    <a href="#">Pages</a>
                                                    <ul>
                                                        <li><a href="about-us.php">About us</a></li>
                                                        <li><a href="our-services.php">Our Services</a></li>
                                                        <li><a href="our-pricing.php">Our Pricing</a></li>
                                                        <li><a href="our-trainers.php">Our Trainers</a></li>
                                                        <li><a href="trainer-details.php">Trainer Details</a></li>
                                                        <li><a href="faq.php">Faq</a></li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown">
                                                    <a href="#">Portfolio</a>
                                                    <ul>
                                                        <li><a href="portfolio-style-1.php">Portfolio Style 1</a></li>
                                                        <li><a href="portfolio-style-2.php">Portfolio Style 2</a></li>
                                                        <li><a href="portfolio-single.php">Portfolio Single</a></li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown">
                                                    <a href="classes.php">Classes</a>
                                                    <ul>
                                                        <li><a href="classes-details.php">Classes Details</a></li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown">
                                                    <a href="blog-grid-view.php">Blog</a>
                                                </li>
                                                <li><a href="contacts.php"><?php echo $translations['contact']; ?></a></li>
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
                                        <a class="tooltip-top" target="_blank" href="https://www.facebook.com/gacik.alexandar.5">
                                            <i class="pbmit-base-icon-facebook"></i>
                                        </a>
                                    </li>
                                    <li class="pbmit-social-instagram">
                                        <a class="tooltip-top" target="_blank" href="https://www.instagram.com/garejiujitsu/">
                                            <i class="pbmit-base-icon-instagram"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="language-selector">
                                <form method="post" action="" class="form-inline">
                                    <select name="lang" onchange="updateLanguage(this.value)">
                                        <option value="en" <?php if ($lang == 'en') echo 'selected'; ?>>EN</option>
                                        <option value="sr" <?php if ($lang == 'sr') echo 'selected'; ?>>SR</option>
                                    </select>
                                </form>
                            </div>
                            <div class="pbmit-header-button">
                                <a class="tooltip-top" href="tel:+381604494033">
                                    <i class="pbmit-base-icon-phone"> </i> 060 44 94 033
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateLanguage(lang) {
        document.cookie = "lang=" + lang + "; path=/; max-age=" + (86400 * 30);
        var currentSlug = '<?php echo $slug; ?>';

        // Make an AJAX request to fetch the corresponding article slug for the selected language
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../get_corresponding_article.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    window.location.href = 'http://localhost/gacikaleksandar/article/' + response.slug;
                } else {
                    alert('Article not found in the selected language.');
                }
            }
        };
        xhr.send('currentSlug=' + encodeURIComponent(currentSlug) + '&lang=' + encodeURIComponent(lang));
    }
</script>