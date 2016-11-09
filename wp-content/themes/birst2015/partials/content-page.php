<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Plinth
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if (!is_page_template( 'page-templates/news-events.php' )) : ?>
  <header class="entry-header">
    <?php get_template_part('partials/component', 'headings'); ?>
  </header><!-- .entry-header -->
	<?php endif; ?>

  <div class="entry-content">
    <?php the_content(); ?>
    <?php
      wp_link_pages( array(
        'before' => '<div class="page-links">' . __( 'Pages:', 'plinth' ),
        'after'  => '</div>',
      ) );
    ?>
  </div><!-- .entry-content -->
  <?php edit_post_link( __( 'Edit', 'plinth' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->
