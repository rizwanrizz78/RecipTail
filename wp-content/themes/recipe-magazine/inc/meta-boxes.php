<?php
/**
 * Recipe Magazine Meta Boxes
 * Includes Featured Status.
 */

/**
 * Add Meta Boxes
 */
function recipe_magazine_add_meta_boxes() {
	// Featured Checkbox
	add_meta_box(
		'recipe_featured_meta_box',
		__( 'Featured Status', 'recipe-magazine' ),
		'recipe_magazine_featured_meta_box_html',
		'post',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'recipe_magazine_add_meta_boxes' );

/**
 * Featured Meta Box HTML
 */
function recipe_magazine_featured_meta_box_html( $post ) {
	$is_featured = get_post_meta( $post->ID, '_recipe_is_featured', true );
	wp_nonce_field( 'recipe_featured_nonce', 'recipe_featured_nonce_field' );
	?>
	<p>
		<label for="recipe_is_featured">
			<input type="checkbox" name="recipe_is_featured" id="recipe_is_featured" value="yes" <?php checked( $is_featured, 'yes' ); ?> />
			<?php _e( 'Mark as Featured Article', 'recipe-magazine' ); ?>
		</label>
	</p>
	<p class="description"><?php _e( 'Featured articles appear prominently on the homepage.', 'recipe-magazine' ); ?></p>
	<?php
}

/**
 * Save Meta Box Data
 */
function recipe_magazine_save_meta_boxes( $post_id ) {
	// Check nonces
	if ( isset( $_POST['recipe_featured_nonce_field'] ) && wp_verify_nonce( $_POST['recipe_featured_nonce_field'], 'recipe_featured_nonce' ) ) {
		$is_featured = isset( $_POST['recipe_is_featured'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_recipe_is_featured', $is_featured );
	}
}
add_action( 'save_post', 'recipe_magazine_save_meta_boxes' );
