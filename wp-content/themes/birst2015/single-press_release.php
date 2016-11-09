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

<div class="primary--wrapper">
  <div class="content-area">
  	<div class="main-wrapper">
    <main id="main" class="site-main" role="main">

      <div class="press-release-list__content">

        <?php if (have_posts()):  ?>
          <?php while (have_posts()): the_post(); ?>
            <?php the_title('<h1 class="h-page-heading">', '</h1>'); ?>
            <?php
              $pr_subhead = get_field('sub_heading');
              if($pr_subhead):
            ?>
            <p class="h-page-subheading"><?php echo $pr_subhead ?></p>
            <?php endif; ?>
            <?php
              $content = wpautop( get_the_content(), true);
              $pr_location = get_field('location');
              $date = get_field('date');
              $date_l = get_the_date('l');
              $date_formatted = plinth_get_formatted_date(get_the_time('c'));
							
							if ($pr_location == '') {
								$pr_location = 'San Francisco, CA';
							}
              if($pr_location):

            echo '<p class="press-release-list__item__location__date" dir="ltr">'.$pr_location.', <time class="press-release-list__item__date news-list__item__date" datetime="' .$date. '">' .$date_formatted. '</time> –&nbsp;</p>' .$content;
            ?>
            <?php endif; ?>
            <?php
              $pr_file = get_field('file');
              if($pr_file):
            ?>
            <a href="<?php echo $pr_file['url']; ?>" class="button" title="<?php echo $pr_file['title']; ?>">View Full Press Release</a>
            <?php endif; ?>
          <?php endwhile; ?>
        <?php else: ?>
          <?php get_template_part('partials/content', 'none'); ?>
        <?php endif; ?>

      </div>

    </main><!-- #main -->
    </div>
    <div class="sidebar-wrapper">
			<div id="secondary">
    	<?php dynamic_sidebar('sidebar_pressrelease'); ?>
			</div>
    </div>
  </div>
  <div class="fill-in__bgcolor"></div>
  <div style="clear:both"></div>
</div>
<?php get_footer(); ?>
