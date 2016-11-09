<?php
// Awards Layer

?>
<section class="layer--awards <?php plinth_the_formatted_array_to_classes($layer['extras']); ?>" <?php plinth_style_attr(array('image' => $layer['background_image'], 'padding-top' => $layer['padding_top'], 'padding-bottom' => $layer['padding_bottom'])); ?>>
	<div class="row">
	<?php if($layer['title'] && !empty($layer['title'])): ?>
    <div class="layer--awards__heading"><?php echo $layer['title']; ?></div>
  <?php endif; ?>
  <?php if ($layer['display'] == 'carousel'): echo '<div id="next"></div><div id="prev"></div><div class="layer--awards__carousel-carousel">'; endif; ?>
	<?php
		$i = 0;
		foreach($layer['awards'] as $award):
		if ($i == 0):
		 //echo '<div class="layer--awards__carousel-container">';
		endif;
	?>
  	<div class="layer--awards__tile">
    	<div class="layer--awards__tile-v">
      	<div class="layer--awards__tile-c">
					<?php 
            $url = get_field('award_url', $award->ID);
            $award_from = get_field('award_from', $award->ID);
            $image = get_field('logo', $award->ID);
          ?>
      		<a href="<?php echo $url; ?>"><img src="<?php echo $image['url']; ?>" alt="<?php echo $award_from; ?>" /></a>
      	</div>
      </div>
    </div>
  <?php
		$i++;
		if ($i == 5):
		 //echo '</div>';
		 $i=0;
		endif;
		endforeach;
	?>
  <?php if ($layer['display'] == 'carousel'): echo '</div>'; endif; ?>
  </div>
  <?php if($layer['cta_label'] && $layer['cta_url']): ?>
	<div class="row cta-container">
		<a href="<?php echo $layer['cta_url']; ?>" class="button button-orange"><?php echo $layer['cta_label']; ?></a>
	</div>
	<?php endif; ?>
  </div>
</section>
