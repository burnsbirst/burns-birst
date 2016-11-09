<section class="layer--resource_tabs">
<?php

	if ($layer['team'] == 'board'):
		 $args = array(
        'post_type'       => 'leadership_bio',
        'posts_per_page'  => -1,
        'post_status'     => 'publish',
        'orderby'         => 'menu_order',
        'order'           => 'ASC',
        'meta_query'      => array(
            array(
                'key'     => 'member_of',
                'value'   => 'board',
                'compare' => 'LIKE',
            ),
        ),
    );
    $management = new WP_Query( $args );
  else: 
    $args = array(
        'post_type'       => 'leadership_bio',
        'posts_per_page'  => -1,
        'post_status'     => 'publish',
        'orderby'         => 'menu_order',
        'order'           => 'ASC',
        'meta_query'      => array(
            array(
                'key'     => 'member_of',
                'value'   => 'management',
                'compare' => 'LIKE',
            ),
        ),
    );
    $management = new WP_Query( $args );
	endif;


 
  ?>

	<div class="container row">
		<div class="three columns sticky-scroller">
			<ul>
			<?php $i = 0; ?>
			<?php while ( $management->have_posts() ) : $management->the_post(); ?>
				<?php $class = ""; ?>
        <?php 
					$post_id = get_the_id(); 
					$job_title = get_field('title', $post_id);
					$name = get_the_title();
					$tab_name = str_replace(' ', '_', $name);
				?>
				<?php if ($i == 0) $class="current"; ?>
				<li class="<?php echo $class; ?>"><a href="#Content-<?php echo plinth_words_to_id( $tab_name ); ?>" class="anchorLink <?php echo $class; ?> small-lines"><?php echo $name; ?>,<br /><span class="small-text"><?php echo $job_title; ?></span></a></li>
				<?php $i++; ?>
			<?php endwhile; ?>
			</ul>
		</div>

		<div class="nine columns resource-content">
    	<?php if ($layer['heading']): ?>
    	<?php echo $layer['heading']; ?>
      <?php endif; ?>
			<?php while ( $management->have_posts() ) : $management->the_post(); ?>
      	<?php 
					$post_id = get_the_id(); 
					$job_title = get_field('title', $post_id);
					$name = get_the_title();
					$bio = get_field('bio', $post_id);
					$tab_name = str_replace(' ', '_', $name);
					$photo = get_field('headshot', $post_id);
				?>
				<section id="Content-<?php echo plinth_words_to_id( $tab_name ); ?>" class="resource-group clearfix">
					<a name="Content-<?php echo plinth_words_to_id( $tab_name ); ?>"></a>
          <div class="leadership-content">
            <div class="headshot">
              <img src="<?php echo $photo['url']; ?>" title="<?php echo $photo['title']; ?>" />
            </div>
            <div class="bio">
            	<h6><span class="t-red"><?php echo $name; ?></span> | <?php echo $job_title; ?></h6>
              <?php echo $bio; ?>
            </div>
          </div>
					
					
				</section>
			<?php endwhile; ?>
		</div>
	</div>
</seciton>


