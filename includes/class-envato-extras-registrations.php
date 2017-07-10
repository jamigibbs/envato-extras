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
 * Register post types and taxonomies.
 *
 * @package Envato_Extras
 */
class Envato_Extras_Registrations {

	public $post_type = 'envato-extras';

	public $taxonomies = array( 'extras-category' );

	public function init() {
		// Add the envato extras post type and taxonomies
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Initiate registrations of post type and taxonomies.
	 *
	 * @uses Envato_Extras_Registrations::register_post_type()
	 * @uses Envato_Extras_Registrations::register_taxonomy_category()
	 */
	public function register() {
		$this->register_post_type();
		$this->register_taxonomy_category();
	}

	/**
	 * Register the custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	protected function register_post_type() {
		$labels = array(
			'name'               => __( 'Envato Extras', 'envato-extras' ),
			'singular_name'      => __( 'Extra', 'envato-extras' ),
			'add_new'            => __( 'Add New', 'envato-extras' ),
			'add_new_item'       => __( 'Add New Envato Extra', 'envato-extras' ),
			'edit_item'          => __( 'Edit Extra', 'envato-extras' ),
			'new_item'           => __( 'New Extra', 'envato-extras' ),
			'view_item'          => __( 'View Extra', 'envato-extras' ),
			'search_items'       => __( 'Search Extras', 'envato-extras' ),
			'not_found'          => __( 'No Extras found', 'envato-extras' ),
			'not_found_in_trash' => __( 'No Extras in the trash', 'envato-extras' ),
		);

		$supports = array(
			'title',
			'editor',
			'thumbnail',
			'revisions',
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'envato-market-extras', ), // Permalinks format
			'menu_position'   => 100,
			'menu_icon'       => 'dashicons-tech-envato',
		);

		$args = apply_filters( 'extras_post_type_args', $args );

		register_post_type( $this->post_type, $args );
	}

		/**
		 * Register a taxonomy for Extras Categories.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
		 */
		protected function register_taxonomy_category() {
			$labels = array(
				'name'                       => __( 'Extras Categories', 'envato-extras' ),
				'singular_name'              => __( 'Extras Category', 'envato-extras' ),
				'menu_name'                  => __( 'Extras Categories', 'envato-extras' ),
				'edit_item'                  => __( 'Edit Extras Category', 'envato-extras' ),
				'update_item'                => __( 'Update Extras Category', 'envato-extras' ),
				'add_new_item'               => __( 'Add New Extras Category', 'envato-extras' ),
				'new_item_name'              => __( 'New Extras Category Name', 'envato-extras' ),
				'parent_item'                => __( 'Parent Extras Category', 'envato-extras' ),
				'parent_item_colon'          => __( 'Parent Extras Category:', 'envato-extras' ),
				'all_items'                  => __( 'All Extras Categories', 'envato-extras' ),
				'search_items'               => __( 'Search Extras Categories', 'envato-extras' ),
				'popular_items'              => __( 'Popular Extras Categories', 'envato-extras' ),
				'separate_items_with_commas' => __( 'Separate extras categories with commas', 'envato-extras' ),
				'add_or_remove_items'        => __( 'Add or remove extras categories', 'envato-extras' ),
				'choose_from_most_used'      => __( 'Choose from the most used extras categories', 'envato-extras' ),
				'not_found'                  => __( 'No extras categories found.', 'envato-extras' ),
			);

			$args = array(
				'labels'            => $labels,
				'public'            => true,
				'show_in_nav_menus' => true,
				'show_ui'           => true,
				'show_tagcloud'     => true,
				'hierarchical'      => true,
				'rewrite'           => array( 'slug' => 'extras-category' ),
				'show_admin_column' => true,
				'query_var'         => true,
			);

			$args = apply_filters( 'envato_extras_post_type_category_args', $args );

			register_taxonomy( $this->taxonomies[0], $this->post_type, $args );
		}
	}
