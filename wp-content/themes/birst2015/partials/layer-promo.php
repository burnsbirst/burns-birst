<?php
// Promo

?>
<section class="layer--promo" data-img-width="1600" data-img-height="1064" <?php plinth_style_attr(array('color' => $layer['background_color'], 'image' => $layer['background_image'], 'padding-top' => $layer['padding_top'], 'padding-bottom' => $layer['padding_bottom'])); ?>>
	<?php $template = get_post_meta($post->ID, '_wp_page_template', true); ?>
  <div class="container row">
    <?php if($layer['content'] && !empty($layer['content'])): ?>
      <div class="layer--promo-content"><?php echo $layer['content']; ?></div>
    <?php endif; ?>
  </div>
</section>
