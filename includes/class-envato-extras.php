<?php
/**
 * Envato Extras
 *
 * @package   Envato_Extras
 * @license   GPL-2.0+
 */

 // Exit if accessed directly.
 if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registration of CPT and related taxonomies.
 *
 * @since 0.1.0
 */
class Envato_Extras {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	const VERSION = EE_VERSION;

	/**
	 * Unique identifier for the plugin.
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	const PLUGIN_SLUG = EE_SLUG;

	protected $registration_handler;

	/**
	 * Initialize the plugin by setting localization and new site activation hooks.
	 *
	 * @since 0.1.0
	 */
	public function __construct( $registration_handler ) {

		$this->registration_handler = $registration_handler;

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );;

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since 0.1.0
	 */
	public function activate() {
		$this->registration_handler->register();
		flush_rewrite_rules();
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since 0.1.0
	 */
	public function deactivate() {
		flush_rewrite_rules();
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 0.1.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( self::PLUGIN_SLUG, FALSE, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages' );
	}

}
