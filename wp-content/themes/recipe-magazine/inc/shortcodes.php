<?php
/**
 * Recipe Magazine Shortcodes
 * Handles affiliate CTA boxes and product recommendations.
 */

/**
 * [recipe_cta] Shortcode
 */
function recipe_magazine_cta_shortcode( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'label'       => 'RECOMMENDED',
		'title'       => 'Check this out',
		'description' => '',
		'button'      => 'Click Here',
		'url'         => '#',
	), $atts, 'recipe_cta' );

	ob_start();
	?>
	<div class="afc-cta">
		<?php if ( ! empty( $atts['label'] ) ) : ?>
			<p class="afc-cta-label"><?php echo esc_html( $atts['label'] ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $atts['title'] ) ) : ?>
			<h3><?php echo esc_html( $atts['title'] ); ?></h3>
		<?php endif; ?>

		<?php if ( ! empty( $atts['description'] ) ) : ?>
			<p class="afc-cta-copy"><?php echo esc_html( $atts['description'] ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $atts['url'] ) && ! empty( $atts['button'] ) ) : ?>
			<a href="<?php echo esc_url( $atts['url'] ); ?>" class="afc-cta-btn" target="_blank" rel="noopener nofollow">
				<?php echo esc_html( $atts['button'] ); ?>
			</a>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'recipe_cta', 'recipe_magazine_cta_shortcode' );

/**
 * [product_box] Shortcode
 */
function recipe_magazine_product_box_shortcode( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'image'       => '',
		'title'       => 'Product Name',
		'description' => '',
		'button'      => 'Buy Now',
		'url'         => '#',
	), $atts, 'product_box' );

	ob_start();
	?>
	<div class="product-box">
		<?php if ( ! empty( $atts['image'] ) ) : ?>
			<div class="product-box-image">
				<img src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>" />
			</div>
		<?php endif; ?>

		<div class="product-box-content">
			<h4 class="product-box-title"><?php echo esc_html( $atts['title'] ); ?></h4>

			<?php if ( ! empty( $atts['description'] ) ) : ?>
				<p class="product-box-description"><?php echo esc_html( $atts['description'] ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $atts['url'] ) && ! empty( $atts['button'] ) ) : ?>
				<a href="<?php echo esc_url( $atts['url'] ); ?>" class="product-box-button" target="_blank" rel="noopener nofollow">
					<?php echo esc_html( $atts['button'] ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'product_box', 'recipe_magazine_product_box_shortcode' );
