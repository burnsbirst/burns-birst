<li class="press-release-list__item news-list__item">
  <time class="press-release-list__item__date news-list__item__date" datetime="<?php esc_attr_e(get_the_date('c')); ?>"><?php esc_html_e(plinth_get_formatted_date(get_the_time('c'))); ?></time>
  <a class="press-release-list__item__title news-list__item__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
</li>
