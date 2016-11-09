<?php 
	$links = get_field('links');
		//print_r($links);
	$url = '';
	$title = '';
	if($links[0]):
		if($links[0]['external_url'] != ''):
			$url = $links[0]['external_url'];
		endif;
		if($links[0]['local_file'] != ''):
			$url = $links[0]['local_file'];
		endif;
		$title = '<a href="'.$url.'">'.get_the_title().'</a>';
	else:
		$title = get_the_title();
	endif;
	
		?>
<li class="news-article-list__item news-list__item">
  <div class="news-article-list__item__content news-list__item__content">
    <time class="news-article-list__item__date news-list__item__date"><?php echo get_the_date(); ?></time>
    <span class="news-article-list__item__title news-list__item__title"><?php echo $title; ?></span>
  </div>
</li>
