<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Plinth
 */

$title_option_keys = array('404_page', '404_page_title');
$content_option_keys = array('404_page', '404_page_content');

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<article class="error-404 not-found">
				<header class="page-header">
					<h1 class="h-page-heading"><?php plinth_the_single_site_option($title_option_keys); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php plinth_the_single_site_option($content_option_keys); ?></p>
				</div><!-- .page-content -->
			</article><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
