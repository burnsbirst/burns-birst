<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Plinth
 */
$slug = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
get_header(); ?>
<?php if ($_GET['s'] == ''): ?>
<?php if (strpos($slug,'/blog/')!==false): ?>
<?php if($wp_query->post_count > 4) :?>
  	<?php if ( have_posts() ) : ?>
    	<?php $count=1; ?>
    	<?php while ( have_posts() ) : the_post(); ?>
        <?php if($count==1){?>
        	<section class="featured--blog">
	<div class="row">
    	<div class="featured--post">
        <header class="entry-header">
    <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
  </header><!-- .entry-header -->
        	<?php if ( 'post' == get_post_type() ) : ?>
      <?php 
      $author = get_post_meta( get_the_ID(), 'guest-author', true );
      if(!$author):
        $author = get_the_author();
      endif;
      ?>
      <?php $description = get_the_author_meta('description'); ?>
      <?php $post_date = get_the_date(); $pd=date('M j, Y',strtotime($post_date));?>
      <div class="entry-meta">
        <span class="post-date"><?php echo $pd ?></span> <span class="author">
        <?php $user_info = get_post_meta( get_the_ID(), 'guest-author', true ); ?>
          <?php 
          if(!$user_info):
          $user_info = get_userdata($post->post_author, 46 ); echo $user_info->first_name.' '.$user_info->last_name;
          else:
          echo $user_info;
          endif;
          ?>
        </span>
      </div><!-- .entry-meta -->
    <?php endif; ?>
    <div class="excerpt"><?php echo strip_tags(get_the_excerpt()); ?></div>
    <p class="arrow"><a href="<?php the_permalink(); ?>" class="button button-outlined">Read More</a></p>
        </div>
    </div>
</section>
<?php } elseif($count>1&&$count<5){?>
<?php if($count==2){ ?>
<section class="featured--blog__blocks">
<?php } ?>
<div class="featured--blog__wrapper">
	<div class="featured--blog__block">
    	<div class="tile-top <?php if($count==3){ ?>blue<?php }?><?php if($count==4){ ?>gray<?php }?>"></div>
    <div class="tile">
    <header class="entry-header">
    	<img src="/wp-content/themes/birst2015/images/featured-blog-<?php echo $count; ?>.jpg" alt="featured block" />
    <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
  </header><!-- .entry-header -->
    	<?php if ( 'post' == get_post_type() ) : ?>
      <?php 
      $author = get_post_meta( get_the_ID(), 'guest-author', true );
      if(!$author):
        $author = get_the_author();
      endif;
      ?>
      <?php $description = get_the_author_meta('description'); ?>
      <?php $post_date = get_the_date(); $pd=date('M j, Y',strtotime($post_date));?>
      <div class="entry-meta">
        <span class="post-date"><?php echo $pd ?></span> <span class="author">
        <?php $user_info = get_post_meta( get_the_ID(), 'guest-author', true ); ?>
          <?php 
          if(!$user_info):
          $user_info = get_userdata($post->post_author, 46 ); echo $user_info->first_name.' '.$user_info->last_name;
          else:
          echo $user_info;
          endif;
          ?>
        </span>
      </div><!-- .entry-meta -->
    <?php endif; ?>
    <?php $excerpt = strip_tags(get_the_excerpt()); ?>
    <div class="excerpt"><?php echo limit_text($excerpt,40); ?></div>
    <p class="arrow"><a href="<?php the_permalink(); ?>" class="button-orange">Read More</a></p>
    </div>
    </div>
</div>
<?php if($count==4){ ?>
	<div style="clear:both"></div>
</section>
<?php } ?>
<?php } ?>
            <?php $count++; ?>
        <?php endwhile; ?>
    <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
<?php endif; ?> 
  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php if ( have_posts() ) : ?>
    
        <?php
          /* Include the Post-Format-specific template for the content.
           * If you want to override this in a child theme, then include a file
           * called content-___.php (where ___ is the Post Format name) and that will be used instead.
           */
          get_template_part( 'partials/content', get_post_format() );
        ?>    

      <?php paginate(); ?>

    <?php else : ?>

      <?php get_template_part( 'partials/content', 'none' ); ?>

    <?php endif; ?>

    </main><!-- #main -->
    <?php get_sidebar(); ?>
  </div><!-- #primary -->


<?php get_footer(); ?>
