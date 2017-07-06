<?php
/**
 * Envato Extras
 *
 * @package   Envato_Extras
 * @license   GPL-2.0+
 */

/**
 * Register metaboxes.
 *
 * @package Envato_Extras
 */
class Envato_Extras_Metaboxes {

	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'extras_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ),  10, 2 );
	}

	/**
	 * Register the metaboxes to be used for the extras post type
	 *
	 * @since 0.1.0
	 */
	public function extras_meta_boxes() {
		add_meta_box(
			'extras_fields',
			'Envato Extra\'s Fields',
			array( $this, 'render_meta_boxes' ),
			'envato-extras',
			'normal',
			'high'
		);
	}

   /**
	* The HTML for the fields
	*
	* @since 0.1.0
	*/
	function render_meta_boxes( $post ) {

		$meta = get_post_custom( $post->ID );
		$project_creator = ! isset( $meta['project_creator'][0] ) ? '' : $meta['project_creator'][0];
		$project_url = ! isset( $meta['project_url'][0] ) ? '' : $meta['project_url'][0];
		$envato_profile = ! isset( $meta['envato_profile'][0] ) ? '' : $meta['envato_profile'][0];
		$twitter_url = ! isset( $meta['project_twitter'][0] ) ? '' : $meta['project_twitter'][0];

		wp_nonce_field( basename( __FILE__ ), 'extras_fields' ); ?>

		<table class="form-table">

			<tr>
				<td class="extras_meta_box_td" colspan="2">
					<label for="project_creator"><?php _e( 'Project Creator', 'envato-extras' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="project_creator" class="regular-text" value="<?php echo esc_attr( $project_creator); ?>" placeholder="Enter name">
				</td>
			</tr>

			<tr>
				<td class="extras_meta_box_td" colspan="2">
					<label for="project_url" ><?php _e( 'Project Link', 'envato-extras' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="project_url" class="regular-text"  placeholder="https://awesome-envato-project.com" value="<?php echo esc_attr( $project_url ); ?>">
				</td>
			</tr>

			<tr>
				<td class="extras_meta_box_td" colspan="2">
					<label for="envato_profile"><?php _e( 'Envato Profile Link', 'envato-extras' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="envato_profile" class="regular-text" placeholder="https://codecanyon.net/user/USERNAME" value="<?php echo esc_attr( $envato_profile ); ?>">
				</td>
			</tr>

			<tr>
				<td class="extras_meta_box_td" colspan="2">
					<label for="project_twitter"><?php _e( 'Twitter Link', 'envato-extras' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="project_twitter" class="regular-text" placeholder="https://twitter.com/envato" value="<?php echo esc_attr( $twitter_url ); ?>">
				</td>
			</tr>

		</table>

	<?php }

   /**
	* Save metaboxes
	*
	* @since 0.1.0
	*/
	function save_meta_boxes( $post_id ) {

		global $post;

		// Verify nonce
		if ( !isset( $_POST['extras_fields'] ) || !wp_verify_nonce( $_POST['extras_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}

		// Check Autosave
		if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) {
			return $post_id;
		}

		// Don't save if only a revision
		if ( isset( $post->post_type ) && $post->post_type == 'revision' ) {
			return $post_id;
		}

		// Check permissions
		if ( !current_user_can( 'edit_post', $post->ID ) ) {
			return $post_id;
		}

		$meta['project_creator'] = ( isset( $_POST['project_creator'] ) ? esc_textarea( $_POST['project_creator'] ) : '' );

		$meta['project_url'] = ( isset( $_POST['project_url'] ) ? esc_url( $_POST['project_url'] ) : '' );

		$meta['envato_profile'] = ( isset( $_POST['envato_profile'] ) ? esc_url( $_POST['envato_profile'] ) : '' );

		$meta['project_twitter'] = ( isset( $_POST['project_twitter'] ) ? esc_url( $_POST['project_twitter'] ) : '' );

		foreach ( $meta as $key => $value ) {
			update_post_meta( $post->ID, $key, $value );
		}
	}

}
