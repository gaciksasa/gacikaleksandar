<?php
require 'config.php';

$current_page = basename($_SERVER['REQUEST_URI'], ".php");
$current_slug = '';

// Check if the current URL is a page or article
if (!in_array($current_page, ['index', 'about-us', 'our-services', 'our-pricing', 'our-trainers', 'trainer-details', 'faq', 'portfolio-style-1', 'portfolio-style-2', 'portfolio-single', 'classes', 'classes-details', 'blog', 'contacts'])) {
    $current_slug = basename($_SERVER['REQUEST_URI']);
    $current_page = 'content'; // Generic identifier for content (article or page)
}

// Fetch menu items from the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT id, title_sr, title_en, link_sr, link_en, is_custom, parent_id FROM menu_items ORDER BY `order`";
$result = $conn->query($sql);
$menu_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $menu_items[] = $row;
    }
}
$conn->close();

// Function to build the menu tree
function buildMenuTree($menu_items, $parent_id = null)
{
    $branch = [];
    foreach ($menu_items as $item) {
        if ($item['parent_id'] == $parent_id) {
            $children = buildMenuTree($menu_items, $item['id']);
            if ($children) {
                $item['children'] = $children;
            }
            $branch[] = $item;
        }
    }
    return $branch;
}

// Build the menu tree
$menu_tree = buildMenuTree($menu_items);
?>

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
                                        <img class="logo-img" src="images/homepage-1/logo.png" alt="Gacik Aleksandar logo">
                                        <img class="sticky-logo" src="images/homepage-1/logo-dark.png" alt="Gacik Aleksandar logo">
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
                                                <?php
                                                function renderMenu($items, $current_page, $current_slug, $lang)
                                                {
                                                    foreach ($items as $item) {
                                                        $active_class = ($current_page == basename($item['link_sr'], ".php") || $current_slug == $item['link_sr']) ? 'active' : '';
                                                        $link = $lang == 'en' ? $item['link_en'] : $item['link_sr'];
                                                        $title = $lang == 'en' ? $item['title_en'] : $item['title_sr'];

                                                        echo '<li class="dropdown ' . $active_class . '">';
                                                        echo '<a href="' . $link . '">' . $title . '</a>';
                                                        if (isset($item['children'])) {
                                                            echo '<ul class="sub-menu">';
                                                            renderMenu($item['children'], $current_page, $current_slug, $lang);
                                                            echo '</ul>';
                                                        }
                                                        echo '</li>';
                                                    }
                                                }
                                                renderMenu($menu_tree, $current_page, $current_slug, $lang);
                                                ?>
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
        var currentPath = window.location.pathname.split("/").pop();

        // Check if currentPath matches a content slug
        if (currentPath && currentPath !== 'index.php') {
            // Make an AJAX request to fetch the corresponding content slug for the selected language
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_corresponding_content.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        window.location.href = '/' + response.slug;
                    } else {
                        // If no corresponding content, reload the page to change language
                        location.reload();
                    }
                }
            };
            xhr.send('currentSlug=' + encodeURIComponent(currentPath) + '&lang=' + encodeURIComponent(lang));
        } else {
            // If not a content page, reload to change language
            location.reload();
        }
    }
</script>