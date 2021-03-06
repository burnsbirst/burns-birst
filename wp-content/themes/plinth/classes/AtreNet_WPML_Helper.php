<?php

require_once dirname(__FILE__) . '/AtreNet_WordPress_Helper.php';

class AtreNet_WPML_Helper extends AtreNet_WordPress_Helper {

  const VERSION = '0.0.1';

  protected static $bridge = null;

  protected static $instance = null;

  protected function __construct($bridge) {
    // TODO - add check for WPML availability

    // Support passing in a bridge for testing
    if (null === $bridge) {
      $bridge = AtreNet_WPML_WordPress_Bridge::getInstance();
    }

    parent::__construct($bridge);
  }

  /*
   * Get the language of a post
   *
   * @param  int  post id
   * @param  string  Optional post type
   *
   * @returns mixed  2 letter language code if translated, FALSE if not translated
   */
  public function postLanguage($post_id, $post_type = false) {
    $post_type = $this->normalize_post_type($post_id, $post_type);

    $lang_details = $this->getBridge()->get_element_language_details($post_id, $post_type);

    return is_object($lang_details) ? $lang_details->language_code : FALSE;
  }

  /*
   * Get the id of the translation of a particular post.
   *
   * If the post has not been translated into that language, FALSE is returned.
   *
   * @param  string  2 letter language code
   * @param  int  post id
   * @param  string  Optional post type
   *
   * @returns mixed  Translated post id or FALSE
   */
  public function getTranslatedId($language_code, $post_id, $post_type = false) {
    $post_type = $this->normalize_post_type($post_id, $post_type);

    $return_trans_details = true;
    $trans_details = $this->isTranslatedToLanguage($language_code, $post_id, $post_type, $return_trans_details);
    //echo("trans_details: <pre>" . print_r($trans_details, 1) . "</pre><br>\n");

    return $trans_details->element_id;
  }

  /*
   * Test to see if a post has been translated into a particular language.
   *
   * @param  string  2 letter language code
   * @param  int     post id
   * @param  string  Optional post type
   * @param  bool    Flag to return the translated post id or not
   *
   * @returns mixed  bool if param 4 is false or post isn't translated, translation details if param 4 is true and post has been translated
   */
  public function isTranslatedToLanguage($language_code, $post_id, $post_type = false, $return_trans_details = false) {
    $post_type = $this->normalize_post_type($post_id, $post_type);

    //echo("post_id: $post_id && post_type: $post_type<br>\n");

    $bridge       = $this->getBridge();
    $lang_details = $bridge->get_element_language_details($post_id, $post_type);
    //echo("lang_details: " . print_r($lang_details, 1) . "<br>\n");
    $translations = $bridge->get_element_translations($lang_details->trid);
    //echo("translations: <pre>" . print_r($translations, 1) . "</pre><br>\n");

    if ( array_key_exists($language_code, $translations) ) {
      if ($return_trans_details) {
        return $translations[$language_code];
      } else {
        return TRUE;
      }
    }

    return FALSE;
  }
}

class AtreNet_WPML_WordPress_Bridge extends AtreNet_WordPress_Bridge {

  const VERSION = '0.0.1';

  protected static $instance = null;

  public function get_element_language_details($post_id, $post_type) {
    global $sitepress;
    return $sitepress->get_element_language_details($post_id, "post_{$post_type}");
  }

  public function get_element_translations($trid) {
    global $sitepress;
    return $sitepress->get_element_translations($trid);
  }
}


