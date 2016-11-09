<?php

// Modified Theme class - mlouden - Oct 8 2014
class PlinthChild_Theme {

  const NAME = 'PlinthChild';

  const TEXTDOMAIN = 'PlinthChild';

  const VERSION = '0.1.0';

  const CSS_VERSION = 22;

  const JS_MAIN_VERSION = 14;

  const JS_PLUGINS_VERSION = 6;

  private static $instance = null;

  public static function getInstance() {
    if (null == self::$instance) {
      self::$instance = new self;
    }

    return self::$instance;
  }

  private function __construct() {
    $this->_setup_parent_overrides();
    $this->_add_image_sizes();
    add_action( 'plinth_dequeue_styles', array($this, 'dequeueStyles') );
    add_action( 'plinth_register_sidebars', array($this, 'registerSidebars') );
  }

  // TODO - extract the details of these methods into a data method so we don't duplicate the size names.
  private function _add_image_sizes() {
    if ( !function_exists('add_image_size') ) { return; }

    add_image_size('award-image', 115, 9999); // 115px wide, unlimited height
    add_image_size('award-image-retina', 230, 9999); // 115px @2x, unlimited height
    add_image_size('press-kit-thumb', 179, 179, true); // Cropped thumbnail for the press kit page
    add_image_size('product-layer-hero', 380, 9999); // 380px wide, unlimited height
    add_image_size('product-layer-hero-retina', 760, 9999); // 380px @2x, unlimited height
    add_image_size('publication-logo', 100, 80);

    add_filter('image_size_names_choose', array($this, 'exposeCustomSizes'), 10, 1);
  }

  function exposeCustomSizes($sizes) {
    return array_merge( $sizes, array(
      //'award-image' => __('Award Image'),
      //'award-image-retina' => __('Retina Award Image'),
      'press-kit-thumb' => __('Press Kit Thumbnail Image', self::TEXTDOMAIN),
      //'product-layer-hero' => __('Product Layer Hero Image', self::TEXTDOMAIN),
      //'product-layer-hero-retina' => __('Retina Product Layer Hero Image', self::TEXTDOMAIN),
    ) );
  }


  private function _setup_parent_overrides() {
    // Filter for Multisite setup to allow non super admins to edit
    // add_filter('plinth_allow_non_super_admins_to_edit_users', true);

    add_filter( 'plinth_css_version', array($this, 'cssVersion') );
    add_filter( 'plinth_js_main_version', array($this, 'jsMainVersion') );
    add_filter( 'plinth_js_plugins_version', array($this, 'jsPluginsVersion') );

    //add_filter( 'plinth_menus_to_register', array($this, 'menusToRegister') );

    // Filter to disable default Plinth sidebars and only register your own
    //add_filter( 'plinth_register_default_sidebars', '__return_false' );

    add_filter( 'plinth_fonts_css_args', array($this, 'fontsCSSArgs') );

    add_filter( 'plinth_child_prefix', array($this, 'childThemePrefix') );

    //add_filter( 'plinth_modernizr_args', array($this, 'modernizrArgs') );
    add_filter( 'plinth_jquery_args', array($this, 'jqueryArgs') );
    add_filter( 'plinth_js_plugins_args', array($this, 'jsPluginsArgs') );
    add_filter( 'plinth_js_main_args', array($this, 'jsMainArgs') );

    add_filter( 'plinth_style_formats', array($this, 'getStyleFormats') );
  }

  // CSS Version for far futures expiration
  function cssVersion($version) {
    return self::CSS_VERSION;
  }

  // JS Main Version for far futures expiration
  function jsMainVersion($version) {
    return self::JS_MAIN_VERSION;
  }

  // JS Plugins Version for far futures expiration
  function jsPluginsVersion($version) {
    return self::JS_PLUGINS_VERSION;
  }

  // Menus to register for site
  function menusToRegister($menus) {
    $menus = array(
      'mobile-nav' => __('Mobile Nav', self::TEXTDOMAIN),
      'toolbar' => __('Toolbar', self::TEXTDOMAIN),
      'cta-buttons' => __('CTA Buttons', self::TEXTDOMAIN),
      'main-nav' => __('Main Nav', self::TEXTDOMAIN),
      'secondary-nav' => __('Secondary Nav', self::TEXTDOMAIN),
      'footer' => __('Footer Nav', self::TEXTDOMAIN),
      'footer-links' => __('Footer Links', self::TEXTDOMAIN),
    );

    return $menus;
  }

  /**
   * Register sidebars
   *
   */
  function registerSidebars() {
    $news_sidebar_options = array_merge(
      array(
        'name' => __('News Sidebar'),
        'id'   => 'sidebar_news',
				'description'   => '',
        'class'         => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
      )
    );
    register_sidebar($news_sidebar_options);
    $pressrelease_sidebar_options = array_merge(
      array(
        'name' => __('Press Release Sidebar'),
        'id'   => 'sidebar_pressrelease',
        'description'   => '',
        'class'         => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
      )
    );
    register_sidebar($pressrelease_sidebar_options);
		$legal_sidebar_options = array_merge(
      array(
        'name' => __('Legal Sidebar'),
        'id'   => 'sidebar_legal',
        'description'   => '',
        'class'         => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
      )
    );
    register_sidebar($legal_sidebar_options);
  }

  // Supply a prefix for resources that are loaded in the parent theme but
  // sourced from the child theme.
  function childThemePrefix($prefix) {
    return self::NAME;
  }

  // Details for web fonts setup
  function fontsCSSArgs($args) {
    // No fonts by default
    return false;

    // Example for returning font setup
    /*
    $args = array(
      self::NAME . '-webfonts', // handle
      '//fast.fonts.net/cssapi/18c0c8e9-222a-4e3e-9956-4a2b3eb9c89b.css', // URL
      false, // dependencies
      '20130912', // version
    );

    return $args;
    */
  }


  // Allow overriding args to load mordernizr via wp_enqueue_script.
  //
  // Simply return false if you don't want to load modernizr
  function modernizrArgs($args) {
    return $args;

    // Override Example - must return at least 4 element array
    /*
    $modernizr_args = array(
      self::NAME . '-modernizr', // handle
      get_template_directory_uri() . '/js/libs/modernizr-2.7.1.min.js', // URL
      array(), // dependencies
      '2.7.1', // version
    );
    return $modernizr_args;
    */
  }

  // Allow overriding args to load jQuery via wp_enqueue_script.
  function jqueryArgs($args) {
    //return $args;

    // Override Example - must return at least 5 element array
    $jquery_args = array(
      'jquery', // handle
      get_stylesheet_directory_uri() . '/js/jquery.min.js', // 
      array(), // dependencies
      '1.11.0', // version
      true, // load at bottom
    );
    return $jquery_args;
    
  }

  // Allow overriding args to load plugins.js via wp_enqueue_script
  function jsPluginsArgs($args) {
    //return $args;

    // Override Example - must return at least 5 element array
    $js_plugins_args = array(
      $prefix . '-plugins-js',
      get_stylesheet_directory_uri() . '/js/plugins.' . self::JS_PLUGINS_VERSION . '.js',
      $js_deps,
      null,
      true,
    );
    return $js_plugins_args;
  }

  // Allow overriding args to load main.js via wp_enqueue_script
  function jsMainArgs($args) {
    //return $args;

    // Override Example - must return at least 5 element array
    $js_main_args = array(
      $prefix . '-main-js',
      get_stylesheet_directory_uri() . '/js/main.' . self::JS_MAIN_VERSION . '.js',
      $js_deps,
      null,
      true,
    );
    return $js_main_args;
  }

  /**
   * Specify style formats (classes) to be added to style select dropdown
   * in WYSIWYG.
   *
   * For format details see: http://codex.wordpress.org/TinyMCE_Custom_Styles#Using_style_formats
   *
   * If any empty array is returned (Plinth should pass in an empty array) no
   * style select dropdown is added to the WYSIWYG.
   */
  function getStyleFormats($style_formats) {
    $theme_style_formats = array(
      //array(
        //'title' => 'List Lead',
        //'selector' => 'p',
        //'classes' => 'list-lead',
      //),
      //array(
        //'title' => 'Quote',
        //'selector' => 'p',
        //'classes' => 'quote',
      //),
      //array(
        //'title' => 'Cite',
        //'selector' => 'p',
        //'classes' => 'cite',
      //),
      //array(
        //'title' => 'Boilerplate Heading',
        //'selector' => 'h3',
        //'classes' => 'press-release__boilerplate__heading',
      //),
      //array(
        //'title' => 'Alt Row',
        //'selector' => 'tr',
        //'classes' => 'alt',
      //),
      //array(
        //'title' => 'Heading Row',
        //'selector' => 'tr',
        //'classes' => 'heading-row',
      //),
      //array(
        //'title' => 'Heading Row Alt',
        //'selector' => 'tr',
        //'classes' => 'heading-row-alt',
      //),
    );
    $style_formats = array_merge($style_formats, $theme_style_formats);
    return $style_formats;
  }

  /*
   * Add wp_dequeue_style calls to dequeue unneeded plugin styles.
   */
  public function dequeueStyles() {
    // page-list - used for site map
    wp_dequeue_style('page-list-style');
  }

}

function custom_excerpt_length( $length ) {
  return 55;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

add_filter('wp_list_categories', 'cat_count_span_inline');
function cat_count_span_inline($output) {
  $output = str_replace('</a> (','<span class="article-count"> ',$output);
  $output = str_replace(')','</span></a> ',$output);
  return $output;
}
