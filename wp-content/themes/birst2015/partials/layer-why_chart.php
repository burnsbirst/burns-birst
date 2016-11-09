<?php
// Why Chart


?>
<section class="layer--why-chart"<?php plinth_style_attr(array('color' => $layer['background_color'], 'image' => $layer['background_image'])); ?>>
	<div class="layer--why-chart-container">
    <div class="layer--why-chart-heading">
      <?php echo $layer['heading']; ?>
    </div>
    <?php if ($layer['table_rows']): ?>
    <table class="layer--why-chart-table responsive">
      <tr class="table-r table-h">
          <td class="table-c dg1">Requirement</td>
          <td class="table-c dg1">Values</td>
          <td class="table-c dg2">Legacy</td>
          <td class="table-c birst"><span class="class-popout"><img src="/images/birst-animation-logo.png" alt="Birst" /></span></td>
          <td class="table-c dg2">Discovery&nbsp;&nbsp;&nbsp;</td>
       </tr>
      <?php foreach ($layer['table_rows'] as $t): ?>
        <tr class="table-r">
          <td class="table-c mg"><?php echo $t['requirement']; ?></td>
          <td class="table-c mg"><?php echo $t['value']; ?></td>
          <td class="table-c ag"><span class="<?php echo $t['legacy_value']; ?>"></span></td>
          <td class="table-c"><span class="<?php echo $t['birst_value']; ?>"></span></td>
          <td class="table-c ag"><span class="<?php echo $t['discovery_value']; ?>"></span></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <?php endif; ?>
  </div>
  <div class="container row">
  	<blockquote class="layer--quote__quote column thirtteen push_one">
	      <?php 
					//print_r($layer['quote'][0]->ID);
					$id = $layer['quote'][0]->ID;
					$quote = get_field('quote', $id);
					$name = get_field('name', $id);
					$title = get_field('title_/_company', $id);
				?>
	      <?php if($quote): ?>
	      	<div class="quote"><?php echo $quote; ?></div>
	      <?php endif ?>
	      <?php if($name): ?>
	      	<div><strong><?php echo $name; ?></strong>, <?php echo $title; ?></div>
	      <?php endif ?>
	    </blockquote>
  </div>
</section>