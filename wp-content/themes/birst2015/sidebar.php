<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package PlinthChild
 */
?>
  <div id="secondary" class="widget-area" role="complementary">
    <?php $sidebar = get_field('sidebar'); ?>
    <?php
      $post_type = get_post_type( get_the_ID() );
      if ($post_type == 'press_release'):
        $sidebar = 'sidebar_pressrelease';
			elseif ($post_type == 'news_article'):
				$sidebar = 'sidebar_news';
			elseif ($post_type == 'post'):
				$sidebar = 'sidebar_blog';
      endif;
    ?>
    <?php dynamic_sidebar( $sidebar ); ?>
  </div><!-- #secondary -->
