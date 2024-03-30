<?php
/**
 * Plugin Name: Phox Hosting
 * Plugin URI: https://whmcsdes.com/
 * Description: Phox Hosting Plugin - to get the full Features of the Theme.
 * Version: 1.7.1
 * Author: whmcsdes
 * Author URI: https://whmcsdes.com/
 *
 * Text Domain: phox-host
 * Domain Path: /languages
 *
 * @package PhoxHost
 * @category Core

 * Phox Hosting is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.

 * Phox Hosting is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

if ( !defined('ABSPATH') ) {
	exit; //Exit if assessed directly
}


//Define the Version
define( 'Phox_HOST_VERSION', '1.7.1' );

//define the Paths
define( 'Phox_HOST__FILE__', __FILE__ );
define( 'Phox_HOST_PLUGIN_BASE', plugin_basename(Phox_HOST__FILE__ ) );
define( 'Phox_HOST_PATH', plugin_dir_path( Phox_HOST__FILE__ ) );
define( 'Phox_HOST_URI', plugin_dir_url( __FILE__ ) );


/**
 * Load Phox Host textdomain
 *
 * Load get text translate for Phox Host text domain
 *
 * @since 1.0.0
 *
 * @return void
 */
function phox_host_load_plugin_textdomain(){

	load_plugin_textdomain('phox-host', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

}

add_action('init', 'phox_host_load_plugin_textdomain', -999 );


/**
 * Phox Host admin notice for use Phox theme
 *
 * warning when the site doesn't have run Phox theme
 *
 * @since 1.0
 * @deprecated since version 1.5.4
 * @return void
 */
function phox_host_fail_phox_theme(){

	$message = esc_html__('This plugin required to run on Phox Theme, Please install it.', 'phox-host');
	$html_message = sprintf('<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );

}

/**
 * Phox_Host admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 *
 * @since 1.6.0
 *
 * @return void
 */
function phox_host_fail_php_version() {
	/* translators: %s: PHP version */
	$message = sprintf( esc_html__( 'Phox-Host plugin requires PHP version %s+, plugin is currently NOT RUNNING.', 'phox-host' ), '7.2' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

/**
 * Phox_Host admin notice for minimum WordPress version.
 *
 * Warning when the site doesn't have the minimum required WordPress version.
 *
 * @since 1.6.0
 *
 * @return void
 */
function phox_host_fail_wp_version() {
	/* translators: %s: WordPress version */
	$message = sprintf( esc_html__( 'Phox-Host requires WordPress version %s+. Because you are using an earlier version, the plugin is currently NOT RUNNING.', 'phox-host' ), '5.2' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

/**
 * Phox_Host admin notice for intl PHP extension.
 *
 * Warning when the server doesn't support intl extension.
 *
 * @since 1.6.0
 *
 * @return void
 */
function phox_host_fail_intl_extension() {
	/* translators: %s: PHP version */
	$message = sprintf( esc_html__( 'Phox-Host plugin requires install %s extension, You must contact your service provider in order to install this extension.', 'phox-host' ), 'intl' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

/**
 * Phox_Host admin notice for Phox Theme not active.
 *
 * Warning when Phox theme not active.
 *
 * @since 1.6.6
 *
 * @return void
 */
function phox_host_fail_phox_active() {
	/* translators: %s: PHP version */
	$message = sprintf( esc_html__( 'Phox-Host plugin requires active Phox Theme because plugin can\'t run without it.', 'phox-host' ), 'intl' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

/**
 * Phox_Host admin notice for icu version compatibility.
 *
 * Warning when icu version under version 4.6.
 *
 * @since 1.6.2
 *
 * @return void
 */
function phox_host_icu_version_compatibility(){
	$message = sprintf( esc_html__( ' The domain search element will not work because it required Version 4.6 or higher for ICU, you need to contact your host provider, your ICU version now is %s', 'phox-host' ), INTL_ICU_VERSION );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

/**
 * Fire Plugin
 *
 * load all plugin files after check requirement
 *
 * @since 1.6.6
 * @return string
 */
function phox_host_fire_plugin() {
	if ( ! version_compare( PHP_VERSION, '7.2', '>=' ) ) {

		add_action( 'admin_notices', 'phox_host_fail_php_version' );

	} elseif ( ! version_compare( get_bloginfo( 'version' ), '5.1', '>=' ) ) {

		add_action( 'admin_notices', 'phox_host_fail_wp_version' );

	} elseif ( ! extension_loaded( 'intl' ) ) {

		add_action( 'admin_notices', 'phox_host_fail_intl_extension' );

	} elseif ( ! defined('WDES_THEME_VERSION') ){

		add_action( 'admin_notices', 'phox_host_fail_phox_active' );

	}else {

		require Phox_HOST_PATH . 'includes/plugin.php';

		if ( ! defined( 'INTL_ICU_VERSION' ) && ! version_compare( INTL_ICU_VERSION, '4.6', '>=' ) ) {
			add_action( 'admin_notices', 'phox_host_icu_version_compatibility' );
		}
	}
}

add_action('after_setup_theme', 'phox_host_fire_plugin');



/**
 * Stop auto update
 *
 * It will block wordpress to try auto update the plugin
 *
 * @since 1.5.7
 * @return string
 */
function phox_host_auto_update_setting_html( $html, $plugin_file, $plugin_data ) {
	if ( 'phox-host/phox-host.php' === $plugin_file ) {
		$html = __( 'Auto-updates are not available for this plugin.', 'phox-host' );
	}

	return $html;
}
add_filter( 'plugin_auto_update_setting_html', 'phox_host_auto_update_setting_html', 10, 3 );



