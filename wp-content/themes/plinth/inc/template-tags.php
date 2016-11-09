<?php
/**
 * Custom template tags for Plinth theme.
 *
 * @package Plinth
 */

require_once get_template_directory() . '/classes/AtreNet_Util.php';
require_once get_template_directory() . '/classes/AtreNet_DateFormat.php';
require_once get_template_directory() . '/classes/Plinth_TagHelpers.php';
require_once get_template_directory() . '/classes/Plinth_Util.php';
require_once get_template_directory() . '/classes/Plinth.php';

function plinth_output_youtube_iframe($youtube_url, $width = '100%', $height = '100%') {
  $youtube_id = '';
  if (preg_match('/[&?]v=([^&]+)/', $youtube_url, $matches)) {
    $youtube_id = $matches[1];
  }
  if ($youtube_id) { ?>
  <iframe width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="//www.youtube.com/embed/<?php echo $youtube_id; ?>?rel=0&wmode=transparent" frameborder="0" allowfullscreen></iframe>
<?php }
}

/**
 * Pluralize a string.
 *
 * Uses AtreNet_Util::pluralize()
 *
 * @todo  Backport to Plinth main
 *
 * @param  string  $string  The string to pluralize
 *
 * @return  string
 */
function plinth_pluralize($string) {
  return AtreNet_Util::pluralize($string);
}

function plinth_display_footer_navigation() {
  Plinth::getInstance()->displayFooterNavigation();
}

function plinth_get_secondary_navigation() {
  return Plinth::getInstance()->getSecondaryNavigation();
}

function plinth_display_secondary_navigation() {
  echo plinth_get_secondary_navigation();
}

function plinth_set_current_post_id($id) {
  Plinth::getInstance()->setCurrentPostId($id);
}

// Echo a site option
function plinth_the_single_site_option($option_keys, $default = '', $language = false) {
  echo Plinth::getSingleSiteOption($option_keys, $default, $language);
}

// Get a site option
function plinth_get_single_site_option($option_keys, $default = '', $language = false) {
  return Plinth::getSingleSiteOption($option_keys, $default, $language);
}

// Echo a site option
function plinth_the_site_option($option_keys, $default = '', $language = false) {
  echo Plinth::getSiteOption($option_keys, $default, $language);
}

// Get a site option
function plinth_get_site_option($option_keys, $default = '', $language = false) {
  return Plinth::getSiteOption($option_keys, $default, $language);
}

// Get permalink to a post object
function plinth_get_post_object_link($post_object) {
  $link = '';
  if ( is_array($post_object) && count($post_object) > 0 ) {
    $post_object = array_shift($post_object);
  }
  if ( is_object($post_object) && isset($post_object->ID) ) {
    $link = get_permalink($post_object->ID);
  }
  return $link;
}

// Echo permalink to a post object
function plinth_the_post_object_link($post_object) {
  echo plinth_get_post_object_link($post_object);
}

// Get list of terms for a taxonomy
function plinth_get_taxonomy_terms($taxonomy) {
  $terms = array();
  $get_term_args = array(
    'hide_empty' => false,
  );
  $term_list = get_terms($taxonomy, $get_term_args);
  foreach ($term_list as $term) {
    $terms[$term->slug] = $term->name;
  }
  return $terms;
}

// Get the label for a specific value of a field
function plinth_get_field_label_for_value($field_name, $value) {
  return Plinth::getFieldLabelForValue($field_name, $value);
}

// Echo the label for a specific value of a field
function plinth_the_field_label_for_value($field_name, $value) {
  echo Plinth::getFieldLabelForValue($field_name, $value);
}

/**
 * Echo the label for the current value of a multi-value field
 *
 * Must be run in the Loop.
 *
 * @uses get_field(), Plinth::getFieldLabelForValue()
 *
 * @todo Backport to Plinth main
 *
 * @param  $field_name  string  The name of a field.
 *
 * @return  void
 */
function plinth_the_field_label_for_current_value($field_name) {
  $value = get_field($field_name);
  echo Plinth::getFieldLabelForValue($field_name, $value);
}

/**
 * Get the label for the current value of a multi-value field
 *
 * Must be run in the Loop.
 *
 * @uses get_field(), Plinth::getFieldLabelForValue()
 *
 * @todo Backport to Plinth main
 *
 * @param  $field_name  string  The name of a field.
 *
 * @return  string
 */
function plinth_get_field_label_for_current_value($field_name) {
  $value = get_field($field_name);
  return Plinth::getFieldLabelForValue($field_name, $value);
}


function plinth_get_next_event() {
  return Plinth::getUpcomingEvents(1);
}

function plinth_get_upcoming_events($limit = -1) {
  return Plinth::getUpcomingEvents($limit);
}

function plinth_get_featured_event() {
  return Plinth::getFeaturedEvent();
}


function plinth_get_field_options($field_name, $post_type, $meta_query = false) {
  return Plinth::getFieldOptionsForPostType($field_name, $post_type, $meta_query);
}

/**
 * Output an img tag from an ACF image subfield
 *
 * If no image is set on field, nothing is output.
 *
 * @param  string  $field_name  The name of the sub field
 * @param  string  $class_name  Optional class to output on img - Default ''
 */
function plinth_image_from_sub_field($field_name, $class_name = '', $alt = '', $sizes = array(), $lazy_load = false) {
  if ( $image = get_sub_field($field_name) ) {
    plinth_output_image($image, $class_name, $alt, $sizes, $lazy_load);
  }
}

/**
 * Output an img tag from an ACF image subfield
 *
 * If no image is set on field, nothing is output.
 *
 * @param  string  $field_name  The name of the field
 * @param  string  $class_name  Optional class to output on img - Default ''
 */
function plinth_image_from_field($field_name, $class_name = '', $alt = '', $sizes = array(), $lazy_load = false) {
  if ( $image = get_field($field_name) ) {
    plinth_output_image($image, $class_name, $alt, $sizes, $lazy_load);
  }
}

function plinth_get_html_for_image($image, $class_name = '', $alt = '', $sizes = array(), $lazy_load = false) {
  ob_start();
  plinth_output_image($image, $class_name, $alt, $sizes, $lazy_load);
  return ob_get_clean();
}

function plinth_get_image_from_video($video_url) {
  try {
    $video = new AtreNet_Video($video_url);
    $video_details = $video->getVideoDetails();
    return plinth_get_html_for_image($video_details['thumbnail']);
  } catch(Exception $e) {}

  return '';
}

/**
 * Output an image tag from an ACF image field object
 *
 * If image object is null, nothing is output.
 *
 * @param  array   $image       Image object from ACF field
 * @param  string  $class_name  Optional class to output on img tag
 */
function plinth_output_image($image, $class_name = '', $alt = '', $sizes = array(), $lazy_load = false) {
  Plinth_TagHelpers::outputImage($image, $class_name, $alt, $sizes, $lazy_load);
}

/**
 * Conditionally output an alt tag.
 *
 * If no text is provided, nothing is output.
 *
 * @uses Plinth_TagHelpers::outputAltTag()
 *
 * @param  string  $alt  The alt text
 */
function plinth_output_alt_tag($alt) {
  Plinth_TagHelpers::outputAltTag($alt);
}

/**
 * Conditionally output a class in HTML
 *
 * If no class name is provided, nothing is output
 *
 * @uses Plinth_TagHelpers::outputClass()
 *
 * @param  string  $class_name  The class to output
 * @param  bool    $bare_class  If true, just output the class name, not the class attribute - Default false
 */
function plinth_output_class($class_name, $bare_class = false) {
  Plinth_TagHelpers::outputClass($class_name, $bare_class);
}

/**
 * Check value and output a min-width style attribute.
 *
 * @users Plinth_TagHelpers::minWidth()
 *
 * @param   int      $width  The min-width value
 * @return  nothing
 */
function plinth_min_width($width, $bare_style = false) {
  Plinth_TagHelpers::minWdith($width, $bare_style);
}

/**
 * Convert a string of words to a value suitable for an HTML ID attribute
 *
 * @uses AtreNet_Util::wordsToId()
 *
 * @param   string  $string
 * @return  string
 */
function plinth_words_to_id($string) {
  return AtreNet_Util::wordsToId($string);
}

/**
 * Output formatted date for language.
 *
 * @param  string  $date  Date string - should be in ISO 8601 format ('c')
 */
function plinth_the_formatted_date($date) {
  echo Plinth_Util::getFormattedDate($date);
}

/**
 * Output formated 'extras' field classes for layer CSS class assignment.
 *
 * @param  array  $extras  Format should be a single dimensional array
 */
function plinth_the_formatted_array_to_classes($extras) {
  echo Plinth_Util::formatArrayToClasses($extras);
}

/**
 * Get formatted date for language.
 *
 * @param   string  $date            Date string - should be in ISO 8601 format ('c')
 * @return  string  $formatted_date
 */
function plinth_get_formatted_date($date) {
  return Plinth_Util::getFormattedDate($date);
}

/**
 * Output formatted date range for language.
 *
 * @param  string  $start_date  Date string - should be in ISO 8601 format ('c')
 * @param  string  $end_date    Date string - should be in ISO 8601 format ('c')
 */
function plinth_the_formatted_date_range($date1, $date2) {
  echo Plinth_Util::getFormattedDateRange($date1, $date2);
}

/**
 * Get formatted date range for language.
 *
 * @param   string  $start_date       Date string - should be in ISO 8601 format ('c')
 * @param   string  $end_date         Date string - should be in ISO 8601 format ('c')
 * @return  string  $formatted_range
 */
function plinth_get_formatted_date_range($date1, $date2) {
  return Plinth_Util::getFormattedDateRange($date1, $date2);
}

/**
 * Get the label(s) for a select sub field.
 *
 * @param   string  $field_name  The name of the custom field
 * @return  string|array         The label(s) for the field value, a string if single, array if multiple
 */
function plinth_the_sub_field_label($field_name) {
  echo Plinth::getSubFieldLabel($field_name);
}

/**
 * Get the label(s) for a select sub field.
 *
 * @param   string  $field_name  The name of the custom field
 * @return  string|array         The label(s) for the field value, a string if single, array if multiple
 */
function plinth_get_sub_field_label($field_name) {
  return Plinth::getSubFieldLabel($field_name);
}

/**
 * Get the label(s) for a select field.
 *
 * @param   string  $field_name  The name of the custom field
 * @return  string|array         The label(s) for the field value, a string if single, array if multiple
 */
function plinth_get_field_label($field_name) {
  return Plinth::getFieldLabel($field_name);
}

/**
 * Echo the label(s) for a select field.
 *
 * @param   string  $field_name  The name of the custom field
 * @param   string  $delimiter   The delimiter for multile values - Default ', '
 */
function plinth_the_field_label($field_name, $delimiter = ', ') {
  $label_value = Plinth::getFieldLabel($field_name);
  if ( is_array($label_value) ) {
    $label_value = implode($delimiter, $label_value);
  }
  echo $label_value;
}

/**
 * Show an excerpt from a custom field.
 * Based on: http://wordpress.org/support/topic/how-to-pull-excerpt-from-advanced-custom-field
 *
 * @param   string  $field_name  The name of the custom field
 * @param   int     $length      The length of the excerpt in words - Default 20
 * @param   string  $read_more   The "read more" string - Default "..."
 * @return  string               The excerpt
 */
function plinth_custom_field_excerpt($field_name, $length = 20, $read_more = '...') {
  $text = get_field($field_name);
  return Plinth_Util::formatExcerpt($text, $length, $read_more);
}

function plinth_format_excerpt($text, $length = 20, $read_more = '...') {
  return Plinth_Util::formatExcerpt($text, $length, $read_more);
}

/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function plinth_comment($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;

  if('pingback' === $comment->comment_type || 'trackback' === $comment->comment_type ): ?>

  <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
    <div class="comment-body">
      <?php _e('Pingback:', 'plinth'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('Edit', 'plinth'), '<span class="edit-link">', '</span>'); ?>
    </div>

  <?php else: ?>

  <li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
    <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
      <footer class="comment-meta">
        <div class="comment-author vcard">
          <?php if(0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
           <?php printf(__('%s <span class="says">says:</span>', 'plinth'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?>
        </div>

        <div class="comment-metadata">
          <a href="<?php echo esc_url( get_comment_link($comment->comment_ID)); ?>">
            <time datetime="<?php comment_time('c'); ?>">
              <?php printf(_x('%1$s at %2$s', '1: date, 2: time', 'plinth'), get_comment_date(), get_comment_time()); ?>
            </time>
          </a>
           <?php edit_comment_link(__('Edit', 'plinth'), '<span class="edit-link">', '</span>'); ?>
        </div>

        <?php if('0' == $comment->comment_approved): ?>
        <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'plinth'); ?></p>
        <?php endif; ?>
      </footer>

      <div class="comment-content"><?php comment_text(); ?></div>

      <?php comment_reply_link(array_merge($args, array(
        'add_below' => 'div-comment',
        'depth'     => $depth,
        'max_depth' => $args['max_depth'],
        'before'    => '<div class="reply">',
        'after'     => '</div>'
      ))); ?>
    </article>
  <?php endif;
}

/**
 * Return permalink for a post via the post slug
 *
 * @param string $slug      Post slug (i.e., post_name field)
 * @param string $post_type [Optional] Post type to limit search by
 *
 * @return string
 */
function plinth_get_permalink_by_slug($slug, $post_type = '') {
  return Plinth::getPermalinkBySlug($slug, $post_type);
}

/**
 * Prints HTML with meta information for the current post author.
 */
// TODO - backport this to Plinth
function plinth_posted_by() {
  printf('<span class="entry-author">%1$s <span class="author vcard"><a class="url fn n" href="%2$s" title="%3$s">%4$s</a></span></span>',
    __('Posted by', 'plinth'),
    esc_url(get_author_posts_url(get_the_author_meta('ID'))),
    esc_attr(sprintf(__( 'View all posts by %s', 'plinth'), get_the_author())),
    esc_html(get_the_author())
  );
}

/**
 * Prints HTML with meta information for the current post-date/time.
 */
// TODO - backport this to Plinth
function plinth_posted_date() {
  $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
  if(get_the_time('U') !== get_the_modified_time('U')) {
    $time_string .= '<time class="entry-date updated" datetime="%3$s">%4$s</time>';
  }

  printf($time_string,
    esc_attr(get_the_date('c')),
    esc_html(get_the_date()),
    esc_attr(get_the_modified_date('c')),
    esc_html(get_the_modified_date())
  );
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
// TODO - backport this to Plinth
function plinth_posted_on() {
  $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
  if(get_the_time('U') !== get_the_modified_time('U')) {
    $time_string .= '<time class="entry-date updated" datetime="%3$s">%4$s</time>';
  }
  $time_string = sprintf($time_string,
    esc_attr(get_the_date('c')),
    esc_html(get_the_date()),
    esc_attr(get_the_modified_date('c')),
    esc_html(get_the_modified_date())
  );

  printf(__('<span class="posted-on">%1$s</span><span class="byline"> by %2$s</span>', 'plinth'),
    $time_string,
    sprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
      esc_url(get_author_posts_url(get_the_author_meta('ID'))),
      esc_attr(sprintf(__( 'View all posts by %s', 'plinth'), get_the_author())),
      esc_html(get_the_author())
    )
  );
}

/**
 * Returns true if a blog has more than 1 category
 */
function plinth_categorized_blog() {
  if(false === ($allCatsInUse = get_transient('allCatsInUse'))) {
    $allCatsInUse = count(get_categories(array('hide_empty' => 1)));
    set_transient('allCatsInUse', $allCatsInUse);
  }

  return $allCatsInUse > 1;
}

/**
 * Flush out the transients used in plinth_categorized_blog
 */
function plinth_category_transient_flusher() {
  delete_transient('all_the_cool_cats');
}
add_action('edit_category', 'plinth_category_transient_flusher');
add_action('save_post',     'plinth_category_transient_flusher');

// TODO - backport this to Plinth
function plinth_paging_nav($options = array()) {
  global $wp_query;

  // Don't print empty markup if there's only one page.
  if ( $wp_query->max_num_pages < 2 ) {
    return;
  }
  ?>
  <nav class="paging-navigation" role="navigation">
    <h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'plinth' ); ?></h1>
    <ul class="paging-navigation__links">

      <?php if (isset($options['numeric'])):
        $paged = max(1, get_query_var('paged'));
        $paginate_links = paginate_links(array(
          'base'    => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
          'format'  => '?paged=%#%',
          'current' => $paged,
          'total'   => $wp_query->max_num_pages,
          'prev_text' => __('Prev', 'plinth'),
          'next_text' => __('Next', 'plinth'),
          'before_page_number' => '<span class="screen-reader-text">' . __('Page', 'plinth') . '</span>',
          'type' => 'array'
        ));

        if(isset($options['always_show_prevnext'])) {
          if($paged === 1) {
            printf('<li class="%1$s">%2$s</li>',
              'paging-navigation__links__link disabled',
              __('Prev', 'plinth')
            );
          }
        }
        foreach($paginate_links as $i => $paginate_link) {
          printf('<li class="%1$s">%2$s</li>',
            'paging-navigation__links__link' . ($i + 1 === $paged ? ' current' : ''),
            $paginate_link
          );
        }
        if(isset($options['always_show_prevnext'])) {
          if($paged === $wp_query->max_num_pages) {
            printf('<li class="%1$s">%2$s</li>',
              'paging-navigation__links__link disabled',
              __('Next', 'plinth')
            );
          }
        } ?>
      <?php else: ?>
        <?php if ( get_next_posts_link() ) : ?>
        <li class="paging-navigation__links__link nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'plinth' ) ); ?></li>
        <?php endif; ?>

        <?php if ( get_previous_posts_link() ) : ?>
        <li class="paging-navigation__links__link nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'plinth' ) ); ?></li>
        <?php endif; ?>
      <?php endif; ?>

    </ul><!-- .paging-navigation__links -->
  </nav><!-- .navigation -->
<?php
}

/**
 * Display navigation to next/previous post when applicable.
 */
function plinth_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'plinth' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'plinth' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link',     'plinth' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

// TODO - backport this to Plinth
function plinth_get_permalink_from_acf_relationship($acf_relationship) {
  if(!is_object($acf_relationship) && is_array($acf_relationship)) {
    $acf_relationship = array_shift($acf_relationship);
  }

   if(is_object($acf_relationship) && is_a($acf_relationship, 'WP_Post') && !empty($acf_relationship->ID)) {
     return get_permalink($acf_relationship->ID);
   }

  return '';
}

// TODO - backport this to Plinth
function plinth_style_attribute($options = array()) {
  return plinth_style_attr($options);
}

// TODO - backport this to Plinth
function plinth_style_attr($options = array()) {
  $defaults = array(
    'min_height' => false,
    'echo' => true,
    'field_name' => 'background_image',
    'color' => false,
    'image' => false,
  );
  $options = array_merge($defaults, $options);
  $style = '';
  $styles = array();

  if ($options['color']) {
    $styles[] = sprintf('background-color:%s', $options['color']);
  }
	
	if ($options['padding-top']) {
    $styles[] = sprintf('padding-top:%s', $options['padding-top']);
  }
	
	if ($options['padding-bottom']) {
    $styles[] = sprintf('padding-bottom:%s', $options['padding-bottom']);
  }

  if ($options['image']) {
    $image = $options['image'];
  } else {
    $image = get_sub_field($options['field_name']);
    if (!$image) {
      $image = get_field($options['field_name']);
    }
  }
  if ($image) {
    $styles[] = sprintf('background-image:url(%s)', $image['url']);
    if($options['min_height']) {
      $styles[] = sprintf('min-height:%spx', $image['height']);
    }
  }

  if (!empty($styles)) {
    $style = ' style="' . implode(';', $styles) . '"';
  }

  if ($options['echo']) {
    echo $style;
  } else {
    return $style;
  }
}


