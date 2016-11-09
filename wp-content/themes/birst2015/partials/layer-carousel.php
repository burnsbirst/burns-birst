<?php if(isset($layer['slides']) && !empty($layer['slides'])): ?>
<section class="layer--carousel">
  <div class="carousel-slides">
    <?php foreach($layer['slides'] as $slide): ?>
      <?php if(isset($slide['columns']) && !empty($slide['columns'])): ?>
        <div class="carousel-slide">
        <div class="slide--wrapper" style=" <?php if($slide['background_color']): echo 'background-color:'.$slide['background_color'].'; '; endif; if($slide['background_image']): echo 'background-image:url('.$slide['background_image'].');'; endif; ?>">
          <div class="container row">
            <?php foreach($slide['columns'] as $i => $item): ?>
              <div class="columns <?php echo $item['column_width']; ?>">
                <div class="content">
  					<?php echo $item['content']; ?>
				</div>
              </div>
            <?php endforeach; ?>
          </div>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
  <div class="carousel-arrows container row"><div class="prev-arrow"><img src="/wp-content/themes/birst2015/images/left-arrow.png" alt="previous" /></div><div class="next-arrow"><img src="/wp-content/themes/birst2015/images/right-arrow.png" alt="next" /></div></div>
  <div class="carousel-pagination"></div>
</section>
<?php endif; ?>
