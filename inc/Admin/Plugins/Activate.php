<?php
/**
 * @package AnyApi
 */

namespace ApiTools\Admin\Plugins;

class Activate 
{

  public static function activate() {
    flush_rewrite_rules();

    $defaultOptions = array(
      'apitools_wc_api',
    );

    foreach ($defaultOptions as $option) {
      if (!get_option($option)) {
        update_option($option, array());
      }
    };
  }

}

