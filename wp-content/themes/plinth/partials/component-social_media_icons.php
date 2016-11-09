<?php

$social_media_profiles = plinth_get_site_option('social_media');

/* If there is only one profile, then $social_media_profiles will not be a
 * mutli-dimensional array, so make it a mutli-dimensional array.
 */
//if(is_array($social_media_profiles) && array_key_exists('network', $social_media_profiles)) {
  //$social_media_profiles = array($social_media_profiles);
//}
?>

<?php if(!empty($social_media_profiles)): ?>
  <ul class="social-media__list" itemscope itemtype="http://schema.org/Organization">
    <link itemprop="url" href="http://www.tanium.com">
    <?php foreach($social_media_profiles as $social_media_profile): ?>
      <?php printf('<li class="social-media__item"><a itemprop="sameAs" href="%2$s" class="icon--%1$s">%3$s</a></li>',
        $social_media_profile['network'],
        $social_media_profile['url'],
        $social_media_profile['network']
        #plinth_get_field_label_for_value('network', $social_media_profile['network']) // only works for posts in The Loop
      ); ?>
    <?php endforeach; ?>
  </ul>
<?php endif;

