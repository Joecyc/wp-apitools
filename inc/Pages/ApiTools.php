<?php
/**
 * @package AnyApi
 */

namespace ApiTools\Pages;

use ApiTools\Admin\Pages;
use ApiTools\Admin\Settings;
use ApiTools\Admin\Plugins\SettingsApi;
use ApiTools\Controller\RespondApi;
use ApiTools\Data\SanitizeApi;
use ApiTools\Pages\ApiSection;

class ApiTools extends Settings
{
  // Admin variables
  public $settings;
  public $adminpages;

  // Section variables
  public $apiSection;
  public $apiParts;
  public $respondApi;

  public $pages = array();
  public $subpages = array();

  public function register() {

    $this->adminpages = new Pages();
    $this->settings = new SettingsApi();

    $this->apiParts = new SanitizeApi();
    $this->apiSection = new ApiSection();
    $this->respondApi = new RespondApi();

    $this->setPages();
    $this->setSettings();
    $this->setSections();
    $this->settings->addPages( $this->pages )->withSubPage( 'API Tools' )->register();

    $this->apiRequest();

  }

  public function setPages() {

    $this->pages = array (
      array (
      'page_title' => 'API Tools for WooCommerce',
      'menu_title' => 'REST API',
      'capability' => 'manage_options',
      'menu_slug' => 'apitools',
      'callback' => array( $this->adminpages, 'apiTools' ),
      'icon_url' => 'dashicons-admin-plugins',
      'position' => 150
      )
    );

  }

  public function setSettings() {

    $args = array(
      array(
				'option_group' => 'apitools_wc_settings',
				'option_name' => 'apitools_wc_api',
				'callback' => array( $this->apiParts, 'fieldSanitize' )
			)
    );

    $this->settings->setSettings( $args );

  }

  public function setSections() {

    $args = array(
      array(
        'id' => 'apitools_fields',
				'title' => 'Send Any WooCommerce REST API',
        'callback' => array( $this->apiSection, 'apiFields'),
				'page' => 'apitools_input_fields',
        'args' => array(
          'option_name' => 'apitools_wc_api'
        )
      ),
      array(
				'id' => 'apitools_response',
				'title' => 'Response',
				'callback' => array( $this->apiSection, 'responseJson' ),
				'page' => 'apitools_response_json',
        'args' => array(
          'option_name' => 'apitools_wc_api'
        )
			),
    );
    $this->settings->setSections( $args );

  }

  public function setFields() {

    $args = array();

    // Loop field from Data/Dataset

    $this->settings->setFields( $args );

  }

  public function apiRequest() {

    $data = 'apitools_wc_api';
    if (!empty($data)) {
      $this->respondApi->updateData($data);
    }

  }

}