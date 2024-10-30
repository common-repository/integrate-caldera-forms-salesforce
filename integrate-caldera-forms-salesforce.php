<?php
/**
 * Plugin Name: Integration of Caldera Forms and Salesforce
 * Plugin URI:  https://zetamatic.com
 * Description: The integration of Caldera Forms and Salesforce plugin lets you add a new Salesforce Processor to Caldera form. It automatically syncs data from your Caldera form to your Salesforce CRM when the form is submitted.
 * Version:     1.0.4
 * Author:      ZetaMatic
 * Author URI:  https://zetamatic.com
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: integrate-caldera-forms-salesforce
 * Domain Path: /languages/
 * Tested up to: 5.7
 *
 * @package ICFS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'ICFS_PLUGIN_FILE' ) ) {
	define( 'ICFS_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'ICFS_ROOT' ) ) {
	define( 'ICFS_ROOT', dirname( plugin_basename( ICFS_PLUGIN_FILE ) ) );
}


// Define plugin version
define( 'ICFS_PLUGIN_VERSION', '1.0.4' );
define( 'WPCFSF_PLUGIN_PATH', dirname(__FILE__) );


if ( ! version_compare( PHP_VERSION, '5.6', '>=' ) ) {
	add_action( 'admin_notices', 'icfs_fail_php_version' );
} else {
	// Include the ICFS class.
	require_once dirname( __FILE__ ) . '/inc/class-icfs.php';
}


/**
 * Admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 *
 * @since 0.0.1
 *
 * @return void
 */
function icfs_fail_php_version() {

	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}

	/* translators: %s: PHP version */
	$message      = sprintf( esc_html__( 'Calder Forms Salesforce Integration requires PHP version %s+, plugin is currently NOT RUNNING.', 'integrate-caldera-forms-salesforce' ), '5.6' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

if(!function_exists('wpcfsf_activate')) {
  function wpcfsf_activate() {
    if(function_exists('icfs_fail_php_version_pro')) {
      require(WPCFSF_PLUGIN_PATH . "/inc/plugin-activation-error.php");
      exit;
    }
  }
  register_activation_hook( __FILE__, 'wpcfsf_activate' );
}

if(get_option("wpcfsf_disable_pro_notice") != "YES"){
	add_action( 'admin_notices', 'wpcfsf_download_pro_plugin' );
}
add_action( 'wp_ajax_wpcfsf_hide_pro_notice', 'wpcfsf_hide_pro_notice' );

define( 'WPCFSF_PLUGIN_NAME', 'Integration of Caldera Forms and Salesforce' );
function wpcfsf_download_pro_plugin() {
	$class = 'notice notice-warning is-dismissible wpcfsf-notice-buy-pro';
	$plugin_url = 'https://zetamatic.com/downloads/caldera-forms-salesforce-integration-pro/';
	$message = __( 'Glad to know that you are already using our '.WPCFSF_PLUGIN_NAME.'. Do you want send data from your Caldera form dynamically to SalesForce? Then please visit <a href="'.$plugin_url.'?utm_src='.WPCFSF_PLUGIN_NAME.'" target="_blank">here</a>.', 'integrate-caldera-forms-salesforce' );
	$dont_show = __( "Don't show this message again!", 'integrate-caldera-forms-salesforce' );
	printf( '<div class="%1$s"><p>%2$s</p><p><a href="javascript:void(0);" class="wpcfsf-hide-pro-notice">%3$s</a></p></div>
	<script type="text/javascript">
		(function () {
			jQuery(function () {
				jQuery("body").on("click", ".wpcfsf-hide-pro-notice", function () {
					jQuery(".wpcfsf-notice-buy-pro").hide();
					jQuery.ajax({
						"type": "post",
						"dataType": "json",
						"url": ajaxurl,
						"data": {
							"action": "wpcfsf_hide_pro_notice"
						},
						"success": function(response){
						}
					});
				});
			});
		})();
		</script>', esc_attr( $class ), $message, $dont_show );
}
function wpcfsf_hide_pro_notice() {
  update_option("wpcfsf_disable_pro_notice", "YES");
  echo json_encode(["status" => "success"]);
  wp_die();
}
