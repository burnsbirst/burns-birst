<?php
// Partners


?>
<section class="layer--partners <?php plinth_the_formatted_array_to_classes($layer['extras']); ?>">
<div class="partners-filter-container">
      <?php
        // Get all a document_role taxonomy terms
        $args = array(
          'orderby'           => 'name', 
          'order'             => 'ASC',
          'hide_empty'        => true, 
          'fields'            => 'all', 
          'hierarchical'      => true, 
          'child_of'          => 0,
          'childless'         => false,
          'pad_counts'        => false, 
          'cache_domain'      => 'core'
        );
        $regions = get_terms(array('partner_regions'), $args);
      ?>
      <select id="partner-region">
        <option value="all">Filter by Region</option>
        <?php foreach($regions as $region): ?>
          <?php echo '<option value="' .$region->slug .'">' .$region->name .'</option>'; ?>
        <?php endforeach; ?>
      </select>
      <?php
        // Get all a document_role taxonomy terms
        $args = array(
          'orderby'           => 'name', 
          'order'             => 'ASC',
          'hide_empty'        => true, 
          'fields'            => 'all', 
          'hierarchical'      => true, 
          'child_of'          => 0,
          'childless'         => false,
          'pad_counts'        => false, 
          'cache_domain'      => 'core'
        );
        $categories = get_terms(array('partner_categories'), $args);
      ?>
      <!--<select id="partner-categories">
        <option value="resources-tile">Filter by Category</option>
        <?php foreach($categories as $category): ?>
          <?php echo '<option value="' .$category->slug .'">' .$category->name .'</option>'; ?>
        <?php endforeach; ?>
      </select> -->
    </div>
	<div class="layer--partners-container">
    
  	<?php
			// -- get all partners query
			$cat_id = get_cat_ID('enterprise');
			//echo $cat_id;
                $args = array(
                  'post_type' => 'partner',
                  'posts_per_page' => -1,
									'orderby' => 'title',
									'order'   => 'ASC',
									'taxonomy' => array('partner_categories', 'enterprise')
                );
                $query = new WP_Query($args);
                $partners = $query->get_posts();
								//print_r($partners);
								//$i=0;
                ?>
                <?php foreach($partners as $partner): ?>
                <?php
                  $logo = get_field('logo', $partner->ID);
									$company_url = get_field('company_url', $partner->ID);
									$terms = wp_get_post_terms( $partner->ID, 'partner_regions');
									
									$regions = '';
									foreach ($terms as $term):
										//print_r($term);
										$regions .= $term->slug .' ';
									endforeach;
									
                ?>
                	<div class="partners-tile <?php echo $regions; ?>">
                  	<a href="<?php echo $company_url; ?>"><div class="partners-tile-container">
                    	<div class="partners-tile-v-container">
                      	<img src="<?php echo $logo['url']; ?>" title="<?php echo $partner->post_title; ?>" />
                    	</div>
                      
                   	</div></a>
                    <div class="partners-tile-title"><a href="<?php echo $company_url; ?>"><?php echo $partner->post_title; ?></a></div>
                  </div>
                <?php endforeach; ?>
  </div>
</section>
