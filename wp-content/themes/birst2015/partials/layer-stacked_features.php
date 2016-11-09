<?php
// Stacked Features

$feature_list = $layer['feature_list'];
$feature_count = 1;
?>
<section class="layer--stacked_features">
	<div class="layer--stacked_features__container" data-js="eqh-w">
		<div class="row">
		<?php foreach ($feature_list as $feature) :?>
			<?php if ($feature_count == 2) : ?>
				<div class="columns three stacked-features-divider">
					<div class="stacked-features-divider__container">
						<div class="arrow-top"></div>
						<div class="divider"></div>
						<div class="arrow-bottom"></div>
					</div>
				</div>
			<?php endif; ?>
			<div class="columns six">
				<div class="layer--stacked_features__heading" data-js="eqh-c2">
					<div class="heading-content">
						<?php echo $feature['title']; ?>
					</div>
				</div>
				<div class="layer--stacked_features__stacks stack-col-<?php echo $feature_count; ?>">
					<?php $stack_count = 1; ?>
					<?php foreach ($feature['features'] as $feature_item) : ?>
					<div class="stack stack-<?php echo $stack_count; ?>">
						<div class="stack-container" data-js="eqh-c">
						<div class="icon"><?php if ($feature_item['icon']) : ?><img src="<?php echo $feature_item['icon']['url']; ?>" alt="<?php echo $feature_item['icon']['alt']; ?>" /><?php endif; ?></div>
						<div class="stack-content">
							<?php echo $feature_item['content']; ?>
						</div>
						</div>
					</div>
					<?php $stack_count++; ?>
					<?php endforeach; ?>
				</div>
			</div>
			<?php $feature_count++; ?>
		<?php endforeach; ?>
		</div>
	</div>
</section>
