<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package test
 */
ob_start();
language_attributes();
$lang_attr = ob_get_clean();
$lang_attr = explode('-', $lang_attr); // get rid of Country code
$lang_attr = $lang_attr[0] .'"';
$html_class = '';
?><!DOCTYPE html>
<!--[if IE 8]>    <html class="no-js ie8 oldie<?php echo $html_class; ?>" <?php echo $lang_attr; ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js<?php echo $html_class; ?>" <?php echo $lang_attr; ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php plinth_the_single_site_option(array('analytics', 'ga_account'), 'UA-XXXXXXX-Y'); ?>']);
  _gaq.push(['_setDomainName', '<?php plinth_the_single_site_option(array('analytics', 'ga_domain'), '.example.com'); ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

  <header id="masthead" class="masthead site-header" role="banner">
    <div class="masthead__row">
      <div class="masthead__row__content">

        <div class="navbar-header primary">
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#mobile-navigation">
            <span class="screen-reader-text">Toggle primary navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <div class="site-branding">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
              <img src="/images/logo.png" width="140" height="100" alt="Logo Text" class="desktop-logo" >
              <img src="/images/logo-inline.png" width="115" height="34" alt="Logo Text" class="mobile-logo" />
            </a>
          </div>
        </div><!-- .navbar-header.primary -->

        <nav id="mobile-navigation" class="section-navigation collapse navbar-collapse" role="navigation">
          <?php wp_nav_menu( array('theme_location' => 'mobile-nav') ); ?>
        </nav>

        <nav id="toolbar" class="divided-nav">
          <?php wp_nav_menu( array('theme_location' => 'toolbar') ); ?>
          <div id="search-container">
            <!-- search goes here... -->
          </div>
        </nav>

        <nav id="site-navigation" class="main-navigation divided-nav" role="navigation">
          <div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'plinth' ); ?>"><?php _e( 'Skip to content', 'plinth' ); ?></a></div>
          <?php wp_nav_menu( array('theme_location' => 'main-nav') ); ?>
        </nav><!-- #site-navigation -->
      </div><!-- .masthead__row__content -->
    </div><!-- .masthead__row -->

    <div class="masthead__row">
      <div class="masthead__row__content">
        <div class="navbar-header secondary">
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#section-navigation">
            <span class="screen-reader-text">Toggle secondary navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <nav id="section-navigation" class="section-navigation collapse navbar-collapse divided-nav" role="navigation">
            <?php plinth_display_secondary_navigation(); ?>
          </nav>
        </div><!-- .navbar-header.secondary -->
      </div><!-- .masthead__row__content -->
    </div><!-- .masthead__row -->
  </header><!-- #masthead -->

  <div id="content-wrapper">
    <div id="content" class="site-content">

