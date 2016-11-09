<?php
/**
 * Template Name: News and Events
 * @subpackage PlinthChild
 */

get_header(); ?>

<section class="news-page__header">
	<header class="page-header">
   	<div class="title-wrapper">
   		<h1 class="page-title"><?php the_title(); ?></h1>
		</div>
	</header>
  <div style="clear:both"></div>
</section>
<div class="primary--wrapper">
  <div class="content-area">
  	<div class="main-wrapper">
    <main id="main" class="site-main" role="main">

      <div class="news-and-events-page">
				<?php if (have_posts()):  ?>
        	<?php while (have_posts()): the_post(); ?>
          	<?php get_template_part('partials/content', 'page'); ?>
						<?php $sidebar = get_field('sidebar'); ?>
        	<?php endwhile; ?>
      	<?php else: ?>
        	<?php get_template_part('partials/content', 'none'); ?>
      	<?php endif; ?>
      </div>
    </main><!-- #main -->
    </div>
    <div class="sidebar-wrapper">
			<div id="secondary">
    		<?php dynamic_sidebar($sidebar); ?>
			</div>
    </div>
  </div>
  <div class="fill-in__bgcolor"></div>
  <div style="clear:both"></div>
</div>
<?php get_footer(); ?>


