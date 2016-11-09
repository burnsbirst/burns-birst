<?php

/**
 * Utility methods for the Plinth WordPress theme.
 */

/**
 * Class to encapsulate utility methods.
 */
class Plinth_Util {

  const VERSION = '0.0.1';

  /**
   * @internal
   *
   * Cache date format lookups for better performance
   */
  private static $date_format_lookup = false;

  /**
   * Format an excerpt of text.
   *
   * @param  string  $text  The text to pull the excerpt from
   * @param  int  $length  The length of the excerpt in words
   * @param  string  $read_more  The trailing text to indicate that there is more.
   *
   * @return  string  The excerpt
   */
  public static function formatExcerpt($text, $length = 20, $read_more = '...') {
    if ( '' != $text ) {
      $text = strip_shortcodes( $text );
      $text = apply_filters('the_content', $text);
      $text = str_replace(']]>', ']]>', $text);
      $text = wp_trim_words( $text, $length, $read_more );
    }
    return apply_filters('the_excerpt', $text);
  }
		
  /**
   * Format 'extras' field classes for layer CSS class assignment.
   *
   * @param  	array  $extras  a single dimensional array class values
   *
   * @return  string  space delimited string ideal for css class assignment
   */
  public static function formatArrayToClasses($extras) {
    $extras_classes = '';
		if($extras):
			foreach ($extras as $class):
				$extras_classes .= $class.' ';
			endforeach;
			$extras_classes = rtrim($extras_classes);
		endif;
    return $extras_classes;
  }
	
  /**
   * Format 'extras' field classes for layer CSS class assignment.
   *
   * @param  	array  $extras  Array of class values
   *
   * @return  string  Extras classes
   */
  public static function formatExtrasClasses($extras) {
    $extras_classes = '';
		if($extras):
			foreach ($extras as $class):
				$extras_classes .= $class.' ';
			endforeach;
			$extras_classes = rtrim($extras_classes);
		endif;
    return $extras_classes;
  }



  /**
   * Format a date.
   *
   * A helper function that builds a date format lookup before calling
   * AtreNet_DateFormat to actually format the date.
   *
   * The date format lookup is built from the Site Options for the
   * current language.
   *
   * @param  string  $date  The date to format
   *
   * @return  string  The formatted date.
   */
  public static function getFormattedDate($date) {
    return AtreNet_DateFormat::getFormattedDate( $date, self::_get_date_format_lookup() );
  }

  /**
   * Format a date range.
   *
   * A helper function that builds a date format lookup before calling
   * AtreNet_DateFormat to actually format the date.
   *
   * The date format lookup is built from the Site Options for the
   * current language.
   *
   * @param  string  $date1  The first date in the range.
   * @param  string  $date2  The last date in the range.
   *
   * @return  string  The formatted date range.
   */
  public static function getFormattedDateRange($date1, $date2) {
    return AtreNet_DateFormat::getFormattedDateRange( $date1, $date2, self::_get_date_format_lookup() );
  }

  /**
   * @internal
   * Get a date formate lookup list.
   *
   * Cached for better performance.
   *
   * NOTE: cache assumes only a single language per request. Does not store
   * different format values for different languages in the same request.
   *
   * @return  array
   */
  private static function _get_date_format_lookup() {
    if ( self::$date_format_lookup === false ) {

      $key_namespace = 'date_formats';
      $keys = array('single_day_format', 'single_month_format', 'multi_month_format', 'multi_year_format');

      $lookup = array();
      foreach ($keys as $key) {
        $format = Plinth::getSiteOption( array($key_namespace, $key) );
        if ( AtreNet_Util::isArray($format, 1) ) {
          $format = array_shift($format);
        }
        $lookup[$key] = $format;
      }

      self::$date_format_lookup = $lookup;
    }

    return self::$date_format_lookup;
  }
}
