<?php
// Customer Spotlight


?>
<section class="layer--customer-spotlight <?php plinth_the_formatted_array_to_classes($layer['extras']); ?> <?php echo 'display-'.$layer['display']; ?>"<?php plinth_style_attr(array('color' => $layer['background_color'], 'image' => $layer['background_image'])); ?>>
	<?php if($layer['heading'] && !empty($layer['heading'])): ?>
    <div class="layer--customer-spotlight__heading"><?php echo $layer['heading']; ?></div>
  <?php endif; ?>
  <?php if($layer['display'] == 'tiles'): ?>
	<div class="row layer--customer-spotlight-container">
  	<?php if($layer['hide_blocks'] != 1): ?>
    <div class="columns eight">
    <?php foreach($layer['customers'] as $customer): ?>
    	<div class="layer--customer-spotlight__item-container">
      	<div class="layer--customer-spotlight__item-content">
        	<div class="layer--customer-spotlight__item-content-v">
          	<div class="layer--customer-spotlight__item-content-c">
          		<?php $img = get_field('logo', $customer->ID); ?>
          		<img src="<?php echo $img['url']; ?>" title="<?php echo htmlspecialchars($customer->post_title); ?>" alt="<?php echo htmlspecialchars ($customer->post_title); ?>" />
          	</div>
          </div>
        </div>
        <div class="layer--customer-spotlight__item-reveal-content">
        	<?php echo htmlspecialchars($customer->post_title); ?>
          <span class="small-text"><?php echo htmlspecialchars(get_field('blurb', $customer->ID)); ?></span>
        </div>
      </div>
    <?php endforeach; ?>
    </div>
    <div class="push_one columns six blocks">
    	<div class="row">
				<?php foreach($layer['blocks'] as $block): ?>
        <div class="block">
          <img src="/images/svg/png/<?php echo $block['icon']; ?>.png" xlink:href="/images/svg/<?php echo $block['icon']; ?>.svg" alt="<?php echo $block['icon']; ?>" />
          <?php echo $block['content']; ?>
        </div>
        <?php endforeach; ?>
      </div>
      <?php if($layer['cta_label'] && $layer['cta_url']): ?>
      <div class="row cta-container">
      	<a href="<?php echo $layer['cta_url']; ?>" class="button button-orange"><?php echo $layer['cta_label']; ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php else: ?>
    <div class="columns fifteen seven-up">
    <?php foreach($layer['customers'] as $customer): ?>
    	<div class="layer--customer-spotlight__item-container">
      	<div class="layer--customer-spotlight__item-content">
        	<div class="layer--customer-spotlight__item-content-v">
          	<div class="layer--customer-spotlight__item-content-c">
        			<?php //print_r($customer); ?>
          		<?php $img = get_field('logo', $customer->ID); ?>
          		<img src="<?php echo $img['url']; ?>" title="<?php echo $customer->post_title; ?>" />
          	</div>
          </div>
        </div>
        <div class="layer--customer-spotlight__item-reveal-content">
        	<?php echo $customer->post_title; ?>
          <span class="small-text"><?php echo get_field('blurb', $customer->ID); ?></span>
        </div>
      </div>
    <?php endforeach; ?>
    </div>
    <?php if($layer['cta_label'] && $layer['cta_url']): ?>
    <div class="row cta-container">
    	<a href="<?php echo $layer['cta_url']; ?>" class="button button-orange"><?php echo $layer['cta_label']; ?></a>
    </div>
    <?php endif; ?>
    <?php endif; ?>
  </div>
  <?php elseif ($layer['display'] == 'logos'): ?>
    <div class="row layer--customer-spotlight-carousel">
    	<div class="prev"></div><div class="next"></div>
    	<div class="layer--customer-spotlight-container">
    	<?php foreach($layer['customers'] as $customer): ?>
      	<div class="customer-tile">
        	<div class="customer-tile-c">
          	<div class="customer-tile-v">
        	<?php $img = get_field('logo', $customer->ID); ?>
          		<img src="<?php echo $img['url']; ?>" title="<?php echo htmlspecialchars($customer->post_title); ?>" alt="<?php echo htmlspecialchars ($customer->post_title); ?>" />
            </div>
          </div>
        </div>
      <?php endforeach ?>
      </div>
    </div>
  <?php elseif($layer['display'] == 'columns'): ?>
		<?php foreach($layer['columns'] as $column): ?>
    	<?php
			//print_r($column['customer']);
				$customer = get_field('logo', $column['customer'][0]->ID);
				//echo 'test';
				
			?>
      <div class="featured-customer-column">
      	<div class="head">
          <div class="head-duo-color"></div>
        </div>
        <div class="featured-customer-column-logo">
        	<div class="featured-customer-column-logo-container">
          	<img src="<?php echo $customer['url']; ?>" />
          </div>
        </div>
        <div class="featured-customer-column-content">
        	<?php echo $column['content']; ?>
        </div>
        <div class="featured-customer-column-cta">
        	<?php if($column['cta_label'] != '' && $column['cta_url'] != ''): ?>
        		<a href="<?php echo $column['cta_url']; ?>" class="button button-orange"><?php echo $column['cta_label']; ?></a>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
  
</section>
