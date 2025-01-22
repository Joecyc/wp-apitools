<?php
/**
 * @package AnyApi
 */

namespace ApiTools\Pages;

use ApiTools\Admin\Settings;

class ApiSection extends Settings
{
  private $setId;
  private $getId;

  public function apiFields( $args ) {

    $optionName = $args['option_name'];

    // <Select> elemment data
    echo '<hr>';
    foreach( $this->dropDownFields as $key => $value ) {
      $tooltips = $value['tooltip'];
      $label = $value['title'];
      $input = $value['option'];
      $name = $key;
      $inputValue = '';

      echo '<div class="api-input-form">';
      echo '<label for="' . esc_html($label) . '">' . esc_html($label) . '</label>';
      echo '<select class="dropdown" id="' . esc_html($name) . '" name="' . esc_html($optionName) . '[' . esc_html($name) . ']">';

      // Inputted values handle
      $options = get_option( $optionName ) ?: array();
      $type = '';
      foreach ($options as $option) {
        $type = $option['type'];
      }

      foreach ($input as $key => $value) {
        echo '<option value="' . esc_html($key) . '" ' . ($key == $type ? ' selected' : '') . '
        >' . esc_html($value) . '</option>';
      }
      echo '</select>';
      echo '</div>';

    }

    echo '<input type="hidden" name="apitools_nonce" value="' . esc_html( wp_create_nonce('apitools_nonce_action') ). '">';

    // <textarea> elemment data
    // Inputted values handle
    $options = get_option( $optionName ) ?: array();
    $apiBody = '';

    foreach ($options as $option) {
      $apiBody = $option['body'];
    }

    $textAreaValue = $apiBody;
    echo '<div class="api-input-form">';
    echo '<label id="bodyLabel" hidden>API BODY</label>';
    echo '<textarea id="body" name="' . esc_html($optionName) . '[body]" class="" placeholder="Please input API BODY" rows="6" hidden>' . esc_html($textAreaValue) . '</textarea></div>';

    // <Input> elemment data
    foreach( $this->inputFields as $key => $value ) {
      $tooltips = $value['tooltip'];
      $label = $value['title'];
      $name = $key;
      $placeholder = $value['placeholder'];
      $inputValue = '';

      // Inputted values handle
      $options = get_option( $optionName ) ?: array();
      $url = '';
      $id = '';
      $key = '';
      $secret = '';
  
      foreach ($options as $option) {
        $url = $option['url'];
        $id = $option['id'];
        $key = $option['key'];
        $secret = $option['secret'];
      }

      if ( isset($_POST["edit_post"]) ) {
        if ( isset($_POST['apitools_nonce']) ) {
          $apiToolsNonce = sanitize_text_field( wp_unslash($_POST['apitools_nonce']) );
          if ( !wp_verify_nonce($apiToolsNonce, 'apitools_nonce_action') ) {
            die('Nonce verification failed');
          }
        }
        $editPostKey = sanitize_text_field( wp_unslash($_POST["edit_post"]) );
        $input = get_option( $optionName );
        $inputValue = $input[$editPostKey][$name];
        $this->getId = $input[$editPostKey]['url'];
      }
      else {
        if ($name === 'url') {
          $this->setId = $url;
          $trimmedUrl = str_replace('https://', '', $url);
          $trimmedUrl = strtok($trimmedUrl, '/');
          $inputValue = $trimmedUrl;
        } elseif ($name === 'id') { 
          $inputValue = $id;
        } elseif ($name === 'key') {
          $inputValue = $key;
        } elseif ($name === 'secret') {
          $inputValue = $secret;
        }
      }

      echo '<div class="api-input-form">';
      echo ' <label for="' . esc_html($label) . '">' . esc_html($label) . '</label><input type="text" id="' . esc_html($name) . '" name="' . esc_html($optionName) . '[' . esc_html($name) . ']" value="' . esc_html($inputValue) . '" placeholder="' . esc_html($placeholder) . '" required>
      </div>';
    }
   
  }

  public function responseJson( $args ) {

    $optionName = $args['option_name'];
    $options = get_option( $optionName );

    foreach ($options as &$option) {
      if (isset($option['url']) && $option['url'] === $this->setId && isset($option['data'])) {
        echo '<section><div class="">';
        echo '<pre class="prettyprint scroll pretty sendapi">';
        echo wp_json_encode($option['data'], JSON_PRETTY_PRINT);
        echo '</pre>';
        echo '</div></section>';
      }
    }

  }

}