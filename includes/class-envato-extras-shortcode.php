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

    echo '<div class="envato-extra-container clearfix">';
    echo '<header class="section-header">';
    echo '<h2 class="section-title">';
    echo sanitize_title( $atts['header'] );
    echo '</h2>';
    echo '</header>';

    // Start looping over the query results.
    while ( $query->have_posts() ) {

      $query->the_post();

      echo '<div class="envato-extra">'; ?>

        <?php
          if ( has_post_thumbnail() ){
            $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'small'); ?>
            <div class="post-image" style="background-image: url('<?php echo esc_url( $image[0] ) ?>'); height: 200px;"></div>
        <?php } ?>

        <header class="entry-title">
          <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php the_title(); ?>
          </a>
        </header>

        <div class="entry-summary">
          <?php the_content(); ?>
        </div>

    <?php echo '</div>'; ?>

    <?php }

    }

    // Restore original post data.
    wp_reset_postdata();

    echo '</div>';

  }

}
