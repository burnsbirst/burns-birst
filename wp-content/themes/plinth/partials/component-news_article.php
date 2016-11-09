<li class="news-article-list__item news-list__item">
  <?php plinth_image_from_field('logo', 'news-article-list__item__logo news-list__item__logo'); ?>
  <div class="news-article-list__item__content news-list__item__content">
    <time class="news-article-list__item__date news-list__item__date"><?php plinth_the_formatted_date_range(get_field('start_date'), get_field('end_date')); ?></time>
    <span class="news-article-list__item__title news-list__item__title"><?php the_title(); ?></span>
    <span class="news-article-list__item__location news-list__item__location"><?php the_field('location'); ?></span>
    <?php if(!empty($event_url)): ?>
      <a href="<?php echo esc_url($event_url); ?>"><?php echo $event_url_cta; ?></a>
    <?php endif; ?>
    <?php if(!empty($registration_url)): ?>
      <?php if(!empty($event_url)) { echo ' | '; } ?>
      <a href="<?php echo esc_url($registration_url); ?>"><?php echo $registration_url_cta; ?></a>
    <?php endif; ?>
  </div>
</li>
