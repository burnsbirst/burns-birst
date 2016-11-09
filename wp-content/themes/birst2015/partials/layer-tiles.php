<?php
// Tiles
$style = $layer['style'];
$title = $layer['title'];
$tiles = $layer['tiles'];
?>
<section class="layer--tiles <?php echo $style; ?>">
	<div class="row">
    <?php if($title){ ?>
    <h2 class="heading"><?php echo $title; ?></h2>
    <?php } ?>
    <?php if($tiles){ ?>
    <div class="tiles-container">
      <?php foreach($tiles as $tile){ ?>
      <?php if($tile['link']){ ?><a href="<?php echo $tile['link']; ?>"><?php } ?>
      <div class="tile">
        <?php if($tile['icon']){ ?>
        <?php $img = $tile['icon']; ?>
        <div class="icon">
          <img src="<?php echo $img['url']; ?>" class="main-image">
          <?php if($tile['hover_icon']){ ?>
          <?php $imgH = $tile['hover_icon'];?>
            <img src="<?php echo $imgH['url']; ?>" class="hover-icon">
          <?php } ?>
        </div>
        <?php } ?>
        <?php if($tile['title']){ ?>
        <div class="title">
          <?php echo $tile['title']; ?>
        </div>
        <?php } ?>
        <?php if($tile['subtext']){ ?>
        <div class="subtext">
          <?php echo $tile['subtext']; ?>
        </div>
        <?php } ?>
      </div>
      <?php if($tile['link']){ ?></a><?php } ?>
      <?php } ?>
    </div>
    <?php } ?>
  </div>
</section>
