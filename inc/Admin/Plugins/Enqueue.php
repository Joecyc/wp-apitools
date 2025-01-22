<?php
/**
 * @package AnyApi
 */

namespace ApiTools\Admin\Plugins;

use ApiTools\Admin\Settings;
/**
 * Scripts settings
 */

class Enqueue extends Settings
{

  public function register() {

    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue') );

  }

  function enqueue () {

    wp_enqueue_style( 'mypluginstyle', $this->plugin_url . 'assets/css/style.css' );
    wp_enqueue_script( 'mypluginscript', $this->plugin_url . 'assets/js/script.min.js' );

  }

} 