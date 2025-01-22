<?php
/**
 * @package AnyApi
 */

namespace ApiTools\Admin\Plugins;

class Deactivate
{

  public static function deactivate () {
    flush_rewrite_rules();
  }

}