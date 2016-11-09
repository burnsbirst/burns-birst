<?php
/**
 * The template for displaying Category pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package PlinthChild
 */

get_header(); ?>

  <section id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
    <h1><?php single_cat_title(); ?></h1>
    <?php if ( have_posts() ) : ?>

      <?php /* Start the Loop */ ?>
      <?php while ( have_posts() ) : the_post(); ?>

        <?php
          /* Include the Post-Format-specific template for the content.
           * If you want to override this in a child theme, then include a file
           * called content-___.php (where ___ is the Post Format name) and that will be used instead.
           */
          get_template_part( 'partials/content', 'category' );
        ?>

      <?php endwhile; ?>

      <?php plinth_paging_nav(); ?>

    <?php else : ?>

      <?php get_template_part( 'partials/content', 'none' ); ?>

    <?php endif; ?>

    </main><!-- #main -->
    <?php get_sidebar(); ?>
  </section><!-- #primary -->

<?php get_footer(); ?>