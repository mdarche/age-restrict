<?php
/*
Plugin Name: Age Restrict
Plugin URI: https://agerestrictplugin.com/
Description: Just another age restriction popup. Simple but flexible.
Author: Mike Darche
Author URI: https://mikedarche.com/
Text Domain: age-restrict
Domain Path: /
Version: 1.0.0
*/

define( 'AR_VERSION', '1.0.0' );

define( 'AR_REQUIRED_WP_VERSION', '4.7' );

define( 'AR_PLUGIN', __FILE__ );

define( 'AR_PLUGIN_BASENAME', plugin_basename( AR_PLUGIN ) );

define( 'AR_PLUGIN_NAME', trim( dirname( AR_PLUGIN_BASENAME ), '/' ) );

define( 'AR_PLUGIN_DIR', untrailingslashit( dirname( AR_PLUGIN ) ) );

if ( is_admin() ) {
	require_once AR_PLUGIN_DIR . '/admin/admin.php';
}

add_action('wp_enqueue_scripts', 'ar_enqueue_scripts');
function ar_enqueue_scripts() {
  if( !isset($_COOKIE['age-restrict']) ) {
    if ( !is_user_logged_in() ) {
      wp_enqueue_style( 'age-restrict', plugins_url( 'includes/css/style.css', __FILE__ ) );
      wp_enqueue_script( 'age-restrict-cookie', plugins_url( 'includes/js/cookie.js', __FILE__ ), array( 'jquery' ), false, true );
      wp_enqueue_script( 'age-restrict', plugins_url( 'includes/js/scripts.js', __FILE__ ), array( 'jquery', 'age-restrict-cookie' ), false, true );
    }
  }
}

add_action( 'get_header','age_restrict_init');
  function age_restrict_init() {

    if(!isset($_COOKIE['age-restrict']) && !is_user_logged_in() && !is_admin() ) {
      add_filter( 'body_class', 'add_body_class' );
      function add_body_class( $classes ) {
        $classes[] = 'age-restrict';
        return $classes;
      }

      $options = get_option( 'ar_settings' );

      ?>

      <div class="ar-overlay">
        <div class="ar-container">
          <img src="<?php echo $options['ar_image_field']; ?>" />
          <h3>Age Verification</h3>
          <p><?php echo $options['ar_warning_field']; ?></p>
          <div class="age-button-wrap">
            <a href="#" id="age-yes">Yes</a>
            <a href="#" id="age-no">No</a>
          </div>
        </div>
      </div>

      <?php
  } else {

  }
}
