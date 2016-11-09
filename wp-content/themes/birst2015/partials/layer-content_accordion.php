<?php
// Content Accordian

	if ($layer['display_type'] == 'careers'):
		 $args = array(
        'post_type'       => 'career_posting',
        'posts_per_page'  => -1,
        'post_status'     => 'publish',
        'orderby'         => 'menu_order',
        'order'           => 'ASC',
    );
    $careers = new WP_Query( $args );
  endif;
?>
<section class="layer--accordion <?php echo $layer['css_classes']; ?>"<?php plinth_style_attr(array('color' => $layer['background_color'], 'image' => $layer['background_image'])); ?>>
	<div class="row">
  <div class="layer--accordian--container">
    <div class="layer--accordian--heading-container">
			<?php echo $layer['title']; ?>
    </div>
    <div class="layer--accordian--content-container">
    	<?php if ($layer['display_type'] == 'careers'): ?>
        <?php while ( $careers->have_posts() ) : $careers->the_post(); ?>
        <?php
					$post_id = get_the_id();
					$title = get_the_title();
					$job_details = get_field('job_details', $post_id);
				?>
          <?php if($title): ?>
          <h3><?php echo $title; ?></h3>
          <?php endif; ?>
          <div>
            <div class="columns six layer-accordian--content-left">
              <?php the_content(); ?>
            </div>
            <div class="columns six layer-accordian--content-right">
              <?php echo $job_details; ?>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
				<?php foreach ($layer['accordian_item'] as $item): ?>
          <?php if($item['title']): ?>
          <h3><?php echo $item['title']; ?></h3>
          <?php endif; ?>
          <?php if($item['title']): ?>
          <div>
          <?php echo $item['content']; ?>
          </div>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
  </div>
</section>
