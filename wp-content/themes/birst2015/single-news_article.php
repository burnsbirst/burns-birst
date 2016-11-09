<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package PlinthChild
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
      
          <?php the_title('<h1 class="h-page-heading">', '</h1>'); ?>
          <?php echo html_entity_decode(get_field('description')); ?>

    </main><!-- #main -->
    <?php get_sidebar(); ?>
  </div><!-- #primary -->

<?php get_footer();
