<?php
/*
Plugin Name: Penguin
Plugin URI: https://www.linkedin.com/in/minhtriet/
Description: Plugin for test purpose.
Author: Tim Nguyen
Version: 1.0
License: GPL v3
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PENGUIN_VERSION', '1.0' );
define( 'PENGUIN_BASENAME', function_exists( 'plugin_basename' ) ? plugin_basename( __FILE__ ) :
	basename( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . basename( __FILE__ ) );

global $wp_plugin_paths;
foreach ( $wp_plugin_paths as $dir => $realdir ) {
	if ( strpos( __FILE__, $realdir ) === 0 ) {
		define( 'PENGUIN_FCPATH', $dir . DIRECTORY_SEPARATOR . basename( __FILE__ ) );
		define( 'PENGUIN_PATH', rtrim( $dir, DIRECTORY_SEPARATOR ) . DIRECTORY_SEPARATOR );

		break;
	}
}
if ( ! defined( 'PENGUIN_FCPATH' ) ) {
	/** @noinspection PhpConstantReassignmentInspection */
	define( 'PENGUIN_FCPATH', __FILE__ );
	/** @noinspection PhpConstantReassignmentInspection */
	define( 'PENGUIN_PATH', rtrim( dirname( PENGUIN_FCPATH ), DIRECTORY_SEPARATOR ) . DIRECTORY_SEPARATOR );
}


require_once( 'Main.php' );
Penguin\Main::install_actions();