    <?php if ($title = get_field('page_heading')): ?>
      <h1 class="h-page-heading"><?php echo $title; ?></h1>
    <?php else: ?>
      <h1 class="h-page-heading"><?php the_title(); ?></h1>
    <?php endif; ?>

    <?php if ($subtitle = get_field('page_sub-heading')): ?>
      <h2 class="h-page-sub-heading"><?php echo $subtitle; ?></h2>
    <?php endif; ?>

