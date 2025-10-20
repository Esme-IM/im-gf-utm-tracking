<?php 
/**
 * Plugin Name: Innermedia GF UTM Tracking
 * Plugin URI: https://www.innermedia.co.uk
 * Description: UTM tracking for Gravity Forms
 * Author: Innermedia
 * GitHub Plugin URI: https://github.com/Esme-IM/im-gf-utm-tracking
 * Primary Branch: main
 * Version: 1.0.6
 */

// Plugin Folder Path.
if ( ! defined( 'IM_TRACKING_PLUGIN_DIR' ) ) {
	define( 'IM_TRACKING_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Plugin Folder URL.
if ( ! defined( 'IM_TRACKING_PLUGIN_URL' ) ) {
	define( 'IM_TRACKING_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// Plugin Root File.
if ( ! defined( 'IM_TRACKING_PLUGIN_FILE' ) ) {
	define( 'IM_TRACKING_PLUGIN_FILE', __FILE__ );
}

include_once('inc/utm_fields.php');

?>