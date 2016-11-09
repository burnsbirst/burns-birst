<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Plinth
 */
?>

    </div><!-- #content -->
  </div><!-- #content-wrapper -->

  <div id="footer-wrapper">
    <footer id="colophon" class="footer" role="contentinfo">
      <div class="row footer-table">
        <nav id="footer-navigation" class="footer-column">
          <?php plinth_display_footer_navigation(); ?>
        </nav>
        <div id="footer-connect" class="footer-column">
          <h2 class="footer-title">Connect</h2>
          <?php get_template_part('partials/component', 'social_media_icons'); ?>

          <?php
$phone = plinth_get_single_site_option(array('footer_contact_info', 'contact_phone'), '1.831.464 0100');
$email = plinth_get_single_site_option(array('footer_contact_info', 'contact_email'), 'info@atre.net');
?>
          <div class="footer-contact">
            <p class="phone"><?php echo $phone ?></p>
            <p class="email"><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo $email; ?></a></p>
          </div>

          <div class="keep-informed">
          <h2 class="footer-title"><?php plinth_the_single_site_option(array('newsletter_signup_form', 'form_title'), 'Keep Informed'); ?></h2>
            <form method="post" action="/marketo-gateway.php" data-js="newsletter-signup" data-replace-on-success="fieldset">
              <fieldset>
                <input type="email" name="Email" placeholder="<?php echo esc_attr(plinth_get_single_site_option(array('newsletter_signup_form', 'email_prompt'), 'Email Address')); ?>" required="required">
                <input type="submit" name="submit" value="&gt;">
                <img src="/images/spinner-footer.gif" width="16" height="16" class="spinner" alt="Loading...">
                <?php get_template_part('partials/marketo', 'hidden_newsletter_fields'); ?>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
      <div class="row">
        <nav class="footer-links">
          <span class="copyright"><?php plinth_the_single_site_option('copyright'); ?></span>
          <?php wp_nav_menu( array('theme_location' => 'footer-links') ); ?>
        </nav>
      </div>
    </footer><!-- #colophon -->
  </div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
