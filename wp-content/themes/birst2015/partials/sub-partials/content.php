<div class="content">
  <?php if($template === 'template-layers.php' && isset($layer['show_breadcrumbs']) && $layer['show_breadcrumbs'] === true && $i === 0): ?>
    <?php include(locate_template('partials/component-breadcrumbs.php')); ?>
  <?php endif; ?>
  <?php echo $item['content']; ?>
</div>
