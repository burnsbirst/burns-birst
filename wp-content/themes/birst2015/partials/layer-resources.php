<?php

// Resources

if(isset($layer['resources']) && !empty($layer['resources'])) {
  $resources = $layer['resources'];
}
?>
<section class="layer--resources"<?php plinth_style_attr(array('color' => $layer['background_color'], 'image' => $layer['background_image'])); ?>>
	<?php if($layer['display'] == 'featured'): ?>
  <div class="resource-filter-container-featured">
  	<?php foreach($layer['resources'] as $resource): 
			$type = str_replace('-', ' ', get_field('type', $resource->ID));
			$type_raw = get_field('type', $resource->ID);
			$requires_registration = get_field('requires_registration', $resource->ID);
			$registration_url = get_field('registration_url', $resource->ID);
			$asset_url = get_field('asset_url', $resource->ID);
                        $youtube_url = get_field('youtube_url', $resource->ID);
			$video = get_field('video', $resource->ID);
			$document = get_field('document', $resource->ID);
			if(get_field('featured_image', $resource->ID)):
				$thumbnail = get_field('featured_image', $resource->ID);
			else:
				$thumbnail = get_field('thumbnail', $resource->ID);
			endif;
			$resource_link = '';
			
			if ($requires_registration == 1):
				$resource_link = $registration_url;
			elseif ($asset_url):
				$resource_link = $asset_url;
			else:
				$resource_link = $document['url'];
			endif;
			$terms = strip_tags(get_the_term_list($resource->ID, 'document_role', '', ' ', ''));
			
			if ($video):
				$c_video_url = get_field('asset_url', $video[0]->ID);
			endif;
		?>
    <div class="featured-resource-column">
    	<div class="featured-resource-column-content">
      	<div class="resource-type">Featured <?php echo $type; ?></div>
				<div class="resource-title"><a href="<?php echo $resource_link; ?>"><?php echo $resource->post_title; ?></a></div>
      </div>
      <div class="featured-resource-column-thumb" <?php plinth_style_attr(array('image' => $thumbnail)); ?>>
			</div>
		</div>
    <?php endforeach; ?>
  </div>
  <?php else: ?>
  <?php $special = $_GET['r']; ?>
	<div class="resource-filter-container">
    <select id="resource-type">
    	<option value="resources-tile">Filter by Type</option>
        <option value="analyst-report"
        <?php if($special=='analyst-report'){echo ' selected="selected"';}?>
        >Analyst Report</option>
        <option value="business-intelligence-guide"
        <?php if($special=='business-intelligence-guide'){echo ' selected="selected"';}?>
        >BI Guide</option>
      <option value="case-study"
      <?php if($special=='case-study'){echo ' selected="selected"';}?>
      >Case Study</option>
      <option value="data-sheet"
      <?php if($special=='data-sheet'){echo ' selected="selected"';}?>
      >Data Sheet</option>
      <option value="ebook"
      <?php if($special=='ebook'){echo ' selected="selected"';}?>
      >eBook</option>
      <option value="video"
      <?php if($special=='video'){echo ' selected="selected"';}?>
      >Video</option>
      <option value="demo"
      <?php if($special=='demo'){echo ' selected="selected"';}?>
      >Demo</option>
      <option value="webinar"
      <?php if($special=='webinar'){echo ' selected="selected"';}?>
      >Webinar</option>
      <option value="whitepaper"
      <?php if($special=='whitepaper'){echo ' selected="selected"';}?>
      >White Paper</option>
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
			$roles = get_terms(array('document_role'), $args);
		?>
    <select id="resource-role">
    	<option value="resources-tile">Filter by Role</option>
    	<?php foreach($roles as $role): ?>
      	<?php echo '<option value="' .$role->name .'">' .$role->name .'</option>'; ?>
      <?php endforeach; ?>
    </select>
  </div>
	<div class="layer--resources-container">
  				<?php
							// -- get all resources query
                $args = array(
                  'post_type' => 'resource',
                  'posts_per_page' => -1,
									'orderby' => 'title',
									'order'   => 'ASC',
                );
                $query = new WP_Query($args);
                $resources = $query->get_posts();
								$i=0;
                ?>
                <?php foreach($resources as $resource): ?>
                <?php
                  $type = str_replace('-', ' ', get_field('type', $resource->ID));
									$type_raw = get_field('type', $resource->ID);
									$type_list = get_field_object('type', $resource->ID);
									//print_r($type_list['choices'][$type_raw]);
									$requires_registration = get_field('requires_registration', $resource->ID);
									$registration_url = get_field('registration_url', $resource->ID);
									$asset_url = get_field('asset_url', $resource->ID);
             								$youtube_url = get_field('youtube_url', $resource->ID);
									$type_asset = $type_list['choices'][$type_raw];
									$video = get_field('video', $resource->ID);
									$document = get_field('document', $resource->ID);
									$thumbnail = get_field('thumbnail', $resource->ID);
									$resource_link = '';
									if($requires_registration == 1):
										$resource_link = $registration_url;
									elseif ($asset_url):
										$resource_link = $asset_url;
									else:
										$resource_link = $document['url'];
									endif;
									
									$terms = strip_tags(get_the_term_list( $resource->ID, 'document_role', '', ' ', ''));
									
									if ($video):
										$c_video_url = get_field('asset_url', $video[0]->ID);
									endif;
									
								
										
                ?>

   	<div class="resources-tile <?php echo $terms; ?> <?php echo $type_raw; ?>">
     
			<?php if ($type_asset == 'Video') { echo "<a href='$youtube_url' target='_blank' />"; } ?>

			<div class="resources-tile-image-container" <?php plinth_style_attr(array('image' => $thumbnail)); ?>> 
			
			<?php if ($type_asset == 'Video') { echo "<div class='play'><a href='$youtube_url'><img src='/wp-content/uploads/2015/03/play-video.png' /></a></div>";}  ?>
			</div><?php if ($type_asset == 'Video') { echo '</a>'; } ?>


                	

                    <div class="resource-info">
                    	<div class="resource-type"><?php echo $type_list['choices'][$type_raw]; ?></div>
                      <div class="resource-title"><a href="<?php echo $resource_link; ?>"><?php echo $resource->post_title;?></a></div>
                    </div>
                  </div>
		<?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>