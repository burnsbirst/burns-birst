<?php

require_once get_template_directory() . '/classes/Plinth_Widget_Abstract.php';

class Plinth_Widget_Authors extends Plinth_Widget_Abstract {
  public function __construct() {
    parent::__construct(
      'plinth-authors-widget',
      'Plinth Authors Widget',
      'Widget for displaying list of blog authors'
    );

    add_action('save_post', array($this, 'flush_widget_cache'));
    add_action('deleted_post', array($this, 'flush_widget_cache'));
    add_action('switch_theme', array($this, 'flush_widget_cache'));
  }

  protected function field_defaults() {
    return array(
      'title' => '',
      'show_photos' => true
    );
  }

  public function form($instance) {
    $defaults = $this->field_defaults();
    $instance = wp_parse_args( (array) $instance, $defaults );
    $title = strip_tags($instance['title'], '<br>');
    $show_photos = !!$instance['show_photos'];

    $this->text_field('Title', 'title', $title);
    $this->checkbox_field('Show Photos?', 'show_photos', $show_photos);
  }

  public function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['show_photos'] = !!$new_instance['show_photos'];
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
      if ($echo) {
        echo $cache[$args['widget_id']];
        return;
      } else {
        return $cache[$args['widget_id']];
      }
    }

    ob_start();
    extract($args);

    $title = !empty($instance['title']) ? $instance['title'] : __('Authors', 'plinth');
    $show_photos = !!$instance['show_photos'];

    $authors = get_users(array(
      'fields' => 'all',
      'who'    => 'authors'
    ));

    echo $before_widget;

    if(!empty($title)) {
      echo $before_title . $title . $after_title;
    }

    echo '<ul class="authors-list">';
    foreach ($authors as $author) {
      if ('admin' === $author->user_nicename || count_user_posts($author->ID) < 1) { continue; }
      printf('<li class="authors-list-item"><a href="%1$s">%2$s<span class="author-meta"><span class="author-name">%3$s</span><span class="author-title">%4$s</span></span></a></li>',
        get_author_posts_url($author->ID, $author->user_nicename),
        $show_photos ? get_avatar($author->ID, 56) : '',
        esc_html($author->display_name),
        get_user_meta($author->ID, 'nickname', true)
      );
    }
    echo '</ul>';

    echo $after_widget;

    $cache[$args['widget_id']] = ob_get_clean();
    wp_cache_set($this->id_base, $cache, 'widget');

    if ($echo) {
      echo $cache[$args['widget_id']];
    } else {
      return $cache[$args['widget_id']];
    }
  }
}

