<?php
// Leadership Overview
?>
<section class="layer--leadership__overview">
	<div class="container">
            <?php if(isset($layer['content']) && !empty($layer['content'])): ?>
	      		<div class="leadership__overview-content"><?php echo $layer['content']; ?></div>
	      	<?php endif ?>
				<div class="leadership__overview-leaders">
					<?php 
					$leaders = $layer['leaders'];
					$counter=1;
					if( $leaders ): ?>
						<ul>
						<?php foreach( $leaders as $p ): ?>
							<?php $image=get_field('headshot', $p->ID); ?>
								<li class="leadership__overview-img headshot-<?php echo $counter;?>" id="headshot-<?php echo $counter;?>">
	    						<img src="<?php echo $image['url'];?>" alt="<?php echo get_the_title( $p->ID ); ?>" class="<?php if($counter==1): echo 'active'; endif;?>" />
	    					</li>
								<?php $counter++;?>
						<?php endforeach; ?>
						</ul>
						<div class="leadership__overview-bios">
							<?php $counter=1; ?>
							<?php foreach( $leaders as $p ): ?>
								<div class="leadership__overview-bio bio-<?php echo $counter;?>" id="bio-<?php echo $counter;?>">
									<div class="name--title">
										<div class="name"><?php echo get_the_title($p->ID);?></div>
										<div class="job-title"><?php echo get_field('title', $p->ID);?></div>
									</div>
									<div class="bio-excerpt"><?php echo get_field('bio', $p->ID);?></div>
								</div>
								<?php $counter++;?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
        <div class="leadership__overview-button"><a href="/company/management-team/" class="button button-orange">View All Bios</a></div>
		</div>
</section>