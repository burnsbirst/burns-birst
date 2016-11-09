<?php
// Product Diagram


?>
<section class="layer--product-diagram <?php plinth_the_formatted_array_to_classes($layer['extras']); ?>" data-img-width="1600" data-img-height="1064" <?php plinth_style_attr(array('color' => $layer['background_color'], 'image' => $layer['background_image'], 'padding-top' => $layer['padding_top'], 'padding-bottom' => $layer['padding_bottom'])); ?>>
  <?php $template = get_post_meta($post->ID, '_wp_page_template', true); ?>
  <div class="container">
    <?php if($layer['heading'] && !empty($layer['heading'])): ?>
      <div class="layer--columns__heading"><?php echo $layer['heading']; ?></div>
    <?php endif; ?>
		
    <div class="image-container">
      <img src="<?php echo $layer['diagram_image']['url']; ?>" alt="<?php echo $layer['diagram_image']['title']; ?>" class="product-diagram-image" usemap="#ProductDiagram"/>
    <?php if($layer['tool_tips']): ?>
      <map name="ProductDiagram">
      	<?php $i = 0; ?>
        <?php foreach($layer['tool_tips'] as $item): ?>
        <area shape="rect" coords="<?php echo $item['shape_coords']; ?>" href="#tool-tip-<?php echo $i; ?>">
        <?php $i++; ?>
        <?php endforeach; ?>
      </map>
    <?php endif; ?>
    <?php if($layer['tool_tips']): ?>
    	<?php $i = 0; ?>
			<?php foreach($layer['tool_tips'] as $item): ?>
      <div class="tool-tip-<?php echo $i; ?> tool-tip">
      	<div class="tool-tip-image">
        	<img src="<?php echo $item['image']['url']; ?>" />
        </div>
        <div class="tool-tip-content">
        	<?php echo $item['content']; ?>
          <span class="content-close"></span>
        </div>
      </div>
      <?php $i++; ?>
      <?php endforeach; ?>
    <?php endif; ?>
    </div>
  </div>
</section>
