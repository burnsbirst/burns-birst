<?php

/**
 * Helper class for building/outputting tags.
 */
class Plinth_TagHelpers {

  const VERSION = '0.0.1';

  /*
   * @internal
   */
  private static function _find_image_size($image_id, $sizes) {
    if ( is_array($image_metadata = wp_get_attachment_metadata($image_id)) ) {
      if ( !empty($image_metadata['sizes']) && is_array($sizes)) {
        //echo('sizes: ' . print_r($sizes, 1));
        //echo("image_metadata['sizes']: " . print_r($image_metadata['sizes'], 1));
        foreach ($sizes as $size) {
          //echo("testing size: '$size'\n");
          if ( array_key_exists($size, $image_metadata['sizes']) ) {
            //echo "matched!\n";
            return $size;
          }
        }
      }
    }
    return 'full';
  }

  /**
   * Output an alt attribute with.
   *
   * If no alt text is provided, nothing is output.
   *
   * @param  string  $alt  Alt text
   */
  public static function outputAltTag($alt) {
    if ($alt) {
      echo ' alt="' . esc_attr($alt) . '"';
    }
  }

  /**
   * Output a class, optionally with attribute label.
   *
   * @param  string  $class_name  The class name.
   * @param  bool  $bare_class  If TRUE, just outputs the class name with a leading space, not the attribute label. Defaults to FALSE.
   */
  public static function outputClass($class_name, $bare_class = false) {
    if ( $class_name ) {
      if ($bare_class) {
        echo ' ' . $class_name;
      } else {
        echo ' class="' . $class_name . '"';
      }
    }
  }

  /**
   * Output an image tag.
   *
   * @param  array  $image  An array of image attributes like that from ACF (http://www.advancedcustomfields.com/resources/field-types/image/)
   * @param  string  $class_name  Class to apply to image
   * @param  string  $alt  Optional alt text for image. If not provided, attempts to get alt text from WordPress or uses image name
   * @param  array  $sizes  Optional array of pre-defined sizes to try to use (for retina images)
   * @param  bool  $lazy_load  If TRUE, outputs image tag with data- attributes instead actual image attributes so that the image can be lazy loaded. Defaults to FALSE.
   */
  public static function outputImage($image, $class_name, $alt = '', $sizes = array(), $lazy_load = false) {
    if ($image) :
      $size = self::_find_image_size($image['id'], $sizes);

      $image_data = wp_get_attachment_image_src($image['id'], $size);
      if ($image_data) {
        $image['url'] = $image_data[0];
        $image['width'] = $image_data[1];
        $image['height'] = $image_data[2];
        if ( strpos($size, 'retina') !== false || preg_match('/@2x\.\w{3,4}$/', $image['url']) ) {
          $image['retina'] = true;
        } else {
          $image['retina'] = false;
        }
      }

      if (!$alt) {
        $media_alt = array_key_exists('alt', $image) ? $image['alt'] : '';
        if ($media_alt) {
          $alt = $media_alt;
        } else if ( $default_alt = explode('/', $image['url']) ) {
          $alt = end($default_alt);
        }
      }

      $width = intval($image['width']);
      $height = intval($image['height']);
      if ($image['retina']) {
        $width = floor($width/2);
        $height = floor($height/2);
      }
?>
      <?php if ($lazy_load) : ?>
        <img data-src="<?php echo $image['url']; ?>" data-width="<?php echo $width; ?>" data-height="<?php echo $height; ?>" data-retina="<?php echo $image['retina'] ? 'yes' : 'no'; ?>"<?php self::outputClass($class_name); ?><?php self::outputAltTag($alt); ?>>
        <noscript><img src="<?php echo $image['url']; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" data-retina="<?php echo $image['retina'] ? 'yes' : 'no'; ?>"<?php self::outputClass($class_name); ?><?php self::outputAltTag($alt); ?>></noscript>
      <?php else : ?>
        <img src="<?php echo $image['url']; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" data-retina="<?php echo $image['retina'] ? 'yes' : 'no'; ?>"<?php self::outputClass($class_name); ?><?php self::outputAltTag($alt); ?>>
      <?php endif; ?>
<?php
    endif;
  }

  /**
   * Output a min-width property and value, optionally with style attribute label.
   *
   * @param  int  $width  The minimum width value, must be > 0
   * @param  bool  $bare_style  If TRUE, just output the min-width property and value with a leading space, not the style attribute label. Defaults to FALSE
   */
  public static function minWidth($width, $bare_style = false) {
    if ( !$width || !is_numeric($width) ) {
      return;
    }
    if ( $width = intval($width, 10) ) {
      if ($bare_style) {
        echo ' min-width: ' . $width . 'px';
      } else {
        echo ' style="min-width: ' . $width . 'px;"';
      }
    }
  }
}
