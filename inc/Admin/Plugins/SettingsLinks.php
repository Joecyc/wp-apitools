<?php
/**
 * @package AnyApi
 */

namespace ApiTools\Admin\Plugins;

use ApiTools\Admin\Settings;

class SettingsLinks extends Settings
{

  public function register () {

    add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );

  }

  public function settings_link( $links ) {

    $settings_link = '<a href="admin.php?page=anyapi">Settings</a>';
    array_push($links, $settings_link);
    return $links;

  }

}