<?php

require_once get_template_directory() . '/classes/Plinth_Widget_Abstract.php';

class Plinth_Widget_News extends Plinth_Widget_Abstract {
  public function __construct() {
    parent::__construct(
      'plinth-news-widget',
      'Plinth News Widget',
      'Widget for displaying recent news articles'
    );

    add_action('save_post', array($this, 'flush_widget_cache'));
    add_action('deleted_post', array($this, 'flush_widget_cache'));
    add_action('switch_theme', array($this, 'flush_widget_cache'));
  }

  protected function field_defaults() {
    return array(
      'title' => 'Recent News',
      'limit' => 5,
      'show_more_link' => false
    );
  }

  public function form($instance) {
    $defaults = $this->field_defaults();
    $instance = wp_parse_args( (array) $instance, $defaults );
    $title = strip_tags($instance['title'], '<br>');
    $limit = intval($instance['limit']);
    $show_more_link = !!$instance['show_more_link'];

    $this->text_field('Title', 'title', $title);
    $this->text_field('Number of posts to show', 'limit', $limit, true, 3);
    $this->checkbox_field('Show more link?', 'show_more_link', $show_more_link);
  }

  public function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['limit'] = intval($new_instance['limit']);
    $instance['show_more_link'] = !!$new_instance['show_more_link'];
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

    $title = !empty($instance['title']) ? $instance['title'] : __('Recent News', 'plinth');
    $limit = !empty($instance['limit']) ? intval($instance['limit']) : 5;
    $show_more_link = !!$instance['show_more_link'];

    $r = new WP_Query(apply_filters('widget_posts_args', array(
      'post_type'           => 'news_article',
      'posts_per_page'      => $limit,
      'no_found_rows'       => true,
      'post_status'         => 'publish',
      'ignore_sticky_posts' => true
    )));

    echo $before_widget;

    if(!empty($title)) {
      echo $before_title . $title . $after_title;
    }

    if(!$r->have_posts()) {
      echo '<p class="news-article-list--empty news-list--empty">' . __('There are no news articles to display.', 'plinth') . '</p>';
    } else {
      echo '<ul class="news-article-list news-list">';
      while ($r->have_posts()) {
        $r->the_post();
        include(locate_template('partials/component-news_article.php'));
      }
      echo '</ul>';

      if($show_more_link) {
        $news_article_listing_page = plinth_get_site_option('news_article_listing_page');
        printf('<a class="more-link" href="%1$s">%2$s</a>',
          get_permalink($news_article_listing_page->ID),
          __('More News', 'plinth')
        );
      }
    }

    echo $after_widget;

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

