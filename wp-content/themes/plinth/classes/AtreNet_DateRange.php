<?php

/**
 * Helper class for handling date ranges.
 */
class AtreNet_DateRange {

  /**
   * @var First date in the range
   */
  private $d1;

  /**
   * @var Last date in the range
   */
  private $d2;

  /**
   * Create a new AtreNet_DateRange.
   *
   * @param  string  $d1  Date for start of range
   * @param  string  $d2  Date for end of range (defaults to empty string which implies a single day "range")
   */
  function __construct($d1, $d2 = '') {
    $this->d1 = strtotime($d1);
    if ( isset($d2) && $d2 !== '' ) {
      $this->d2 = strtotime($d2);
    } else {
      $this->d2 = false;
    }
  }

  /**
   * Callback for preg_replace_callback to get a part of a date from the range based on
   * the format template.
   *
   * @see AtreNet_DateFormat::getFormattedDateRange()
   *
   * @param  array  $matches  Array of matches from preg_replace_callback
   *
   * @return mixed
   */
  function get_date_part($matches) {
    $date = $matches[2] == '1' ? $this->d1 : $this->d2;
    return date($matches[1], $date);
  }

  /**
   * Determine what date format should be used based in "distance" between
   * dates in the range
   *
   * @return string
   */
  function determine_format_type() {
    $format_type = 'same_day_format';
    if (!$this->d2) {
      // default
    }
    else if ( date('Y', $this->d1) != date('Y', $this->d2) ) {
      $format_type = 'diff_year_format';
    }
    else if ( date('m', $this->d1) != date('m', $this->d2) ) {
      $format_type = 'same_year_format';
    }
    else if ( date('d', $this->d1) != date('d', $this->d2) ) {
      $format_type = 'same_month_format';
    }

    return $format_type;
  }

}

