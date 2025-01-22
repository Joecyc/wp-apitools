<?php
/**
 * @package AnyApi
 */

namespace ApiTools\Data\Dataset;

Class Tools
{
  public static function getToolsConfig() {

    return array(
      'dropDownFields' => array(
        'type' => array(
          'title' => 'API Type',
          'option' => array(
            'orders' => 'Orders',
            'customers' => 'Customers',
            'products' => 'Products',
          )
        ),
        'method' => array(
          'title' => 'API Methods',
          'option' => array(
            'get' => 'GET',
            'post' => 'POST',
            'patch' => 'PATCH',
            'delete' => strval('DELETE'),
          )
        ),
      ),
      'inputFields' => array(
        'url' => array(
          'title' => 'Domain Name',
          'placeholder' => 'Enter domain name',
        ),
        'id' => array(
          'title' => 'ID',
          'placeholder' => 'Enter Order ID',
        ),
        'key' => array(
          'title' => 'Consumer Key',
          'placeholder' => 'Enter consumer key',
        ),
        'secret' => array(
          'title' => 'Consumer Secret', 
          'placeholder' => 'Enter consumer secret',
        ),
      ),
    );

  }

}