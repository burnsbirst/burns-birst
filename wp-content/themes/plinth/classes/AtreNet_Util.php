<?php

/**
 * Helper class to provide common utility functions.
 */
class AtreNet_Util {

  const VERSION = '0.0.1';

  /**
   * Convert words to an ID string.
   *
   * @param  string  $string  A string of white-space separated words.
   *
   * @return string
   */
  public static function wordsToId($string) {
    $string = preg_replace('/&amp;/', 'and', $string);
    $string = preg_replace('/\s+/', '_', $string);
    $words = preg_split('/_|-/', $string);
    $string = implode('', array_map(array(self, '_uc_first_lc_others'), $words));
    return preg_replace('/[^\pL\pN_]/u', '', $string);
  }

  private static function _uc_first_lc_others($string) {
    return ucfirst(strtolower($string));
  }

	/**
   * Test if a variable is an array and has at least a certain number of
   * elements.
   *
   * @param  mixed  $ary  Variable to test
   * @param  int  $min_count  Minimum number of elements to check for
   *
   * @return bool
   */
  public static function isArray($ary, $min_count = 0) {
    return $ary && is_array($ary) && count($ary) >= $min_count;
  }
	
	/**
   * Insert a new entry in an associative array after an existing key.
   *
   * If the key does not exist, the new entry is appended
   *
   * Adapted from: http://stackoverflow.com/questions/2149437/how-to-add-an-array-value-to-the-middle-of-an-associative-array#answer-9847709
   *
   * @todo backport to Plinth
   *
   * @param  array  $array  The array to add a new entry to
   * @param  string  $key  The key to insert the new entry after
   * @param  array  $data  The new entry to exist ex:
   *                       array( 'new_key' => 'new_value' )
   *
   * @return  array  A new array with the new entry added
   */
  public static function insertAfterKey($array, $key, $data = null) {
    if (($offset = array_search($key, array_keys($array))) === false) {
      $offset = count($array);
    } else {
      $offset++;
    }

    // Handle odd situations...
    if ($offset > count($array)) {
      $offset = count($array);
    }

    return array_merge(array_slice($array, 0, $offset), (array) $data, array_slice($array, $offset));
  }

  /**
   * Pluralize a string
   *
   * Uses Inflect::pluralize() which is based on Rails Inflect class.
   * See: http://kuwamoto.org/2007/12/17/improved-pluralizing-in-php-actionscript-and-ror/
   *
   * @todo  Backport to Plinth main
   *
   * @param  string  $string  The string to pluralize
   *
   * @return  string
   */
  public static function pluralize($string) {
    return Inflect::pluralize($string);
  }
	
}
