<?php
// Analytics Server Diagram
?>
<section class="layer--asd">
	<div class="container">
		<?php if($layer['header'] && !empty($layer['header'])): ?>
	  <div class="layer--asd__heading"><?php echo $layer['header']; ?></div>
		<?php endif; ?>
		
		<div class="layer--asd__container" data-js="eqh-w">
			<?php 
				$segments = $layer['diagram_segments'];
				$diagram = array();
				foreach ($segments as $segment) :
					$diagram[$segment['diagram_section']]['title'] = $segment['title'];
					$diagram[$segment['diagram_section']]['blurb'] = $segment['blurb'];
				endforeach;
			?>
			<div class="blurb top-blurb" data-js="eqh-c"><div class="blurb-content"><h4><?php echo $diagram['top']['title']; ?></h4><?php echo $diagram['top']['blurb']; ?></div></div>
			<div class="diagram-image" data-js="eqh-c">
				<div class="image">
					<img src="/images/analytics-server-diagram.png" alt="Analytics Server Diagram" class="desktop" />
					<img src="/images/analytics-server-diagram-mobile.png" alt="Analytics Server Diagram - Mobile" class="mobile" />
				</div>
				<div class="top-title"><?php echo $diagram['top']['title']; ?></div>
				<div class="bottom-title"><?php echo $diagram['bottom']['title']; ?></div>
			</div>
			<div class="blurb bottom-blurb" data-js="eqh-c"><div class="blurb-content"><h4><?php echo $diagram['bottom']['title']; ?></h4><?php echo $diagram['bottom']['blurb']; ?></div></div>
		</div>
	</div>
</section>
