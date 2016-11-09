<?php
/**
 * The Template for displaying a press release.
 *
 * @package Plinth
 */

$pr_details = plinth_get_site_option(array('press_release_details'));
$press_releases_list_post_object = $pr_details['press_release_listing_page'];
plinth_set_current_post_id($press_releases_list_post_object->ID);
get_header(); ?>
  <div class="row">
    <nav class="breadcrumbs">
      <a href="<?php echo post_permalink($press_releases_list_post_object->ID); ?>" class="back"><?php _e('Back to Press Releases', 'plinth'); ?></a>
    </nav>
  </div>
  <div class="row">
    <div id="primary" class="content-area twelve columns">
      <main id="main" class="site-main" role="main">

      <?php
//print_r($press_releases_list_post_object);
      ?>
      <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <header class="pr-header">
            <h1 class="h-main-heading"><?php the_title(); ?></h1>

            <?php if ( get_field('subtitle') ) : ?>
              <h2 class="h-sub-heading"><?php the_field('subtitle'); ?></h2>
            <?php endif; ?>

          </header>

          <div class="entry-content">
            <?php
              // Use output buffering and the_content() so that <p> tags are added correctly
              ob_start();
              the_content();
              $content = ob_get_clean();

              // Inject the location and date into the start
              $lead_tag = '<p>';
              if ( preg_match('/^\s*(<[^>]+>)/', $content, $matches) ) {
                $lead_tag = $matches[1];
                $content = preg_replace("/^\s*{$lead_tag}/", '', $content);
              }
              echo $lead_tag;
              the_field('location');
              echo ', ';
              plinth_the_formatted_date(get_the_time('c'));
              echo ' - ';
              echo $content;
            ?>

            <?php if ( get_field('partner_boilerplate') ) : ?>
              <?php while ( has_sub_field('partner_boilerplate') ) : ?>
                <h3><?php the_sub_field('heading'); ?></h3>
                <?php the_sub_field('content'); ?>
              <?php endwhile; ?>
            <?php endif; ?>

            <?php if ( $company_boilerplate = get_field('company_boilerplate') ) : ?>
              <h3><?php _e('About Company, Inc.', 'plinth'); ?></h3>
              <?php echo $company_boilerplate ?>
            <?php endif; ?>

            <?php if ( get_field('more_information') ) : ?>
              <p class="center">###</p>
              <?php the_field('more_information'); ?>
            <?php endif; ?>

            <aside class="press-contacts">
              <?php if ( get_field('other_press_contacts') ) : ?>
                <?php while ( has_sub_field('other_press_contacts') ) : ?>
                  <div class="press-contact">
                    <h3><?php echo sprintf( __('%s Contact:', 'plinth'), get_sub_field('company') ); ?></h3>
                    <p>
                      <?php the_sub_field('name'); ?><br>
                      <?php the_sub_field('email'); ?><br>
                      <?php the_sub_field('phone'); ?>
                    </p>
                  </div>
                <?php endwhile; ?>
              <?php endif; ?>
              <div class="press-contact">
                <h3><?php _e('Vidyo Contact:', 'plinth'); ?></h3>
                <p>
                  <?php echo $pr_details['press_contact_name']; ?><br>
                  <?php echo $pr_details['press_contact_email']; ?><br>
                  <?php echo $pr_details['press_contact_phone']; ?>
                </p>
              </div>
            </aside>

          </div>
        </article>

      <?php endwhile; // end of the loop. ?>

      </main><!-- #main -->
    </div><!-- #primary -->

  </div><!-- .row -->
<?php get_footer(); ?>


