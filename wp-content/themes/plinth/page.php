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

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <?php if (have_posts()):  ?>
        <?php while (have_posts()): the_post(); ?>
          <?php if (is_front_page()): ?>
            <?php get_template_part('partials/content', 'home'); ?>
          <?php else: ?>
            <?php get_template_part('partials/content', 'page'); ?>
          <?php endif; ?>
        <?php endwhile; ?>
      <?php else: ?>
        <?php get_template_part('partials/content', 'none'); ?>
      <?php endif; ?>
    </main><!-- #main -->
  </div><!-- #primary -->

<?php get_footer();
