<?php
// Include the configuration file
require 'config.php';

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch sliders
$sql = "SELECT id, title, subtitle, background_image, link FROM sliders";
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
  die("Query failed: " . $conn->error);
}

$sliders = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $sliders[] = $row;
  }
}

$conn->close();
?>

<style>
  .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1;
  }
</style>

<!-- START Home Slider 1 REVOLUTION SLIDER 6.5.19 -->
<p class="rs-p-wp-fix"></p>
<rs-module-wrap id="rev_slider_1_1_wrapper" data-alias="Home-Slider-1" data-source="gallery" style="visibility:hidden;background:#222d35;padding:0;margin:0px auto;margin-top:0;margin-bottom:0;">
  <rs-module id="rev_slider_1_1" data-version="6.5.19">
    <rs-slides>
      <?php foreach ($sliders as $index => $slider) : ?>
        <rs-slide style="position: absolute;" data-key="rs-<?php echo $index; ?>" data-title="Slide" data-thumb="revolution/images/slider01-1a-50x100.jpg" data-anim="ms:1000;r:0;" data-in="o:0;" data-out="a:false;">
          <img src="uploads/<?php echo htmlspecialchars($slider['background_image']); ?>" alt="<?php echo htmlspecialchars($slider['title']); ?>" title="<?php echo htmlspecialchars($slider['title']); ?>" width="1900" height="898" class="rev-slidebg tp-rs-img rs-lazyload" data-lazyload="uploads/<?php echo htmlspecialchars($slider['background_image']); ?>" data-no-retina>
          <div class="overlay"></div>
          <rs-layer id="slider-<?php echo $index; ?>-layer-0" data-type="text" data-rsp_ch="on" data-xy="xo:30px;yo:374px,374px,374px,175px;" data-text="s:100,100,100,40;l:100,100,100,40;ls:3px,3px,3px,2px;fw:700;" data-frame_0="x:50,50,50,19;" data-frame_1="st:1490;sp:1000;sR:1490;" data-frame_999="o:0;st:w;sR:6510;" style="z-index:9;font-family:'Rajdhani';text-transform:uppercase;"><span class="pbmit-skincolor"><?php echo htmlspecialchars($slider['title']); ?></span>
          </rs-layer>
          <rs-layer id="slider-<?php echo $index; ?>-layer-1" data-type="text" data-xy="xo:30px;yo:334px,334px,334px,152px;" data-text="w:normal;s:26,26,26,18;l:28,28,28,18;ls:8px,8px,8px,3px;fw:700;" data-rsp_bd="off" data-frame_0="x:-50,-50,-50,-19;" data-frame_1="st:1050;sp:1000;sR:1050;" data-frame_999="o:0;st:w;sR:6950;" style="z-index:8;font-family:'Rajdhani';text-transform:uppercase;"><?php echo htmlspecialchars($slider['subtitle']); ?>
          </rs-layer>
          <rs-layer id="slider-<?php echo $index; ?>-layer-2" data-type="button" data-rsp_ch="on" data-xy="xo:30px;yo:603px,603px,603px,266px;" data-text="w:normal;s:25,25,25,14;l:55,55,55,25;a:center;" data-dim="w:60px,60px,60px,27px;h:60px,60px,60px,27px;minw:60px,60px,60px,none;minh:60px,60px,60px,none;" data-border="bos:solid;boc:#ffffff;bow:2px,2px,2px,2px;bor:50%,50%,50%,50%;" data-frame_0="x:0,0,0,0px;y:50,50,50,23px;" data-frame_1="x:0,0,0,0px;y:0,0,0,0px;st:2220;sp:1000;sR:2220;" data-frame_999="o:0;st:w;sR:5780;" style="z-index:10;background-color:rgba(255,255,255,0);font-family:'Roboto';text-transform:uppercase;"><i class="fa-angle-right"></i>
          </rs-layer>
          <rs-layer id="slider-<?php echo $index; ?>-layer-3" data-type="text" data-xy="xo:101px;yo:619px,619px,619px,273px;" data-text="w:normal;s:14,14,14,12;l:25,25,25,14;ls:2px,2px,2px,1px;fw:700;" data-vbility="t,f,f,f" data-frame_0="y:50,50,50,19;" data-frame_1="st:2210;sp:1000;sR:2210;" data-frame_999="o:0;st:w;sR:5790;" style="z-index:11;font-family:'Rajdhani';text-transform:uppercase;"><a href="<?php echo htmlspecialchars($slider['link']); ?>">Discover more</a>
          </rs-layer>
        </rs-slide>
      <?php endforeach; ?>
    </rs-slides>
  </rs-module>
</rs-module-wrap>
<!-- END REVOLUTION SLIDER -->