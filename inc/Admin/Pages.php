<?php
/**
 * @package AnyApi
 */

namespace ApiTools\Admin;

use ApiTools\Admin\Settings;

Class Pages extends Settings 
{
  public function apiTools() {

    return require_once( "$this->plugin_path/templates/apitools.php" );

  }

}