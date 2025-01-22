<?php
/**
 * @package AnyApi
 */

namespace ApiTools\Data;

use ApiTools\Admin\Settings;

Class SanitizeApi extends Settings
{
  public function fieldSanitize( $input ) {

    $output = get_option( 'apitools_wc_api' );
    $outputUrl = '';

    if ( isset($_POST["remove"]) ) {
      if (isset($_GET['setupkey_nonce'])) {
        $setupKeyNonce = sanitize_text_field(wp_unslash($_GET['setupkey_nonce']));
        if ( !wp_verify_nonce($setupKeyNonce, 'setupkey_nonce_action')) {
          die('Nonce verification failed');
        }
      };
      unset($output[$_POST["remove"]]);
      return $output;
    }

    $inputType = $input['type'];
    $inputUrl = $input['url'];
    $inputId = $input['id'];

    $endpoints = [
      'orders' => '/wp-json/wc/v3/orders/',
      'customers' => '/wp-json/wc/v3/customers/',
      'products' => '/wp-json/wc/v3/products/'
    ];

    if (isset($endpoints[$inputType])) {
      $endpoint = $endpoints[$inputType];

      if (filter_var($inputUrl, FILTER_VALIDATE_URL) && preg_match('#' . preg_quote($endpoint, '#') . '.*#', $inputUrl)) {
        $outputUrl = preg_replace('#(' . preg_quote($endpoint, '#') . ').*#', '${1}' . $inputId, $inputUrl);
      } else {
        $inputUrl = trim($inputUrl);
        if (!preg_match('#^https?://#', $inputUrl)) {
          $inputUrl = 'https://' . $inputUrl;
        }
        if (!preg_match('#^https?://www\.#', $inputUrl)) {
          $inputUrl = str_replace('://', '://www.', $inputUrl);
        }
        $outputUrl = $inputUrl . $endpoint . $inputId;
      }
    }

    $input['url'] = $outputUrl;
    $output = array($input['url'] => $input);

    return $output;

  }

}