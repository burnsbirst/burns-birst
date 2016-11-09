<?php
// Why Animated Layer

?>
<section class="layer--why-animated-layer">
	<div class="layer--why-animated-layer-container">
		<?php foreach($layer['animation_layer'] as $l): ?>
    <div class="layer--why-animated-animation">
    	<div class="layer--why-animated-animation-bg-container-bg"></div>
    	<div class="layer--why-animated-animation-bg-container"><div class="layer--why-animated-animation-bg" style="background-image: url('<?php echo $l['background_image']['url']; ?>');"></div></div>
      <div class="layer--why-animated-animation-container">
      	<div class="layer--why-animated-animation-title">
      		<?php echo $l['title']; ?>
        </div>
        <div class="layer--why-animated-animation-tiles">
        	<div class="layer--why-animated-animation-tiles-t">
            <div class="layer--why-animated-animation-tile-legacy">
              <div class="title">
              	<h4>Legacy</h4>
              </div>
              <div class="content">
              	<?php echo $l['legacy']; ?>
              </div>
            </div>
            <div class="layer--why-animated-animation-tile-birst">
              <div class="title">
                <img src="/images/birst-animation-logo.png" alt="Birst" />
              </div>
              <div class="content">
              	<?php echo $l['birst']; ?>
              </div>
            </div>
            <div class="layer--why-animated-animation-tile-discovery">
              <div class="title">
              	<h4>Discovery</h4>
              </div>
              <div class="content">
              	<?php echo $l['discovery']; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>
