<?php
/**
 * AnyApi
 *
 * @package           AnyApi
 * @author            Anyapiplugin.com
 * @license           GPL-2.0-or-later
 *
 * Plugin Name:       API Tools for WooCommerce
 * Plugin URI:        https://anyapiplugin.com
 * Description:       Rest API tools for WooCommerce
 * Version:           1.0.0
 * Author:            Anyapiplugin.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       apitools
 *
 */

defined ('ABSPATH') or exit;

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
  require_once dirname(__FILE__) . '/vendor/autoload.php';
}

function apitools_activate() {
  ApiTools\Admin\Plugins\Activate::activate();
}
register_activation_hook( __FILE__, 'apitools_activate' );

function apitools_deactivate() {
  ApiTools\Admin\Plugins\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'apitools_deactivate' );

if (class_exists('ApiTools\\Init')) {
  ApiTools\Init::registerServices();
}