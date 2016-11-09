<?php
/*
Plugin Name: AtreNet Post Types
Plugin URI: http://www.atre.net
Description: Enable common post types for a site.
Author: AtreNet
Version: 1.0.0
Author URI: http://www.atre.net
 */
if ( !class_exists('AtreNet_Post_Types') ) {

  class AtreNet_Post_Types {

    const VERSION = '1.0.0';
    const NAME = 'atrenet_post_types';
    const TEXTDOMAIN = self::NAME;

    var $settings = null;

    public function __construct() {
      //require_once( dirname(__FILE__) . '/settings.php' );
      $this->settings = AtreNet_Post_Types_Settings::getInstance();

      add_action( 'init', array($this, 'init') );
      add_action( 'save_post', array($this, 'save_post'), 10, 2 );

      $this->setup_custom_columns();
      $this->setup_post_filters();
    }

    // Per: http://wordpress.stackexchange.com/questions/45436/add-filter-menu-to-admin-list-of-posts-of-custom-type-to-filter-posts-by-custo
    private function setup_post_filters() {
      // resource
      add_action( 'restrict_manage_posts', array($this, 'resource_post_filter_options') );
      add_filter( 'parse_query', array($this, 'resource_post_filter'), 10, 1 );
    }

    public function resource_post_filter($query) {
      global $pagenow;
      $type = 'post';
      if ( isset($_GET['post_type']) ) {
        $type = $_GET['post_type'];
      }

      if (
        'resource' == $type
        && is_admin()
        && $pagenow == 'edit.php'
        && isset($_GET['ADMIN_FILTER_FIELD_VALUE'])
        && $_GET['ADMIN_FILTER_FIELD_VALUE'] != ''
      ) {
        $query->query_vars['meta_key'] = 'document_type';
        $query->query_vars['meta_value'] = $_GET['ADMIN_FILTER_FIELD_VALUE'];
      }
    }

    public function resource_post_filter_options() {
      $type = 'post';
      if ( isset($_GET['post_type']) ) {
        $type = $_GET['post_type'];
      }

      if ( 'resource' == $type ) {
        // TODO - pull this from the ACF setup somehow
        $values = array(
          'resource-kit' => 'Resource Kit',
          'webinar' => 'Webinar',
          'white-paper' => 'White Paper',
          'video' => 'Video',
          'brochure' => 'Brochure',
          'case-study' => 'Case Study',
          'datasheet' => 'Datasheet',
          'solution-brief' => 'Solution Brief',
        );

      ?>
        <select name="ADMIN_FILTER_FIELD_VALUE">
          <option value=""><?php _e('All Document Types', self::TEXTDOMAIN); ?></option>
          <?php
            $current_v = '';
            if ( isset($_GET['ADMIN_FILTER_FIELD_VALUE']) ) {
              $current_v = $_GET['ADMIN_FILTER_FIELD_VALUE'];
            }
            foreach ( $values as $value => $label ) {
              $selected = $value == $current_v ? ' selected="selected"' : '';
              printf('<option value="%s"%s>%s</option>', $value, $selected, $label);
            }
          ?>
        </select>
        <?php
      }
    }

    private function setup_custom_columns() {
      // leadership_bio
      add_filter( 'manage_leadership_bio_posts_columns', array($this, 'leadership_bio_admin_columns'), 10, 1 );
      add_action( 'manage_leadership_bio_posts_custom_column', array($this, 'leadership_bio_admin_columns_content'), 10, 2 );

      // event
      add_filter( 'manage_event_posts_columns', array($this, 'event_admin_columns'), 10, 1 );
      add_action( 'manage_event_posts_custom_column', array($this, 'event_admin_columns_content'), 10, 2 );

      // news_article
      add_filter( 'manage_news_article_posts_columns', array($this, 'news_article_admin_columns'), 10, 1 );
      add_action( 'manage_news_article_posts_custom_column', array($this, 'news_article_admin_columns_content'), 10, 2 );

      // award
      add_filter( 'manage_award_posts_columns', array($this, 'award_admin_columns'), 10, 1 );
      add_action( 'manage_award_posts_custom_column', array($this, 'award_admin_columns_content'), 10, 2 );

      // resource
      add_filter( 'manage_resource_posts_columns', array($this, 'resource_admin_columns'), 10, 1 );
      add_action( 'manage_resource_posts_custom_column', array($this, 'resource_admin_columns_content'), 10, 2 );

      // support_resource
      add_filter( 'manage_support_resource_posts_columns', array($this, 'support_resource_admin_columns'), 10, 1 );
      add_action( 'manage_support_resource_posts_custom_column', array($this, 'support_resource_admin_columns_content'), 10, 2 );

      // customer
      add_filter( 'manage_customer_posts_columns', array($this, 'customer_admin_columns'), 10, 1 );
      add_action( 'manage_customer_posts_custom_column', array($this, 'customer_admin_columns_content'), 10, 2 );

      // career_posting
      add_filter( 'manage_career_posting_posts_columns', array($this, 'career_posting_admin_columns'), 10, 1 );
      add_action( 'manage_career_posting_posts_custom_column', array($this, 'career_posting_admin_columns_content'), 10, 2 );

      // partner
      add_filter( 'manage_partner_posts_columns', array($this, 'partner_admin_columns'), 10, 1 );
      add_action( 'manage_partner_posts_custom_column', array($this, 'partner_admin_columns_content'), 10, 2 );

    }

    public function leadership_bio_admin_columns($default_columns) {
      $column_keys = array( 'cb', 'title', 'job_title', 'member_of', 'headshot', 'date' );
      $custom_columns = array(
        'headshot' => 'Image',
        'title' => 'Name',
        'job_title' => 'Title',
        'member_of' => 'Member Of',
      );
      return $this->_setup_column_fields($column_keys, $custom_columns, $default_columns);
    }

    public function event_admin_columns($default_columns) {
      $column_keys = array( 'cb', 'title', 'event_date', 'shown', 'featured_event', 'logo', 'location', 'date' );
      $custom_columns = array(
        'event_date' => 'Event Date',
        'title' => 'Event Name',
        'date' => 'Post Date',
        'location' => 'Location',
        'shown' => 'Shown',
        'featured_event' => 'Featured',
        'logo' => 'Event Logo',
      );
      return $this->_setup_column_fields($column_keys, $custom_columns, $default_columns);
    }

    public function news_article_admin_columns($default_columns) {
      $column_keys = array( 'cb', 'title', 'publication', 'featured', 'logo', 'date' );
      $custom_columns = array(
        'publication' => 'Publication',
        'logo' => 'Logo',
        'featured' => 'Featured',
      );
      return $this->_setup_column_fields($column_keys, $custom_columns, $default_columns);
    }

    public function award_admin_columns($default_columns) {
      $column_keys = array( 'cb', 'title', 'award_from', 'logo', 'date' );
      $custom_columns = array(
        'award_from' => 'Award From',
        'logo' => 'Logo',
      );
      return $this->_setup_column_fields($column_keys, $custom_columns, $default_columns);
    }

    public function resource_admin_columns($default_columns) {
      $column_keys = array( 'cb', 'title', 'document_type', 'featured', 'requires_registration', 'doc_categories', 'date' );
      $custom_columns = array(
        'document_type' => 'Document Type',
        'featured' => 'Featured',
        'requires_registration' => 'Requires Registration',
        'doc_categories' => 'Categories',
      );
      return $this->_setup_column_fields($column_keys, $custom_columns, $default_columns);
    }

    public function support_resource_admin_columns($default_columns) {
      $column_keys = array( 'cb', 'title', 'application', 'platform', 'date' );
      $custom_columns = array(
        'application' => 'Applications',
        'platform' => 'Platforms',
      );
      return $this->_setup_column_fields($column_keys, $custom_columns, $default_columns);
    }

    public function career_posting_admin_columns($default_columns) {
      $column_keys = array( 'cb', 'title', 'date');
      $custom_columns = array(
      );
      return $this->_setup_column_fields($column_keys, $custom_columns, $default_columns);
    }

    public function customer_admin_columns($default_columns) {
      $column_keys = array( 'cb', 'title', 'logo', 'featured', 'industries', 'date' );
      $custom_columns = array(
        'logo' => 'Logo',
        'featured' => 'Featured',
        'industries' => 'Industries',
      );
      return $this->_setup_column_fields($column_keys, $custom_columns, $default_columns);
    }

    public function partner_admin_columns($default_columns) {
      $column_keys = array( 'cb', 'title', 'logo', 'featured', 'partner_categories', 'date' );
      $custom_columns = array(
        'logo' => 'Logo',
        'featured' => 'Featured',
        'partner_categories' => 'Categories',
      );
      return $this->_setup_column_fields($column_keys, $custom_columns, $default_columns);
    }

    private function _setup_column_fields($column_keys, $custom_columns, $default_columns) {
      $columns = array();
      foreach ($column_keys as $key) {
        if ( array_key_exists($key, $custom_columns) ) {
          $columns[$key] = $custom_columns[$key];
        } else if ( array_key_exists($key, $default_columns) ) {
          $columns[$key] = $default_columns[$key];
        }
      }
      return $columns;
    }

    public function leadership_bio_admin_columns_content($column_name, $post_ID) {
      if ('headshot' == $column_name) {
        $image = get_field('headshot', $post_ID);
        if ($image) {
          echo wp_get_attachment_image($image['id']);
        }
      }
      if ('member_of' == $column_name) {
        echo $this->_get_labels_for_field($column_name, $post_ID);
      }
      if ('job_title' == $column_name) {
        echo get_field('title', $post_ID);
      }
    }

    public function event_admin_columns_content($column_name, $post_ID) {
      if ('event_date' == $column_name) {
				if(get_field('end_date', $post_ID)):
					echo get_field('start_date', $post_ID) .' - ' .get_field('end_date', $post_ID);
				else:
					echo get_field('start_date', $post_ID);
				endif;
      }
      if ('location' == $column_name) {
        echo get_field('location', $post_ID);
      }
      if ('shown' == $column_name) {
        if ( $this->_event_in_past(get_field('start_date', $post_ID), get_field('end_date', $post_ID)) ) {
          _e('No', self::TEXTDOMAIN);
        } else {
          _e('Yes', self::TEXTDOMAIN);
        }
      }
      if ('featured_event' == $column_name) {
        echo $this->_get_boolean_for_field($column_name, $post_ID);
      }
      if ('logo' == $column_name) {
        $image = get_field('logo', $post_ID);
        if ($image) {
          echo wp_get_attachment_image($image['id']);
        }
      }
    }

    private function _event_in_past($start_date, $end_date) {
      $date = $end_date;
      if ( !$date ) {
        $date = $start_date;
      }
      return strtotime($date) < strtotime(date('Y-m-d'));
    }

    public function news_article_admin_columns_content($column_name, $post_ID) {
      if ('publication' == $column_name) {
        echo get_field('publication', $post_ID);
      }
      if ('logo' == $column_name) {
        $image = get_field('logo', $post_ID);
        if ($image) {
          echo wp_get_attachment_image($image['id']);
        }
      }
      if ('featured' == $column_name) {
        echo $this->_get_boolean_for_field($column_name, $post_ID);
      }
    }

    public function award_admin_columns_content($column_name, $post_ID) {
      if ('award_from' == $column_name) {
        echo get_field('award_from', $post_ID);
      }
      if ('logo' == $column_name) {
        $image = get_field('logo', $post_ID);
        if ($image) {
          $image_tag = wp_get_attachment_image($image['id'], 'award-image');
          if ( !$image_tag ) {
            $image_tag = wp_get_attachment_image($image['id']);
          }
          echo $image_tag;
        }
      }
    }

    public function resource_admin_columns_content($column_name, $post_ID) {
      if ('document_type' == $column_name) {
        echo $this->_get_labels_for_field($column_name, $post_ID);
      }
      if ('featured' == $column_name) {
        echo $this->_get_boolean_for_field($column_name, $post_ID);
      }
      if ('requires_registration' == $column_name) {
        echo $this->_get_boolean_for_field($column_name, $post_ID);
      }
      if ('doc_categories' == $column_name) {
        $category_fields = array('white_paper_categories', 'video_categories', 'case_study_categories', 'datasheet_categories');
        $category_labels = array();
        foreach ($category_fields as $field_name) {
          $category_labels = array_merge($category_labels, (array)$this->_get_labels_for_field($field_name, $post_ID));
        }
        echo implode(', ', array_filter($category_labels));
      }
    }

    public function support_resource_admin_columns_content($column_name, $post_ID) {
      if ('application' == $column_name) {
        echo $this->_get_labels_for_field($column_name, $post_ID);
      }
      if ('platform' == $column_name) {
        echo $this->_get_labels_for_field($column_name, $post_ID);
      }
    }

    public function career_posting_admin_columns_content($column_name, $post_ID) {
      if ('department' == $column_name) {
        echo $this->_get_labels_for_taxonomy('career_departments', $post_ID);
      }
    }

    public function customer_admin_columns_content($column_name, $post_ID) {
      if ('featured' == $column_name) {
        echo $this->_get_boolean_for_field($column_name, $post_ID);
      }
      if ('logo' == $column_name) {
        $image = get_field('logo', $post_ID);
        if ($image) {
          echo wp_get_attachment_image($image['id']);
        }
      }
      if ('industries' == $column_name) {
        echo $this->_get_labels_for_taxonomy($column_name, $post_ID);
      }
    }

    public function partner_admin_columns_content($column_name, $post_ID) {
      if ('featured' == $column_name) {
        echo $this->_get_boolean_for_field($column_name, $post_ID);
      }
      if ('logo' == $column_name) {
        $image = get_field('logo', $post_ID);
        if ($image) {
          echo wp_get_attachment_image($image['id']);
        }
      }
      if ('partner_categories' == $column_name) {
        echo $this->_get_labels_for_taxonomy('partner_categories', $post_ID);
      }
    }

    private function _get_labels_for_taxonomy($taxonomy_slug, $post_ID, $delimiter = ', ') {
      $taxonomy_labels = wp_get_post_terms($post_ID, $taxonomy_slug, array('fields' => 'names'));
      if ($delimiter) {
        return implode($delimiter, $taxonomy_labels);
      }
      return $taxonomy_labels;
    }

    private function _get_labels_for_field($field_name, $post_ID, $delimiter = ', ') {
      $field = get_field_object($field_name);
      if ( !is_array($field) ) {
        return;
      }

      $values = get_field($field_name, $post_ID);
      $labels = array();
      if ( !is_array($values) ) {
        $values = array($values);
      }
      foreach ($values as $value) {
        if (!empty($field['choices'])) {
          $labels[]= $field['choices'][$value];
        }
      }
      if ($delimiter) {
        return implode($delimiter, $labels);
      }
      return $labels;
    }

    private function _get_boolean_for_field($field_name, $post_ID, $yes = 'Yes', $no = 'No') {
      if ( get_field($field_name, $post_ID) ) {
        return $yes;
      }
      return $no;
    }

    public static function activate() {
    }

    public static function deactivate() {
    }

    public function save_post($post_id, $post) {
      $taxonomies = get_object_taxonomies($post->post_type);
      foreach ( (array) $taxonomies as $taxonomy ) {
        $terms = wp_get_post_terms($post_id, $taxonomy);
        if ( empty($terms) ) {
          $default_term = $this->get_default_taxonomy_term($taxonomy);
          if ($default_term) {
            wp_set_object_terms($post_id, $default_term, $taxonomy);
          }
        }
      }
    }

    private function get_default_taxonomy_term($taxonomy_name) {
      $taxonomies = $this->taxonomies();
      if ( !array_key_exists($taxonomy_name, $taxonomies) ) {
        return false;
      }

      if ( !array_key_exists('default', $taxonomies[$taxonomy_name]) ) {
        return false;
      }

      return $taxonomies[$taxonomy_name]['default'];
    }

    public static function taxonomies() {
      return array(
        'career_departments' => array(
          'post_types' => array('career_posting'),
          'label' => 'Career Departments',
          'args' => array(
            'label' => 'Departments',
            'singular_label' => 'Department'
          ),
        ),
        'industries' => array(
          'post_types' => array('customer'),
          'label' => 'Industries',
          'args' => array(
            'label' => 'Industries',
            'singular_label' => 'Industry'
          ),
        ),
        'partner_categories' => array(
          'post_types' => array('partner'),
          'label' => 'Partner Categories',
          'args' => array(
            'label' => 'Partner Categories',
            'singular_label' => 'Partner Category'
          ),
        ),
				'partner_regions' => array(
          'post_types' => array('partner'),
          'label' => 'Partner Regions',
          'args' => array(
            'label' => 'Partner Regions',
            'singular_label' => 'Partner Region'
          ),
        ),
        'visibility' => array(
          'post_types' => array('press_release', 'event', 'resource'),
          'label' => 'Visibility Areas',
          'args' => array(
            'label' => 'Visibility Areas',
            'singular_label' => 'Visible Area',
          ),
          'default' => array('Corporate'),
        ),
        'event_type' => array(
          'post_types' => array('event'),
          'label' => 'Event Types',
          'args' => array(
            'label' => 'Event Types',
            'singular_label' => 'Event Type',
          ),
        ),
        'document_type' => array(
          'post_types' => array('resource'),
          'label' => 'Document Types',
          'args' => array(
            'label' => 'Document Types',
            'singular_label' => 'Document Type',
          ),
        ),
				'document_role' => array(
          'post_types' => array('resource'),
          'label' => 'Document Role',
          'args' => array(
            'label' => 'Document  Roles',
            'singular_label' => 'Document Role',
          ),
        ),
        'location' => array(
          'post_types' => array('customer'),
          'label' => 'Location',
          'args' => array(
            'label' => 'Locations',
            'singular_label' => 'Location',
          ),
        ),
      );
    }

    private function default_taxonomy_args($name) {
      return array(
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
          'slug' => $name,
        ),
      );
    }

    public static function postTypes() {
      return array(
        'press_release' => array(
          'label' => 'Press Releases',
          'single' => 'Press Release',
          'plural' => 'Press Releases',
          'slug' => 'company/press',
          'supports' => array('title', 'editor', 'revision'),
          'taxonomies' => array('visibility'),
          'default' => 1,
        ),
        'event' => array(
          'label' => 'Events',
          'single' => 'Event',
          'plural' => 'Events',
          'slug' => 'company/news-and-events/events',
          'supports' => array('title'),
          'taxonomies' => array('visibility'),
          'default' => 1,
        ),
        'resource' => array(
          'label' => 'Resources - Collateral',
          'single' => 'Resource - Collateral',
          'plural' => 'Resources - Collateral',
          'slug' => 'resource',
          'supports' => array('title'),
          'taxonomies' => array('visibility'),
          'default' => 1,
        ),
        'leadership_bio' => array(
          'label' => 'Leadership Bios',
          'single' => 'Leadership Bio',
          'plural' => 'Leadership Bios',
          'slug' => 'company/leadership',
          'supports' => array('title', 'thumbnail'),
          'taxonomies' => array('visibility'),
          'default' => 1,
        ),
        'news_article' => array(
          'label' => 'News Articles',
          'single' => 'News Article',
          'plural' => 'News Articles',
          'slug' => 'company/press/news',
          'supports' => array('title'),
          'taxonomies' => array('visibility'),
          'default' => 1,
        ),
        'customer' => array(
          'label' => 'Customers',
          'single' => 'Customer',
          'plural' => 'Customers',
          'slug' => 'customers',
          'supports' => array('title'),
          'taxonomies' => array('visibility'),
          'default' => 1,
        ),
        'partner' => array(
          'label' => 'Partners',
          'single' => 'Partner',
          'plural' => 'Partners',
          'slug' => 'partner',
          'supports' => array('title'),
          'taxonomies' => array('visibility'),
          'default' => 1,
        ),
        'product' => array(
          'label' => 'Products',
          'single' => 'Product',
          'plural' => 'Products',
          'slug' => 'products',
          'supports' => array('title', 'editor', 'revisions'),
          'taxonomies' => array('visibility'),
          'default' => 1,
        ),
        'quote' => array(
          'label' => 'Quotes',
          'single' => 'Quote',
          'plural' => 'Quotes',
          'slug' => 'quotes',
          'supports' => array('title', 'editor', 'revisions'),
          'taxonomies' => array('visibility'),
          'default' => 1,
        ),
        'award' => array(
          'label' => 'Awards',
          'single' => 'Award',
          'plural' => 'Awards',
          'slug' => 'company/awards',
          'supports' => array('title', 'editor', 'revisions'),
          'taxonomies' => array('visibility'),
          'default' => 1,
        ),
        'career_posting' => array(
          'label' => 'Career Postings',
          'single' => 'Career Posting',
          'plural' => 'Career Postings',
          'slug' => 'company/careers',
          'supports' => array('title', 'editor', 'revisions'),
          'taxonomies' => array('visibility'),
          'default' => 1,
        ),
        'support_resource' => array(
          'label' => 'Resources - Support',
          'single' => 'Resource - Support',
          'plural' => 'Resources - Support',
          'slug' => 'services-support/technical-support/knowledge-center',
          'supports' => array('title', 'editor', 'revisions', 'comments'),
          'taxonomies' => array('visibility'),
          'default' => 1,
        ),
				'linkedin' => array(
          'label' => 'LinkedIn',
          'single' => 'LinkedIn',
          'plural' => 'LinkedIn',
          'supports' => array('title', 'editor'),
          'taxonomies' => array('visibility'),
          'default' => 1,
        ),
				'twitter' => array(
          'label' => 'Twitter',
          'single' => 'Twitter',
          'plural' => 'Twitter',
          'supports' => array('title', 'editor'),
          'taxonomies' => array('visibility'),
          'default' => 1,
        ),
        'site_options' => array(
          'label' => 'Site Options',
          'single' => 'Site Options',
          'plural' => 'Site Options',
          'slug' => 'site-options',
          'supports' => array('title', 'revisions'),
          'taxonomies' => array(),
          'default' => 1,
        ),
      );
    }

    function init() {
      $this->setup_post_types();
      $this->setup_taxonomies();
    }

    private function setup_taxonomies() {
      $taxonomies = self::taxonomies();
      foreach ($taxonomies as $name => $details) {
        if ( $this->settings->taxonomy_enabled($name) ) {
          $this->setup_taxonomy($name, $details);
        }
      }
    }

    private function setup_taxonomy($name, $details) {
      $args = array_merge($this->default_taxonomy_args($name), $details['args']);
      register_taxonomy(
        $name,
        $details['post_types'],
        $args
      );
    }

    private function setup_post_types() {
      $post_types = self::postTypes();
      foreach ($post_types as $type => $details) {
        if ( $this->settings->post_type_enabled($type) ) {
          $this->setup_post_type($type, $details);
        }
      }
    }

    private function setup_post_type($name, $details) {
      register_post_type(
        $name,
        array(
          'label' => __($details['label']),
          'description' => '',
          'public' => true,
          'show_ui' => true,
          'show_in_menu' => true,
          'capability_type' => 'post',
          'hierarchical' => false,
          'rewrite' => array(
            'slug' => $details['slug'],
            'with_front' => false
          ),
          'query_var' => true,
          'exclude_from_search' => false,
          'supports' => $details['supports'],
          'labels' => array (
            'name' => $details['plural'],
            'singular_name' => $details['single'],
            'menu_name' => $details['plural'],
            'add_new' => 'Add ' .$details['single'],
            'add_new_item' => "Add New {$details['single']}",
            'edit' => 'Edit',
            'edit_item' => "Edit {$details['single']}",
            'new_item' => "New {$details['single']}",
            'view' => "View {$details['single']}",
            'view_item' => "View {$details['single']}",
            'search_items' => "Search {$details['plural']}",
            'not_found' => "No {$details['plural']} Found",
            'not_found_in_trash' => "No {$details['plural']} Found in Trash",
            'parent' => "Parent {$details['single']}",
          ),
        )
      );
    }
  }
}

if ( class_exists('AtreNet_Post_Types') ) {
  register_activation_hook( __FILE__, array('AtreNet_Post_Types', 'activate') );
  register_deactivation_hook( __FILE__, array('AtreNet_Post_Types', 'activate') );

  $atrenet_post_types_plugin = new AtreNet_Post_Types();
}

class AtreNet_Post_Types_Settings {

  const OPTIONGROUP = 'atrenet_post_type_settings-group';
  const OPTIONPREFIX = 'atrenet_post_type_option_';
  const TEXTDOMAIN = AtreNet_Post_Types::TEXTDOMAIN;

  var $post_type_values = false;
  var $taxonomy_values = false;

  private static $instance = null;

  public static function getInstance() {
    if ( null == self::$instance ) {
      self::$instance = new self;
    }

    return self::$instance;
  }

  private function __construct() {
    add_action( 'admin_init', array($this, 'admin_init') );
    add_action( 'admin_menu', array($this, 'add_menu') );
  }

  public function admin_init() {
    register_setting( self::OPTIONGROUP, $this->get_option_name('post_types'), array($this, 'sanitizePostTypes') );
    register_setting( self::OPTIONGROUP, $this->get_option_name('taxonomies'), array($this, 'sanitizeTaxonomies') );
  }

  public function sanitizeTaxonomies($options) {
    $valid_names = array_keys( AtreNet_Post_Types::taxonomies() );
    return $this->sanitize_options($options, $valid_names);
  }

  public function sanitizePostTypes($options) {
    $valid_names = array_keys( AtreNet_Post_Types::postTypes() );
    return $this->sanitize_options($options, $valid_names);
  }

  public function sanitize_options($options, $valid_names) {
    if ( !is_array($options) || empty($options) || (false === $options) ) {
      return array();
    }

    $clean_options = array();

    foreach ($valid_names as $option_name) {
      if ( isset($options[$option_name]) && (1 == $options[$option_name]) ) {
        $clean_options[$option_name] = 1;
      }
    }

    unset($options);
    return $clean_options;
  }


  public function settings_section_atrenet_post_types() {
    // Help text for the section
    echo 'These settings do things for the AtreNet Post Types plugin';
  }

  public function add_menu() {
    add_options_page(
      'AtreNet Post Types Settings', // page title
      'AtreNet Post Types', // menu title
      'manage_options', // capability
      'atrenet_post_types', // menu slug
      array($this, 'plugin_settings_page') // output callback function
    );
  }

  public function plugin_settings_page() {
    if ( !current_user_can('manage_options') ) {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    $post_types = AtreNet_Post_Types::postTypes();
    $taxonomies = AtreNet_Post_Types::taxonomies();
?>
<div class="wrap">
  <form method="post" action="options.php">
    <?php settings_fields(self::OPTIONGROUP); ?>
    <h2><?php _e('AtreNet Post Types', self::TEXTDOMAIN); ?></h2>
    <?php $post_type_values = $this->post_type_values(); ?>
    <table class="form-table">
      <?php foreach ($post_types as $name => $info) : ?>
        <tr valign="top">
          <th scope="row"><?php _e($info['label'], self::TEXTDOMAIN); ?></th>
          <td>
            <input type="checkbox" name="<?php $this->the_option_name('post_types', $name); ?>" value="1" <?php $this->the_option_checked($name, $post_type_values); ?> /></td>
        </tr>
      <?php endforeach; ?>
    </table>


    <h2><?php _e('AtreNet Taxonomies', self::TEXTDOMAIN); ?></h2>
    <?php $taxonomy_values = $this->taxonomy_values(); ?>
    <table class="form-table">
      <?php foreach ($taxonomies as $name => $info) : ?>
        <tr valign="top">
          <th scope="row"><?php _e($info['label'], self::TEXTDOMAIN); ?></th>
          <td>
            <input type="checkbox" name="<?php $this->the_option_name('taxonomies', $name); ?>" value="1" <?php $this->the_option_checked($name, $taxonomy_values); ?> /></td>
        </tr>
      <?php endforeach; ?>
    </table>

    <?php submit_button(); ?>
  </form>
</div>
<?php
  }

  private function the_option_name($name, $index = '') {
    echo $this->get_option_name($name, $index);
  }

  public function get_option_name($name, $index = '') {
    $option_name = self::OPTIONGROUP . $name;
    if ('' !== $index) {
      $option_name .= '[' . $index . ']';
    }
    return $option_name;
  }

  private function the_option_checked($index, $values) {
    echo $this->get_option_checked($index, $values);
  }

  private function get_option_checked($name, $values) {
    $checked = '';
    if ( $this->option_enabled($name, $values) ) {
      $checked = ' checked';
    }

    return $checked;
  }

  private function taxonomy_values() {
    if (!$this->taxonomy_values) {
      $this->taxonomy_values = get_option( $this->get_option_name('taxonomies') );
    }
    return $this->taxonomy_values;
  }

  private function post_type_values() {
    if (!$this->post_type_values) {
      $this->post_type_values = get_option( $this->get_option_name('post_types') );
    }
    return $this->post_type_values;
  }

  private function post_type_value($type) {
    $post_type_values = $this->post_type_values();
    return $this->option_value($type, $post_type_values);
  }

  private function taxonomy_value($name) {
    $taxonomy_values = $this->taxonomy_values();
    return $this->option_value($name, $taxonomy_values);
  }

  private function option_value($index, $values) {
    $value = 0;
    if ( is_array($values) && array_key_exists($index, $values) ) {
      $value = $values[$index];
    }
    return $value;
  }

  function option_enabled($name, $values) {
    return 1 == $this->option_value($name, $values);
  }

  function taxonomy_enabled($name) {
    return 1 == $this->taxonomy_value($name);
  }

  function post_type_enabled($type) {
    return 1 == $this->post_type_value($type);
  }
}
