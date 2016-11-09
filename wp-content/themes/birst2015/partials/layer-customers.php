<?php
// Customers


?>
<section class="layer--customers <?php plinth_the_formatted_array_to_classes($layer['extras']); ?>"<?php plinth_style_attr(array('color' => $layer['background_color'], 'image' => $layer['background_image'])); ?>>
	<div class="layer--customers-container">
	<?php if($layer['heading'] && !empty($layer['heading'])): ?>
    <div class="layer--customers__heading"><?php echo $layer['heading']; ?></div>
  <?php endif; ?>
  	<?php
			// -- get all customers query
                $args = array(
                  'post_type' => 'customer',
                  'posts_per_page' => -1,
									'orderby' => 'title',
									'order'   => 'ASC',
                );
                $query = new WP_Query($args);
                $customers = $query->get_posts();
								$i=0;
                ?>
                <?php foreach($customers as $customer): ?>
                <?php
                  $logo = get_field('logo', $customer->ID);
                  $casestudy = get_field('case_study', $customer->ID);
                  $video = get_field('video', $customer->ID);
									$category = get_field('category', $customer->ID);
                  
                  $casestudy_url = '';
                  $c_asset_url = get_field('asset_url', $casestudy[0]->ID);
									$c_reg_url = get_field('registration_url', $casestudy[0]->ID);
                  $c_asset_document = get_field('document', $casestudy[0]->ID);
									
									$pressrelease_url = get_field('press_release', $customer->ID);
									$review_url = get_field('review', $customer->ID);
									//echo '<pre>';
									//print_r($review_url);
									//echo '</pre>';
									
                  
                  if($c_asset_url != ''):
                    $casestudy_url = $c_asset_url;
									elseif ($c_reg_url != ''):
										$casestudy_url = $c_reg_url;
                  else:
                    $casestudy_url = $c_asset_document['url'];
                  endif;
									
									// get video URL
									$c_video_url = get_field('asset_url', $video[0]->ID);
									
                ?>
                	<div class="customer-tile <?php echo $category; ?>">
                  	<div class="customer-tile-container">
                    	<div class="customer-tile-v-container">
                      	<img src="<?php echo $logo['url']; ?>" title="<?php echo $customer->post_title; ?>" alt="<?php echo $logo['alt']; ?>" />
                    	</div>
                      <?php if ($c_video_url || $casestudy_url || $pressrelease_url[0]->guid || $review_url): ?>
                    
                      <div class="customer-tile-buttons">
                      	<div class="customer-tile-buttons-title"><?php echo $customer->post_title; ?></div>
                        <?php if ($casestudy_url): ?>
                          <a href="<?php echo $casestudy_url; ?>" class="casestudy"><span class="icon"></span>Case Study</a>
                        <?php endif; ?>
                        <?php if ($c_video_url): ?>
                          <a href="<?php echo $c_video_url; ?>" class="video"><span class="icon"></span>Video</a>
                        <?php endif; ?>
                        <?php if ($pressrelease_url[0]->guid): ?>
                        <a href="<?php echo $pressrelease_url[0]->guid; ?>" class="press-release"><span class="icon"></span>Press Release</a>
                        <?php endif; ?>
                        <?php if ($review_url): ?>
                        <a href="<?php echo $review_url; ?>" class="review"><span class="icon"></span>Review</a>
                        <?php endif; ?>
                      </div>
                      
                      <div class="customer-tile-icons">
                      	<?php if ($casestudy_url): ?>
                          <span class="icon casestudy"></span>
                        <?php endif; ?>
                        <?php if ($c_video_url): ?>
                          <span class="icon video"></span>
                        <?php endif; ?>
                        <?php if ($pressrelease_url[0]->guid): ?>
                        	<span class="icon press-release"></span>
                        <?php endif; ?>
                        <?php if ($review_url): ?>
                        	<span class="icon review"></span>
                        <?php endif; ?>
                      </div>
                      
                      <?php endif; ?>
                   	</div>
                    
                  </div>
                <?php endforeach; ?>
  </div>
</section>