<?php
/**
 * Template Name: Layers
 * @subpackage PlinthChild
 */

get_header();

$layers = get_field('layers');
if(isset($layers) && !empty($layers)) {
  foreach($layers as $layer) {
    include(locate_template('partials/layer-' . $layer['acf_fc_layout'] . '.php'));
  }
}

#$opportunities_group = get_field('opportunity_tiles_group');
#if($opportunities_group) {
#  include(locate_template('partials/component-opportunities_tiles.php'));
#}

get_footer();

