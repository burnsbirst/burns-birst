<?php

require_once get_template_directory() . '/classes/Plinth.php';

abstract class Plinth_Widget_Abstract extends WP_Widget {
  /**
   * Constructor
   *
   * @param string $id_base Optional Base ID for the widget, lower case, if left empty a portion of the widget's class name will be used. Has to be unique.
   * @param string $name Name for the widget displayed on the configuration page.
   * @param string $description Description of widget
   * @param string $classname CSS class name to apply to widget container
   */
  public function __construct($id_base, $name, $description, $classname = false) {
    $options = array('description' => __($description, 'plinth'));
    if($classname) {
      $options['classname'] = $classname;
    }

    parent::__construct(
      $id_base,
      __($name, 'plinth'),
      $options
    );

    add_shortcode($this->id_base, array($this, 'shortcode'));
  }

  /**
   * Return array of default values for this widget's fields
   *
   * @return array
   */
  abstract protected function field_defaults();

  /**
   * Echo the settings update form
   *
   * @param array $instance Current settings
   */
  public function form($instance) {
    parent::form($instance);
  }

  /**
   * Update widget settings.
   *
   * @param array $new_instance New settings for this instance as input by the user via form()
   * @param array $old_instance Old settings for this instance
   *
   * @return array|bool Array of settings to save or FALSE to cancel saving
   */
  public function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $field_names = array_keys($this->field_defaults());
    foreach ($field_names as $name) {
      $instance[$name] = strip_tags($new_instance[$name], '<br>');
    }

    $this->flush_widget_cache();
    $alloptions = wp_cache_get('alloptions', 'options');
    if (isset($alloptions[$this->id_base])) {
      delete_option($this->id_base);
    }

    return $instance;
  }

  public function shortcode($atts) {
    return $this->widget(array(
      'before_widget' => '<div class="widget widget_' . $this->id_base . '">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2 class="widgettitle">',
      'after_title'   => '</h2>'
    ), shortcode_atts($this->field_defaults(), $atts), false);
  }

  /**
   * Echo the widget content.
   *
   * @param array $args     Display arguments including before_title, after_title, before_widget, and after_widget.
   * @param array $instance The settings for the particular instance of the widget
   * @param bool  $echo     [Optional] If true, immediately echo the widget HTML. Default true.
   *
   * @return string Widget HTML
   */
  public function widget($args, $instance, $echo = true) {
    die('function Plinth_AbstractWidget::widget() must be over-ridden in a sub-class.');
  }

  /**
   * Remove widget content from cache
   *
   */
  public function flush_widget_cache() {
    wp_cache_delete($this->id_base, 'widget');
  }

  /**
   * Helper method for displaying a checkbox input field for a widget setting
   *
   * @param string $label   Label for input field
   * @param string $field   Name of input field
   * @param bool   $checked Is the checkbox checked?
   */
  protected function checkbox_field($label, $field, $checked) {
?>
  <p>
    <?php printf('<input class="checkbox" type="checkbox" name="%s"%s />',
      $this->get_field_name($field),
      $checked ? ' checked="checked"' : ''
    ); ?>
    <label for="<?php echo $this->get_field_id($field); ?>"><?php _e($label, 'plinth'); ?></label>
  </p>
<?php
  }

  /**
   * Helper method for displaying a select input field for a widget setting
   *
   * @param string $label   Label for input field
   * @param string $field   Name of input field
   * @param string $value   Value of input field
   * @param array  $options Options
   */
  protected function select_field($label, $field, $value, $options) {
?>
  <p>
    <label for="<?php echo $this->get_field_id($field); ?>"><?php _e($label, 'plinth'); ?>:</label>
    <select id="<?php echo $this->get_field_id($field); ?>" name="<?php echo $this->get_field_name($field); ?>">
      <?php foreach($options as $option_value => $label): ?>
        <option value="<?php echo esc_attr($option_value); ?>"<?php echo $value == $option_value ? ' selected' : ''; ?>><?php _e($label, 'plinth'); ?></option>
      <?php endforeach; ?>
    </select>
  </p>
<?php
  }

  /**
   * Helper method for displaying a text input field for a widget setting
   *
   * @param string $label  Label for input field
   * @param string $field  Name of input field
   * @param string $value  Value of input field
   * @param bool   $inline Inline field
   * @param int    $size   Size of field
   */
  protected function text_field($label, $field, $value, $inline = false, $size = null) {
?>
  <p>
    <label for="<?php echo $this->get_field_id($field); ?>"><?php _e($label, 'plinth'); ?>:</label>
    <?php printf('<input%s name="%s" type="text" value="%s"%s />',
      $inline ? '' : ' class="widefat"',
      $this->get_field_name($field),
      esc_attr($value),
      is_numeric($size) ? " size=\"$size\"" : ''
    ); ?>
  </p>
<?php
  }
}


