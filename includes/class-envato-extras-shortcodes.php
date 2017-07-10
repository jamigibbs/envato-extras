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
 * Register and Display the Shortcode.
 *
 * @package Envato_Extras
 */
class Envato_Extras_Shortcodes {

  public function init() {
		add_shortcode( 'envato_extras_category', array( $this, 'envato_extras_category' ) );
	}

  public function envato_extras_category( $atts ) {

    $atts = shortcode_atts( array(
      'cat' => '',
      'header' => ''
    ), $atts, 'envato_extras_category' );

    ob_start();
    $this->shortcode_template( $atts );
    return ob_get_clean();
  }

  public function shortcode_template( $atts ){

    global $wp_query, $post;

    $args = array(
      'post_type'       => 'envato-extras',
      'order'           => 'ASC',
      'extras-category' => sanitize_text_field( $atts['cat'] )
    );

    // Custom query.
    $query = new WP_Query( $args );

    // Check that we have query results.
    if ( $query->have_posts() ) {

    echo '<div class="envato-extra-container clearfix">';
    echo '<header class="section-header" id="'. sanitize_text_field( $atts['cat'] ) .'">';
    echo '<h2 class="section-title">' . sanitize_text_field( $atts['header'] ) . '</h2>';
    echo '</header>';
    echo '<div class="display-wrap">';

    // Start looping over the query results.
    while ( $query->have_posts() ) {

      $query->the_post();

      echo '<div class="envato-extra">'; ?>

        <?php
          if ( has_post_thumbnail() ){
            $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'small');
          } else {
            $image = array( plugins_url( 'img/default.png', dirname(__FILE__) ) );
          } ?>

        <?php if( get_post_meta( $post->ID, 'project_url', true ) ) {
            $project_url = get_post_meta( $post->ID, 'project_url', true ); ?>

            <a href="<?php echo esc_url( $project_url ) ?>">
              <div class="post-image" style="background-image: url('<?php echo esc_url( $image[0] ) ?>')"></div>
            </a>

        <?php } else { ?>

          <div class="post-image" style="background-image: url('<?php echo esc_url( $image[0] ) ?>')"></div>

        <?php }?>

        <header class="entry-title">
          <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
            <?php the_title(); ?>
          </a>
        </header>

        <div class="entry-summary">
          <?php the_excerpt(); ?>
        </div>

        <div class="meta-fields">

          <ul>

            <?php if ( get_post_meta( $post->ID, 'project_creator', true ) && get_post_meta( $post->ID, 'envato_profile', true ) ) {

              $project_creator = get_post_meta( $post->ID, 'project_creator', true );
              $envato_profile = get_post_meta( $post->ID, 'envato_profile', true );

              echo '<li class="creator"><i>by </i><a href=" ' . esc_url( $envato_profile ) . ' ">' . esc_html( $project_creator ) . '</a></li>';

            } elseif ( get_post_meta( $post->ID, 'project_creator', true ) ) {

              $project_creator = get_post_meta( $post->ID, 'project_creator', true );
              echo '<li class="creator"><i>by </i>' . esc_html( $project_creator ) . '</li>';

            }?>

            <?php edit_post_link( __( 'edit', 'envato-extras' ), '<li>', '</li>' ); ?>

            <?php if ( get_post_meta( $post->ID, 'project_twitter', true ) ) {
              $twitter_username = get_post_meta( $post->ID, 'project_twitter', true );

              echo '<li class="social twitter"><a href="https://twitter.com/' . esc_attr( $twitter_username ) . ' "><div class="icon dashicons-tech-twitter"></div></a></li>';

            } ?>

          </ul>

        </div>

    <?php
      echo '</div>';
    ?>

    <?php }

    }

    // Restore original post data.
    wp_reset_postdata();

    echo '</div>';
    echo '</div>';

  }

}
