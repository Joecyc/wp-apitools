<div class="wrap">

  <h1>API Tools for WooCommerce</h1>
  <br>
  <?php if ( ! defined( 'ABSPATH' ) ) exit; settings_errors(); ?>

  <div class="tab-content">
    <div>
      <form method="post" action="options.php">
        <div class="container">
          <?php
            do_settings_sections( 'apitools_input_fields' );
            settings_fields( 'apitools_wc_settings' );
          ?>
          <input type="submit" name="submit" id="submit" class="btn btn--outline" value="Send">
          <hr><br>
        </div>
      </form>

      <div class ="container">
        <?php 
          do_settings_sections( 'apitools_response_json');
        ?>
      </div>
    </div>
  </div>

</div>