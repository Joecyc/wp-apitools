<?php
/**
 * @package AnyApi
 */

namespace ApiTools\Controller;

class ApiRequest
{
  /**
   * CRUD request
   * @param mixed $option
   * @return void
   */

  public function readRequest(&$option) {
    $this->handleRequest($option, 'GET');
  }
  public function createRequest(&$option) {
    $body = $option['body'];
    $this->handleRequest($option, 'POST', $body);
  }
  public function updateRequest(&$option) {
    $body = $option['body'];
    $this->handleRequest($option, 'PATCH', $body);
  }
  public function deleteRequest(&$option) {
    $this->handleRequest($option, 'DELETE');
  }

  /**
   * Callback of executeRequest method
   * @param mixed $option
   * @param mixed $method
   * @param mixed $body
   * @return void
   */

  private function handleRequest(&$option, $method, $body = null) {

    $url = $option['url'];
    $key = $option['key'];
    $secret = $option['secret'];

    $data = $this->executeRequest($url, $key, $secret, $method, $body);
    $option['data'] = $data;

  }

  /**
   * Request Woocommerce API request
   * @param mixed $url
   * @param mixed $key
   * @param mixed $secret
   * @param mixed $method
   * @param mixed $body
   * @return mixed
   */

  public function executeRequest($url, $key, $secret, $method, $body = null) {

    if (filter_var($url, FILTER_VALIDATE_URL)) {

      $auth = base64_encode($key . ':' . $secret);
      $headers = array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Basic ' . $auth,
      );
      $args = array(
        'method'    => $method,
        'headers'   => $headers,
        'body'      => $body ? wp_json_encode($body) : null,
        'timeout'   => 15,
      );

      $response = wp_remote_post($url, $args);

      if (is_wp_error($response)) {
        return array(
          'message'   => '',
          'response'  => $response->get_error_message(),
        );
      }

      $httpcode = wp_remote_retrieve_response_code($response);
      $responseBody = wp_remote_retrieve_body($response);

      if ($httpcode == 200) {
        $data = json_decode($responseBody, true);
      } else {
        $decodedResponse = json_decode($responseBody, true);
        if (isset($decodedResponse['message'])) {
          $strippedMessage = wp_strip_all_tags($decodedResponse['message']);
          $decodedResponse['message'] = $strippedMessage;
        }
        $data = $decodedResponse;
      }
    } else {
      $data = array(
        'message'   => '',
        'response'  => 'Invalid URL',
      );
    }

    return $data;

  }

}