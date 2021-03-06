<?php
class Plinth_PostsByTaxonomyQuery extends WP_Query {
  public function __construct($args = array()) {
    $this->my_taxonomy = $args['taxonomy'];
    unset($args['taxonomy']);

    // Force these args
    $args = array_merge($args, array(
      #'post_type' => 'book',
      #'posts_per_page' => -1,  // Turn off paging
      'no_found_rows' => true, // Optimize query for no paging
      'update_post_term_cache' => false,
      'update_post_meta_cache' => false
    ));

    add_filter('posts_fields', array($this, 'my_posts_fields'));
    add_filter('posts_join', array($this, 'my_posts_join'));
    add_filter('posts_where', array($this, 'my_posts_where'));
    add_filter('posts_orderby', array($this, 'my_posts_orderby'));

    parent::__construct($args);

    // Make sure these filters don't affect any other queries
    remove_filter('posts_fields', array($this, 'my_posts_fields'));
    remove_filter('posts_join', array($this, 'my_posts_join'));
    remove_filter('posts_where', array($this, 'my_posts_where'));
    remove_filter('posts_orderby', array($this, 'my_posts_orderby'));
  }

  function my_posts_fields($sql) {
    global $wpdb;
    return $sql . ", $wpdb->terms.name AS '{$this->my_taxonomy}'";
  }

  function my_posts_join($sql) {
    global $wpdb;
    return $sql . "
      INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id)
      INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
      INNER JOIN $wpdb->terms ON ($wpdb->terms.term_id = $wpdb->term_taxonomy.term_id)
    ";
  }

  function my_posts_where( $sql ) {
    global $wpdb;
    return $sql . " AND $wpdb->term_taxonomy.taxonomy = '{$this->my_taxonomy}'";
  }

  function my_posts_orderby( $sql ) {
    global $wpdb;
    return "$wpdb->terms.name ASC, $wpdb->posts.post_title ASC";
  }

}
