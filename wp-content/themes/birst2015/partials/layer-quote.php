<?php
// Quote Layer
$use_carousel = $layer['use_carousel'];
$layer_class = "";
if ($use_carousel) :
	$layer_class = "with-carousel";
endif;
?>
<section class="layer--quote <?php echo $layer_class; ?>" <?php plinth_style_attr(array('color' => $layer['background_color'])); ?>>
  <div class="container row">
    
		<?php if ($use_carousel): ?>
			<div class="layer--quote__carousel">
			
			<?php 
				$quotes = $layer['quotes']; 
				
				foreach( $quotes as $q ):
					$id = $q->ID;
					$quote = get_field('quote', $id);
					$name = get_field('name', $id);
					$title = get_field('title_/_company', $id);
					$logo = get_field('logo', $id);
					$case_study_url = get_field('case_study_url', $id);
					$content = get_field('content', $id);
			?>
				<div class="carousel-item" data-js="eqh-w">
					<?php 
						$quote_columns_classes = "fifteen";
						$equal_heights = "";
						if ($content) :
							$quote_columns_classes = "ten has-content equal-height-column";
							$equal_heights = 'data-js="eqh-c"';
						endif;
					?>
					
					<blockquote class="layer--quote__quote columns <?php echo $quote_columns_classes; ?>" <?php echo $equal_heights; ?>>
						<?php if ($content) :?><div class="equal-height-container"><?php endif; ?>
			      <?php if($logo): ?>
			      	<div class="logo"><img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>" title="<?php echo $logo['title']; ?>" /></div>
			      <?php endif ?>
						<?php if($quote): ?>
			      	<q><?php echo strip_tags($quote, '<a><span><b><strong><i><em>'); ?></q>
			      <?php endif ?>
			      <?php if($name): ?>
			      	<div><strong><?php echo $name; ?></strong>, <?php echo $title; ?></div>
			      <?php endif ?>
						<?php if ($content) :?></div><?php endif; ?>
			    </blockquote>
				<?php if ($content) : ?>
					<div class="layer--quote__case_study columns five equal-height-column" data-js="eqh-c">
						<div class="equal-height-containers">
						<?php echo $content; ?>
						<?php if ($case_study_url) : ?>
							<a href="<?php echo $case_study_url; ?>" class="button button-orange button-medium">Read the Case Study</a>
						<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
					
				</div>
				<?php endforeach; ?>
			</div>
			<div class="layer--quote__pagination"></div>
		<?php else : ?>
	    <blockquote class="layer--quote__quote column thirtteen push_two">
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
		<?php endif; ?>
		
    <?php if($layer['add_cta'] == 1 && !empty($layer['cta_text'])): ?>
    	<div class="layer--quote__cta">
        	<a href="<?php echo $layer['cta_link']; ?>" class="button white--button"><?php echo $layer['cta_text']; ?></a>
        </div>
    <?php endif ?>
  </div>
</section>
