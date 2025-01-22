<?php
/**
 * @package AnyApi
 */

namespace ApiTools\Admin;

use ApiTools\Data\Dataset\Tools;

class Settings
{
  public $plugin_path;
  public $plugin_url;
  public $plugin;

  // ApiTools Settings
  public $dropDownFields = array();
  public $inputFields = array();

  public function __construct() {

    $this->plugin_path = plugin_dir_path( dirname( __FILE__, 2) );
    $this->plugin_url = plugin_dir_url( dirname( __FILE__, 2) );
    $this->plugin = plugin_basename( dirname( __FILE__, 3) ) . '/apitools.php';

    $apiTools = Tools::getToolsConfig();
    $this->dropDownFields = $apiTools['dropDownFields'];
    $this->inputFields = $apiTools['inputFields'];

  }

}