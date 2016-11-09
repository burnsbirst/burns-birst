<?php

require_once get_template_directory() . '/classes/Plinth_Widget_Abstract.php';

class Plinth_Widget_Events extends Plinth_Widget_Abstract {
  public function __construct() {
    parent::__construct(
      'plinth-events-widget',
      'Plinth Events Widget',
      'Widget for displaying upcoming events'
    );

    add_action('save_post', array($this, 'flush_widget_cache'));
    add_action('deleted_post', array($this, 'flush_widget_cache'));
    add_action('switch_theme', array($this, 'flush_widget_cache'));
  }

  protected function field_defaults() {
    return array(
      'title' => 'Upcoming Events',
      'limit' => 5,
      'show_more_link' => false,
			'show_description' => false
    );
  }

  public function form($instance) {
    $defaults = $this->field_defaults();
    $instance = wp_parse_args( (array) $instance, $defaults );
    $title = strip_tags($instance['title'], '<br>');
    $limit = absint($instance['limit']);
    $show_more_link = !!$instance['show_more_link'];

    $this->text_field('Title', 'title', $title);
    $this->text_field('Number of posts to show', 'limit', $limit, true, 3);
    $this->checkbox_field('Show more link?', 'show_more_link', $show_more_link);
  }

  public function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['limit'] = (int) $new_instance['limit'];
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

    $title = !empty($instance['title']) ? $instance['title'] : '';
    $limit = !empty($instance['limit']) ? intval($instance['limit']) : 5;
    $show_more_link = !!$instance['show_more_link'];
		$show_description = !!$instance['show_description'];

    $r = new WP_Query(apply_filters('widget_posts_args', array(
      'post_type'           => 'event',
			'meta_key' => 'start_date',
      'meta_query'          => array(array(
					'key'     => 'start_date',
					'value'   => date('Y-m-d H:i'),
					'compare' => '>',
					'type' => 'DATE'
				)),
      'no_found_rows'       => true,
      'post_status'         => 'publish',
      'ignore_sticky_posts' => true,
			'posts_per_page'      => $limit,
			'orderby' => 'start_date',
			'order' => 'ASC'
    )));

    echo $before_widget;

    if(!empty($title)) {
      echo $before_title . $title . $after_title;
    }
		
		//$r->posts = array_reverse($r->posts);
		//echo count($r->posts);
		// reverse array when limit is set | TODO: investigate why this is nessecary
		if($limit != -1):
			for($i=0; $i<=count($r->posts); $i++):
				if($i >= $limit):
					unset($r->posts[$i]);
				endif;
			endfor;
		endif;
		
		//echo '<pre>';
			//print_r($r->posts);
		//echo '</pre>';
		
    if(!$r->have_posts()) {
      echo '<p class="event-list--empty news-list--empty">' . __('There are no upcoming events.', 'plinth') . '</p>';
    } else {
      echo '<ul class="event-list news-list">';
	  $count=1;
      while ($r->have_posts()) {
        $r->the_post();
        include(locate_template('partials/component-event.php'));
      }
      echo '</ul>';

      if($show_more_link) {
        $event_listing_page = plinth_get_site_option('event_listing_page');
        printf('<a class="more-link" href="%1$s">%2$s</a>',
          get_permalink($event_listing_page->ID),
          __('More Events', 'plinth')
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

