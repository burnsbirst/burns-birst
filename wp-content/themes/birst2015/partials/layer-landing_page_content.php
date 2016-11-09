<?php
// Landing Page Content

?>
<section class="layer--landing-page-content" <?php plinth_style_attr(array('color' => $layer['main_content_background_color'], 'image' => $layer['main_content_background_image'])); ?>>
	<?php
		$secondary_image_style = '';
		$secondary_image_alignment = $layer['image_alignment'];
		
		
		switch ($secondary_image_alignment) {
			case 'top-left':
				$secondary_image_style = '0 0';
				break;
			case 'top-center':
				$secondary_image_style = '50% 0';
				break;
			case 'top-right':
				$secondary_image_style = '100% 0';
				break;
			case 'middle-left':
				$secondary_image_style = '0 50%';
				break;
			case 'middle-center':
				$secondary_image_style = '50% 50%';
				break;
			case 'middle-right':
				$secondary_image_style = '100% 50%';
				break;
			case 'bottom-left':
				$secondary_image_style = '0 100%';
				break;
			case 'bottom-center':
				$secondary_image_style = '50% 100%';
				break;
			case 'bottom-right':
				$secondary_image_style = '100% 100%';
				break;
		}
	?>
  <?php if (!empty($layer['secondary_background_image'])): ?>
	<div class="secondary-background" <?php plinth_style_attr(array('image' => $layer['secondary_background_image'])); ?> data-bg-position="<?php echo $secondary_image_style; ?>"></div>
  <?php endif; ?>
	<?php $template = get_post_meta($post->ID, '_wp_page_template', true); ?>
  <div class="container row">
		<div class="columns nine main-content">
    	<?php echo $layer['main_content']; ?>
    </div>
    <div class="columns push_one five sidebar">
    	<div class="sidebar-form" <?php plinth_style_attr(array('color' => $layer['sidebar_background_color'], 'image' => $layer['sidebar_background_image'])); ?>>
      	<?php echo $layer['sidebar_form']; ?>
      </div>
      <div class="sidebar-content">
      	<?php echo $layer['sidebar_content']; ?>
      </div>
    </div>
  </div>

</section>
