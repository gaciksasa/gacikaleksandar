<?php
require 'config.php';

// Fetch footer items from the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT title_sr, title_en, link_sr, link_en, is_custom, menu FROM footer_items ORDER BY `order`";
$result = $conn->query($sql);
$footer_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $footer_items[$row['menu']][] = $row;
    }
}
$conn->close();
?>

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
                        <h3 class="widget-title"><?php echo $lang == 'en' ? 'Information' : 'Informacije'; ?></h3>
                        <div class="textwidget">
                            <ul>
                                <?php if (isset($footer_items['information'])) : ?>
                                    <?php foreach ($footer_items['information'] as $item) : ?>
                                        <li><a href="<?php echo $lang == 'en' ? $item['link_en'] : $item['link_sr']; ?>"><?php echo $lang == 'en' ? $item['title_en'] : $item['title_sr']; ?></a></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="footer-widget-col-3">
                    <div class="widget">
                        <h3 class="widget-title"><?php echo $lang == 'en' ? 'Our Services' : 'Naše Usluge'; ?></h3>
                        <div class="textwidget">
                            <ul>
                                <?php if (isset($footer_items['services'])) : ?>
                                    <?php foreach ($footer_items['services'] as $item) : ?>
                                        <li><a href="<?php echo $lang == 'en' ? $item['link_en'] : $item['link_sr']; ?>"><?php echo $lang == 'en' ? $item['title_en'] : $item['title_sr']; ?></a></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="footer-widget-col-4">
                    <div class="widget">
                        <h3 class="widget-title"><?php echo $lang == 'en' ? 'Subscribe Us' : 'Pretplatite se'; ?></h3>
                        <div class="textwidget">
                            <form>
                                <input type="email" name="EMAIL" placeholder="Email address" required="">
                                <button type="submit"><?php echo $lang == 'en' ? 'Subscribe' : 'Pretplati se'; ?></button>
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
                            <p>Copyright © 2024 All Rights<br>Reserved.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="widget-as-link">
                            <ul class="pbmit_contact_widget_wrapper">
                                <li><a href="tel:+381604494033">(+381) 060 44 94 033</a></li>
                                <li><a href="mailto:info@gacikaleksandar.com">info@gacikaleksandar.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="widget-as-link">
                            <ul class="pbmit_contact_widget_wrapper">
                                <li>Dušanova 58/601,<br>18000 Niš, Serbia</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="widget-as-link">
                            <div class="pbmit-social-links-wrapper">
                                <ul class="social-icons mt-3">
                                    <li class="pbmit-social-facebook">
                                        <a class="tooltip-top" target="_blank" href="https://www.facebook.com/gacik.alexandar.5" data-tooltip="Facebook" rel="noopener">
                                            <i class="pbmit-base-icon-facebook"></i>
                                        </a>
                                    </li>
                                    <li class="pbmit-social-instagram">
                                        <a class="tooltip-top" target="_blank" href="https://www.instagram.com/garejiujitsu/" data-tooltip="Instagram" rel="noopener">
                                            <i class="pbmit-base-icon-instagram"></i>
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