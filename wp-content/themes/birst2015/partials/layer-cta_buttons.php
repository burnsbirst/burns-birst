<?php
// CTA Buttons

?>
<section class="layer--cta-buttons">
	<div class="layer--cta-buttons-container">
  	<div class="cta-statement">
    	<h2><?php echo $layer['cta_statement']; ?></h2>
    </div>
	<?php
		foreach($layer['cta_buttons'] as $button):
	?>
  	<div class="layer--cta-button-container">
    	<a href="<?php echo $button['cta_url']; ?>" class="button button-orange"><?php echo $button['cta_label']; ?></a>
    </div>
  <?php
		endforeach;
	?>
  </div>
</section>
