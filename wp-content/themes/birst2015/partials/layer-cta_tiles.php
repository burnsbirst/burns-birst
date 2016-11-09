<?php
// CTA Tiles

?>
<section class="layer--cta-tiles">
	<?php
		foreach($layer['tile'] as $tile):
	?>
  	<div class="layer--cta-tiles--tile">
    	<div class="layer--cta-tiles--tile-top"></div>
      <div class="layer--cta-tiles--tile-cotent">
        <a style="display:block;"><div class="icon-container">
          <img src="/images/svg/png/<?php echo $tile['icon']; ?>.png" xlink:href="/images/svg/<?php echo $tile['icon']; ?>.svg" alt="<?php echo $tile['title']; ?>"/>
        </div>
        <h4><?php echo $tile['title']; ?></h4></a>
      </div>
      <div class="layer--cta-tiles--tile-hover">
      	<h4><?php echo $tile['rollover_content']; ?></h4>
        <a href="<?php echo $tile['cta_url']; ?>" class="button-outlined"><?php echo $tile['cta_label']; ?></a>
      </div>
    </div>
  <?php
		endforeach;
	?>
</section>
