<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Plinth
 */

get_header(); ?>

  <div id="primary" class="content-area row">
    <main id="main" class="site-main" role="main">

      <?php if (have_posts()):  ?>
        <?php while (have_posts()): the_post(); ?>
          <?php get_template_part('partials/content', 'page'); ?>
        <?php endwhile; ?>
      <?php else: ?>
        <?php get_template_part('partials/content', 'none'); ?>
      <?php endif; ?>
    </main><!-- #main -->
    <?php if(get_field('sidebar')): ?>
    <?php get_sidebar(); ?>
    <?php //get_template_part( 'partials/component', 'dynamic_sidebar' ); ?>
    <?php endif; ?>
  </div><!-- #primary -->

<?php get_footer();
