<?php
/**
 * Envata Extras
 *
 * @package   Envato_Extras
 * @license   GPL-2.0+
 */

 // Exit if accessed directly.
 if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Envato_Extras
 */
class Envato_Extras_Public {

  /**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since 0.1.0
	 *
	 * @var string VERSION Plugin version.
	 */
	const VERSION = EE_VERSION;

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	const PLUGIN_SLUG = EE_SLUG;

  public function init() {
    add_action( 'wp_enqueue_scripts', array( $this, 'envato_extras_scripts' ) );
    add_filter( 'the_content', array( $this, 'single_post_content' ), 1 );
    add_filter( 'the_content', array( $this, 'page_content' ), 1 );
	}

  public function envato_extras_scripts() {
  	wp_register_style( self::PLUGIN_SLUG, plugin_dir_url( __DIR__ ) . 'css/style.css', array(), self::VERSION, 'all'  );
  }

  /**
   * Adds target=_self to all links on the pages named 'envato-market-extras'
   * and removes the "New Page Link" plugin filter.
   *
   * This was added specifically for the envato.com site because of a plugin
   * conflict.
   *
   * @since 0.1.3
   */
  public function page_content( $content ){

    global $post;

    if( is_page( 'envato-market-extras' ) ){
      remove_filter( 'the_content', 'npl_autoblank' );
      $content = str_replace('<a', '<a target="_self"', $content);
    }

    return $content;

  }

  /**
   * Add the custom post's meta to the single page content
   *
   * @since 0.1.0
   */
  public function single_post_content( $content ) {

    global $post;

    if ( $post->post_type == 'envato-extras' && is_single() ) {

      wp_enqueue_style( 'envato-extras' );

      $meta = get_post_meta( get_the_ID() );

      if( $meta['envato_profile'][0] ){
        $content .= '<p><i>Created by <a href="' . $meta['envato_profile'][0] . '">' . $meta['project_creator'][0] . '</a></i></p>';
      } else {
        $content .= '<p><i>Created by ' . $meta['project_creator'][0] . '</i></p>';
      }
      $content .= '<p><a target="_blank" href="' . $meta['project_url'][0] . '"><button class="envato-button">Go to Project &rarr;</button></a></p>';
    }

    return $content;

  }

}
