<?php
// Mast

// -- init variables
$style;
$min_height;
$class;

if ($layer['background_image']):
	$style .= 'background-image: url(\'' .$layer['background_image']['url'] .'\'); ';
endif;

if ($layer['background_color']):
	$style .= 'background-color: ' .$layer['background_color'];
endif;

if ($layer['min_height']):
	$min_height = 'height: ' .$layer['min_height'] .'px';
endif;

if ($layer['display'] == 'carousel'):
	$class = 'has-carousel';
endif;

$mobile_bg_image = '';
if ($layer['mobile_background_image']) {
	$mobile_bg_image = 'data-mobileimage="'.$layer['mobile_background_image']['url'].'"';
}

$layer['mobile_background_image'] = '';

?>
<section class="layer--mast <?php echo $class; ?>" style="<?php echo $style; ?>" <?php echo $mobile_bg_image; ?>>
	<div class="layer--mast-container">
  	<?php if ($layer['display'] == 'carousel'): ?>
    <?php if ($layer['use_background_video'] == true): ?>
    <div class="layer--mast-video-screen"></div>
    <div class="layer--mast-video">
    	<video autoplay loop>
      	<source src="/images/videos/birst-website-sizzle-v3.mp4"  type="video/mp4">
        <source src="/images/videos/birst-website-sizzle-v3.ogv"  type="video/ogg">
        <source src="/images/videos/birst-website-sizzle-v3.webm"  type="video/webm">
      </video>
    </div>
    <div class="layer--mast-mobile-bg">
    	<img src="/images/mast/bg-home-hero-mobile-1.jpg" alt="Birst Home" />
      <img src="/images/mast/bg-home-hero-mobile-2.jpg" alt="Birst Home" />
      <img src="/images/mast/bg-home-hero-mobile-3.jpg" alt="Birst Home" />
      <img src="/images/mast/bg-home-hero-mobile-4.jpg" alt="Birst Home" class="no-fade" />
    </div>
    <?php endif; ?>
    <?php endif; ?>
  	<?php if ($layer['display'] == 'mast' || $layer['display'] == ''): ?>
  	<div class="layer--mast-container-c">
    	<div class="layer--mast-container-v" style="<?php echo $min_height; ?>">
  			<?php echo $layer['content']; ?>
      </div>
    </div>
    <?php elseif ($layer['display'] == 'carousel'): ?>
    <div class="layer--mast-carousel">
			<?php foreach ($layer['slides'] as $s): ?>
      <?php
				if ($s['no_padding'] == true):
					$class = 'no-padding';
				endif;
			?>
      <div class="layer--mast-container-c">
        <div class="layer--mast-container-v <?php echo $class; ?>" style="<?php echo $min_height; ?>">
          <?php echo $s['content']; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php if ($layer['display'] == 'carousel-nav'): ?>
    	<div class="layer--mast-carousel carousel-nav">
      <?php foreach ($layer['slides'] as $s): ?>
      <?php
				if ($s['background_image']):
					$bgi = 'data-bgimage="' .$s['background_image']['url'] .'"';
				endif;
			?>
      <?php
				if ($s['no_padding'] == true):
					$class = 'no-padding';
				endif;
			?>
      <div class="layer--mast-container-c" <?php echo $bgi; ?>>
        <div class="layer--mast-container-v <?php echo $class; ?>" <?php echo $min_height; ?>>
          <?php echo $s['content']; ?>
        </div>
      </div>
      <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
  <?php if ($layer['display'] == 'carousel-nav'): ?>
		<div class="layer--mast-carousel-carousel-nav-side-bg"></div>
  <?php endif; ?>
</section>
