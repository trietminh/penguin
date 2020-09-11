<?php

namespace Penguin;

use Penguin\Crons\MovieCron;
use Penguin\PostTypes\Movie;
use Penguin\Users\Viewer;

class Main {

	static $settings;

	private function __construct() {
	}

	private function __clone() {
	}

	private function __wakeup() {
	}

	public static function install_actions() {
		// load libs
		spl_autoload_register( 'Penguin\Main::autoload_class' );

		// activation hook
		register_activation_hook( PENGUIN_FCPATH, 'Penguin\Main::install_plugin' );
		register_deactivation_hook( PENGUIN_FCPATH, 'Penguin\Main::uninstall_plugin' );

		// add actions
		add_action( 'init', 'Penguin\Main::init', 10 );
		add_action( 'plugins_loaded', 'Penguin\Main::plugins_loaded' );

		// add cron
		add_action( 'penguin_cron', 'Penguin\Main::add_cron' );
		if ( ! wp_next_scheduled( 'penguin_cron' ) ) {
			wp_schedule_event( time(), 'daily', 'penguin_cron' );
		}
	}

	public static function add_cron() {
		MovieCron::penguin_sendmail_cron();
	}

	public static function install_plugin() {
		if ( ! is_blog_installed() ) {
			return;
		}

		Viewer::register_role();
	}

	public static function uninstall_plugin() {
		wp_clear_scheduled_hook( 'penguin_cron' );
	}

	public static function init() {
		// Initial functions here
		do_action( 'penguin_init' );

		// Add custom post type
		new Movie();
		new MovieCron();
	}

	public static function plugins_loaded() {
		// set settings
		self::$settings = array(
			'slug'            => basename( dirname( __FILE__ ) ),
			'plugin_path'     => PENGUIN_PATH,
			'plugin_fcpath'   => PENGUIN_FCPATH,
			'plugin_basename' => PENGUIN_BASENAME
		);
	}

	public static function autoload_class( $class_name ) {
		// project-specific namespace prefix
		$prefix = 'Penguin\\';

		// does the class use the namespace prefix?
		$len = strlen( $prefix );
		if ( strncmp( $prefix, $class_name, $len ) !== 0 ) {
			return;
		}

		$relative_class = substr( $class_name, $len );

		$file = PENGUIN_PATH . str_replace( '\\', DIRECTORY_SEPARATOR, $relative_class ) . '.php';

		// if the file exists, require it
		if ( file_exists( $file ) ) {
			require $file;
		}
	}

}   // endclass