<?php
// Solution Finder

?>
<section class="layer--solution-finder">
	<div class="row" <?php plinth_style_attr(array('image' => $layer['background_image'])); ?>>
  	<div class="columns four">
    	<?php
				echo $layer['content']; 
			?>
      <ul class="solution-nav">
      
      	<?php foreach($layer['solution'] as $solution): ?>
        	<li><a href="<?php echo $solution['solutions_link']; ?>"><?php echo $solution['title']; ?></a></li>
        <?php endforeach; ?>
   
      </ul>
      <?php if($layer['cta_label']): ?>
      	<a href="<?php echo $layer['solution'][0]['solutions_link']; ?>" class="button-orange cta-link"><?php echo $layer['cta_label']; ?></a>
      <?php endif; ?>
    </div>
    <div class="columns push_four seven question-container">
      <?php foreach($layer['solution'] as $solution): ?>
      	<div class="questions" data-bgimage="<?php echo $solution['person_image']['url']; ?>">
        	<?php foreach($solution['questions'] as $question): ?>
        	<div class="question">
          	<a href="<?php echo $solution['solutions_link']; ?>">"<?php echo $question['question']; ?>"</a>
          </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </div>
	</div>
</section>
