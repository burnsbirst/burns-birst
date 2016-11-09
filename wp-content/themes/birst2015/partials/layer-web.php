<?php
// Web
$count = 1;
?>
<section class="layer--web">
	<div class="row">
    <div class="web-items">
    <?php foreach($layer['surrounding_items'] as $item){ ?>
    <div class="item item<?php echo $count; ?>">
      <div class="item-text"><?php echo $item['title']; ?></div>
      <div class="line"><div class="cir"></div></div>
    </div>
    <?php $count++; ?>
    <?php } ?>
      <div class="center-item">
        <?php echo $layer['center_item_text']; ?>
      </div>
    </div>
    <div class="content-below">
      <div class="center-content"><?php echo $layer['content_below']; ?></div>
      <?php foreach($layer['surrounding_items'] as $item){ ?>
        <div class="secondary-content"><?php echo $item['content']; ?></div>
      <?php } ?>
    </div>
  </div>
  <div class="bottom-gradient-border"></div>
</section>
