<?php
$event_url = get_field('event_url');
$event_url_cta = get_field('event_url_cta');
if(empty($event_url_cta)) {
  $event_url_cta = __('Learn More', Plinth::TEXTDOMAIN);
}
$registration_url = get_field('registration_url');
$registration_url_cta = get_field('registration_url_cta');
if(empty($registration_url_cta)) {
  $registration_url_cta = __('Register Now', Plinth::TEXTDOMAIN);
}
$today_timestamp = strtotime(date('Y-m-d'));
$start_date_timestamp = strtotime(get_field('start_date'));

if ($today_timestamp <= $start_date_timestamp):
if ($limit>=$count||$limit==-1):
?>
<li class="event-list__item news-list__item">
  <div class="event-list__item__logo news-list__item__logo">
    <?php plinth_image_from_field('logo'); ?>
  </div>
  <div class="event-list__item__content news-list__item__content">
    <span class="event-list__item__title news-list__item__title"><?php the_title(); ?></span>
    <time class="event-list__item__date news-list__item__date"><?php plinth_the_formatted_date_range(get_field('start_date'), get_field('end_date')); ?></time>
    <span class="event-list__item__location news-list__item__location"><?php the_field('location'); ?></span>
    <?php if(!empty($event_url)): ?>
      <a href="<?php echo esc_url($event_url); ?>"><?php echo $event_url_cta; ?></a>
    <?php endif; ?>
    <?php if(!empty($registration_url)): ?>
      <?php if(!empty($event_url)) { echo ' | '; } ?>
      <a href="<?php echo esc_url($registration_url); ?>"><?php echo $registration_url_cta; ?></a>
    <?php endif; ?>
  </div>
</li>
<?php $count++; ?>
<?php endif; ?>
<?php endif; ?>