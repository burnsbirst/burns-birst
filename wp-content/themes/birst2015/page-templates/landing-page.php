<?php
/**
 * Template Name: Landing Page
 * @subpackage PlinthChild
 */

get_header();

$layers = get_field('layers');
if(isset($layers) && !empty($layers)) {
  foreach($layers as $layer) {
    include(locate_template('partials/layer-' . $layer['acf_fc_layout'] . '.php'));
  }
}

?>
<div class="footer-copyright">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        © Birst All Rights Reserved.
      </div>
      <div class="privacy">
        <a href="/website/privacy-policy/" target="_blank">Privacy Policy</a> | <a href="/company/contact/" target="_blank">Contact Birst</a>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();

