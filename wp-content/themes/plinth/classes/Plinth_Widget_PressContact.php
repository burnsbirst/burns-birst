<?php

require_once get_template_directory() . '/classes/Plinth_Widget_Abstract.php';

class Plinth_Widget_PressContact extends Plinth_Widget_Abstract {
  public function __construct() {
    parent::__construct(
      'plinth-press-contact-widget',
      'Plinth Press Contact Widget',
      'Widget for displaying press contact(s)'
    );
  }

  protected function field_defaults() {
    return array(
      'title' => ''
    );
  }

  public function form($instance) {
    $defaults = $this->field_defaults();
    $instance = wp_parse_args( (array) $instance, $defaults );
    $title = strip_tags($instance['title'], '<br>');

    $this->text_field('Title', 'title', $title);
  }

  public function widget($args, $instance, $echo = true) {
    #global $post;

    extract($args);

    $title = $instance['title'];

    #$pressContactTemplate = '<p class="press-contact"><span class="press-contact-name">%s</span><span class="press-contact-phone">%s</span><span class="press-contact-email">%s</span></p>';
    $pressContactTemplate = '<div class="press-contact">%s</div>';

    #$pr_details = plinth_get_site_option('press_release_details');
    #$pr_contact = $pr_details['press_contact'];
    $pr_options = plinth_get_site_option('press_releases');
    $pr_contact = $pr_options['press_contact'];

    if(empty($pr_contact)) {
      return;
    }

    echo $before_widget;

    if(!empty($title)) {
      echo $before_title . $title . $after_title;
    }

    printf($pressContactTemplate, $pr_contact);

    echo $after_widget;
  }
}

