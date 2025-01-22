<?php
/**
 * @package AnyApi
 */

namespace ApiTools\Controller;

/**
 * Execute WooCommerce API
 */

class RespondApi extends ApiRequest
{
  public function updateData($data) {

    $options = !empty($data) ? get_option($data) ?: array() : array();

    foreach ($options as &$option) {
      if (!isset($option['triggered'])) {
        $option['triggered'] = false;
      }

      if (!$option['triggered']) {
        $method = strtoupper($option['method']);
        switch ($method) {
          case 'GET':
            $this->readRequest($option);
            break;
          case 'POST':
            $this->createRequest($option);
            break;
          case 'PATCH':
            $this->updateRequest($option);
            break;
          case 'DELETE':
            $this->deleteRequest($option);
            break;
        }

        $type = $option['type'];
        switch ($type) {
          case 'orders':
            $order = array($option['url'] => $option);
            break;
          case 'customers':
            $customer = array($option['url'] => $option);
            break;
          case 'products':
            $product = array($option['url'] => $option);
            break;
        }
        $option['triggered'] = true;
      }

    }

    update_option($data, $options);

  }

}