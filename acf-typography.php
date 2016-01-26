<?php namespace CustomFieldTypography;

require __DIR__ . '/vendor/autoload.php';

use Michelf\SmartyPants;
use add_filter;
use add_action;
use get_field;


/*
Plugin Name: ACF Typography
Plugin URI: http://github.com/shortlist-digital/acf-typography
Description: Improve typography in WordPress sites using ACF fields
Version: 1.0.0
Author: Jon Sherrard
Author URI: http://twitter.com/jshez
License: GPL2
*/

class CustomFieldTypography {

  function __construct() {
    add_action('after_setup_theme', array($this, 'setup_filters'));
  }

  function setup_filters() {
    add_filter('acf/update_value/type=text', array($this, 'format'), 13, 3);
    add_filter('acf/update_value/type=wysiwyg', array($this, 'format'), 13, 3);
    add_filter('acf/update_value/type=strict_wysiwyg', array($this, 'format'), 13, 3);
    add_filter('wp_insert_post_data', array($this, 'format_title'), 13, 2);
  }

  function format_title($data, $post_arr) {
    $data['post_title'] = $this->do_format($data['post_title']);
    return $data;
  }

  function do_format($value) {
    $value = stripcslashes($value);
    $value = SmartyPants::defaultTransform($value);
    $value = html_entity_decode($value);
    return $value;
  }

  function format($value, $post_id = null , $field= null) {
    if (!empty($value)) {
      $value = $this->do_format($value);
      return $value;
    }
  }

}

new CustomFieldTypography();
