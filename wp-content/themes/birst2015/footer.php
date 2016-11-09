<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package PlinthChild
 */
?>

    </div><!-- #content -->
  </div><!-- #content-wrapper -->
  <?php if(get_field('show_featured_resources') == 1): ?>
  <?php get_template_part( 'partials/component', 'featured_resources' ); ?>
  <?php endif; ?>
  <?php if(get_field('show_buzz') == 1): ?>
  <?php get_template_part( 'partials/component', 'buzz' ); ?>
  <?php endif; ?>
  <?php $template_file = get_post_meta( get_the_ID(), '_wp_page_template', TRUE ); ?>
  <?php if ( $template_file != 'page-templates/landing-page.php' ): ?>
  <div id="footer-wrapper">
    <?php
  function curl_captora_download($url) {
  // is cURL installed?
  if (!function_exists('curl_init')){
    die('cURL is not installed!');
  }
  // Create a new cURL resource handle
  $ch = curl_init();
  // Set URL to download
  curl_setopt($ch, CURLOPT_URL, $url);
  // Include header in result? (0 = yes, 1 = no)
  curl_setopt($ch, CURLOPT_HEADER, 0);
  // Should cURL return or print out the data? (true = return, false = print)
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // Timeout in seconds
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  // Download the given URL, and return output
  $output = curl_exec($ch);
  // Close the cURL resource, and free system resources
  curl_close($ch);
  return $output;
}

$current_url = urlencode($_SERVER['REQUEST_URI']);
$server_url = "https://widgets.captora.com/wserver/?key=fb516c87e0ae587a52576c86a3816d76&domain=birst.com&url=" . $current_url;

$content = curl_captora_download($server_url);
  ?>
    <footer id="footer">
      <div class="footer-content">
          <nav class="footer-links">
              <ul id="menu-footer-menu" class="menu">
              <?php
              $args = array(
                  'theme_location' => 'footer',
									'sub_menu' => true,
                  'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>' 
              );
              wp_nav_menu( $args );
              ?>
              
          </nav>
          <div class="connect-content">
          	<!--<h4>Keep Informed</h4>
            <div class="subscribe-form">
            	<form>
            		<input type="text" name="email" id="email" placeholder="Your Email..." />
              	<input type="submit" value="&#8594;" />
              </form>
            </div>-->
            
          	<h4>Follow Us</h4>
            <?php get_template_part( 'partials/component', 'social_media_icons' ); ?>
            <?php echo plinth_the_single_site_option( array( 'footer_contact_info' ) ); ?>
            <!-- TRUSTe cookie manager -->
	<div id='teconsent'>
	<script async="async" type="text/javascript" src='//consent.truste.com/notice?domain=birst.com&c=teconsent' crossorigin></script>
	</div>
<!-- End TRUSTe cookie manager -->
          </div>
          <div class="featured-resources-footer">
            <span class="featured-title">Trending Now:</span>
            <?php echo $content; ?>
          </div>
      </div>
      <div class="copyright-content">
        	<span class="copyright">&copy; <?php echo date('Y'); ?> Birst, Inc. All rights reserved.</span>
          <?php
              $args = array(
                  'theme_location' => 'footer-links'
              );
              wp_nav_menu( $args );
              ?>
      </div>

    </footer><!-- #colophon -->
  </div>
  <?php endif; ?>
</div><!-- #page -->

<?php if(strpos($_SERVER['REQUEST_URI'], "resources") !== false){ ?>
<script>
(function(win, doc, src, name ) {
win['HushlyWidgetObject'] = {name:name}; win[name] = win[name] || function() { (win[name].queue = win[name].queue || []).push(arguments) }
var hws = doc.createElement('script'); hws.type  = 'text/javascript'; hws.async = true;  hws.src = src;
var node = doc.getElementsByTagName('script')[0];  node.parentNode.insertBefore(hws, node);
})(window, document, 'https://www.hushly.com/widget/js/v3?company=76', 'hushly');
</script>
<?php } ?>

<?php wp_footer(); ?>

<!-- Google Code for visitors -->
	<!-- Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. For instructions on adding this tag and more information on the above requirements, read the setup guide: google.com/ads/remarketingsetup -->
	<script type="text/javascript">
	// <![CDATA[ /
	var google_conversion_id = 1044086636;
	var google_conversion_label = "x3JyCOSsrwIQ7P7t8QM";
	var google_custom_params = window.google_tag_params;
	var google_remarketing_only = true;
	// ]]> /
	</script>
	<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
	</script>
	<noscript>
	<div style="display:inline;">
	<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1044086636/?value=0&amp;label=x3JyCOSsrwIQ7P7t8QM&amp;guid=ON&amp;script=0"/>
	</div>
	</noscript>
  
  <!-- Default Insight Tag (Bizographics)  -->
  <script type="text/javascript">
  var _bizo_data_partner_id = "7290";
  </script>
  <script type="text/javascript">
  (function() {
  var s = document.getElementsByTagName("script")[0];
  var b = document.createElement("script");
  b.type = "text/javascript";
  b.async = true;
  b.src = (window.location.protocol === "https:" ? "https://sjs" : "http://js") + ".bizographics.com/insight.min.js";
  s.parentNode.insertBefore(b, s);
  })();
  </script>
  <noscript>
  <img height="1" width="1" alt="" style="display:none;" src="//www.bizographics.com/collect/?pid=7290&fmt=gif" />
  </noscript>	
  
  <!-- Crazyegg -->
  <script type="text/javascript">
	<!--//--><![CDATA[//><!--
      setTimeout(function(){var a=document.createElement("script");
      var b=document.getElementsByTagName('script')[0];
      a.src=document.location.protocol+"//dnn506yrbagrg.cloudfront.net/pages/scripts/0016/9982.js";
      a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);     
	//--><!]]>
	</script>
  
  
  
  <!-- Marketo Tracking -->
  <script type="text/javascript">
	(function() {
		var didInit = false;
		function initMunchkin() {
			if(didInit === false) {
				didInit = true;
				Munchkin.init('299-OVS-376');
			}
		}
		var s = document.createElement('script');
		s.type = 'text/javascript';
		s.async = true;
		s.src = '//munchkin.marketo.net/munchkin.js';
		s.onreadystatechange = function() {
			if (this.readyState == 'complete' || this.readyState == 'loaded') {
				initMunchkin();
			}
		};
		s.onload = initMunchkin;
		document.getElementsByTagName('head')[0].appendChild(s);
	})();
	</script>
  <!-- end Marketo Tracking -->
  <script>
(function(d,b,a,s,e){ var t = b.createElement(a),
    fs = b.getElementsByTagName(a)[0]; t.async=1; t.id=e; t.src=s;
    fs.parentNode.insertBefore(t, fs); })
(window,document,'script','https://scripts.demandbase.com/jK2dYdGV.min.js','demandbase_js_lib');
</script>
</body>
</html>