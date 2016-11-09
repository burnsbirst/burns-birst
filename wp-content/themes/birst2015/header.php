<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package PlinthChild
 */
?><?php  flush_rewrite_rules();  ?><!DOCTYPE html>
<<<<<<< HEAD
<!--[if IE 8]>    <html class="no-js ie8 oldie<?php echo $html_class; ?>" <?php echo $lang_attr; ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js<?php echo $html_class; ?>" <?php echo $lang_attr; ?>> <!--<![endif]-->
=======
<!--[if IE 8]>    <html class="no-js ie8 oldie<?php echo $html_class; ?>" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js<?php echo $html_class; ?>" <?php language_attributes(); ?>> <!--<![endif]-->
>>>>>>> 89b9172eea483f5158c9e5148834d1fb070b325b
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<title><?php
    $title = wp_title(' - ', false, 'right');
    if (strlen($title) > 55) $title = substr($title, 0, 52) . "...";
    echo $title;
?></title>

  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <?php if(get_field('canonical')):?>
  <link rel="canonical" href=" <?php echo get_site_url(); ?>/<?php the_field('canonical'); ?>" />
  <?php endif; ?>

  <link rel="shortcut icon" href="/favicon.ico" />
  <meta name="google-site-verification" content="sAxU6P9Sa1VMLsVPNbUDcR61mRwHP7SSatTtcjsVoUQ" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!--[if lt IE 9]> <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/vendor/selectivizr-1.0.2.min.js" type="text/javascript"></script> 	<![endif]-->
  <!--[if lt IE 9]> <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/vendor/respond-1.4.2.min.js" type="text/javascript"></script> <![endif]-->

  <?php wp_head(); ?>
  
  <script type="text/javascript" src="//cdn.captora.com/js/track.js"></script>
  
  <!-- Optimizely tracking script -->
  <script src="//cdn.optimizely.com/js/1517790672.js" async></script>  
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-5057004-1', 'auto');
  ga('send', 'pageview');

</script>
  <link type="text/css" rel="stylesheet" href="https://fast.fonts.net/cssapi/c8b545a6-5eb7-4db0-aa2d-9ce45c07999a.css"/>

</head>
<body <?php body_class(); ?>>

<div id="page" class="hfeed site">
<<<<<<< HEAD
<<<<<<< HEAD

  <div id="masthead-wrapper">
    <header id="masthead" class="site-header" role="banner">
      <div class="masthead-container">
				
=======
  <?php if ( get_field('show_header') !== false ): ?>
=======
	<?php if ( get_field('show_header') !== false ): ?>
>>>>>>> b578282b3bb11b4d4292d0819a77cb78c063e920
  <div id="masthead-wrapper">
    <header id="masthead" class="site-header" role="banner">
      <div class="masthead-container">

>>>>>>> 89b9172eea483f5158c9e5148834d1fb070b325b
        <div id="mobile-search-container">
          <form action="/" method="get">
          	<input type="text" name="s" id="search-mobile" placeholder="Search" value="<?php the_search_query(); ?>" />
            <input type="image" placeholder="Search" alt="Search" src="<?php echo get_stylesheet_directory_uri() ; ?>/images/search.jpg" />
            
          </form>
          <input type="image" class="close-search" alt="Close" src="<?php echo get_stylesheet_directory_uri() ; ?>/images/search-close.jpg" />
        </div>
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#mobile-navigation">
          <span class="screen-reader-text">Toggle primary navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <div class="navbar-header primary">
          <div class="site-branding">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
              <img src="/images/birst-logo-2.png" width="294" height="65" alt="Logo Text" class="desktop-logo" >
            </a>
          </div>
        </div><!-- .navbar-header.primary -->
				
        <div class="navigation-container">
        	<nav id="mobile-navigation" class="section-navigation collapse navbar-collapse" role="navigation">
						<?php wp_nav_menu( array('theme_location' => 'mobile-nav') ); ?>
          </nav>
          <nav id="toolbar">
            <?php wp_nav_menu( array('theme_location' => 'toolbar') ); ?>
            <div id="search-container">
            <form action="/" method="get">
                <input type="text" name="s" id="search" placeholder="Search" value="<?php the_search_query(); ?>" />
                <input type="image" placeholder="Search" alt="Search" src="<?php echo get_stylesheet_directory_uri() ; ?>/images/search.jpg" />
            </form>
            </div>
          </nav>
  
          <div id="site-navigation" class="main-nav">
          	<?php wp_nav_menu( array('theme_location' => 'main-nav') ); ?>
          </div>
          <div class="clearfix"></div>
        </div>
        
      </div><!-- .masthead-container -->
	  </header><!-- #masthead -->
    <?php if ( $secondary_nav = plinth_get_secondary_navigation() ) : ?>
      <div class="secondary-nav--container">
        <div class="secondary-nav--container-row">
          <nav id="section-navigation" class="section-navigation collapse navbar-collapse" role="navigation">
            <?php echo $secondary_nav; ?>
          </nav><!--#section-navigation-->
        </div>
      </div>
    <?php endif; ?>
  </div><!-- .masthead-wrapper -->

<<<<<<< HEAD
=======
  <?php endif; ?>

>>>>>>> 89b9172eea483f5158c9e5148834d1fb070b325b
  <div id="content-wrapper">
    <div id="content" class="site-content">
