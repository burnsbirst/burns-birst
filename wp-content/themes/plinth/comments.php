<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package Matrixx2014
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
  return;
}
?>

<div id="comments" class="comments-area">

  <?php if ( have_comments() ) : ?>

  <h2 class="comments-title">
    <?php
      printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'twentyfourteen' ),
        number_format_i18n( get_comments_number() ), get_the_title() );
    ?>
  </h2>

  <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
  <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
    <h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'twentyfourteen' ); ?></h1>
    <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'twentyfourteen' ) ); ?></div>
    <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'twentyfourteen' ) ); ?></div>
  </nav><!-- #comment-nav-above -->
  <?php endif; // Check for comment navigation. ?>

  <ol class="comment-list">
    <?php
      wp_list_comments( array(
        'style'      => 'ol',
        'short_ping' => true,
        'avatar_size'=> 34,
      ) );
    ?>
  </ol><!-- .comment-list -->

  <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
  <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
    <h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'twentyfourteen' ); ?></h1>
    <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'twentyfourteen' ) ); ?></div>
    <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'twentyfourteen' ) ); ?></div>
  </nav><!-- #comment-nav-below -->
  <?php endif; // Check for comment navigation. ?>

  <?php if ( ! comments_open() ) : ?>
  <p class="no-comments"><?php _e( 'Comments are closed.', 'twentyfourteen' ); ?></p>
  <?php endif; ?>

  <?php endif; // have_comments() ?>

  <?php
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');

    comment_form(array(
      'fields' => apply_filters('comment_form_default_fields', array(
        'author' => sprintf('<p class="comment-form-author"><label for="author">%1$s%2$s</label><input id="author" name="author" type="text" value="%3$s" size="30"%4$s /></p>',
          __('Name', 'plinth'),
          $req ? '<span class="required">*</span>' : '',
          esc_attr($commenter['comment_author']),
          $req ? ' aria-required="true"' : ''
        ),
        'email' => sprintf('<p class="comment-form-email"><label for="email">%1$s%2$s</label><input id="email" name="email" type="text" value="%3$s" size="30"%4$s /></p>',
          __('Email', 'plinth'),
          $req ? '<span class="required">*</span>' : '',
          esc_attr($commenter['comment_author_email']),
          $req ? ' aria-required="true"' : ''
        ),
        'url' => sprintf('<p class="comment-form-url"><label for="url">%1$s</label><input id="url" name="url" type="text" value="%2$s" size="30" /></p>',
          __('Website', 'plinth'),
          esc_attr($commenter['comment_author_url'])
        )
      ))
    )); ?>

</div><!-- #comments -->
