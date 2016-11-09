<?php
/**
 * @package Plinth
 */
 if($count==1){
?>
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
        <span class="post-date"><?php echo $pd ?></span> <span class="author"><?php echo $author ?></span>
      </div><!-- .entry-meta -->
    <?php endif; ?>
    <?php the_excerpt(); ?>
    <p class="arrow"><a href="<?php the_permalink(); ?>" class="button-orange">Read More</a></p>
        </div>
    </div>
</section>
<?php } elseif($count>1&&$count<5){?>
<?php if($count==2){ ?>
<section class="">
<?php } ?>
	<div class="featured--blog__block">
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
        <span class="post-date"><?php echo $pd ?></span> <span class="author"><?php echo $author ?></span>
      </div><!-- .entry-meta -->
    <?php endif; ?>
    <?php the_excerpt(); ?>
    <p class="arrow"><a href="<?php the_permalink(); ?>" class="button-orange">Read More</a></p>
    </div>
<?php if($count==4){ ?>
</section>
<?php } ?>
<?php } 