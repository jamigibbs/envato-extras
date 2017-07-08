<?php
/**
 * Envata Extras
 *
 * @package   Envato_Extras
 * @license   GPL-2.0+
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Envato_Extras
 */
class Envato_Extras_Public {

  public function init() {
		add_filter( 'the_content', array( $this, 'single_post_content' ), 1 );
	}

  public function single_post_content( $content ) {

    global $post;

    if ( $post->post_type == 'envato-extras' && is_single() ) {

      $meta = get_post_meta( get_the_ID() );

      if( $meta['envato_profile'][0] ){
        $content .= '<p><i>Created by <a href="' . $meta['envato_profile'][0] . '">' . $meta['project_creator'][0] . '</a></i></p>';
      } else {
        $content .= '<p><i>Created by ' . $meta['project_creator'][0] . '</i></p>';
      }
      $content .= '<p><a href="' . $meta['project_url'][0] . '"><button class="envato-button">Go to Project &rarr;</button></a></p>';
    }

    return $content;

  }

}

// Initialize
$envato_extras_public = new Envato_Extras_Public;
$envato_extras_public->init();
