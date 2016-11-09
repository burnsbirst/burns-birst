<?php
/**
 * The Template for displaying all single posts
 *
 * @package PlinthChild
 */

get_header(); ?>

<section class="blog-post__header" <?php if (has_post_thumbnail( $post->ID ) ): ?><?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>style="background-image: url('<?php echo $image[0]; ?>')"<?php endif; ?>>
	<header class="entry-header">
    	<div class="title-wrapper">
    		<h1 class="entry-title"><?php the_title(); ?></h1>
    		<div class="avatar--info">
    			<div class="author-avatar">
    				<?php echo get_avatar( $post->post_author, 46 ); ?>
   				</div>
        <?php 
      $author = get_post_meta( get_the_ID(), 'guest-author', true );
      if(!$author):
        $author = get_the_author();
      endif;
      ?>
				<?php $post_date = get_the_date(); $pd=date('M j, Y',strtotime($post_date));?>
				<div class="entry-meta-single">
        			<div class="date"><?php echo $pd; ?></div>
					<div class="author">
          <?php $user_info = get_post_meta( get_the_ID(), 'guest-author', true ); ?>
          <?php 
          if(!$user_info):
          $user_info = get_userdata($post->post_author, 46 ); echo $user_info->first_name.' '.$user_info->last_name;
          else:
          echo $user_info;
          endif;
          ?>
          </div>
				</div><!-- .entry-meta -->
    		</div>
		</div>
		<div class="tags-share-wrapper">
        	<div class="tags">
            	<div class="tags__title">TAGS</div>
            	<?php
				$tags = wp_get_post_tags($post->ID);
  					if ($tags) {
    					foreach($tags as $tag) {
        					echo '<div class="tag--name">'.$tag->name.'</div>';
    					}
  					}
				?>
            </div>
            <div class="shares">
            	<div class="shares__title">SHARE</div>
                	<div class="addthis_sharing_toolbox"><!--<span class="at_flat_counter birst-share twitter">30</span><span class="at_flat_counter birst-share facebook">0</span><span class="at_flat_counter birst-share linkedin">110</span><span class="at_flat_counter birst-share google">0</span>--></div>
					<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-553937d9540d44f5" async="async"></script>
            </div>
        </div>
	</header><!-- .entry-header -->
    <div style="clear:both"></div>
</section>
<div class="primary--wrapper">
  <div class="content-area">
  	<div class="main-wrapper">
    <main id="main" class="site-main" role="main">

      <div class="blog-post-single">

        <?php if ( have_posts() ) : the_post(); ?>

          <?php get_template_part('partials/content', 'single'); ?>

          <?php else: ?>
            <?php get_template_part('partials/content', 'none'); ?>
          <?php endif; ?>
      </div>
    </main><!-- #main -->
    </div>
    <div class="sidebar-wrapper">
    <?php get_sidebar(); ?>
    </div>
  </div>
  <div class="fill-in__bgcolor"></div>
  <div style="clear:both"></div>
</div>
<?php get_footer(); ?>
