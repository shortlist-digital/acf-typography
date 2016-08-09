<?php

namespace CustomFieldTypography;

require __DIR__.'/vendor/autoload.php';

use add_action;
use add_filter;
use Michelf\SmartyPants;

/*
Plugin Name: ACF Typography
Plugin URI: http://github.com/shortlist-digital/acf-typography
Description: Improve typography in WordPress sites using ACF fields
Version: 1.0.0
Author: Jon Sherrard
Author URI: http://twitter.com/jshez
License: GPL2
*/

class CustomFieldTypography
{
    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'setup_filters']);
    }

    public function setup_filters()
    {
        add_filter('acf/update_value/type=text', [$this, 'format'], 13, 3);
        add_filter('acf/update_value/type=wysiwyg', [$this, 'format'], 13, 3);
        add_filter('acf/update_value/type=strict_wysiwyg', [$this, 'format'], 13, 3);
        add_filter('wp_insert_post_data', [$this, 'format_title'], 13, 2);
    }

    public function format_title($data, $post_arr)
    {
        $data['post_title'] = $this->do_format($data['post_title']);

        return $data;
    }

    public function do_format($value)
    {
        $value = stripcslashes($value);
        $value = SmartyPants::defaultTransform($value);
        $value = html_entity_decode($value);

        return $value;
    }

    public function format($value, $post_id = null, $field = null)
    {
        if (!empty($value)) {
            $value = $this->do_format($value);

            return $value;
        }
    }
}

new CustomFieldTypography();
