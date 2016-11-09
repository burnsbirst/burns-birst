<div id="buzz-wrapper">
	<div class="buzz-wrapper-container">
		<div class="news-content">
			<?php echo do_shortcode('[plinth-pr-widget title="What\'s New" limit="4"]'); ?>
      <a href="/company/press/">read more	&#8594;</a>
		</div>
		<div class="events-content">
			<?php echo do_shortcode('[plinth-news-widget title="Birst in the News" limit="4"]'); ?>
      <a href="/company/news/">read more &#8594;</a>
		</div>
		<div class="promo-content">
			<h2 class="widgettitle"><?php echo plinth_the_single_site_option( array( 'buzz_bug_title' ) ); ?></h2>
			<?php echo plinth_the_single_site_option( array( 'buzz_bug_content' ) ); ?>
		</div>
	</div>
</div>