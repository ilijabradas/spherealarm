<?php
/*
Plugin Name: Sphere Return
Plugin URI: https://www.spherealarm.com/
Description: Save Shpere Return in DB
Author: Ilija Bradas
Author URI: https://www.linkedin.com/in/ilijabradas/
Text Domain: sphere-return
Version: 1.0.0
*/

define( 'WPSRET_VERSION', '1.0.0' );

define( 'WPSRET_REQUIRED_WP_VERSION', '4.8' );

define( 'WPSRET_PLUGIN', __FILE__ );

define( 'WPSRET_PLUGIN_BASENAME', plugin_basename( WPSRET_PLUGIN ) );

define( 'WPSRET_PLUGIN_NAME', trim( dirname( WPSRET_PLUGIN_BASENAME ), '/' ) );

define( 'WPSRET_PLUGIN_DIR', untrailingslashit( dirname( WPSRET_PLUGIN ) ) );

define( 'WPSRET_PLUGIN_MODULES_DIR', WPSRET_PLUGIN_DIR . '/modules' );


require_once WPSRET_PLUGIN_DIR . '/settings.php';
