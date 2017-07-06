<?php
/**
 * Envato Extras
 *
 * @package   Envato_Extras
 * @license   GPL-2.0+
 */

/**
 * Register and Display the Shortcode.
 *
 * @package Envato_Extras
 */
class Envato_Extras_Shortcode {

  public function init() {
		add_shortcode( 'envato_extras', array( $this, 'extras_shortcode' ) );
	}

  public function extras_shortcode( $atts ) {

    global $wp_query, $post;

    $atts = shortcode_atts( array(
      'cat' => '',
      'header' => ''
    ), $atts );

    $args = array(
      'post_type'       => 'envato-extras',
      'order'           => 'ASC',
      'extras-category' => sanitize_title( $atts['cat'] )
    );

    // Custom query.
    $query = new WP_Query( $args );

    // Check that we have query results.
    if ( $query->have_posts() ) {

    echo '<h3>' . sanitize_title( $atts['header'] ) . '</h3>';
    echo '<ul class="category posts">';

    // Start looping over the query results.
    while ( $query->have_posts() ) {

      $query->the_post(); ?>

      <li <?php post_class( 'left' ); ?>>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
          <?php the_title(); ?>
        </a>
      </li>

    <?php }

      echo '</ul>';

    }

    // Restore original post data.
    wp_reset_postdata();

  }

}
