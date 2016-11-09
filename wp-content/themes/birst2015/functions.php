<?php

// Loaded right before the parent theme's functions.php

require_once get_stylesheet_directory() . '/classes/PlinthChild_Theme.php';
PlinthChild_Theme::getInstance();
add_theme_support( 'post-thumbnails' );

//
// shortcode: [get_posts type="{post_type}" limit="{total}"]
// creates press releases list
//
function posts_shortcode($atts){

// begin jhouston comments

// example query
// Use the WP_Query object and loop for grabbing records from custom post types
// Also, well want to be able to pass in parameters in the $atts array, but those would have default values. So $atts['posts_per_page'] might have a value of three which in that case this 'posts_per_page' values of the $args array being passed into the array would also return a value of 3 results

// For best technical reference, see this page -- http://codex.wordpress.org/Class_Reference/WP_Query

// $args = array( 'post_type' => 'press_release', 'posts_per_page' => 10 );
// $loop = new WP_Query( $args );
//while ( $loop->have_posts() ) : $loop->the_post();
//  the_title();
//  echo '<div class="entry-content">';
//  the_content();
//  echo '</div>';
//endwhile;

// end jhouston comments

	if ($atts['type'] == 'press_release') : 
	$args = array( 'post_type' => $atts['type'], 'posts_per_page' => $atts['limit']);
	$loop = new WP_Query( $args );
	$content = '';
		$pr_year = -1;
		while($loop->have_posts()):
			$loop->the_post();
			
			if (get_the_date('Y') != $pr_year) :
				if ($pr_year != -1) :
					$content .= '</section><!-- .press-releases -->';
				endif;
				$content .= '<section id="pr-year-'. get_the_date('Y') .'" class="news-index-list press-releases" data-section-name="pr-year-'. get_the_date('Y') .'" data-dropdown-text="'. get_the_date('Y') .'">';
				$pr_year = get_the_date('Y');
			endif;
			$content .= '<div class="press-release-item">';
	  	$content .= '<h2 class="press-release-item__heading">'. get_the_title() .'</h2>';
	  	$content .= '<time class="press-release-item__date">'. get_the_date() .' | '. get_field('location') .'</time>';
			$pr_content = get_the_content();
			$content .= '<div class="press-release-item__content">' .get_the_excerpt() .'</div>';
			$content .= '<p class="press-release-item__read_more"><a href="'. get_permalink() .'" class="button button-orange">Read More</a></p>';
			$content .= '</div>';
		endwhile;
		$content .= '</section><!-- .press-releases -->';
	elseif ($atts['type'] == 'award') :
	$args = array( 'post_type' => $atts['type'], 'posts_per_page' => $atts['limit'] );
	$loop = new WP_Query( $args );
	$content = '';
		$content .= '<section class="awards"><ul>';
		while($loop->have_posts()):
			$loop->the_post();
	  	$content .= '<li>';
				if (get_field('award_url')) : 
					$content .= '<a href="'. get_field('award_url') .'">'; 
				endif;
				$award_logo = get_field('logo');
				$content .= '<img src="'. $award_logo['url'] .'" alt="'. get_the_title() .'" />';
				if (get_field('award_url')) : 
					$content .= '</a>'; 
				endif;
				$content .= '</li>';
			endwhile;
			$content .= '</ul></section><!-- .awards -->';
	elseif ($atts['type'] == 'post') :
	$args = array( 'post_type' => $atts['type'], 'posts_per_page' => $atts['limit'] );
	$loop = new WP_Query( $args );
	$content = '';
		$content .= '<section class="blog-posts"><ul class="blog-list">';
		while($loop->have_posts()):
			$loop->the_post();
			$date = get_the_date();
			$date_formatted = plinth_get_formatted_date(get_the_time('c'));
			$content .= '<li class="blog-post-item">';
			$content .= '<time class="blog-post-item__date">'. $date_formatted .'</time>';
			$content .= '<span class="blog-post-item__title"><a href="'. get_the_permalink() .'">'. get_the_title() .'</a></span>';
			$content .= '</li>';
		endwhile;
		$content .= '</ul></section><!-- .blog-posts -->';
	elseif ($atts['type'] == 'news_article') :
	$args = array( 'post_type' => $atts['type'], 'posts_per_page' => $atts['limit'] );
	$loop = new WP_Query( $args );
	$content = '';
		$article_year = -1;
		while($loop->have_posts()):
			$loop->the_post();
			
			if (get_the_date('Y') != $article_year) :
				if ($article_year != -1) :
					$content .= '</section><!-- .articles -->';
				endif;
				$content .= '<section id="article-year-'. get_the_date('Y') .'" class="news-index-list articles" data-section-name="article-year-'. get_the_date('Y') .'" data-dropdown-text="'. get_the_date('Y') .'">';
				$article_year = get_the_date('Y');
			endif;
			
			$links = get_field('links');
			$url = '';
			$read_link = '';
			if($links[0]):
				if($links[0]['external_url'] != ''):
					$url = $links[0]['external_url'];
				endif;
				if($links[0]['local_file'] != ''):
					$url = $links[0]['local_file'];
				endif;
				$read_link = '<a href="'.$url.'" class="button button-orange">'.$links[0]['link_text'].'</a>';
			endif;
			
			$date = get_field('date');
      $date_formatted = plinth_get_formatted_date(get_the_time('c'));
			
			$content .= '<div class="article-item">';
	  	$content .= '<h2 class="article-item__heading">'. get_the_title() .'</h2>';
	  	$content .= '<time class="article-item__date">'. $date_formatted .'</time>';
			$content .= '<span class="article-item__content">'. get_field('description') .'</span>';
			if ($read_link) :
				$content .= '<p class="article-item__read_more">'.$read_link.'</p>';
			endif;
			$content .= '</div>';
		endwhile;
		$content .= '</section><!-- .articles -->';
		
		elseif ($atts['type'] == 'event') :
		$args = array( 'post_type' => $atts['type'], 'posts_per_page' => $atts['limit'], 'meta_key' => 'start_date', 'orderby' => 'meta_value', 'order' => 'ASC' );
	$loop = new WP_Query( $args );
	$content = '';
		$content.='<div class="events">';
		while($loop->have_posts()):
			$loop->the_post();
				if(strtotime(get_field('start_date'))>=strtotime('now')):
				$content.='<div class="event">';
				$content.='<div class="event__start-date">'.get_field('start_date').' </div>';
				if(get_field('start_date')!=get_field('end_date')&&get_field('end_date')!=''):
					$content.= ' - <div class="event__end-date">'.get_field('end_date').' </div>';
				endif;
				$content.='<div class="event__location"> | '.get_field('location').'</div>';
				$content.='<div class="event__title"><a href="'.get_field('event_url').'">'.get_the_title().'</a></div>';
				$content.='<div class="event__description">'.get_field('description').'</div>';
				if(get_field('event_url_cta')!=''):
					$content.='<div class="learn--more"><a href="'.get_field('event_url').'" class="button button-orange">'.get_field('event_url_cta').'</a></div>';
				endif;
				$content.='</div>';		
				endif;
			endwhile;
			$content.='</div>';
	endif;
	
	
	wp_reset_postdata();
	return $content; 
}
add_shortcode('get_posts','posts_shortcode');

//
// shortcode: [get_posts type="{post_type}" limit="{total}"]
// creates press releases list
//
function appthority_posts_shortcode( $atts ) {

    // begin jhouston comments
    
    // example query
    // Use the WP_Query object and loop for grabbing records from custom post   types
    // Also, well want to be able to pass in parameters in the $atts array, but those would have default values. So $atts['posts_per_page'] might have a value of three which in that case this 'posts_per_page' values of the $args array being passed into the array would also return a value of 3 results
    
    // For best technical reference, see this page -- http://codex.wordpress.org/Class_Reference/WP_Query
    
    // $args = array( 'post_type' => 'press_release', 'posts_per_page' => 10 );
    // $loop = new WP_Query( $args );
    //while ( $loop->have_posts() ) : $loop->the_post();
    //  the_title();
    //  echo '<div class="entry-content">';
    //  the_content();
    //  echo '</div>';
    //endwhile;

    // end jhouston comments

    $args = array(
        'post_type'      => $atts[ 'type' ],
        'posts_per_page' => $atts[ 'limit' ],
    );
    $loop = new WP_Query( $args );
    // create content
    $content = '';
    while ( $loop->have_posts() ) :
        $loop->the_post();
        $content .= '<section class="press-releases">';
        $content .= '<h2 class="press-release-heading">' . the_title() . '</h2>';
        $content .= '<div class="press-release-div">' . the_content() . '</div>';
        $content .= '</section><!-- .press-releases -->';
    endwhile;
    
    return $content; 
}
//add_shortcode( 'get_posts', 'appthority_posts_shortcode' );

/**
 * Lists off the most recent Leadership Bios in the specified "member_of" category (defaults to all)
 * shortcode: [leadership_bios member_of=“management” max_posts="6" title="Leadership Team"]
 *
 * @author Wes Moberly
 */

function leadership_bios_shortcode( $atts, $content = null, $code = '' ) {
    extract( shortcode_atts( array( 
        'title'     => '',
        'max_posts' => '6',
        'member_of' => null,
    ), $atts ) );
    
    // Validate attributes, cast as appropriate data types,
    // and fall back on defaults for any invalid values
    if ( is_string( $title ) ) {
        $title = wp_kses_post( $title );
    } else {
        $title = '';
    }
    
    if ( is_numeric( $max_posts ) ) {
        $max_posts = intval( $max_posts );
    } else {
        $max_posts = 6;
    }
    
    if ( is_string( $member_of ) ) {
        $member_of = strtolower( $member_of );
    } else {
        $member_of = null;
    }
    
    $args = array(
        'numberposts' => $max_posts,
        'post_type'   => 'leadership_bio',
        'order'       => 'ASC',
        'meta_query'  => array(
            array(
                'key'     => 'member_of',
                'value'   => $member_of,
                'compare' => 'LIKE'
            ),
        ),
    );
    
    $bio_query = new WP_Query( $args );
    
    // Return empty string if no posts are found
    if ( !$bio_query->have_posts() ) {
        return '';
    }
    
    ob_start();
    ?>
    <section class="shortcode--leadership-bios clearfix">
        <?php if ( $title ) : ?>
            <h4 class="bios-heading"><?php echo $title; ?></h4>
        <?php endif; ?>
        <?php while ( $bio_query->have_posts() ) : $bio_query->the_post(); ?>
            <?php
            $name       = get_the_title();
            $job_title  = get_field( 'title' );
            $image_data = get_field( 'headshot' );
            $bio_text   = get_field( 'bio' );
            
            if ( $image_data ) {
                $image_sizes  = $image_data[ 'sizes' ];
                $image_url    = $image_sizes[ 'leadership-bio-image' ];
                $image_width  = $image_sizes[ 'leadership-bio-image-width' ];
                $image_height = $image_sizes[ 'leadership-bio-image-height' ];
                
                $image_alt_text = '';
                if ( isset( $image_data[ 'alt' ] ) ) {
                    $image_alt_text = $image_data[ 'alt' ];
                } else if ( isset( $image_data[ 'caption' ] ) ) {
                    $image_alt_text = $image_data[ 'caption' ];
                } else if ( isset( $image_data[ 'description' ] ) ) {
                    $image_alt_text = $image_data[ 'description' ];
                } else if ( isset( $image_data[ 'title' ] ) ) {
                    $image_alt_text = $image_data[ 'title' ];
                }
            }
            
            if ( $bio_text ) {
                $bio_text = wpautop( wp_kses_post( $bio_text ) );
            }
            
            $container_class = 'bio-entry clearfix';
            if ( !$image_data ) {
                $container_class .= ' no-image';
            }
            ?>
            <div class="<?php echo $container_class; ?>">
                <?php if ( $image_data ) : ?>
                    <div class="aside-content">
                        <img class="bio-image" alt="<?php echo $image_alt_text; ?>" src="<?php echo $image_data[ 'url' ]; ?>">
                    </div>
                <?php endif; ?>
                <div class="main-content">
                    <?php
                    $headline_text = $job_title;
                    if ( $name ) {
                        $headline_text = $name . ', ' . $headline_text;
                    }
                    ?>
                    <span class="bio-headline"><?php echo $headline_text; ?></span>
                    <?php if ( $bio_text ) : ?>
                        <div class="bio-text">
                            <?php echo $bio_text; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </section>
    <?php
    wp_reset_query();
    
    return ob_get_clean();
}
add_shortcode( 'leadership_bios', 'leadership_bios_shortcode' );

/*
Plugin Name: Custom Styles
Plugin URI: http://www.speckygeek.com
Description: Add custom styles in your posts and pages content using TinyMCE WYSIWYG editor. The plugin adds a Styles dropdown menu in the visual post editor.
Based on TinyMCE Kit plug-in for WordPress
http://plugins.svn.wordpress.org/tinymce-advanced/branches/tinymce-kit/tinymce-kit.php
*/
/**
 * Apply styles to the visual editor
 */ 
add_filter('mce_css', 'tuts_mcekit_editor_style');
function tuts_mcekit_editor_style($url) {
 
    if ( !empty($url) )
        $url .= ',';
 
    // Retrieves the plugin directory URL
    // Change the path here if using different directories
    $url .= trailingslashit( plugin_dir_url(__FILE__) ) . '/editor-styles.css';
 
    return $url;
}

// =================================================================
// Add "Styles" drop-down
// =================================================================
add_filter( 'mce_buttons_2', 'tuts_mce_editor_buttons' );
 
function tuts_mce_editor_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}

// =================================================================
// Add styles/classes to the "Styles" drop-down
// =================================================================
add_filter( 'tiny_mce_before_init', 'tuts_mce_before_init' );
 
function tuts_mce_before_init( $settings ) {
 
    $style_formats = array(
        array(
            'title' => 'Orange Text',
            'inline' => 'span',
            'styles' => array(
                'color' => '#ff5800',
            )
        ),
				array(
            'title' => 'Blue Text',
            'inline' => 'span',
            'styles' => array(
                'color' => '#408eaa',
            )
        ),
				array(
            'title' => 'Gray Text',
            'inline' => 'span',
            'styles' => array(
                'color' => '#616363',
            )
        ),
				array(
            'title' => 'Brown Text',
            'inline' => 'span',
            'styles' => array(
                'color' => '#221e1e',
            )
        ),
				array(
            'title' => 'Double Space',
            'inline' => 'span',
            'styles' => array(
                'line-height' => '150%',
            )
        ),
				array(
            'title' => 'White Text',
            'inline' => 'span',
            'classes' => 'white-text',
        ),
				array(
            'title' => 'Light Gray Text',
            'inline' => 'span',
            'classes' => 'light-gray-text',
        ),
				array(
            'title' => 'Text Indent',
            'inline' => 'span',
            'classes' => 'text-indent',
        ),
				array(
            'title' => 'Small Upper Heading',
            'inline' => 'span',
            'classes' => 'small-upper-heading',
        ),
        array(
            'title' => 'Button',
            'selector' => 'a',
            'classes' => 'button',
        ),
				array(
            'title' => 'Button Outlined',
            'selector' => 'a',
            'classes' => 'button button-outlined',
        ),
				array(
            'title' => 'Button Orange',
            'selector' => 'a',
            'classes' => 'button button-orange',
        ),
				array(
            'title' => 'Button Orange Medium',
            'selector' => 'a',
            'classes' => 'button button-orange button-medium',
        ),
				array(
            'title' => 'Button Margin Top 20',
            'selector' => 'a',
            'styles' => array(
                'margin-top' => '20px',
            )
        ),
				array(
            'title' => 'Button Margin Bottom 40',
            'selector' => 'a',
            'styles' => array(
                'margin-bottom' => '40px',
            )
        ),
				array(
            'title' => 'h1 Margin Bottom 40',
						'selector' => 'h1',
            'styles' => array(
                'margin-bottom' => '40px',
            )
        ),
				array(
            'title' => 'h2 Margin Bottom 40',
						'selector' => 'h2',
            'styles' => array(
                'margin-bottom' => '40px',
            )
        ),
				array(
            'title' => 'h2 Margin Bottom 20',
						'selector' => 'h2',
            'styles' => array(
                'margin-bottom' => '40px',
            )
        ),
				array(
            'title' => 'h3 Margin Bottom 40',
						'selector' => 'h3',
            'styles' => array(
                'margin-bottom' => '20px',
            )
        ),
				array(
            'title' => 'h4 Margin Bottom 10',
						'selector' => 'h4',
            'styles' => array(
                'margin-bottom' => '10px',
            )
        ),
				array(
            'title' => 'img Margin Bottom 20',
						'selector' => 'img',
            'styles' => array(
                'margin-bottom' => '20px',
            )
        ),
				array(
            'title' => 'Image Border',
						'selector' => 'img',
            'classes' => 'img-border',
        ),
    );
 
    $settings['style_formats'] = json_encode( $style_formats );
 
    return $settings;
 
}

// =================================================================
// Add Font Size Range to Font Sizes the ACF WYSIWYF toolbar.
// =================================================================
function tweek_mce( $init ) {
	$max_font_size = 150;
	$fontsize_formats = '';
	for($i=8; $i<=$max_font_size; $i++):
		$fontsize_formats .= $i.'px ';
	endfor;
	$init['fontsize_formats'] = rtrim($fontsize_formats);
	return $init;
}
add_filter('tiny_mce_before_init', 'tweek_mce');

// =================================================================
// Add Font Sizes the ACF WYSIWYF toolbar.
// =================================================================

function customize_acf_wysiwyg_toolbar( $toolbars ) {
  // Edit the "Full" toolbar and add 'fontsizeselect' if not already present.
	
  if (($key = array_search('fontsizeselect' , $toolbars['Full'][2])) !== true) {
    array_push($toolbars['Full'][2], 'fontsizeselect');
  }

  // return $toolbars - IMPORTANT!
  return $toolbars;
}

add_filter('acf/fields/wysiwyg/toolbars' , 'customize_acf_wysiwyg_toolbar');

function paginate() {
	global $wp_query, $wp_rewrite;
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
	
	$pagination = array(
		'base' => @add_query_arg('page','%#%'),
		'format' => '',
		'total' => $wp_query->max_num_pages,
		'current' => $current,
		'show_all' => false,
		'type' => 'list',
		'next_text' => '<div class="next-page">Next</div>',
		'prev_text' => '<div class="last-page">Prev</div>'
		);
	
	if( $wp_rewrite->using_permalinks() )
		$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
	
	if( !empty($wp_query->query_vars['s']) )
		$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
	
	echo paginate_links( $pagination );
}

function sbt_auto_excerpt_more( $more ) {
return '';
}
add_filter( 'excerpt_more', 'sbt_auto_excerpt_more', 20 );

function sbt_custom_excerpt_more( $output ) {return preg_replace('/<a[^>]+>Continue reading.*?<\/a>/i','',$output);
}
add_filter( 'get_the_excerpt', 'sbt_custom_excerpt_more', 20 );

if ( ! function_exists( 'wpse0001_custom_wp_trim_excerpt' ) ) : 

    function wpse0001_custom_wp_trim_excerpt($wpse0001_excerpt) {
    global $post;
    $raw_excerpt = $wpse0001_excerpt;
        if ( '' == $wpse0001_excerpt ) {

            $wpse0001_excerpt = get_the_content('');
            $wpse0001_excerpt = strip_shortcodes( $wpse0001_excerpt );
            $wpse0001_excerpt = apply_filters('the_content', $wpse0001_excerpt);
            $wpse0001_excerpt = substr( $wpse0001_excerpt, 0, strpos( $wpse0001_excerpt, '</p>' ) + 4 );
            $wpse0001_excerpt = str_replace(']]>', ']]&gt;', $wpse0001_excerpt);

            $excerpt_end = ''; 
            $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end); 

            $wpse0001_excerpt .= $excerpt_end;

            return $wpse0001_excerpt;   

        }
        return apply_filters('wpse0001_custom_wp_trim_excerpt', $wpse0001_excerpt, $raw_excerpt);
    }

endif; 

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wpse0001_custom_wp_trim_excerpt');

function limit_text($text, $limit) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
}


// search filter
function fb_search_filter($query) {
if ( !$query->is_admin && $query->is_search) {
$query->set('post_type', array('press_release', 'page','post') ); // id of page or post
}
return $query;
}
add_filter( 'pre_get_posts', 'fb_search_filter' );

/*function list_searcheable_acf(){
  $list_searcheable_acf = array("title", "sub_title", "excerpt_short", "excerpt_long", "xyz", "myACF");
  return $list_searcheable_acf;
}
function advanced_custom_search( $where, &$wp_query ) {
    global $wpdb;
 
    if ( empty( $where ))
        return $where;
 
    // get search expression
    $terms = $wp_query->query_vars[ 's' ];
    
    // explode search expression to get search terms
    $exploded = explode( ' ', $terms );
    if( $exploded === FALSE || count( $exploded ) == 0 )
        $exploded = array( 0 => $terms );
         
    // reset search in order to rebuilt it as we whish
    $where = '';
    
    // get searcheable_acf, a list of advanced custom fields you want to search content in
    $list_searcheable_acf = list_searcheable_acf();
    foreach( $exploded as $tag ) :
        $where .= " 
          AND (
            (wp_posts.post_title LIKE '%$tag%')
            OR (wp_posts.post_content LIKE '%$tag%')
            OR EXISTS (
              SELECT * FROM wp_postmeta
	              WHERE post_id = wp_posts.ID
	                AND (";
        foreach ($list_searcheable_acf as $searcheable_acf) :
          if ($searcheable_acf == $list_searcheable_acf[0]):
            $where .= " (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
          else :
            $where .= " OR (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
          endif;
        endforeach;
	        $where .= ")
            )
            OR EXISTS (
              SELECT * FROM wp_comments
              WHERE comment_post_ID = wp_posts.ID
                AND comment_content LIKE '%$tag%'
            )
            OR EXISTS (
              SELECT * FROM wp_terms
              INNER JOIN wp_term_taxonomy
                ON wp_term_taxonomy.term_id = wp_terms.term_id
              INNER JOIN wp_term_relationships
                ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
              WHERE (
          		taxonomy = 'post_tag'
            		OR taxonomy = 'category'          		
            		OR taxonomy = 'myCustomTax'
          		)
              	AND object_id = wp_posts.ID
              	AND wp_terms.name LIKE '%$tag%'
            )
        )";
    endforeach;
    return $where;
}
 
add_filter( 'posts_search', 'advanced_custom_search', 500, 2 );*/

function cf_search_join( $join ) {
    global $wpdb;

    if ( is_search() ) {    
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    
    return $join;
}
add_filter('posts_join', 'cf_search_join' );

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function cf_search_where( $where ) {
    global $pagenow, $wpdb;
   
    if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }

    return $where;
}
add_filter( 'posts_where', 'cf_search_where' );

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );

add_filter( 'the_author', 'guest_author_name' );
add_filter( 'get_the_author_display_name', 'guest_author_name' );
 
function guest_author_name( $name ) {
global $post;
 
$author = get_post_meta( $post->ID, 'guest-author', true );
 
if ( $author )
 
$name = $author;
 
return $name;
}
