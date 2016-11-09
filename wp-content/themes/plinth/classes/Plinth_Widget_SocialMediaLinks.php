<?php

require_once get_template_directory() . '/classes/Plinth_Widget_Abstract.php';

class Plinth_Widget_SocialMediaLinks extends Plinth_Widget_Abstract {
  public function __construct() {
    parent::__construct(
      'plinth-social-media-links-widget',
      'Plinth Social Media Links Widget',
      'Widget for displaying social media links'
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

    // TODO - Get list of social media profiles from Site Options and inject JS to allow users to insert/remove and sort the profiles they'd like to provide links to. Also provide text fields for setting (optional) link text.
    /*
    $social_media_profiles = plinth_get_site_option('social_media');
    foreach($social_media_profiles as $social_media_profile) {
    }
    */
  }

  public function widget($args, $instance) {
    #global $post;

    extract($args);

    $title = $instance['title'];

    echo $before_widget;

    #$pressContactTemplate = '<p class="press-contact"><span class="press-contact-name">%s</span><span class="press-contact-phone">%s</span><span class="press-contact-email">%s</span></p>';
    $socialMediaLinkTemplate = '<div class="social-media-link">%s</div>';

    if(!empty($title)) {
      echo $before_title . $title . $after_title;
    }

    printf($pressContactTemplate, $pr_contact);

    echo $after_widget;
  }
}

