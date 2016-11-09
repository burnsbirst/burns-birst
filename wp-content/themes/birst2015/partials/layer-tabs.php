<?php
// Awards Layer

if(isset($layer['tabs']) && !empty($layer['tabs'])) {
  $tabs = $layer['tabs'];
}
if(isset($layer['alt_tabs']) && !empty($layer['alt_tabs'])) {
  $tabs2 = $layer['alt_tabs'];
}

?>
<section class="layer--tabs tabs<?php if ($tabs2){ ?> alt-tabs<?php } ?>"<?php plinth_style_attr(array('color' => $layer['background_color'], 'image' => $layer['background_image'])); ?>>
    <?php if ($tabs): ?>
    <div class="tab-nav-container">
    	<div class="tab-nav-container-alignment">
        <ul class="tab-nav">
          <?php foreach ($tabs as $i => $tab): ?>
            <?php //print_r($resource); ?>
            <li>
            	<div class="icon"><img src="/images/svg/<?php echo $tab['tab_icon']; ?>.svg" alt="<?php echo $tab['tab_icon']; ?>" /></div>
            	<a href="#"><?php echo $tab['tab_label']; ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
    <?php foreach ($tabs as $i => $tab): ?>
      <div class="tab-content">
      	<div class="tab-content-content">
        	
        	<?php if($tab['tab_content_image'] != ''): ?>
          <div class="tab-content-content-image">
          	<img src="<?php echo $tab['tab_content_image']['url']; ?>" />
          </div>
          <div class="tab-content-content-container">
      			<?php echo $tab['tab_content']; ?>
          </div>
          <?php else: ?>
          <div class="tab-content-content-container-full">
          <?php echo $tab['tab_content']; ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
		<?php endforeach; ?>
    <?php endif; ?>
    <?php if ($tabs2){ ?>
    <div class="tab-nav-container">
    	<div class="tab-nav-container-alignment">
        <ul class="tab-nav">
          <?php foreach ($tabs2 as $i => $tab): ?>
            <li>
            	<a href="#"><?php echo $tab['tab_label']; ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
    <?php $carousel = 0; ?>
    <?php foreach ($tabs2 as $i => $tab): ?>
      <div class="tab-content" id="<?php echo 'carousel'.$carousel; ?>">
      	<div class="tab-content-content">
          <div class="carousel">
        	<?php foreach ($tab['tab_slides'] as $slide): ?>
          <div class="slide-content">
            <?php if($slide['subheading']){ ?><div class="subtext"><?php echo $slide['subheading']; ?></div><?php } ?>
            <?php if($slide['main_heading']){ ?><div class="main-text"><?php echo $slide['main_heading']; ?></div><?php } ?>
            <?php if($slide['content']){ ?><div class="p-text"><?php echo $slide['content']; ?></div><?php } ?>
          </div>
          <?php endforeach; ?>
          </div>
        <div class="carousel-arrows"><div class="prev"><img src="/wp-content/themes/birst2015/images/left-arrow.png"></div><div class="next"><img src="/wp-content/themes/birst2015/images/right-arrow.png"></div></div>
        </div>
      </div>
		<?php $carousel++; endforeach; ?>
    <?php } ?>
</section>
