<?php

if(isset($layer['list_items']) && !empty($layer['list_items'])) {
  $list_items = $layer['list_items'];
}

$mobile_bg_image='';
if ($layer['mobile_background_image'] && $layer['layout'] != 'three-up') {
	$mobile_bg_image = 'data-mobileimage="'.$layer['mobile_background_image']['url'].'"';
}

$layer['mobile_background_image'] = '';

?>
<section class="layer--badged-list <?php echo $layer['layout']; ?>"<?php plinth_style_attr(array('color' => $layer['background_color'], 'image' => $layer['background_image'], 'padding-top' => $layer['padding_top'], 'padding-bottom' => $layer['padding_bottom'])); ?> <?php echo $mobile_bg_image; ?>>
  <div class="container row">
    <?php if($layer['heading'] && !empty($layer['heading'])): ?>
      <div class="layer--badged-list__heading"><?php echo $layer['heading']; ?></div>
    <?php endif; ?>

    <?php if(isset($list_items) && $layer['layout'] != 'six-up' && $layer['layout'] != 'two-up'): ?>
      <ul class="badged-list">
        <?php foreach($list_items as $i => $item): ?>
          <li class="badged-list__list-item">
          	<?php if($item['link']): ?><a href="<?php echo $item['link']; ?>"><?php endif; ?>
            <div class="badged-list__list-item__badge">
            	<div class="badged-list__list-item__badge-v">
              	<div class="badged-list__list-item__badge-c">
									<img src="<?php echo $item['badge']['url']; ?>" alt="<?php echo $item['badge']['title']; ?>" />
                </div>
              </div>
              <div class="badged-list__list-item__badge-line"></div>
              <div class="badged-list__list-item__badge-cir"></div>
             </div>
            <div class="badged-list__list-item__text"><?php echo $item['text']; ?></div>
            <?php if($item['link']): ?></a><?php endif;?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    
    <?php if(isset($list_items) && $layer['layout'] == 'two-up'): ?>
      <ul class="badged-list">
        <?php foreach($list_items as $i => $item): ?>
          <li class="badged-list__list-item">
          	<?php if($item['link']): ?><a href="<?php echo $item['link']; ?>"><?php endif; ?>
            <div class="badged-list__list-item__badge">
            	<div class="badged-list__list-item__badge-v">
              	<div class="badged-list__list-item__badge-c">
									<img src="<?php echo $item['badge']['url']; ?>" alt="<?php echo $item['badge']['title']; ?>" />
                </div>
              </div>
              <div class="badged-list__list-item__badge-cir"></div>
              <div class="badged-list__list-item__badge-line"></div>
              <div class="badged-list__list-item__badge-cir end"></div>
             </div>
            <div class="badged-list__list-item__text"><?php echo $item['text']; ?></div>
            <?php if($item['link']): ?></a><?php endif;?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    
    <?php if($layer['badge_groups']): ?>
    	<?php foreach($layer['badge_groups'] as $group): ?>
      	<div class="badge-group">
        	<div class="badge-group-title"><?php echo $group['group_title']; ?></div>
          <ul class="badged-list">
					<?php foreach($group['badge_items'] as $item): ?>
          	<li class="badged-list__list-item">
          	<?php if($item['link']): ?><a href="<?php echo $item['link']; ?>"><?php endif; ?>
            <div class="badged-list__list-item__badge">
            	<div class="badged-list__list-item__badge-v">
              	<div class="badged-list__list-item__badge-c">
									<img src="<?php echo $item['badge']['url']; ?>" alt="<?php echo $item['badge']['title']; ?>" />
                </div>
              </div>
              <div class="badged-list__list-item__badge-line"></div>
              <div class="badged-list__list-item__badge-cir"></div>
             </div>
            <div class="badged-list__list-item__text"><?php echo $item['text']; ?></div>
            <?php if($item['link']): ?></a><?php endif;?>
          </li>
          <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>
</section>