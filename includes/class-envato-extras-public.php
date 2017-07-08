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

    if ($post->post_type == 'envato-extras') {

      $meta = get_post_meta( get_the_ID() );

      $content .= '<p>' . $meta['project_creator'][0] . '</p>';
      $content .= '<p>' . $meta['project_url'][0] . '</p>';
      $content .= '<p>' . $meta['envato_profile'][0] . '</p>';
      $content .= '<p>' . $meta['project_twitter'][0] . '</p>';
    }

    return $content;

  }

}

// Initialize
$envato_extras_public = new Envato_Extras_Public;
$envato_extras_public->init();
