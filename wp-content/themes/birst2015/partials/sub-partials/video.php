<div class="video-container">
  <?php printf('<a href="%s" class="video-placeholder %s">%s</a>',
    $item['video_url'],
    (isset($item['video_popup']) && $item['video_popup']) ? 'modal-video' : '',
    (isset($item['video_thumbnail']) && !empty($item['video_thumbnail'])) ? plinth_get_html_for_image($item['video_thumbnail']) : plinth_get_image_from_video($item['video_url'])
  ); ?>
</div>

