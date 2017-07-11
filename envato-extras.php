<?php
/**
 * Envato Extras
 *
 * @package   Envato_Extras
 * @license   GPL-2.0+
 *
 * Plugin Name: Envato Extras
 * Plugin URI:  https://github.com/jamigibbs/envato-extras
 * Description: Enables an Envato Extras custom post type and shortcode for displaying projects created using the Envato API.
 * Version:     0.1.0
 * Author:      Jami Gibbs
 * Author URI:  http://jamigibbs.com
 * Text Domain: envato-extras
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// Plugin version.
if ( !defined( 'EE_VERSION' ) ) {
	define( 'EE_VERSION', '0.1.0' );
}

// Plugin handle
if ( !defined( 'EE_SLUG' ) ) {
	define( 'EE_SLUG', 'envato-extras' );
}

// Required files for registering the post type, taxonomies, and shortcode.
require plugin_dir_path( __FILE__ ) . 'includes/class-envato-extras.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-envato-extras-registrations.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-envato-extras-metaboxes.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-envato-extras-shortcodes.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-envato-extras-public.php';

// Instantiate registration class, so we can add it as a dependency to main plugin class.
$envato_extras_registrations = new Envato_Extras_Registrations;

// Instantiate main plugin file, so activation callback does not need to be static.
$envato_extras = new Envato_Extras( $envato_extras_registrations );

// Register callback that is fired when the plugin is activated.
register_activation_hook( __FILE__, array( $envato_extras, 'activate' ) );

// Initialize registrations for post-activation requests.
$envato_extras_registrations->init();

// Initialize metaboxes
$envato_extras_metaboxes = new Envato_Extras_Metaboxes;
$envato_extras_metaboxes->init();

// Initialize shortcode
$envato_extras_shortcodes = new Envato_Extras_Shortcodes;
$envato_extras_shortcodes->init();

// Initialize public-facing functionality
$envato_extras_public = new Envato_Extras_Public;
$envato_extras_public->init();

/**
 * Adds styling to the dashboard for the post type and adds team posts
 * to the "At a Glance" metabox.
 */
if ( is_admin() ) {

	// Loads for users viewing the WordPress dashboard
	if ( ! class_exists( 'Envato_Extras_Dashboard_Glancer' ) ) {
		require plugin_dir_path( __FILE__ ) . 'includes/class-envato-extras-dashboard-glancer.php';  // WP 3.8
	}

	require plugin_dir_path( __FILE__ ) . 'includes/class-envato-extras-admin.php';

	$envato_extras_admin = new Envato_Extras_Admin( $envato_extras_registrations );
	$envato_extras_admin->init();

}
