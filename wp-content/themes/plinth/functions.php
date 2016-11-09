<?php

// Utility Classes
require_once get_template_directory() . '/classes/AtreNet_DateFormat.php';
require_once get_template_directory() . '/classes/Plinth_PostsByTaxonomyQuery.php';

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}

// Widgets
$widgets = array(
  'Plinth_Widget_Authors',
  'Plinth_Widget_Events',
  'Plinth_Widget_News',
  'Plinth_Widget_PressContact',
  'Plinth_Widget_PressReleases'
);
foreach ($widgets as $widget) {
  require_once get_template_directory() . "/classes/{$widget}.php";
  add_action('widgets_init', create_function('', "register_widget('{$widget}');"));
}

// Core Theme Class
require_once get_template_directory() . '/classes/Plinth.php';
Plinth::getInstance();

// Custom template tags
require_once get_template_directory() . '/inc/template-tags.php';
