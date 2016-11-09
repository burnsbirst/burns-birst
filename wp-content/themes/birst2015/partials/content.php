<?php
/**
 * @package Plinth
 */
 $count=1;
 
?>
<?php if ($_GET['s'] == ''): ?>
<?php if($wp_query->post_count > 4) {?>
<?php while ( have_posts() ) : the_post(); if($count>4){?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">

    <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
  </header><!-- .entry-header -->

  <div class="entry-content">
  	<div class="thumbnail">
    	<?php $thumb=get_field('thumbnail_img');?>
        <?php if(!empty($thumb)): ?>
        	<img src="<?php echo $thumb['url']; ?>" alt="article image" />
       <?php endif; ?>
    </div>
  	<div class="excerpt-date-author">
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
    <p class="arrow"><a href="<?php the_permalink(); ?>" class="button-orange">Read More</a></p>
    </div>
    <hr class="horizontal-line" />
  </div><!-- .entry-content -->
</article><!-- #post-## -->
<?php }$count++; ?>
<?php endwhile; ?>
<?php }else{?>
<?php while ( have_posts() ) : the_post();?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">

    <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
  </header><!-- .entry-header -->

  <div class="entry-content">
  	<div class="thumbnail">
    	<?php $thumb=get_field('thumbnail_img');?>
        <?php if(!empty($thumb)): ?>
        	<img src="<?php echo $thumb['url']; ?>" alt="article image" />
       <?php endif; ?>
    </div>
  	<div class="excerpt-date-author">
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
        <span class="post-date"><?php echo $pd ?></span> <span class="author"><?php $user_info = get_userdata($post->post_author, 46 ); echo $user_info->first_name.' '.$user_info->last_name;?></span>
      </div><!-- .entry-meta -->
    <?php endif; ?>
    <?php the_excerpt(); ?>
    <p class="arrow"><a href="<?php the_permalink(); ?>" class="button-orange">Read More</a></p>
    </div>
    <hr class="horizontal-line" />
  </div><!-- .entry-content -->
</article><!-- #post-## -->
<?php endwhile; ?>
<?php } ?>
<?php endif; ?>