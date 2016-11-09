<div class="wrap">
  <h2>AtreNet Post Types</h2>
  <form method="post" action="options.php">
    <?php
      settings_fields('atrenet_post_types-group');
      do_settings_fields('atrenet_post_types', 'atrenet_post_types-group');
      do_settings_sections('atrenet_post_types');
      submit_button();
    ?>
  </form>
</div>
