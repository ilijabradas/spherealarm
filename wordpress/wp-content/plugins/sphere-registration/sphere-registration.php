<?php
/*
Plugin Name: Sphere Registration
Plugin URI: https://www.spherealarm.com/
Description: Save Shpere Registration in DB
Author: Ilija Bradas
Author URI: https://www.linkedin.com/in/ilijabradas/
Text Domain: sphere-registration
Version: 1.0.0
*/

define( 'WPSR_VERSION', '1.0.0' );

define( 'WPSR_REQUIRED_WP_VERSION', '4.8' );

define( 'WPSR_PLUGIN', __FILE__ );

define( 'WPSR_PLUGIN_BASENAME', plugin_basename( WPSR_PLUGIN ) );

define( 'WPSR_PLUGIN_NAME', trim( dirname( WPSR_PLUGIN_BASENAME ), '/' ) );

define( 'WPSR_PLUGIN_DIR', untrailingslashit( dirname( WPSR_PLUGIN ) ) );

define( 'WPSR_PLUGIN_MODULES_DIR', WPSR_PLUGIN_DIR . '/modules' );


require_once WPSR_PLUGIN_DIR . '/settings.php';
