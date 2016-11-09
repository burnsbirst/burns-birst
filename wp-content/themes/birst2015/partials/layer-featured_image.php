<?php
// Featured Image


?>
<section class="layer--featured-image <?php echo $layer['display']; ?>"<?php plinth_style_attr(array('color' => $layer['background_color'], 'image' => $layer['background_image'])); ?>>
	<div class="layer--featured-image-content">
  	<?php echo $layer['content']; ?>
  </div>
  <?php if ($layer['image'] && $layer['display'] != 'video'): ?>
  <div class="layer--featured-image-image">
  	<div class="container row">
      <div class="columns <?php if($layer['image_right']): ?>seven<?php else: ?>fifteen<?php endif; ?>">
        <img src="<?php echo $layer['image']['url']; ?>" alt="<?php echo $layer['image']['title']; ?>" />
        <?php if($layer['add_button_first']): ?>
          <div class="button-area">
            <a href="<?php echo $layer['button_url_first']; ?>" class="button button-orange"><?php echo $layer['button_text_first']; ?></a>
          </div>
        <?php endif; ?>
      </div>
      <?php if($layer['image_right']): ?>
      <div class="columns seven push_one">
        <img src="<?php echo $layer['image_right']['url']; ?>" alt="<?php echo $layer['image_right']['title']; ?>" />
        <?php if($layer['add_button_second']): ?>
          <div class="button-area">
            <a href="<?php echo $layer['button_url_second']; ?>" class="button button-orange"><?php echo $layer['button_text_second']; ?></a>
          </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <?php elseif ($layer['display'] == 'video'): ?>
  <div class="layer--featured-image-image video">
  	<img src="/images/analytics-devices-mobile.jpg" class="mobile-view-mobile" alt="Analytics Devices" />
  	<div class="video-container">
      <img src="/images/analytics-devices.png" class="desktop-view" alt="Analytics Devices" />
      <video width="570">
        <source src="/images/videos/website-home-loop-vid-2.mp4"  type="video/mp4">
        <source src="/images/videos/website-home-loop-vid-2.ogv"  type="video/ogg">
        <source src="/images/videos/website-home-loop-vid-2.webm"  type="video/webm">
      </video>
    </div>
  </div>
  <?php endif; ?>
</section>