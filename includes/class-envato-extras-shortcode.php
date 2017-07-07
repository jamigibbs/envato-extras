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
    ), $atts, 'envato_extras' );

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
    echo '<header class="section-header">';
    echo '<h2 class="section-title">';
    echo sanitize_text_field( $atts['header'] );
    echo '</h2>';
    echo '</header>';
    echo '<div class="display-wrap">';

    // Start looping over the query results.
    while ( $query->have_posts() ) {

      $query->the_post();

      echo '<div class="envato-extra">'; ?>

        <?php
          if ( has_post_thumbnail() ){
            $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'small'); ?>
            <div class="post-image" style="background-image: url('<?php echo esc_url( $image[0] ) ?>')"></div>
        <?php } ?>

        <header class="entry-title">

          <?php if( get_post_meta( $post->ID, 'project_url', true ) ) {
            $project_url = get_post_meta( $post->ID, 'project_url', true ); ?>
            <a href="<?php echo esc_url( $project_url ) ?>" title="<?php the_title_attribute(); ?>">
              <?php the_title(); ?>
            </a>
          <?php } ?>

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
              echo '<li class="social twitter"><a href="https://twitter.com/' . esc_attr( $twitter_username ) . ' "> <img src="'. plugins_url( 'img/twitter.svg', dirname(__FILE__) ) .'" alt="Twitter"></a></li>';
            } ?>

            <?php if ( get_post_meta( $post->ID, 'envato_profile', true ) ) {
              $envato_profile = get_post_meta( $post->ID, 'envato_profile', true );
              echo '<li class="social envato"><a href=" ' . esc_url( $envato_profile ) . ' "> <img src="'. plugins_url( 'img/envato.svg', dirname(__FILE__) ) .'" alt="Envato"> </a></li>';
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
