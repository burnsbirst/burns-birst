<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">

    <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
  </header><!-- .entry-header -->

  <div class="entry-content">
  	<div class="excerpt-date-author">
    <?php if (get_the_excerpt()): ?>
    <?php the_excerpt(); ?>
    <?php else: ?>
    <p>
    <?php echo get_post_meta($post->ID, '_yoast_wpseo_metadesc', true); ?>
    </p>
    <?php endif; ?>
    <p class="arrow"><a href="<?php the_permalink(); ?>" class="button-orange">Read More</a></p>
    </div>
    <hr class="horizontal-line" />
  </div><!-- .entry-content -->
</article><!-- #post-## -->