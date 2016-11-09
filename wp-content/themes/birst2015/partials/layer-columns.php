<?php
// Columns

$columns = "";
if(isset($layer['columns']) && !empty($layer['columns'])) {
  $columns = $layer['columns'];
}

$layer_extras = $layer['extras'];
$border_top = false;
$border_bottom = false;

if (is_array($layer_extras)) :
	$extras = implode(" ", $layer_extras);
else : 
	$extras = $layer_extras;
endif;

// Search extras for borders
if( strpos($extras, 'layer-border-top') !== false ) :
	$border_top = true;
endif;
if( strpos($extras, 'layer-border-bottom') !== false ) :
	$border_bottom = true;
endif;

$mobile_bg_image = '';
if ($layer['secondary_background_image']) :
	$mobile_bg_image = 'data-mobileimage="'.$layer['secondary_background_image']['url'].'"';
endif;



?>
<section class="layer--columns <?php plinth_the_formatted_array_to_classes($layer['extras']); ?>" data-img-width="1600" data-img-height="1064" <?php plinth_style_attr(array('color' => $layer['background_color'], 'image' => $layer['background_image'], 'padding-top' => $layer['padding_top'], 'padding-bottom' => $layer['padding_bottom'])); ?> <?php echo $mobile_bg_image; ?>>
	<?php if (is_array($layer['background_video']) && strpos($extras, 'background_video') !== false ) : ?>
  	<video autoplay loop>
  	<?php foreach ( $layer['background_video'] as $v ): ?>
    <?php //print_r( $v['video']['url'] ); ?>
    	<source src="<?php echo $v['video']['url']; ?>" type="<?php echo $v['video']['mime_type']; ?>">
    <?php endforeach; ?>
    </video>
  <?php endif; ?>
  <?php if ($border_top) : ?><div class="top-gradient-border"></div><?php endif; ?>
	<?php $template = get_post_meta($post->ID, '_wp_page_template', true); ?>
  <div class="container row">
    <?php if($layer['heading'] && !empty($layer['heading'])): ?>
      <div class="layer--columns__heading" <?php //live_edit('heading'); ?>><?php echo $layer['heading']; ?></div>
    <?php endif; ?>

    <?php if($columns): ?>
      <div class="row">
        <?php foreach($columns as $i => $item): ?>
        	<?php
					$push_width = '';
					if($item['push_column'] == 1):
						$push_width = $item['push_width'];
					endif;
          ?>
          <div class="columns <?php echo $item['column_width']; ?> <?php echo $push_width; ?> <?php echo $item['type']; ?>-column <?php plinth_the_formatted_array_to_classes($item['extras']); ?>">
            <?php include(locate_template('partials/sub-partials/' . $item['type'] . '.php' )); ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
	<?php if ($border_bottom) : ?><div class="bottom-gradient-border"></div><?php endif; ?>
</section>
