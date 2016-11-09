<?php

require_once get_template_directory() . '/classes/Plinth_Widget_Abstract.php';

class Plinth_Widget_PressReleases extends Plinth_Widget_Abstract {
  public function __construct() {
    parent::__construct(
      'plinth-pr-widget',
      'Plinth PR Widget',
      'Widget for displaying recent press releases'
    );

    add_action('save_post', array($this, 'flush_widget_cache'));
    add_action('deleted_post', array($this, 'flush_widget_cache'));
    add_action('switch_theme', array($this, 'flush_widget_cache'));
  }

  protected function field_defaults() {
    return array(
      'title' => 'Recent Press Releases',
      'limit' => '5'
    );
  }

  public function form($instance) {
    $defaults = $this->field_defaults();
    $instance = wp_parse_args( (array) $instance, $defaults );
    $title = strip_tags($instance['title'], '<br>');
    $limit = absint($instance['limit']);

    $this->text_field('Title', 'title', $title);
    $this->text_field('Number of posts to show', 'limit', $limit, true, 3);
  }

  public function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['limit'] = (int) $new_instance['limit'];
    $this->flush_widget_cache();

    $alloptions = wp_cache_get('alloptions', 'options');
    if (isset($alloptions[$this->id_base])) {
      delete_option($this->id_base);
    }

    return $instance;
  }

  public function widget($args, $instance, $echo = true) {
    $cache = wp_cache_get($this->id_base, 'widget');
    if (!is_array($cache)) {
      $cache = array();
    }

    if (!isset($args['widget_id'])) {
      $args['widget_id'] = $this->id;
    }

    if (isset($cache[$args['widget_id']])) {
      if($echo) {
        echo $cache[$args['widget_id']];
        return;
      } else {
        return $cache[$args['widget_id']];
      }
    }

    ob_start();
    extract($args);

    $title = !empty($instance['title']) ? $instance['title'] : '';
    $limit = !empty($instance['limit']) ? intval($instance['limit']) : 5;

    $query_args = array(
      'post_type'           => 'press_release',
      'posts_per_page'      => $limit,
      'no_found_rows'       => true,
      'post_status'         => 'publish',
      'ignore_sticky_posts' => true
    );

    $r = new WP_Query(apply_filters('widget_posts_args', $query_args));

    if($r->have_posts()) {
      echo $before_widget;

      if(!empty($title)) {
        echo $before_title . $title . $after_title;
      }

      $out = '';
      while ($r->have_posts()) {
        $r->the_post();
        $title = get_the_title();
        $id = get_the_ID();
        $out .= sprintf('<li><time class="post-date" datetime="%s">%s</time><a href="%s" title="%s">%s</a>%s</li>',
          esc_attr(get_the_date('c')),
          esc_html(plinth_get_formatted_date(get_the_time('c'))),
          get_the_permalink($id),
          esc_attr($title ? $title : $id),
          $title ? $title : $id,
          plinth_custom_field_excerpt('excerpt', 24, ' [...]')
        );
      }

      echo "<ul>$out</ul>";

      echo $after_widget;
    }

    // Reset the global $the_post as this query will have stomped on it
    wp_reset_postdata();

    #$cache[$args['widget_id']] = ob_get_flush();
    $cache[$args['widget_id']] = ob_get_clean();
    wp_cache_set($this->id_base, $cache, 'widget');

    if($echo) {
      echo $cache[$args['widget_id']];
    } else {
      return $cache[$args['widget_id']];
    }
  }
}

