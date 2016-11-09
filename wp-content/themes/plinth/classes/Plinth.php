<?php

/**
 * Plinth class file.
 */

require_once get_template_directory() . '/classes/Plinth_Util.php';
require_once get_template_directory() . '/classes/Plinth_TagHelpers.php';
require_once get_template_directory() . '/classes/AtreNet_Util.php';

/**
 * Base class for theme development helpers.
 *
 * The Plinth class contains many standard methods methods and functions
 * to make it easier to build a WordPress theme.
 *
 * @package Plinth
 */

class Plinth {

  // Theme name
  const NAME = 'plinth';

  // Theme version
  const VERSION = '0.1.0';

  const TEXTDOMAIN = 'plinth';

  const CSS_VERSION = 1;

  const JS_PLUGINS_VERSION = 1;

  const JS_MAIN_VERSION = 1;


  /**
   * Reference to the navigation menu items
   *
   * @var array
   */
  private $secondary_nav_menu_items = array();

  /**
   * Reference to the footer navigation menu items
   *
   * @var array
   */
  private $footer_nav_menu_items = array();

  /**
   * Navigation menu item corresponding to the current post
   *
   * @var mixed
   */
  private $current_menu_item = null;

  /**
   * Navigation menu item corresponding to the parent menu item of the current post
   *
   * @var mixed
   */
  private $parent_menu_item = null;

  /**
   * Current post ID
   *
   * @var mixed
   */
  private $current_post_id = false;

  /**
   * Single instance of class
   * @see http://wp.tutsplus.com/tutorials/creative-coding/design-patterns-in-wordpress-the-singleton-pattern/
   * @var object
   */
  private static $instance = null;

  /**
   * Return single instance of this class
   *
   * @return object
   */
  public static function getInstance() {
    if (null == self::$instance) {
      self::$instance = new self;
    }

    return self::$instance;
  }

  /**
   * Constructor
   *
   */
  private function __construct() {
    $this->_clean_wordpress_header_bits();
    $this->_setup_resources();
    $this->_customize_wordpress_output();
    $this->_setup_menus();
    $this->_setup_sidebars();
    //$this->_setup_widgets();
    $this->_customize_editor();
    $this->_setup_user_editing();
    $this->_add_theme_support();
    $this->_add_shortcodes();
    $this->_customize_wordpress_behavior();
	$this->_setup_breadcrumb_behavior();
    $this->_setup_acf_behavior();
    $this->_setup_ramp_support();
    $this->_setup_xml_sitemap_url_fix();

    if ( is_admin() ) {
      $this->_customize_wordpress_admin();
    }
  }

  /**
   * Remove existing action hooks.
   *
   * This is mostly to hide unneeded bits and WordPress version for a cleaner site.
   *
   */
  private function _clean_wordpress_header_bits() {
    remove_action( 'wp_head', 'feed_links_extra', 3 ); // Don't display the links to the extra feeds such as category feeds
    remove_action( 'wp_head', 'feed_links', 2 ); // Don't display the links to the general feeds: Post and Comment Feed
    remove_action( 'wp_head', 'rsd_link' ); // Don't display the link to the Really Simple Discovery service endpoint, EditURI link
    remove_action( 'wp_head', 'wlwmanifest_link' ); // Don't display the link to the Windows Live Writer manifest file.
    remove_action( 'wp_head', 'index_rel_link' ); // index link
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
    remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
    remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
    remove_action( 'wp_head', 'wp_generator' ); // Don't display the XHTML generator that is generated on the wp_head hook, WP version
  }

  /**
   * Setup CSS and JS resources.
   */
  private function _setup_resources() {
    add_action( 'wp_enqueue_scripts', array($this, 'enqueScripts') );
    add_action( 'wp_print_styles', array($this, 'dequeueStyles'), 100 );
    add_filter( 'wp_default_scripts', array($this, 'dequeueJQuery'), 10, 1 );
    add_filter( 'stylesheet_uri', array($this, 'addCSSVersion'), 10, 2 );
  }

  /**
   * Customize various bits of the WordPress output.
   */
  private function _customize_wordpress_output() {
    add_filter('admin_head', array($this, 'hidePreviewButton'), 1);
    add_filter('wp_nav_menu_objects', array($this, 'addFirstLastMenuClasses'), 10, 1);
    add_filter('excerpt_more', array($this, 'excerptMore'), 10, 1);
    add_filter('excerpt_length', array($this, 'excerptLength'), 10, 1);
    add_filter('body_class', array($this, 'addBodyClasses'), 10, 1);
    add_filter('widget_tag_cloud_args', array($this, 'customizeTagCloudArgs'), 10, 1);
  }

  /**
   * Customize behavior in WordPress
   */
  private function _customize_wordpress_behavior() {
    add_filter('wp_prepare_attachment_for_js', array($this, 'hideTiffThumbnails'), 10, 3);
    add_filter('upload_mimes', array($this, 'allowAdditionalMimeTypes'), 10, 1);
    add_action( 'init', array($this, 'updateOptions') );
  }

  /**
   * Register menus in WordPress.
   */
  private function _setup_menus() {
    add_action( 'init', array($this, 'registerMenus') );
  }

  /**
   * Register sidebars in WordPress
   */
  private function _setup_sidebars() {
    add_action( 'widgets_init', array($this, 'registerSidebars') );
  }

  //private function _setup_widgets() {
    //add_action( 'widgets_init', array($this, 'setupWidgets') );
  //}

  /**
   * Customize the WYSIWYG editor.
   */
  private function _customize_editor() {
    add_action( 'init', array($this, 'addEditorStyles') );
    add_filter( 'mce_buttons_2', array($this, 'addEditorStyleDropdown') );
    add_filter( 'tiny_mce_before_init', array($this, 'mceBeforeInit'), 10, 1 );
  }

  /**
   * Setup some more advanced user editing. Probably only useful on a multisite.
   *
   * @filter 'plinth_allow_non_super_admins_to_edit_users'
   */
  private function _setup_user_editing() {
    /**
     * Filter: 'plinth_allow_non_super_admins_to_edit_users' - Allow child theme to enable a non-superadmin
     * to edit users
     *
     * @api  bool  $enable  Flag to enable or not - defaults to false (don't enable)
     */
    $enable = apply_filters('plinth_allow_non_super_admins_to_edit_users', false);

    if ($enable) {
      // By default, WP treats hostnames that resolve to internal IP addresses as
      // invalid which makes RAMP deploys fail.
      // This filter forces WP to treat "internal" hostnames as external.
      // Refer to: http://wordpress.stackexchange.com/questions/123307/how-do-i-use-the-http-request-host-is-external-filter
      //      and: http://steadman.io/blog/tag/wp_http_validate_url/
      add_filter('http_request_host_is_external', '__return_true');

      // Enable non-SuperAdmins to edit users with the right capabilities
      // http://thereforei.am/2011/03/15/how-to-allow-administrators-to-edit-users-in-a-wordpress-network/
      add_filter('map_meta_cap', array($this, 'adminUsersCaps'), 1, 4);
      remove_all_filters('enable_edit_any_user_configuration');
      add_filter('enable_edit_any_user_configuration', '__return_true');
      // Make sure non-SuperAdmins can't edit SuperAdmins
      add_filter('admin_head', array($this, 'editPermissionCheck'), 1, 4);
    }
  }

  /**
   * Add hooks to help with RAMP support
   */
  private function _setup_ramp_support() {
    // Update post_modified value on post-types-order save to trigger RAMP
    add_filter('post-types-order_save-ajax-order', array($this, 'addPostModified'), 10, 3);
  }

	/**
   * Alter breadcrumb behavior
   */
  private function _setup_breadcrumb_behavior() {
    //add_filter('wpseo_breadcrumb_links', array($this, 'customizeBreadcrumbs'), 10, 1);
  }

  /**
   * Add hooks to help with XML sitemap
   */
  private function _setup_xml_sitemap_url_fix() {
    add_filter( 'wpseo_xml_sitemap_post_url', array($this, 'fixXmlSitemapUrl'), 10, 2 );
  }

  /**
   * Add hooks to customize the WordPress admin interface.
   */
  private function _customize_wordpress_admin() {
    if ( is_admin() ) {
      add_action( 'manage_edit-page_columns', array($this, 'updatePageColumnsInAdmin') );
      add_action( 'manage_pages_custom_column', array($this, 'setPageColumnContentInAdmin'), 10, 2 );
    }
  }

  /**
   * Fix the site map URL in case root relative urls has made it non-absolute.
   *
   * Without this fix, the post type site maps are served with a 200 status code but the File not Found content.
   *
   * @since 0.1.0
   *
   * @uses home_url()
   *
   * @param  string  $url  The URL for a sitemap link
   * @param  object  $post  Post object for the URL
   *
   * @return string
   */
  public function fixXmlSitemapUrl($url, $post) {
    if ( 'http' !== substr($url, 0, 4) ) {
      $url = home_url($url);
    }
    return $url;
  }

  /**
   * Add additional columns to the Page list in the WP Admin.
   *
   * By default, adds a column for Template.
   *
   * Based on: http://www.elliotcondon.com/advanced-custom-fields-admin-custom-columns/
   *
   * @since 0.1.0
   *
   * @uses AtreNet_Util::insertAfterKey()
   *
   * @filter 'plinth_page_columns'
   *
   * @param  array  $columns  Array of current columns
   *
   * @return  array  Modified columns array
   */
  public function updatePageColumnsInAdmin($columns) {
    $template_column = array( 'template' => 'Template' );
    $columns = AtreNet_Util::insertAfterKey($columns, 'title', $template_column);

    /**
     * Filter: 'plinth_page_columns' - Allow child theme to change columns.
     *
     * @since 0.1.0
     *
     * @api  array  $columns  Array of columns to show
     */
    return apply_filters('plinth_page_columns', $columns);
  }

  /**
   * Output the value for a custom column in the Page list in the WP
   * Admin.
   *
   * Outputs Template column value by default.
   *
   * Based on: http://www.elliotcondon.com/advanced-custom-fields-admin-custom-columns/
   *
   * @since 0.1.0
   *
   * @uses get_post_meta
   *
   * @action 'plinth_page_column_value'
   *
   * @param  string  $column  Name of custom column as registered in
   *   updatePageColumnsInAdmin()
   * @param  int  $post_id  The id of the Page in the current row
   *
   * @return void
   */
  public function setPageColumnContentInAdmin($column, $post_id) {
    if ($column == 'template') {
      $single = true;
      $template_file = get_post_meta($post_id, '_wp_page_template', $single);
      echo $this->getNameForTemplateFile($template_file);
    }

    /**
     * Action: 'plinth_page_column_value' - Allow child theme to output value(s) for custom Page column.
     *
     * @since 0.1.0
     *
     * @param  string  $column  Column name
     * @param  int  $post_id  The post ID
     */
    do_action('plinth_page_column_value', $column, $post_id);
  }

  /**
   * Get the name of a template based on the template file.
   *
   * @since 0.1.0
   *
   * @uses get_page_templates() and caches lookup
   *
   * @param  string  $template_file  Template file name such as value
   *   for _wp_page_template meta key
   *
   * @return  string  The template name
   */
  public function getNameForTemplateFile($template_file) {
    static $template_lookup;
    if (is_null($template_lookup)) {
      $templates = get_page_templates();
      foreach ($templates as $template_name => $template_filename) {
        $template_lookup[$template_filename] = $template_name;
      }
    }

    if ( isset($template_lookup[$template_file]) ) {
      return $template_lookup[$template_file];
    }

    // Probably default - make more readable
    return ucfirst($template_file);
  }


  /**
   * Provide some custom ACF behavior.
   *
   * @placeholder
   */
  private function _setup_acf_behavior() {
    //add_action( 'acf/save_post', array($this, 'getVideoDetails'), 15, 2 );
    //add_filter('acf/fields/relationship/result/name=related_resources', array($this, 'relatedResourcesResult'), 10, 4);
    //add_filter('acf/fields/relationship/query/name=customers_with_quotes', array($this, 'customersWithQuotesQuery'), 10, 3);
    //add_filter('acf/fields/relationship/query/name=case_study', array($this, 'caseStudyQuery'), 10, 3);
  }

  /**
   * Register support of certain theme features.
   *
   * @since 0.0.3
   *
   * @action 'plinth_add_theme_support'
   *
   * @return void
   */
  private function _add_theme_support() {
    if ( !function_exists('add_theme_support') ) { return; }

    add_theme_support('menus');

    /**
     * Action: 'plinth_add_theme_support' - Allow child themes to add additional theme support items.
     *
     * @since 0.0.3
     *
     * @param none
     */
    do_action('plinth_add_theme_support');
  }


  /**
   * Register shortcodes.
   */
  private function _add_shortcodes() {
    add_shortcode('wp_caption', array($this, 'fixImageCaption'));
    add_shortcode('caption', array($this, 'fixImageCaption'));
  }

  /**
   * Helper to handle basically unversioned code when running in development.
   *
   * Since we are using far futures expirations[1], this verison number is used
   * to easily expire the cache. However, when we're in development we don't
   * want to mess with changing this constantly.
   *
   * This function returns time() as the "version number" if in development
   * (WP_DEBUG === true) and the passed in $version if not.
   *
   * [1] https://developer.yahoo.com/performance/rules.html#expires
   *
   * @since 0.0.3
   *
   * @param  int  $version   Version number
   *
   * @returns  int  dev-aware $version
   */
  public static function versionWithDebugCheck($version) {
    if (true === WP_DEBUG) {
      return time();
    }
    return $version;
  }

  /**
   * Get CSS version.
   *
   * @since 0.0.3
   *
   * @filter 'plinth_css_version'
   *
   * @return  int  CSS Version
   */
  private static function _css_version() {
    return self::versionWithDebugCheck(
    /**
     * Filter: 'plinth_css_version' - Allow child theme to change the CSS version number for far-futures expiration.
     *
     * This is only used when WP_DEBUG is disabled.
     *
     * @since 0.0.3
     *
     * @api  int  $version  CSS Version
     */
      apply_filters('plinth_css_version', self::CSS_VERSION)
    );
  }

  /**
   * Get JS Plugins file version.
   *
   * @since 0.0.3
   *
   * @filter 'plinth_js_plugins_version'
   *
   * @return  int  JS Plugin Version
   */
  private static function _js_plugins_version() {
    return self::versionWithDebugCheck(
    /**
     * Filter: 'plinth_js_plugins_version' - Allow child theme to change the JS Plugins version number for far-futures expiration.
     *
     * This is only used when WP_DEBUG is disabled.
     *
     * @since 0.0.3
     *
     * @api  int  $version  JS Plugins Version
     */
      apply_filters('plinth_js_plugins_version', self::JS_PLUGINS_VERSION)
    );
  }

  /**
   * Get JS Main file version.
   *
   * @since 0.0.3
   *
   * @filter 'plinth_js_main_version' to change JS Main Version
   *
   * @return  int  JS Plugin Version
   */
  private static function _js_main_version() {
    return self::versionWithDebugCheck(
      /**
       * Filter: 'plinth_js_main_version' - Allow child theme to change the JS Main version number for far-futures expiration.
       *
       * This is only used when WP_DEBUG is disabled.
       *
       * @since 0.0.3
       *
       * @api  int  $version  JS Main Version
       */
      apply_filters('plinth_js_main_version', self::JS_MAIN_VERSION)
    );
  }

  /**
   * Add a version number to the main CSS include to support
   * cache-busting with far-futures expirations.
   *
   * @see  WordPress Hook 'stylesheet_uri'
   *
   * @since 0.0.3
   *
   * @param  string  $stylesheet_uri  Stylesheet URI for the current theme/child theme.
   * @param  string  $stylesheet_dir_uri  Stylesheet directory for the current theme/child theme.
   *
   * @return string  $stylesheet_uri
   */
  public function addCSSVersion($stylesheet_uri, $stylesheet_dir_uri) {
    if ( '.css' === substr($stylesheet_uri, -4) ) {
      $stylesheet_uri = substr($stylesheet_uri, 0, strlen($stylesheet_uri) - 3) . self::_css_version() . '.css';
    }
    return $stylesheet_uri;
  }

  /**
   * Shortcode helper method to get rid of hard-coded widths on captions.
   *
   * @see WordPress Hooks 'wp_caption' and 'caption'
   *
   * @since 0.0.3
   *
   * @filter 'img_caption_shortcode'
   *
   * @param  array  $attr  Array of attributes
   * @param  string  $content  Content of shortcode
   *
   * @return string  HTML for image with caption
   */
  public function fixImageCaption($attr, $content = null) {
    if ( !isset($attr['caption']) ) {
      if ( preg_match('#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches) ) {
        $content = $matches[1];
        $attr['caption'] = trim($matches[2]);
      }
    }
    $output = apply_filters('img_caption_shortcode', '', $attr, $content);
    if ($output != '') {
      return $output;
    }

    extract(
      shortcode_atts(
        array(
          'id' => '',
          'align' => 'alignnone',
          'width' => '',
          'caption' => '',
        ),
        $attr
      )
    );
    if (
        1 > (int) $width
        || empty($caption)
    ) {
      return $content;
    }
    if ($id) {
      $id = 'id="' . esc_attr($id) . '"';
    }

    return '<div ' . $id . ' class="wp-caption ' . esc_attr($align) . '">' . do_shortcode($content) . '<p class="wp-caption-text">' . $caption . '</p></div>';
  }


  // ==============================================
  // Actions
  // ==============================================

  /**
   * Dequeue styles from plugins we don't need.
   *
   * @since 0.0.3
   */
  public function dequeueStyles() {
    do_action('plinth_dequeue_styles');
  }

  /**
   * Load custom CSS for the WYSIWYG so we can expose some styles in the editor.
   *
   * @since 0.0.3
   */
  public function addEditorStyles() {
    add_editor_style('custom-editor-style.css');
  }

  /**
   * Enqueue CSS and JavaScript for loading
   *
   * Child theme can change script loading behavior via filters.
   *
   * @since 0.0.3
   *
   * @filter 'plinth_fonts_css_args'
   * @filter 'plinth_child_prefix'
   * @filter 'plinth_modernizr_args'
   * @filter 'plinth_jquery_args'
   * @filter 'plinth_js_plugin_args'
   * @filter 'plinth_js_main_args'
   *
   * @uses wp_enqueue_style
   * @uses wp_enqueue_script
   * @uses get_stylesheet_uri
   * @uses get_stylesheet_directory_uri
   * @uses AtreNet_Util::isArray
   *
   */
  public function enqueScripts() {
    // CSS
    /**
     * Filter: 'plinth_fonts_css_args' - Allow child theme to specify args to load CSS for fonts
     *
     * @since 0.0.3
     *
     * @see child_theme/classes/Child_Theme.php for example usage
     *
     * @api  array  $fonts_css_args  Array of args for wp_enqueue_style - defaults to empty array (no fonts)
     */
    $fonts_css_args = apply_filters( 'plinth_fonts_css_args', array() );
    $css_deps = array();
    if ( AtreNet_Util::isArray($fonts_css_args, 2) ) {
      call_user_func_array('wp_enqueue_style', $fonts_css_args);
      $css_deps[]= $fonts_css_args[0];
    }

    /**
     * Filter: 'plinth_child_prefix' - Allow child theme to override prefix used in handle when enqueueing style.css to avoid handle collisions.
     *
     * @since 0.0.3
     *
     * @see child_theme/classes/Child_Theme.php for example usage
     *
     * @api  string  $prefix  Defaults to Plinth::NAME
     */
    $prefix = apply_filters( 'plinth_child_prefix', self::NAME );
    wp_enqueue_style( $prefix . '-style', get_stylesheet_uri(), $css_deps, null );



    // JS

    // Setup Modernizr but allow overrides
    $modernizr_args = array(
      self::NAME . '-modernizr', // handle
      get_template_directory_uri() . '/js/libs/modernizr-2.8.3.min.js', // URL
      array(), // dependencies
      '2.8.1', // version
    );

    /**
     * Filter: 'plinth_modernizr_args' - Allow child theme to change args to wp_enqueue_script for loading modernizr.
     *
     * Can return false to disable Modernizr
     *
     * @since 0.0.3
     *
     * @api  array|false  $modernizr_args  Array of args for enqueuing modernizr
     */
    $modernizr_args = apply_filters( 'plinth_modernizr_args', $modernizr_args );
    if ( AtreNet_Util::isArray($modernizr_args, 4) ) {
      call_user_func_array('wp_enqueue_script', $modernizr_args);
    }



    // Setup jQuery but allow overrides
    $jquery_args = array(
      'jquery', // handle
      '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', // URL
      array(), // dependencies
      '1.11.0', // version
      true, // load at bottom
    );

    /**
     * Filter: 'plinth_jquery_args' - Allow child theme to change args to wp_enqueue_script for loading jQuery
     *
     * Can return false to disable jQuery (not advised)
     *
     * @since 0.0.3
     *
     * @api  array|false  $jquery_args  Array of args for enqueuing jQuery
     */
    $jquery_args = apply_filters( 'plinth_jquery_args', $jquery_args );
    $js_deps = array();
    if ( AtreNet_Util::isArray($jquery_args, 5) ) {
      call_user_func_array('wp_enqueue_script', $jquery_args);
      $js_deps[]= $jquery_args[0];
    }
    // TODO - implement local fallback based on this: https://gist.github.com/wpsmith/4083811 (use transients)



    // Plugins
    $js_plugins_args = array(
      $prefix . '-plugins-js',
      get_stylesheet_directory_uri() . '/js/plugins.' . self::_js_plugins_version() . '.js',
      $js_deps,
      null,
      true,
    );

    /**
     * Filter: 'plinth_js_plugins_args' - Allow child theme to change args to wp_enqueue_script for loading plugins JavaScript.
     *
     * Can return false to disable loading plugins.js (not advised)
     *
     * @since 0.0.3
     *
     * @api  array|false  $js_plugins_args  Array of args for enqueuing plugins.js
     */
    $js_plugins_args = apply_filters( 'plinth_js_plugins_args', $js_plugins_args );
    if ( AtreNet_Util::isArray($js_plugins_args, 5) ) {
      call_user_func_array('wp_enqueue_script', $js_plugins_args);
      $js_deps[]= $js_plugins_args[0];
    }



    // Main Script
    $js_main_args = array(
      $prefix . '-main-js',
      get_stylesheet_directory_uri() . '/js/main.' . self::_js_main_version() . '.js',
      $js_deps,
      null,
      true,
    );

    /**
     * Filter: 'plinth_js_main_args' - Allow child theme to change args to wp_enqueue_script for loading main JavaScript.
     *
     * Can return false to disable loading main.js (not advised)
     *
     * @since 0.0.3
     *
     * @api  array|false  $js_main_args  Array of args for enqueuing main.js
     */
    $js_main_args = apply_filters( 'plinth_js_main_args', $js_main_args );
    if ( AtreNet_Util::isArray($js_main_args, 5) ) {
      call_user_func_array('wp_enqueue_script', $js_main_args);
    }
  }

  /**
   * Hide admin bar for non-admins
   *
   * @since 0.0.3
   *
   * @uses show_admin_bar
   *
   * @return void
   */
  public function hideAdminBar() {
    if ( current_user_can('administrator') || is_admin() ) {
      // Show bar
    } else {
      // Hide bar
      show_admin_bar(false);
    }
  }

  /**
   * Register navigation menus
   *
   * @since 0.0.3
   *
   * @uses register_nav_menus()
   *
   * @filter 'plinth_menus_to_register'
   *
   * @return void
   */
  public function registerMenus() {
    $menus = array(
      'mobile-nav' => __('Mobile Nav', self::TEXTDOMAIN),
      'toolbar' => __('Toolbar Nav', self::TEXTDOMAIN),
      'cta-buttons' => __('CTA Buttons', self::TEXTDOMAIN),
      'main-nav' => __('Main Nav', self::TEXTDOMAIN),
      'secondary-nav' => __('Secondary Nav', self::TEXTDOMAIN),
      'footer' => __('Footer Nav', self::TEXTDOMAIN),
      'footer-links' => __('Footer Links', self::TEXTDOMAIN),
    );

    /**
     * Filter: 'plinth_menus_to_register' - Allow child theme to change menus to register.
     *
     * @since 0.0.3
     *
     * @api array $menus Array of menus to be passed to register_nav_menus()
     */
    $menus = apply_filters('plinth_menus_to_register', $menus);
    register_nav_menus($menus);
  }

  /**
   * Standard options for a sidebar.
   *
   * @since 0.0.3
   *
   * @return array options to be passed to register_sidebar()
   */
  public static function defaultSidebarOptions() {
    return array(
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
      );
  }

  /**
   * Register sidebars
   *
   * @since 0.0.3
   *
   * @uses register_sidebar()
   *
   * @filter 'plinth_register_default_sidebars'
   * @action 'plinth_register_sidebars'
   *
   * @return void
   */
  public function registerSidebars() {
    /**
     * Filter: 'plinth_register_sidebars' - Flag to let child themes stop default Plinth sidebars from being setup
     *
     * @since 0.0.3
     *
     * @api  bool  $setup_default_sidebars  Defaults to true
     */
    $setup_default_sidebars = apply_filters('plinth_register_default_sidebars', true);
    if ($setup_default_sidebars) {
      $main_sidebar_options = array_merge(
        self::defaultSidebarOptions(),
        array(
          'name' => __('Main Sidebar'),
          'id'   => 'sidebar_right',
        )
      );
      register_sidebar($main_sidebar_options);

      $blog_sidebar_options = array_merge(
        self::defaultSidebarOptions(),
        array(
          'name' => __('Blog Sidebar'),
          'id'   => 'sidebar_blog',
        )
      );
      register_sidebar($blog_sidebar_options);
    }

    /**
     * Action: 'plinth_register_sidebars' - Allow child themes to register sidebars
     *
     * @since 0.0.3
     */
    do_action('plinth_register_sidebars');
  }


  /**
   * Update WordPress options
   *
   * @since 0.0.3
   *
   * @uses update_option
   *
   * @return void
   */
  public function updateOptions() {
    update_option('image_default_link_type', 'none');
  }

  // ==============================================
  // Filters
  // ==============================================


  /**
   * Let users who are admin (but not super admin) edit other users on multisite.
   *
   * @since 0.4.0
   *
   * @see WordPress Hook 'map_meta_cap'
   *
   * @param  array  $caps  Array of user's actual capabilities
   * @param  string  $cap  Capability name
   * @param  int  $user_id  The User ID
   * @param  array  $args  Adds the context to the cap. Typically the object ID.
   *
   * @return  array  $caps
   */
  function adminUsersCaps($caps, $cap, $user_id, $args) {
    foreach ($caps as $key => $capability) {
      if ($capability != 'do_not_allow') {
        continue;
      }

      switch ($cap) {
        case 'edit_user':
        case 'edit_users':
          $caps[$key] = 'edit_users';
          break;
        case 'delete_user':
        case 'delete_users':
          $caps[$key] = 'delete_users';
          break;
        case 'create_users':
          $caps[$key] = $cap;
          break;
      }
    }

    return $caps;
  }

  /**
   * Ensure that non-SuperAdmins cannot edit SuperAdmins
   *
   * @since 0.4.0
   *
   * @uses $current_user
   * @uses $profile_user
   * @uses get_current_screen()
   * @uses get_currentuserinfo()
   * @uses is_super_admin()
   * @uses is_member_of_blog()
   * @uses get_current_blog_id()
   *
   * @return void
   */
  function editPermissionCheck() {
    global $current_user, $profile_user;

    $screen = get_current_screen();
    get_currentuserinfo();

    if ( !is_super_admin($current_user->ID) && in_array($screen->base, array('user-edit', 'user-edit-network')) ) { // editing a user profile
      if ( is_super_admin($profile_user->ID) ) { // trying to edit a superadmin while less than a superadmin
        wp_die( __('You do not have permission to edit this user.') );
      } else if (
        !(
          is_user_member_of_blog($profile_user->ID, get_current_blog_id())
          && is_user_member_of_blog($current_user->ID, get_current_blog_id())
        )
      ) { // editing user and edited user aren't members of the same blog
        wp_die( __('You do not have permission to edit this user.') );
      }
    }
  }

  /**
   * Hide the preview button if we have RAMP enabled because it causes issues with WPML.
   *
   * @since 0.4.0
   *
   * @uses is_plugin_active()
   *
   * @return void
   */
  function hidePreviewButton() {
    if (is_plugin_active('ramp')) {
      echo '<style>#minor-publishing-actions{display:none!important}</style>';
    }
  }

  /**
   * Mark posts that are modified by re-ordering so that the changes are
   * noticed and deployable with RAMP.
   *
   * @see  Post Types Order plugin Hook 'post-types-order_save-ajax-order'
   *
   * @since 0.0.3
   *
   * @param  array  $data  Array of data to update for a post
   * @param  string  $key
   * @param  int  $id  ID of post being ordered
   *
   * @return  array  $data
   */
  function addPostModified($data, $key, $id) {
    global $wpdb;

    $new_position = $data['menu_order'];
    $query = sprintf('SELECT menu_order FROM %s WHERE ID = %d', $wpdb->posts, $id);
    $old_position = $wpdb->get_var($query);
    if ($new_position != $old_position) {
      $data['post_modified'] = current_time('mysql');
    }
    return $data;
  }


  /**
   * Dequeu the standard WordPress jQuery so we can add our own for the main site.
   *
   * @since 0.0.3
   *
   * @see WordPress Hook 'wp_default_scripts'
   *
   * @param  object  $scripts  WP_Scripts instance, passed by reference
   *
   * @return void
   */
  function dequeueJQuery($scripts) {
    if ( !is_admin() ) {
      $scripts->remove('jquery');
    }
  }

  /**
   * Don't try to show TIFF thumbnails in admin because they're too big.
   *
   * @since 0.4.0
   *
   * @see https://gist.github.com/benhuson/5134174
   *
   * @see WordPress Hook 'wp_prepare_attachment_for_js'
   *
   * @param  array  $response  Array of prepared attachment data
   * @param  int|object  $attachment  Attachment ID or object
   * @param  array|object  $meta  Array of attachment meta data
   *
   * @return array  $response
   */
  function hideTiffThumbnails($response, $attachment, $meta) {
    $tiff_image_subtypes = array('tiff', 'tif');
    if ( is_admin() && $response['type'] == 'image' && in_array($response['subtype'], $tiff_image_subtypes) ) {
      $response['type'] = 'application';
    }
    return $response;
  }

  /**
   * Add additional mime types - mainly to allow upload of apk files.
   *
   * Only grants ability to admins.
   *
   * @since 0.4.0
   *
   * @see WordPress Hook 'upload_mimes'
   *
   * @uses user_can()
   * @uses current_user_can()
   *
   * @filter 'plinth_allow_additional_mime_types'
   *
   * @param  array  $mimes  Mime types keyed by the file extension corresponding to those types.
   * @param  int|WP_User|null  $user  User ID, User object, or null if not provided (indicates current user)
   *
   * @return array  $mimes
   */
  public function allowAdditionalMimeTypes($mimes, $user = null) {
    // Don't let just anyone upload apk files
    if ( function_exists('current_user_can') ) {
      // Administrators can do this on single and multi-sites:
      //   http://codex.wordpress.org/Roles_and_Capabilities#Capability_vs._Role_Table
      $unfiltered = isset($user) ? user_can($user, 'activate_plugins') : current_user_can('activate_plugins');
    }
    if ( !empty($unfiltered) ) {
      $mimes['apk'] = 'application/vnd.android.package-archive';
      $mimes['eps'] = 'application/postscript';

      // TODO Add example usage of 'plinth_allow_additional_mime_types' to child theme
      /**
       * Filter: 'plinth_allow_additional_mime_types' - Allow child theme to add additional mime types to be uploaded.
       *
       * Only called if user is Admin - no need to check permissions in filter.
       *
       * @api  array  $mimes  Mime types keyed by file extension
       *
       */
      $mimes = apply_filters('plinth_allow_additional_mime_types', $mimes);
    }

    return $mimes;
  }

  /**
   * Do some setup for WYSIWYG Editor
   *
   * Adds classes to the style select if there are any available.
   *
   * @since 0.4.0
   *
   * @uses $this->getStyleFormats() to get styles to add
   *
   * @param  array  $init_array  Array of MCE init details
   *
   * @return array $init_array
   */
  public function mceBeforeInit($init_array) {
    $style_formats = $this->getStyleFormats();
    if ( count($style_formats) > 0 ) {
      $init_array['style_formats'] = json_encode($style_formats);
    }
    return $init_array;
  }


  /**
   * Add a Formats dropdown to the WYSIWYG to facilitate letting the editor
   * pick classes to apply to elements.
   *
   * Dropdown is only added if there are styles to add.
   *
   * @since 0.4.0
   *
   * @uses $this->getStyleFormats() to check for styles.
   *
   * @param  array  $buttons  Array of buttons
   *
   * @return array
   */
  public function addEditorStyleDropdown($buttons) {
    // Only add the style dropdown if we have styles to populate it
    $style_formats = $this->getStyleFormats();
    if ( count($style_formats) > 0 ) {
      array_unshift($buttons, 'styleselect');
    }
    return $buttons;
  }

  /**
   * Get a struct of styles to include in the formats dropdown.
   *
   * @since 0.4.0
   *
   * @filter 'plinth_style_formats'
   *
   * @return array
   */
  public function getStyleFormats() {
    $style_formats = array();

    /**
     * Filter: 'plinth_style_formats' - Allow child theme to specify formats to add
     *
     * @see child_theme/classes/Child_Theme.php for example usage
     *
     * @api  array  $style_formats  initially empty array of formats
     */
    $style_formats = apply_filters('plinth_style_formats', $style_formats);
    return $style_formats;
  }

  //public function caseStudyQuery($args, $field, $post) {
    //$args['meta_query'] = array(array(
      //'key'   => 'document_type',
      //'value' => 'case-study',
    //));
    //return $args;
  //}

  //public function customersWithQuotesQuery($args, $field, $post) {
    //$args['meta_query'] = array(
      //array(
        //'key' => 'quote_0_quote_text',
        //'value' => '',
        //'compare' => '!=',
      //)
    //);
    //return $args;
  //}

  //public function relatedResourcesResult($result, $object, $field, $post) {
    //$document_type = get_field('document_type', $object->ID);
    //$result .= sprintf(' (%s)', $document_type);
    //return $result;
  //}

  /**
   * Add CSS classes to <body>
   *
   * @since 0.0.3
   *
   * @param array $classes Array of CSS class names to be added to <body> element
   *
   * @return array
   */
  public function addBodyClasses($classes) {
    global $post;

    //if(self::isBlogCurrentSite()) {
      //$classes[] = 'blog';
    //}

    if($post) {
      $classes[] = sanitize_html_class($post->post_type . '-' . $post->post_name);
    }

    // TODO Add handler for nicer class names if templates are in a subdir
    // TODO Add support for page_type body class from Pramata

    return $classes;
  }

  /**
   * Add first/last CSS classes to navigation menu items
   *
   * @since 0.0.3
   *
   * @param array $items Navigation menu items
   *
   * @return array Navigation menu items with first/last CSS classes
   */
  public function addFirstLastMenuClasses($items) {
    $nav_lookup_tree = $this->build_navigation_lookup_tree($items);
    foreach ($nav_lookup_tree as $menu_item_parent => $keys) {
      $items[$keys[0]]->classes[]= 'first';
      $items[$keys[count($keys) - 1]]->classes[]= 'last';
    }
    return $items;
  }

  /**
   * Since $items holds all nav items in a list, we need to turn it into a
   * hierarchy so we can correctly mark first/last items.
   *
   * @since 0.0.3
   *
   * @param array $items Navigation menu items
   *
   * @return array Hierarchical list of navigation menu items
   */
  private function build_navigation_lookup_tree($items) {
    $tree = array();
    foreach ($items as $key => $item) {
      $menu_item_parent = $item->menu_item_parent;
      if ( !array_key_exists($menu_item_parent, $tree) ) {
        $tree[$menu_item_parent] = array();
      }
      $tree[$menu_item_parent][]= $key;
    }
    return $tree;
  }

  /**
   * Customize arguments used for generating the tag cloud widget.
   *
   * Child theme should override to change value.
   *
   * @since 0.0.3
   *
   * @param array $args Array of arguments passed to wp_tag_cloud for generating the tag cloud widget.
   *
   * @return array $args
   */
  public function customizeTagCloudArgs($args) {
    $args['smallest'] = 8;
    $args['largest']  = 24;

    return $args;
  }

  /**
   * Customize the excerpt length.
   *
   * Child theme should override to change value.
   *
   * @since 0.0.3
   *
   * @param   int  $length  Current length
   * @return  int  $length  New length
   */
  public function excerptLength($length) {
    return 20;
  }

  /**
   * Customize the "read more" indicator for an excerpt.
   *
   * Can only be used in The Loop.
   *
   * Child theme should override to change value.
   *
   * @since 0.0.3
   *
   * @uses get_permalink()
   * @uses get_the_ID()
   *
   * @param   string  $more  Current "read more" indicator
   * @return  string  $more  New "read more" indicator
   */
  public function excerptMore($more) {
    return ' ... <a class="read-more" href="' . get_permalink( get_the_ID() ) . '">continue reading</a>';
  }

  // ==============================================
  // General Theme Helper Methods
  // ==============================================

  /**
   * Return permalink for a post via the post slug
   *
   * @since 0.0.3
   *
   * @uses $wpdb
   * @uses get_permalink()
   *
   * @param  string  $slug  Post slug (i.e., post_name field)
   * @param  string  $post_type  [Optional] Post type to limit search by
   *
   * @return string
   */
  public static function getPermalinkBySlug($slug, $post_type = '') {
    global $wpdb;
    $sql = "SELECT ID FROM $wpdb->posts WHERE $wpdb->posts.post_name = %s" . (!empty($post_type) ? " AND $wpdb->posts.post_type = %s" : '');
    $page_id = $wpdb->get_var($wpdb->prepare($sql, $slug, $post_type));
    if ($page_id) {
      return get_permalink($page_id);
    }

    return null;
  }


  /**
   * Test to see if WPML is activated. Used as a conditional because with WPML
   * we need to query by language.
   *
   * @since 0.0.3
   *
   * @return bool
   */
  public static function wpmlActivated() {
    return defined('ICL_LANGUAGE_CODE');
  }

  /**
   * Get a list of Post objects for upcoming events.
   *
   * Upcoming means start_date or end_date is on or after today.
   *
   * @since 0.0.3
   *
   * @uses $wpdb
   *
   * @param  int  $limit  Limit how many events are returned, use -1 for unlimited
   *
   * @return array array of Event post objects.
   */
  public static function getUpcomingEvents($limit = -1) {
    global $wpdb;

    $query_str = self::_get_upcoming_events_sql($limit);

    return $wpdb->get_results($query_str, OBJECT);
  }

  /**
   * Build query for upcoming events
   *
   * If WPML plugin is active, includes language in WHERE clause.
   *
   * @since 0.0.3
   *
   * @uses $wpdb
   *
   * @filter 'plinth_get_upcoming_events_sql'
   *
   * @param  int  $limit  How many events to return, defaults to -1 (all events)
   *
   * @return string  $query_str
   */
  private static function _get_upcoming_events_sql($limit = -1) {
    global $wpdb;

    $select_format = "SELECT %1\$s.*\n";
    $from_format = <<<EOFF
FROM %1\$s
  INNER JOIN %2\$s AS mt1 ON (%1\$s.ID = mt1.post_id AND mt1.meta_key = 'start_date')
  INNER JOIN %2\$s AS mt2 ON (%1\$s.ID = mt2.post_id AND mt2.meta_key = 'end_date')
EOFF;

    $where_format = <<<EOWF

WHERE
  %1\$s.post_type = 'event'
  AND %1\$s.post_status = 'publish'
  AND (
    CAST(mt1.meta_value AS DATE) >= '%3\$s'
    OR  CAST(mt2.meta_value AS DATE) >= '%3\$s'
  )
EOWF;

    $other_format = <<<EOOF

GROUP BY %1\$s.ID
ORDER BY %1\$s.menu_order, mt1.meta_value ASC
EOOF;

    if ( self::wpmlActivated() ) {
      $from_format .= "\n\tJOIN %5\$s AS t ON %1\$s.ID = t.element_id AND t.element_type = 'post_event'";
      $from_format .= "\n\tJOIN %6\$s AS l ON t.language_code = l.code AND l.active = 1";
      $where_format .= "\n\tAND t.language_code='%4\$s'";
    }

    if ($limit && intval($limit) > 0) {
      $other_format .= "\nLIMIT %7\$d";
    }

    $today = date('Y-m-d');
    $language = esc_sql(Plinth::getLanguage());
    $trans_table = "{$wpdb->prefix}icl_translations";
    $lang_table = "{$wpdb->prefix}icl_languages";
    $limit = intval($limit);

    $select = sprintf($select_format, $wpdb->posts, $wpdb->postmeta, $today, $language, $trans_table, $lang_table, $limit);
    $from   = sprintf($from_format,   $wpdb->posts, $wpdb->postmeta, $today, $language, $trans_table, $lang_table, $limit);
    $where  = sprintf($where_format,  $wpdb->posts, $wpdb->postmeta, $today, $language, $trans_table, $lang_table, $limit);
    $other  = sprintf($other_format,  $wpdb->posts, $wpdb->postmeta, $today, $language, $trans_table, $lang_table, $limit);

    $query_str = $select . $from . $where . $other;

    /**
     * Filter: 'plinth_get_upcoming_events_sql' - Allow child theme to manipulate SQL for querying upcoming events.
     *
     * All clause parmeters can be concatenated to form query (required leading
     * whitespace already added to $from, $where, $other, and $limit.
     *
     * @api  $query_str  The full query string
     *
     * @param  string  $select  Select clause (columns)
     * @param  string  $from  From clause (table and joins)
     * @param  string  $where  Where clause
     * @param  string  $other  Group by, Order by, and Limit (if $limit > 0)
     * @param  int  $limit  The $limit value
     */
    return apply_filters( 'plinth_get_upcoming_events_sql', $query_str, $select, $from, $where, $other, $limit );
  }

  /**
   * Get featured events.
   *
   * @since 0.0.3
   *
   * @uses Plinth::_get_featured_event_sql()
   * @uses $wpdb
   *
   * @return array
   */
  public static function getFeaturedEvent() {
    global $wpdb;

    $query_str = self::_get_featured_event_sql();

    return $wpdb->get_results($query_str, OBJECT);
  }

  /**
   *  Helper to generate SQL to get a featured event.
   *
   *  @since 0.0.3
   *
   *  @uses $wpdb
   *
   *  @filter 'plinth_get_featured_event_sql'
   *
   *  @return string $query_str
   */
  private static function _get_featured_event_sql() {
    global $wpdb;

    $select_format = "SELECT %1\$s.*\n";
    $from_format = <<<EOFF
FROM %1\$s
	INNER JOIN %2\$s AS mt1 ON (%1\$s.ID = mt1.post_id AND mt1.meta_key = 'start_date')
  INNER JOIN %2\$s AS mt2 ON (%1\$s.ID = mt2.post_id AND mt2.meta_key = 'end_date')
  INNER JOIN %2\$s AS mt3 ON (%1\$s.ID = mt3.post_id AND mt3.meta_key = 'featured_event')
  JOIN %5\$s AS t ON %1\$s.ID = t.element_id AND t.element_type = 'post_event'
EOFF;

    $where_format = <<<EOWF
WHERE
  %1\$s.post_type = 'event'
	AND %1\$s.post_status = 'publish'
	AND (
		CAST(mt1.meta_value AS DATE) >= '%3\$s'
		OR  CAST(mt2.meta_value AS DATE) >= '%3\$s'
  )
  AND mt3.meta_value = 1
EOWF;

    $other_format = <<<EOOF
GROUP BY %1\$s.ID
ORDER BY %1\$s.menu_order, mt1.meta_value ASC
LIMIT 1
EOOF;

    if ( self::wpmlActivated() ) {
      $from_format .= "\n\tJOIN %6\$s AS l ON t.language_code = l.code AND l.active = 1";
      $where_format .= "\n\tAND t.language_code='%4\$s'";
    }

    $today = date('Y-m-d');
    $language = esc_sql(Plinth::getLanguage());
    $trans_table = "{$wpdb->prefix}icl_translations";
    $lang_table = "{$wpdb->prefix}icl_languages";

    $select = sprintf($select_format, $wpdb->posts, $wpdb->postmeta, $today, $language, $trans_table, $lang_table);
    $from   = sprintf($from_format,   $wpdb->posts, $wpdb->postmeta, $today, $language, $trans_table, $lang_table);
    $where  = sprintf($where_format,  $wpdb->posts, $wpdb->postmeta, $today, $language, $trans_table, $lang_table);
    $other  = sprintf($other_format,  $wpdb->posts, $wpdb->postmeta, $today, $language, $trans_table, $lang_table);

    $query_str = $select . $from . $where . $other;

    /**
     * Filter: 'plinth_get_featured_event_sql' - Allow child theme to manipulate SQL for querying featured events.
     *
     * All clause parmeters can be concatenated to form query (required leading
     * whitespace already added to $from, $where, and $other.
     *
     * @api  $query_str  The full query string
     *
     * @param  string  $select  Select clause (columns)
     * @param  string  $from  From clause (table and joins)
     * @param  string  $where  Where clause
     * @param  string  $other  Group by, Order by
     */
    return apply_filters( 'plinth_get_featured_event_sql', $query_str, $select, $from, $where, $other );
  }

  /**
   * Output image from ACF sub_field.
   *
   * @TODO Clean up alt text handling - look at Vidyo
   * @TODO Add more details about lazy loading
   *
   * @since 0.0.3
   *
   * @uses Plinth_TagHelpers::outputImage()
   *
   * @param  string  $field_name  The name of the sub field
   * @param  string  $class_name  Class name to add to image
   * @param  string  $alt  Alt text for image
   * @param  array  $sizes  List of sizes to try to use for field
   * @param  bool  $lazy_load  Flag to indicate if field should be lazy-loaded for performance.
   *
   * @return void
   */
  public static function imageFromSubField($field_name, $class_name = '', $alt = '', $sizes = array(), $lazy_load = false) {
    if ( $image = get_sub_field($field_name) ) {
      if (!$alt) {
        $default_alt = explode('/', $image['url']);
        $alt = end($default_alt);
      }
      Plinth_TagHelpers::outputImage($image, $class_name, $alt, $sizes, $lazy_load);
    }
  }


  /**
   * Get options for a particular field of a particular post type. Special
   * handling to support getting options outside of a Loop.
   *
   * @since 0.0.3
   *
   * @todo Add note about query results if first post doesn't have field (like resources)
   *
   * @uses WP_Query
   * @uses Plinth::getFieldOptions()
   *
   * @param  string  $field_name  Name of ACF field
   * @param  string  $post_type   Name of post type
   * @param  mixed   $meta_query  Optional meta_query argument to WP_Query to limit query
   *
   * @return array ACF Choices
   */
  public static function getFieldOptionsForPostType($field_name, $post_type, $meta_query = false) {
    $options = array();
    $query_args = array(
      'post_type' => $post_type,
      'posts_per_page' => 1,
      'page' => 1,
    );
    if ($meta_query) {
      $query_args['meta_query'] = array($meta_query);
    }
    $loop = new WP_Query($query_args);
    if ( $loop->have_posts() ) {
      while ( $loop->have_posts() ) {
        $loop->the_post();
        $options = self::getFieldOptions($field_name);
        break;
      }
      wp_reset_query();
    }
    return $options;
  }

  /**
   * Get options for a sub field.
   *
   * Results are cached for performance. Only works in a has_sub_field loop.
   *
   * @since 0.0.3
   *
   * @uses get_post_type()
   * @uses ACF
   *
   * @param string $field_name Name of sub field
   *
   * @return array ACF Choices for the sub field
   */
  public static function getSubFieldOptions($field_name) {
    static $cache;
    $key = get_post_type() . '--' . $field_name;
    if ( !is_null($cache) && array_key_exists($key, $cache) ) {
      return $cache[$key];
    }

    $sub_field = get_sub_field_object($field_name);
    if ( array_key_exists('choices', $sub_field) ) {
      $cache[$key] = $sub_field['choices'];
    } else {
      $cache[$key] = array();
    }
    return $cache[$key];
  }

  /**
   * Get the options for a particular field_name.
   *
   * Only works in The Loop and caches results for performance.
   *
   * @since 0.0.3
   *
   * @uses get_post_type()
   * @uses ACF
   *
   * @param  string  $field_name
   *
   * @return array  ACF Choices for the field
   */
  public static function getFieldOptions($field_name) {
    static $cache;
    $key = get_post_type() . '-' . $field_name;

    if ( !is_null($cache) && array_key_exists($key, $cache) ) {
      return $cache[$key];
    }

    $field = get_field_object($field_name);
    if ( array_key_exists('choices', $field) ) {
      $cache[$key] = $field['choices'];
    } else {
      $cache[$key] = array();
    }
    return $cache[$key];
  }

  /**
   * Get the label(s) for a select field.
   *
   * @since 0.0.3
   *
   * @uses ACF
   * @uses Plinth::get_field_options()
   *
   * @param  string  $field_name  The name of the custom field
   *
   * @return  string|array   The label(s) for the field value, a string if single, array if multiple
   */
  public static function getFieldLabel($field_name) {
    $field_options = self::getFieldOptions($field_name);
    $value = get_field($field_name);
    return self::_get_field_options_label($field_options, $value);
  }

  /**
   * Get the label for a particular field and value.
   *
   * @since 0.0.3
   *
   * @uses ACF
   * @uses Plinth::getFieldOptions()
   *
   * @param  string  $field_name
   * @param  string  $value
   *
   * @return string $label  Empty string if value not found for field
   */
  public static function getFieldLabelForValue($field_name, $value) {
    $options = self::getFieldOptions($field_name);
    if ( array_key_exists($value, $options) ) {
      return $options[$value];
    }
    return '';
  }

  /**
   * Get the label(s) for a select sub field.
   *
   * @since 0.0.3
   *
   * @uses ACF
   *
   * @param   string  $field_name  The name of the custom field
   * @return  string|array         The label(s) for the field value, a string if single, array if multiple
   */
  public static function getSubFieldLabel($field_name) {
    $field_options = self::getSubFieldOptions($field_name);
    $value = get_sub_field($field_name);
    return self::_get_field_options_label($field_options, $value);
  }

  /**
   * Helper method to get the label for a particular value from field options.
   *
   * @since 0.0.3
   *
   * @param  array  $field_options  Field option array from Plinth::getSubFieldOptions() or similar.
   * @param  string  $value  The value to look for.
   *
   * @return string  $label
   */
  private static function _get_field_options_label($field_options, $value) {
    $label = '';
    if ( is_array($value) ) {
      $label = array();
      foreach($value as $key) {
        $label[]= $field_options[$key];
      }
    } else {
      $label = $field_options[$value];
    }
    return $label;
  }


  /**
   * Get a value from a WP Option page for a given language.
   *
   * Should only be used to get the SiteOptions post. All other queries should use Plinth::getSiteOption().
   *
   * @since 0.0.3
   *
   * @internal
   */
  private static function _get_the_option($key, $language = false) {
    return self::_get_option_with_default($key, '', $language);
  }

  /**
   * Get a Site Option value from the Site Options post for the given site/language.
   *
   * @since 0.0.3
   *
   * @uses ACF
   *
   * @param mixed   $option_keys  (array or string)   Keys to access an ACF field
   * @param mixed   $default      (array or string)   Default value to return if the requested value isn't found
   * @param mixed   $language     (false or string)   Desired language for return value
   *
   * @return mixed  ACF field value for the given keys and language. If a
   * string key is provided, a string value is returned. If an array of keys
   * is provided, an array of values is returned.
   */
  public static function getSiteOption($option_keys, $default = '', $language = false) {
    $return_single = false;

    $language = self::getLanguage($language);

    // Shortcut to be able to pass a string for a single key
    if ( !is_array($option_keys) ) {
      $option_keys = array($option_keys);

      // Expect a single value back, not a list
      $return_single = true;
    }

    $site_options_post = self::_get_the_option('site_options', $language);

    if ( !isset($site_options_post->ID) ) {
      // Can't find site options post
      return $default;
    }

    $option_value = self::_get_option_value($site_options_post->ID, $option_keys);
    if ( $option_value === false ) {
      return $default;
    }
    if ( $return_single && is_array($option_value) && count($option_value) == 1 ) {
      return array_pop($option_value);
    }

    return $option_value;
  }

  /**
   * Get a single site option. Easier to work with a string instead of an array.
   *
   * Note - May return an array if multiple values are unexpectedly found.
   *
   * @since 0.0.3
   *
   * @param array|string $option_keys Key(s) to access field
   * @param array|string $default  Default value to return if no value is found for key
   * @param string|bool  $language  Language of site option to look in
   *
   * @return array|string
   */
  public static function getSingleSiteOption($option_keys, $default = '', $language = false) {
    $value = self::getSiteOption($option_keys, $default, $language);

    if ( AtreNet_Util::isArray($value, 1) && AtreNet_Util::isArray($option_keys, 1) ) {
      return array_pop($value);
    }

    return $value;
  }

  /**
   * Echo Site Option value from Site Options post for the given site/language.
   *
   * Same as getSiteOption() but echos the result instead of returning it.
   *
   * @since 0.0.3
   *
   * @param array|string $option_keys Key(s) to access field
   * @param array|string $default  Default value to return if no value is found for key
   * @param string|bool  $language  Language of site option to look in
   *
   * @return void
   */
  public static function theSiteOption($option_keys, $default = '', $language = false) {
    echo self::getSiteOption($option_keys, $default, $language);
  }

  /**
   * Get a value from a Site Options post based on option keys
   *
   * @since 0.0.3
   *
   * @uses ACF
   *
   * @param  int  $post_id  ID of Site Options post to query
   * @param  array  $option_keys  Array of option keys
   *
   * @return mixed Value found, or array of values if keys point to field with subfields, or false (no option found for keys)
   */
  private static function _get_option_value($post_id, $option_keys) {
    if ( !is_array($option_keys) || count($option_keys) === 0 ) {
      return false;
    }

    $field_name = array_shift($option_keys);
    $option_field = get_field($field_name, $post_id);
    if (!$option_field) {
      return false;
    }
    return self::_find_option_value($option_field, $option_keys);
  }

  /**
   * Recurse through an option field to find a value based on supplied keys
   *
   * @since 0.0.3
   *
   * @param  array  $option_field  Array of data from get_field() [ACF]
   * @param  array  $option_keys  Keys to look at
   *
   * @return mixed Value found, or array of values if keys point to field with subfields, or false (no option found for keys)
   */
  private static function _find_option_value($option_field, $option_keys) {
    if ( !is_array($option_keys) || count($option_keys) === 0 ) {
      return $option_field;
    }

    if ( is_array($option_field) ) {
      // For now, don't support multi-dimensional values
      $option_field = array_shift($option_field);
    }

    $subfield_name = array_shift($option_keys);
    if ( array_key_exists($subfield_name, $option_field) ) {
      return self::_find_option_value($option_field[$subfield_name], $option_keys);
    }
    return false;
  }


  /**
   * Get a value from the WP Option page for the language.
   *
   * Should only be used to look the Site Options post.
   *
   * @since 0.0.3
   *
   * @internal
   *
   * @param string $key Field name without language
   * @param mixed $default Default to return if option not found
   * @param string|bool $language Language to look for - defaults to current language
   *
   * @return mixed
   */
  private static function _get_option_with_default($key, $default, $language = false) {
    $language = self::getLanguage($language);

    $value = get_field($key . '_' . $language, 'option');
    if ('' == $value) {
      $value = $default;
    }
    return $value;
  }

  /**
   * Return the code for the current langauge.
   *
   * Defaults to English ('en').
   *
   * @since 0.0.3
   *
   * @uses WPML (http://wpml.org/)
   *
   * @param  bool|string  $language  Can pass in an existing langauge value to "normalize" - will return the value if it's !== false
   *
   * @return string Code for the current language
   */
  public static function getLanguage($language = false) {
    if ($language !== false) {
      return $language;
    }

    // Language code from WPML
    if (defined('ICL_LANGUAGE_CODE') ) {
      return ICL_LANGUAGE_CODE;
    }

    // Default to English
    return 'en';
  }

  /**
   * Allow overriding of current post ID so that we can control what secondary
   * navigation is displayed more easily.
   *
   * @since 0.0.3
   *
   * @param int $id Post ID
   *
   * @return void
   */
  public function setCurrentPostId($id) {
    $this->current_post_id = $id;
  }

  /**
   * Returns the current post ID
   *
   * @since 0.0.3
   *
   * @return int Current post ID
   */
  private function _current_post_id() {
    if ( $this->current_post_id === false ) {
      global $post;
      if (!$post) { return null; }
      $this->current_post_id = $post->ID;
    }

    return $this->current_post_id;
  }


  // ==============================================
  // Secondary/Section Navigation
  // ==============================================

  /**
   * Echo secondary navigation menu
   *
   * @since 0.0.3
   *
   * @return void
   */
  public function displaySecondaryNavigation() {
    $secondary_nav_struct = $this->_build_secondary_nav_struct();
    $level = 0;
    foreach ($secondary_nav_struct as $nav_struct) {
      if ( count($nav_struct) > 0 ) {
        $level++;
        echo $this->formatSecondaryNavigation($nav_struct, $level);
      }
    }
  }

  /**
   * Return secondary navigation menu
   *
   */
  public function getSecondaryNavigation() {
    $output = '';
    $secondary_nav_struct = $this->_build_secondary_nav_struct();
    $level = 0;
    foreach ($secondary_nav_struct as $nav_struct) {
      if ( count($nav_struct) > 0 ) {
        $level++;
        $output .= $this->formatSecondaryNavigation($nav_struct, $level);
      }
    }

    return $output;
  }

  /**
   * Format secondary navigation menu
   *
   * @since 0.0.3
   *
   * @param  array  $struct  Secondary navigation menu items
   * @param  int  $level  The level number to support custom styling on stacked secondary navigation
   *
   * @return string HTML for secondary navigation menu
   */
  public function formatSecondaryNavigation($struct, $level = 1) {
    $output = '';
    $output .= '<div class="nav-content-wrapper nav-content-wrapper-' . $level . '">';
    $output .= '<div class="nav-content nav-content-' . $level . '">';
    $output .= '<ul class="menu menu-' . $level . '">';
    $counter = 0;
    $struct_count = count($struct);
    foreach ($struct as $menu_item) {
      if(!$menu_item) { continue; }
      $counter++;
      $classes = array('menu-item');
      if ( $this->menu_item_is_for_current_post($menu_item) ) {
        $classes[]= 'active';
      }
      if ( $this->menu_item_is_parent_of_current_post($menu_item) ) {
        $classes[]= 'parent-of-active';
      }

      if ($counter == 1) {
        $classes[]= 'first';
      }
      if ($counter == $struct_count) {
        $classes[]= 'last';
      }
      $output .=  '<li class="' . implode(' ', $classes) . '"><a href="' . $menu_item->url . '">' . $menu_item->title . '</a></li>';
    }
    $output .= '</ul>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
  }

  /**
   * Build secondary navigation struct
   *
   * @since 0.0.3
   *
   * @return array
   */
  private function _build_secondary_nav_struct() {
    //$lead_menu_item = $this->currentMenuItem();
    #die(var_export($lead_menu_item, true));
    $parent_nav_struct = array();
    $child_nav_struct = $this->find_child_menu_items();
    //die("child_nav_struct: " . print_r($child_nav_struct, 1) . "\n");
    // if menu item has children and parent is not root, then show siblings of menu item as parent nav struct
    // this handles News and Events
    if ( count($child_nav_struct) > 0 && $this->currentMenuItemParentMenuId() != 0 ) {
      $parent_nav_struct = $this->find_sibling_menu_items();
    } else {
      $parent_nav_struct = $this->find_parent_menu_items();
    }
    //die("parent_nav_struct: " . print_r($parent_nav_struct, 1) . "\n");
    #die(var_export($nav_struct, true));
    if ( count($child_nav_struct) === 0 ) {
      $child_nav_struct = $this->find_sibling_menu_items();
      $lead_menu_item = $this->parentMenuItem();
    }

    return array($parent_nav_struct, $child_nav_struct);
  }

  /**
   * Get secondary nav menu id from Site Options.
   *
   * Dies if no secondary_nav_menu_id is specified in Site Options.
   *
   * @since 0.0.3
   *
   * @return int
   */
  private function _secondary_nav_menu_id() {
    if ( $secondary_nav_menu_option = self::getSiteOption('secondary_nav_menu_id', false) ) {
      return $secondary_nav_menu_option;
    }

    //wp_die("Must specify secondary_nav_menu_id in Site Options");
  }

  /**
   * Lazy load and cache the nav menu items.
   *
   * Menu is based on secondary_nav_menu_id Site Options value.
   *
   * @since 0.0.3
   *
   * @uses wp_get_nav_menu_items()
   *
   * @return array
   */
  private function _secondary_nav_menu_items() {
    if (count($this->secondary_nav_menu_items) === 0) {
      $this->secondary_nav_menu_items = wp_get_nav_menu_items( $this->_secondary_nav_menu_id() );
    }

    if(!is_array($this->secondary_nav_menu_items)) {
      $this->secondary_nav_menu_items = array();
    }

    return $this->secondary_nav_menu_items;
  }

  // ==============================================
  // Footer Navigation
  // ==============================================

  /**
   * Echo footer navigation
   *
   * @since 0.0.3
   *
   * @return void
   */
  public function displayFooterNavigation() {
    $footer_nav_struct = $this->_build_footer_nav_struct();
    echo $this->formatFooterNavigation($footer_nav_struct);
  }

  /**
   * Format footer navigation for display
   *
   * @since 0.0.3
   *
   * @param array $struct Footer navigation items
   *
   * @return string HTML for footer navigation
   */
  public function formatFooterNavigation($struct) {
    $output = '';
    $output .=  '<ul>';
    foreach ( $struct as $item ) {
      $output .= $this->_format_footer_nav_item($item);
    }
    $output .= '</ul>';
    return $output;
  }

  /**
   * Format single footer navigation item
   *
   * @since 0.0.3
   *
   * @param array $item  Footer navigation item
   * @param int   $level Hierarchy level of navigation item
   *
   * @return string HTML for single footer navigation item
   */
  private function _format_footer_nav_item($item, $level = 1) {
    $output = '';
    $item_item = $item['item'];
    $item_item->classes[]= 'menu-item';
    $item_item->classes[]= "level-{$level}";
    $output .= '<li class="' . implode(' ', $item_item->classes) . '">';
    if ( $top_level = $this->_top_level($level) ) {
      $output .= '<h3 class="footer-nav-title">';
    } else if ( $linked = $this->_item_linked($item_item) ) {
      $output .= '<a href="' . $item_item->url . '">';
    } else {
      $output .= '<span>';
    }
    $output .= $item_item->title;

    if ($top_level) {
      $output .= '</h3>';
    } else if ($linked) {
      $output .= '</a>';
    } else {
      $output .= '</span>';
    }
    if ( $item['children'] ) {
      $output .= '<ul>';
      foreach ($item['children'] as $child) {
        $output .= $this->_format_footer_nav_item($child, $level + 1);
      }
      $output .= '</ul>';
    }
    $output .= '</li>';
    return $output;
  }

  /**
   * Build footer navigation struct
   *
   * @since 0.0.3
   *
   * @return array
   */
  private function _build_footer_nav_struct() {
    $footer_nav_menu_items = $this->addFirstLastMenuClasses($this->_footer_nav_menu_items());
    $child_lookup_struct = $this->_build_menu_children_lookup_struct($footer_nav_menu_items);
    $footer_nav_struct = array();
    if ( AtreNet_Util::isArray($child_lookup_struct, 1) ) {
      foreach ( $child_lookup_struct[0] as $item ) {
        $footer_nav_struct[]= array ( 'item' => $item, 'children' => $this->_find_children($item->ID, $child_lookup_struct) );
      }
    }
    return $footer_nav_struct;
  }

  /**
   * Return list of footer navigation items
   *
   * @since 0.0.3
   *
   * @return array Footer navigation items
   */
  private function _footer_nav_menu_items() {
    if ( count($this->footer_nav_menu_items) === 0 ) {
      $this->footer_nav_menu_items = wp_get_nav_menu_items( $this->_footer_nav_menu_id() );
    }

    if ( !is_array($this->footer_nav_menu_items) ) {
      $this->footer_nav_menu_items = array();
    }

    return $this->footer_nav_menu_items;
  }

  /**
   * Get ID for footer menu from Site Options.
   *
   * Dies if no footer_nav_menu_id specified in Site Options.
   *
   * @since 0.0.3
   *
   * @return int
   */
  private function _footer_nav_menu_id() {
    if ( $footer_nav_menu_option = self::getSiteOption('footer_nav_menu_id') ) {
      return $footer_nav_menu_option;
    }

    wp_die("Must specify footer_nav_menu_id in Site Options");
  }


  // ==============================================
  // Navigation Helper Methods
  // ==============================================

  /**
   * Get the ID of the current menu item's parent menu item
   *
   * @since 0.0.3
   *
   * @return int
   */
  public function currentMenuItemParentMenuId() {
    $currentMenuItem = $this->currentMenuItem();
    return $currentMenuItem ? $currentMenuItem->menu_item_parent : null;
  }

  /**
   * Get the ID of the current menu item's parent post
   *
   * @since 0.0.3
   *
   * @return int
   */
  public function currentMenuItemParentPostId() {
    $currentMenuItem = $this->currentMenuItem();
    return $currentMenuItem === null ? $currentMenuItem->post_parent : null;
  }

  /**
   * Get the menu item for the current page.
   *
   * @since 0.0.3
   *
   * @return object
   */
  public function currentMenuItem() {
    if ( is_null($this->current_menu_item) ) {
      $this->current_menu_item = $this->find_current_menu_item();
    }

    return $this->current_menu_item;
  }

  /**
   * Get the parent menu item of the current menu item
   *
   * @since 0.0.3
   *
   * @return object
   */
  public function parentMenuItem() {
    if ( is_null($this->parent_menu_item) ) {
      $this->parent_menu_item = $this->find_parent_menu_item();
    }

    return $this->parent_menu_item;
  }


  /**
   * Get the list of secondary navigation menu items
   *
   * @since 0.0.3
   *
   * @return array
   */
  private function _nav_menu_items() {
    return $this->_secondary_nav_menu_items();
  }

  /**
   * Find children of menu item.
   *
   * @since 0.0.3
   *
   * @param  int  $parent_id  The ID of the parent menu item to find children of
   * @param  array  $items  Array of menu item objects
   *
   * @return array|bool  False if no children found.
   */
  private function _find_children($parent_id, $items) {
    if ( array_key_exists($parent_id, $items) ) {
      $children = array();
      foreach ( $items[$parent_id] as $item ) {
        $children[]= array( 'item' => $item, 'children' => $this->_find_children($item->ID, $items) );
      }
      return $children;
    }
    return false;
  }

  /**
   * Simple test to see if an item is linked up or not.
   *
   * @since 0.0.3
   *
   * @param  object  $item  Item to check
   *
   * @return bool
   */
  private function _item_linked($item) {
    return '#' != $item->url && 'http://*' != $item->url;
  }

  /**
   * Check to see if the $level is the top level.
   *
   * @since 0.0.3
   *
   * @param  int  $level  Level to test
   *
   * @return bool
   */
  private function _top_level($level) {
    return 1 == $level;
  }

  private function _build_menu_children_lookup_struct($items) {
    $struct = array();
    foreach ( $items as $item ) {
      $menu_item_parent_id = $item->menu_item_parent;
      if ( !array_key_exists($menu_item_parent_id, $struct) ) {
        $struct[$menu_item_parent_id] = array();
      }
      $struct[$menu_item_parent_id][]= $item;
    }
    return $struct;
  }

  private function menu_item_is_for_current_post($menu_item) {
    return $menu_item->object_id == $this->_current_post_id();
  }

  private function menu_item_is_parent_of_current_post($menu_item) {
    return $menu_item->ID == $this->currentMenuItemParentMenuId();
  }

  private function find_current_menu_item() {
    return $this->find_menu_item_for_post_id($this->_current_post_id());
  }

  private function find_parent_menu_item() {
    $parent_menu_id = $this->currentMenuItemParentMenuId();
    return $this->find_menu_item_for_menu_id($parent_menu_id);
  }

  public function find_menu_item_for_menu_item_id($menu_item_id) {
    return $this->find_menu_item_for_menu_id($menu_item_id);
  }

  public function find_menu_item_for_menu_id($menu_id) {
    foreach ( $this->_nav_menu_items() as $menu_item ) {
      if ( $menu_item->ID == $menu_id ) {
        return $menu_item;
      }
    }

    return false;
  }

  /**
   * Find the navigation menu item that corresponds to the given post ID.
   *
   * @param int $post_id Post ID
   * @return mixed Corresponding menu item or false if not found
   */
  public function find_menu_item_for_post_id($post_id) {
    foreach ( $this->_nav_menu_items() as $menu_item ) {
      if ( $menu_item->object_id == $post_id ) {
        return $menu_item;
      }
    }

    return false;
  }

  private function find_child_menu_items() {
    return $this->find_menu_items_with_parent_menu_id( $this->current_menu_id() );
  }

  private function find_parent_menu_items() {
    $parent_menu_item_siblings = array();
    $parent_menu_item_id = $this->currentMenuItemParentMenuId();
    //die("parent_menu_item_id: " . print_r($parent_menu_item_id, 1) . "\n");
    $nav_menu_items = $this->_nav_menu_items();
    //die("nav menu items: " . print_r($nav_menu_items, 1) . "\n");
    $parent_menu_item = $this->find_menu_item_for_menu_id($parent_menu_item_id);
    //die("parent_menu_item: " . print_r($parent_menu_item, 1) . "\n");
    if($parent_menu_item) {
      $grandparent_menu_item_id = $parent_menu_item->menu_item_parent;
      //die("grandparent_menu_item_id: " . print_r($grandparent_menu_item_id, 1) . "\n");
      $grandparent_menu_item = $this->find_menu_item_for_menu_id($grandparent_menu_item_id);
      //die("grandparent_menu_item: " . print_r($grandparent_menu_item, 1) . "\n");
      if ($grandparent_menu_item) {
        return $this->find_menu_items_with_parent_menu_id($grandparent_menu_item_id);
      }
    }
    return array();
  }


  /**
   * @deprecated Use $this->findMenuItemsWithParentMenuItemId($menu_item_id)
   */
  public function find_menu_items_with_parent_menu_id($menu_id) {
    return $this->findMenuItemsWithParentMenuItemId($menu_id);
  }

  /**
   * Get child menu items.
   *
   * @since 0.4.0
   *
   * @param  int  $menu_item_id  Menu item id to find children of
   *
   * @return array  Augmented WP_Post objects (see wp_get_nav_menu_items())
   */
  public function findMenuItemsWithParentMenuItemId($menu_item_id) {
    $child_menu_items = array();

    foreach ( $this->_nav_menu_items() as $menu_item ) {
      if ( $menu_item->menu_item_parent == $menu_item_id ) {
        $child_menu_items[]= $menu_item;
      }
    }

    return $child_menu_items;
  }

  /**
   * Get menu items that are siblings of the current menu item.
   *
   * @since 0.0.3
   *
   * @see wp_get_nav_menu_items()
   *
   * @return array Augmented WP_Post objects.
   */
  private function find_sibling_menu_items() {
    $parent_menu_id = $this->currentMenuItemParentMenuId();
    return $this->find_menu_items_with_parent_menu_id($parent_menu_id);
  }

  /**
   * @deprecated Use $this->_current_menu_item_id()
   */
  private function current_menu_id() {
    return $this->_current_menu_item_id();
  }

  /**
   * Get the ID of the menu item for the current page.
   *
   * @since 0.4.0
   *
   * @return int|null null if no current menu item
   */
  private function _current_menu_item_id() {
    $currentMenuItem = $this->currentMenuItem();
    return $currentMenuItem ? $currentMenuItem->ID : null;
  }
}

