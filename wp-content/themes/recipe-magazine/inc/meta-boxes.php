<?php
/**
 * Recipe Magazine Meta Boxes
 * Includes Featured Status and Repeatable Recipe Blocks
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

	// Recipe Blocks (Repeatable)
	add_meta_box(
		'recipe_blocks_meta_box',
		__( 'Recipe Cards (Roundup)', 'recipe-magazine' ),
		'recipe_magazine_blocks_meta_box_html',
		'post',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'recipe_magazine_add_meta_boxes' );

/**
 * Enqueue Admin Scripts for Meta Boxes
 */
function recipe_magazine_admin_scripts( $hook ) {
	if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
		return;
	}
	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'recipe_magazine_admin_scripts' );

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
 * Recipe Blocks Meta Box HTML
 */
function recipe_magazine_blocks_meta_box_html( $post ) {
	wp_nonce_field( 'recipe_blocks_nonce', 'recipe_blocks_nonce_field' );

	$recipe_blocks = get_post_meta( $post->ID, '_recipe_blocks', true );
	if ( ! is_array( $recipe_blocks ) ) {
		$recipe_blocks = array(); // Start empty
	}
	?>
	<style>
		.recipe-blocks-wrapper { margin-bottom: 20px; }
		.recipe-block { border: 1px solid #ccc; background: #fff; padding: 20px; margin-bottom: 20px; border-radius: 4px; position: relative; }
		.recipe-block-header { font-weight: bold; font-size: 16px; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; display: flex; justify-content: space-between; align-items: center; }
		.remove-recipe-block { color: #d63638; text-decoration: none; font-size: 14px; font-weight: normal; cursor: pointer; }

		.recipe-field-row { margin-bottom: 15px; }
		.recipe-field-row label { display: block; font-weight: bold; margin-bottom: 5px; }
		.recipe-field-row input[type="text"], .recipe-field-row textarea { width: 100%; max-width: 600px; }
		.recipe-field-row textarea { min-height: 80px; }

		.recipe-meta-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; max-width: 600px; margin-bottom: 20px; }
		.recipe-meta-grid .recipe-field-row { margin-bottom: 0; }

		.recipe-list-repeater { border: 1px solid #ddd; padding: 15px; background: #f9f9f9; margin-bottom: 20px; }
		.recipe-list-item { display: flex; align-items: center; margin-bottom: 10px; }
		.recipe-list-item input, .recipe-list-item textarea { flex-grow: 1; margin-right: 10px; }
		.remove-list-item { color: #d63638; cursor: pointer; text-decoration: none; flex-shrink: 0; }

		.image-preview { max-width: 150px; height: auto; margin-top: 10px; display: block; }
	</style>

	<div id="recipe-blocks-container" class="recipe-blocks-wrapper">
		<?php
		$block_index = 0;
		foreach ( $recipe_blocks as $block ) {
			recipe_magazine_render_block_html( $block, $block_index );
			$block_index++;
		}
		?>
	</div>

	<a href="#" class="button button-primary" id="add-recipe-block">+ Add Recipe</a>

	<!-- Hidden Template for New Block -->
	<div id="recipe-block-template" style="display: none;">
		<?php recipe_magazine_render_block_html( array(), '__INDEX__' ); ?>
	</div>

	<script>
		jQuery(document).ready(function($) {
			var blockIndex = <?php echo $block_index; ?>;

			// Add New Recipe Block
			$('#add-recipe-block').on('click', function(e) {
				e.preventDefault();
				var template = $('#recipe-block-template').html();
				template = template.replace(/__INDEX__/g, blockIndex);
				$('#recipe-blocks-container').append(template);
				blockIndex++;
			});

			// Remove Recipe Block
			$(document).on('click', '.remove-recipe-block', function(e) {
				e.preventDefault();
				if ( confirm('Are you sure you want to remove this recipe card?') ) {
					$(this).closest('.recipe-block').remove();
				}
			});

			// Add Ingredient/Instruction Item
			$(document).on('click', '.add-list-item', function(e) {
				e.preventDefault();
				var targetClass = $(this).data('target');
				var nameAttr = $(this).data('name');
				var type = $(this).data('type');
				var listContainer = $(this).siblings('.repeater-list-items');

				var inputHtml = type === 'textarea'
					? '<textarea name="' + nameAttr + '" placeholder=""></textarea>'
					: '<input type="text" name="' + nameAttr + '" value="" placeholder="" />';

				var newItem = $('<div class="recipe-list-item">' + inputHtml + '<a href="#" class="remove-list-item">&times; Remove</a></div>');
				listContainer.append(newItem);
			});

			// Remove Ingredient/Instruction Item
			$(document).on('click', '.remove-list-item', function(e) {
				e.preventDefault();
				$(this).closest('.recipe-list-item').remove();
			});

			// Media Uploader
			$(document).on('click', '.upload-recipe-image', function(e) {
				e.preventDefault();
				var button = $(this);
				var blockId = button.data('block');
				var custom_uploader = wp.media({
					title: 'Select Recipe Image',
					button: { text: 'Use this image' },
					multiple: false
				}).on('select', function() {
					var attachment = custom_uploader.state().get('selection').first().toJSON();
					$('#recipe_image_' + blockId).val(attachment.url);
					$('#recipe_image_preview_' + blockId).attr('src', attachment.url).show();
				}).open();
			});

			$(document).on('click', '.remove-recipe-image', function(e) {
				e.preventDefault();
				var blockId = $(this).data('block');
				$('#recipe_image_' + blockId).val('');
				$('#recipe_image_preview_' + blockId).hide().attr('src', '');
			});
		});
	</script>
	<?php
}

/**
 * Helper to render a single recipe block HTML
 */
function recipe_magazine_render_block_html( $block, $index ) {
	$title        = isset( $block['title'] ) ? $block['title'] : '';
	$description  = isset( $block['description'] ) ? $block['description'] : '';
	$image        = isset( $block['image'] ) ? $block['image'] : '';
	$prep_time    = isset( $block['prep_time'] ) ? $block['prep_time'] : '';
	$cook_time    = isset( $block['cook_time'] ) ? $block['cook_time'] : '';
	$servings     = isset( $block['servings'] ) ? $block['servings'] : '';
	$calories     = isset( $block['calories'] ) ? $block['calories'] : '';
	$ingredients  = isset( $block['ingredients'] ) && is_array( $block['ingredients'] ) ? $block['ingredients'] : array('');
	$instructions = isset( $block['instructions'] ) && is_array( $block['instructions'] ) ? $block['instructions'] : array('');
	$tip          = isset( $block['tip'] ) ? $block['tip'] : '';

	$field_prefix = "recipe_blocks[{$index}]";
	?>
	<div class="recipe-block">
		<div class="recipe-block-header">
			<span>Recipe Card</span>
			<a href="#" class="remove-recipe-block">Delete Recipe</a>
		</div>

		<div class="recipe-field-row">
			<label>Recipe Title</label>
			<input type="text" name="<?php echo $field_prefix; ?>[title]" value="<?php echo esc_attr( $title ); ?>" />
		</div>

		<div class="recipe-field-row">
			<label>Short Description</label>
			<textarea name="<?php echo $field_prefix; ?>[description]"><?php echo esc_textarea( $description ); ?></textarea>
		</div>

		<div class="recipe-field-row">
			<label>Recipe Image</label>
			<div class="image-upload-wrapper">
				<input type="hidden" name="<?php echo $field_prefix; ?>[image]" id="recipe_image_<?php echo $index; ?>" value="<?php echo esc_url( $image ); ?>" />
				<a href="#" class="button upload-recipe-image" data-block="<?php echo $index; ?>">Choose Image</a>
				<a href="#" class="remove-recipe-image" data-block="<?php echo $index; ?>" style="margin-left: 10px; color: #d63638; text-decoration: none;">Remove</a>
				<img id="recipe_image_preview_<?php echo $index; ?>" src="<?php echo esc_url( $image ); ?>" class="image-preview" style="<?php echo empty( $image ) ? 'display:none;' : ''; ?>" />
			</div>
		</div>

		<div class="recipe-meta-grid">
			<div class="recipe-field-row">
				<label>Prep Time</label>
				<input type="text" name="<?php echo $field_prefix; ?>[prep_time]" value="<?php echo esc_attr( $prep_time ); ?>" placeholder="e.g. 15 mins" />
			</div>
			<div class="recipe-field-row">
				<label>Cook Time</label>
				<input type="text" name="<?php echo $field_prefix; ?>[cook_time]" value="<?php echo esc_attr( $cook_time ); ?>" placeholder="e.g. 10 mins" />
			</div>
			<div class="recipe-field-row">
				<label>Servings</label>
				<input type="text" name="<?php echo $field_prefix; ?>[servings]" value="<?php echo esc_attr( $servings ); ?>" placeholder="e.g. 4" />
			</div>
			<div class="recipe-field-row">
				<label>Calories (Optional)</label>
				<input type="text" name="<?php echo $field_prefix; ?>[calories]" value="<?php echo esc_attr( $calories ); ?>" placeholder="e.g. 450 kcal" />
			</div>
		</div>

		<div class="recipe-list-repeater">
			<label>Ingredients</label>
			<div class="repeater-list-items">
				<?php foreach ( $ingredients as $ingredient ) : ?>
					<div class="recipe-list-item">
						<input type="text" name="<?php echo $field_prefix; ?>[ingredients][]" value="<?php echo esc_attr( $ingredient ); ?>" placeholder="1 cup flour" />
						<a href="#" class="remove-list-item">&times; Remove</a>
					</div>
				<?php endforeach; ?>
			</div>
			<a href="#" class="button add-list-item" data-name="<?php echo $field_prefix; ?>[ingredients][]" data-type="text">+ Add Ingredient</a>
		</div>

		<div class="recipe-list-repeater">
			<label>Instructions</label>
			<div class="repeater-list-items">
				<?php foreach ( $instructions as $instruction ) : ?>
					<div class="recipe-list-item">
						<textarea name="<?php echo $field_prefix; ?>[instructions][]" placeholder="Preheat the oven..."><?php echo esc_textarea( $instruction ); ?></textarea>
						<a href="#" class="remove-list-item">&times; Remove</a>
					</div>
				<?php endforeach; ?>
			</div>
			<a href="#" class="button add-list-item" data-name="<?php echo $field_prefix; ?>[instructions][]" data-type="textarea">+ Add Instruction</a>
		</div>

		<div class="recipe-field-row">
			<label>Recipe Tip (Optional)</label>
			<textarea name="<?php echo $field_prefix; ?>[tip]" placeholder="Helpful note here..."><?php echo esc_textarea( $tip ); ?></textarea>
		</div>
	</div>
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

	if ( ! isset( $_POST['recipe_blocks_nonce_field'] ) || ! wp_verify_nonce( $_POST['recipe_blocks_nonce_field'], 'recipe_blocks_nonce' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$saved_blocks = array();

	if ( isset( $_POST['recipe_blocks'] ) && is_array( $_POST['recipe_blocks'] ) ) {
		foreach ( wp_unslash( $_POST['recipe_blocks'] ) as $block ) {
			// Skip entirely empty blocks
			if ( empty( $block['title'] ) && empty( $block['description'] ) ) {
				continue;
			}

			$clean_block = array(
				'title'       => sanitize_text_field( $block['title'] ?? '' ),
				'description' => sanitize_textarea_field( $block['description'] ?? '' ),
				'image'       => esc_url_raw( $block['image'] ?? '' ),
				'prep_time'   => sanitize_text_field( $block['prep_time'] ?? '' ),
				'cook_time'   => sanitize_text_field( $block['cook_time'] ?? '' ),
				'servings'    => sanitize_text_field( $block['servings'] ?? '' ),
				'calories'    => sanitize_text_field( $block['calories'] ?? '' ),
				'tip'         => sanitize_textarea_field( $block['tip'] ?? '' ),
			);

			$clean_ingredients = array();
			if ( isset( $block['ingredients'] ) && is_array( $block['ingredients'] ) ) {
				$clean_ingredients = array_filter( array_map( 'sanitize_text_field', $block['ingredients'] ) );
			}
			$clean_block['ingredients'] = array_values( $clean_ingredients );

			$clean_instructions = array();
			if ( isset( $block['instructions'] ) && is_array( $block['instructions'] ) ) {
				$clean_instructions = array_filter( array_map( 'sanitize_textarea_field', $block['instructions'] ) );
			}
			$clean_block['instructions'] = array_values( $clean_instructions );

			$saved_blocks[] = $clean_block;
		}
	}

	update_post_meta( $post_id, '_recipe_blocks', $saved_blocks );
}
add_action( 'save_post', 'recipe_magazine_save_meta_boxes' );
