<?php
// Mast (Animated)

if(isset($layer['columns']) && !empty($layer['columns'])) {
  $columns = $layer['columns'];
}

?>
<section class="layer--mast-animated">
	<div class="layer--mast-animated-animation">
  	<div class="layer--mast-animated-animation-container">
      <div class="sprite sprite-1"><img src="/images/animate/laptop-on-desk.png" alt="2-Tier BI and Analytics" /></div>
      <div class="sprite sprite-2"><img src="/images/animate/laptop-transition-1.jpg" alt="2-Tier BI and Analytics" /></div>
      <div class="sprite sprite-3"><img src="/images/animate/laptop-transition-2.jpg" alt="2-Tier BI and Analytics" /></div>
      <div class="sprite sprite-4"><img src="/images/animate/laptop-transition-3.jpg" alt="2-Tier BI and Analytics" /></div>
      <div class="sprite sprite-5"><img src="/images/animate/laptop-rotated.png" alt="2-Tier BI and Analytics" /></div>
      <div class="sprite sprite-6"><img src="/images/animate/machine-bg.png" alt="2-Tier BI and Analytics" /></div>
    </div>
  </div>
	<?php
		foreach($layer['slides'] as $slide):
	?>
  	<div class="layer--mast-animated--slide"  <?php plinth_style_attr(array('image' => $slide['slide_image'])); ?>></div>
  <?php
		endforeach;
	?>
  <div class="container primary row">
			<div class="columns seven">
				<?php echo $layer['content']; ?>
			</div>
  </div>
  <div class="container secondary row">
			<div class="columns seven">
				<?php echo $layer['secondary_content']; ?>
			</div>
  </div>
</section>
