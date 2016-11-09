<div id="featured-resources">
	<?php
	$fr=get_field('modify_resources');
	if(!empty($fr)):
	$featured_resources = get_field('featured_resources_page');
	else: 
	$site_options = get_field('site_options_en', 'option');
		//print_r($site_options);
	$featured_resources = get_field('featured_resources', $site_options->ID);
	 //echo '<pre>';
	 //print_r($featured_resources);
	 //echo '</pre>';
	endif;
	$i = 0;
	$column_class = '';
	foreach ($featured_resources as $resource):
		$type = str_replace('-', ' ', get_field('type', $resource->ID));
	 	$requires_registration = get_field('requires_registration', $resource->ID);
		$registration_url = get_field('registration_url', $resource->ID);
		$asset_url = get_field('asset_url', $resource->ID);
		$document = get_field('document', $resource->ID);
		if(get_field('featured_image', $resource->ID)):
			$thumbnail = get_field('featured_image', $resource->ID);
		else:
			$thumbnail = get_field('thumbnail', $resource->ID);
		endif;
		$resource_link = '';
		if($requires_registration == 1):
			$resource_link = $registration_url;
		elseif ($asset_url):
			$resource_link = $asset_url;
		else:
			$resource_link = $document['url'];
		endif;
		if ($i == 0):
		?>
		<div class="main-content-column" <?php plinth_style_attr(array('image' => $thumbnail)); ?>>
    	<div class="content">
      	<span class="resource-type"><?php echo $type; ?></span>
				<h2><a href="<?php echo $resource_link; ?>"><?php echo $resource->post_title; ?></a></h2>
      </div>
      <div class="foot">
      </div>
		</div> 
		<?php
		else:
		?>
    <?php 
			if (get_field('use_spotlight', $resource->ID) ==  true && get_field('featured_image', $resource->ID) != ''):
				$thumbnail_bg = '';
			else:
				$thumbnail_bg = $thumbnail;
			endif;
		?>
		<div class="secondary-content-column" <?php plinth_style_attr(array('image' => $thumbnail_bg)); ?>>
    	<div class="content">
      	<span class="resource-type"><?php echo $type; ?></span>
				<h2><a href="<?php echo $resource_link; ?>"><?php echo $resource->post_title; ?></a></h2>
      </div>
      <?php
				if (get_field('use_spotlight', $resource->ID) ==  true && get_field('featured_image', $resource->ID) != ''):
			?>
      <div class="resource-image">
      	<div class="resource-image-v">
        	<div class="resource-image-c">
          	<img src="<?php echo $thumbnail['url']; ?>" <?php echo $thumbnail['title']; ?> />
          </div>
        </div>
      </div>
      <?php
				endif;
			?>
      <div class="foot">
      	<div class="foot-duo-color"></div>
      </div>
		</div> 
		<?php
		endif;
		$i++;
	endforeach;
	?>
</div>