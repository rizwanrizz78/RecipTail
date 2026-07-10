<?php
/**
 * Recipe Magazine Meta Boxes
 * Includes Featured Status and Recipe Data fields
 */

/**
 * Add Meta Boxes
 */
function recipe_magazine_add_meta_boxes() {
	// Featured Checkbox
	add_meta_box(
		'recipe_featured_meta_box',
		__( 'Featured Recipe', 'recipe-magazine' ),
		'recipe_magazine_featured_meta_box_html',
		'post',
		'side',
		'high'
	);

	// Recipe Data
	add_meta_box(
		'recipe_data_meta_box',
		__( 'Recipe Data', 'recipe-magazine' ),
		'recipe_magazine_data_meta_box_html',
		'post',
		'normal',
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
			<?php _e( 'Mark as Featured Recipe', 'recipe-magazine' ); ?>
		</label>
	</p>
	<p class="description"><?php _e( 'Featured recipes appear prominently on the homepage.', 'recipe-magazine' ); ?></p>
	<?php
}

/**
 * Recipe Data Meta Box HTML
 */
function recipe_magazine_data_meta_box_html( $post ) {
	wp_nonce_field( 'recipe_data_nonce', 'recipe_data_nonce_field' );

	$prep_time    = get_post_meta( $post->ID, '_recipe_prep_time', true );
	$cook_time    = get_post_meta( $post->ID, '_recipe_cook_time', true );
	$total_time   = get_post_meta( $post->ID, '_recipe_total_time', true );
	$servings     = get_post_meta( $post->ID, '_recipe_servings', true );
	$calories     = get_post_meta( $post->ID, '_recipe_calories', true );
	$ingredients  = get_post_meta( $post->ID, '_recipe_ingredients', true );
	$instructions = get_post_meta( $post->ID, '_recipe_instructions', true );

	if ( ! is_array( $ingredients ) ) {
		$ingredients = array( '' );
	}
	if ( ! is_array( $instructions ) ) {
		$instructions = array( '' );
	}
	?>
	<style>
		.recipe-meta-row { margin-bottom: 15px; }
		.recipe-meta-row label { display: block; font-weight: bold; margin-bottom: 5px; }
		.recipe-meta-row input[type="text"] { width: 100%; max-width: 400px; }
		.recipe-repeater { margin-bottom: 20px; border: 1px solid #ccc; padding: 15px; background: #f9f9f9; }
		.recipe-repeater-item { display: flex; align-items: center; margin-bottom: 10px; }
		.recipe-repeater-item input, .recipe-repeater-item textarea { flex-grow: 1; margin-right: 10px; }
		.recipe-repeater-item textarea { min-height: 60px; }
		.remove-repeater-item { color: #d63638; cursor: pointer; text-decoration: none; }
		.add-repeater-item { display: inline-block; margin-top: 10px; }
	</style>

	<p class="description">Fill in these fields to automatically generate the recipe card and schema. Leave blank if this is just a standard blog post.</p>

	<div class="recipe-meta-row">
		<label for="recipe_prep_time"><?php _e( 'Prep Time (e.g., 15 mins)', 'recipe-magazine' ); ?></label>
		<input type="text" name="recipe_prep_time" id="recipe_prep_time" value="<?php echo esc_attr( $prep_time ); ?>" />
	</div>

	<div class="recipe-meta-row">
		<label for="recipe_cook_time"><?php _e( 'Cook Time (e.g., 45 mins)', 'recipe-magazine' ); ?></label>
		<input type="text" name="recipe_cook_time" id="recipe_cook_time" value="<?php echo esc_attr( $cook_time ); ?>" />
	</div>

	<div class="recipe-meta-row">
		<label for="recipe_total_time"><?php _e( 'Total Time (e.g., 1 hour)', 'recipe-magazine' ); ?></label>
		<input type="text" name="recipe_total_time" id="recipe_total_time" value="<?php echo esc_attr( $total_time ); ?>" />
	</div>

	<div class="recipe-meta-row">
		<label for="recipe_servings"><?php _e( 'Servings (e.g., 4)', 'recipe-magazine' ); ?></label>
		<input type="text" name="recipe_servings" id="recipe_servings" value="<?php echo esc_attr( $servings ); ?>" />
	</div>

	<div class="recipe-meta-row">
		<label for="recipe_calories"><?php _e( 'Calories (e.g., 350 kcal)', 'recipe-magazine' ); ?></label>
		<input type="text" name="recipe_calories" id="recipe_calories" value="<?php echo esc_attr( $calories ); ?>" />
	</div>

	<div class="recipe-repeater" id="ingredients-repeater">
		<label><?php _e( 'Ingredients', 'recipe-magazine' ); ?></label>
		<div class="repeater-list">
			<?php foreach ( $ingredients as $ingredient ) : ?>
				<div class="recipe-repeater-item">
					<input type="text" name="recipe_ingredients[]" value="<?php echo esc_attr( $ingredient ); ?>" placeholder="1 cup flour" />
					<a href="#" class="remove-repeater-item">&times; Remove</a>
				</div>
			<?php endforeach; ?>
		</div>
		<a href="#" class="button add-repeater-item" data-target="ingredients-repeater" data-name="recipe_ingredients[]">+ Add Ingredient</a>
	</div>

	<div class="recipe-repeater" id="instructions-repeater">
		<label><?php _e( 'Instructions', 'recipe-magazine' ); ?></label>
		<div class="repeater-list">
			<?php foreach ( $instructions as $instruction ) : ?>
				<div class="recipe-repeater-item">
					<textarea name="recipe_instructions[]" placeholder="Preheat the oven..."><?php echo esc_textarea( $instruction ); ?></textarea>
					<a href="#" class="remove-repeater-item">&times; Remove</a>
				</div>
			<?php endforeach; ?>
		</div>
		<a href="#" class="button add-repeater-item" data-target="instructions-repeater" data-name="recipe_instructions[]" data-type="textarea">+ Add Instruction</a>
	</div>

	<script>
		jQuery(document).ready(function($) {
			$('.add-repeater-item').on('click', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				var name = $(this).data('name');
				var type = $(this).data('type');
				var list = $('#' + target + ' .repeater-list');

				var inputHtml = type === 'textarea'
					? '<textarea name="' + name + '" placeholder=""></textarea>'
					: '<input type="text" name="' + name + '" value="" placeholder="" />';

				var newItem = $('<div class="recipe-repeater-item">' + inputHtml + '<a href="#" class="remove-repeater-item">&times; Remove</a></div>');
				list.append(newItem);
			});

			$(document).on('click', '.remove-repeater-item', function(e) {
				e.preventDefault();
				$(this).closest('.recipe-repeater-item').remove();
			});
		});
	</script>
	<?php
}

/**
 * Save Meta Box Data
 */
function recipe_magazine_save_meta_boxes( $post_id ) {
	// Check nonces
	if ( ! isset( $_POST['recipe_featured_nonce_field'] ) || ! wp_verify_nonce( $_POST['recipe_featured_nonce_field'], 'recipe_featured_nonce' ) ) {
		// Just continue, maybe it's not the right screen
	} else {
		$is_featured = isset( $_POST['recipe_is_featured'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_recipe_is_featured', $is_featured );
	}

	if ( ! isset( $_POST['recipe_data_nonce_field'] ) || ! wp_verify_nonce( $_POST['recipe_data_nonce_field'], 'recipe_data_nonce' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Save basic text fields
	$fields = array( 'recipe_prep_time', 'recipe_cook_time', 'recipe_total_time', 'recipe_servings', 'recipe_calories' );
	foreach ( $fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, '_' . $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	// Save repeatable fields
	if ( isset( $_POST['recipe_ingredients'] ) && is_array( $_POST['recipe_ingredients'] ) ) {
		$ingredients = array_map( 'sanitize_text_field', wp_unslash( $_POST['recipe_ingredients'] ) );
		// Filter out empty ones
		$ingredients = array_filter( $ingredients );
		update_post_meta( $post_id, '_recipe_ingredients', array_values( $ingredients ) );
	} else {
		delete_post_meta( $post_id, '_recipe_ingredients' );
	}

	if ( isset( $_POST['recipe_instructions'] ) && is_array( $_POST['recipe_instructions'] ) ) {
		$instructions = array_map( 'sanitize_textarea_field', wp_unslash( $_POST['recipe_instructions'] ) );
		$instructions = array_filter( $instructions );
		update_post_meta( $post_id, '_recipe_instructions', array_values( $instructions ) );
	} else {
		delete_post_meta( $post_id, '_recipe_instructions' );
	}
}
add_action( 'save_post', 'recipe_magazine_save_meta_boxes' );
