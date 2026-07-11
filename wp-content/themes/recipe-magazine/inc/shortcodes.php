<?php
/**
 * Recipe Magazine Shortcodes
 * Replaces the old system with the new rt_* suite.
 */

/**
 * [rt_dek]
 */
function recipe_magazine_rt_dek( $atts, $content = null ) {
	return '<p class="afc-dek">' . wp_kses_post( $content ) . '</p>';
}
add_shortcode( 'rt_dek', 'recipe_magazine_rt_dek' );

/**
 * [rt_disclosure]
 */
function recipe_magazine_rt_disclosure( $atts ) {
	$atts = shortcode_atts( array(
		'position' => 'top',
	), $atts, 'rt_disclosure' );

	if ( 'bottom' === $atts['position'] ) {
		$text = get_theme_mod( 'rt_disclosure_text_bottom', '<strong>Affiliate Disclosure:</strong> This post contains affiliate links, including links to Amazon. As an Amazon Associate, we earn from qualifying purchases at no extra cost to you. We only recommend products we believe add real value to your cooking.' );
		return '<div class="afc-disclosure-bottom">' . wp_kses_post( $text ) . '</div>';
	}

	$text = get_theme_mod( 'rt_disclosure_text_top', 'This post contains affiliate links. As an Amazon Associate, we earn from qualifying purchases.' );
	return '<p class="afc-disclosure-top">' . wp_kses_post( $text ) . '</p>';
}
add_shortcode( 'rt_disclosure', 'recipe_magazine_rt_disclosure' );

/**
 * [rt_cta]
 */
function recipe_magazine_rt_cta( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'label'  => '',
		'title'  => '',
		'button' => '',
		'link'   => '#',
	), $atts, 'rt_cta' );

	ob_start();
	?>
	<div class="afc-cta">
		<?php if ( ! empty( $atts['label'] ) ) : ?>
			<p class="afc-cta-label"><?php echo esc_html( $atts['label'] ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $atts['title'] ) ) : ?>
			<h3><?php echo esc_html( $atts['title'] ); ?></h3>
		<?php endif; ?>

		<?php if ( ! empty( $content ) ) : ?>
			<p class="afc-cta-copy"><?php echo wp_kses_post( trim( $content ) ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $atts['link'] ) && ! empty( $atts['button'] ) ) : ?>
			<a href="<?php echo esc_url( $atts['link'] ); ?>" class="afc-cta-btn" target="_blank" rel="noopener nofollow">
				<?php echo esc_html( $atts['button'] ); ?>
			</a>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'rt_cta', 'recipe_magazine_rt_cta' );

/**
 * [rt_divider]
 */
function recipe_magazine_rt_divider() {
	return '<hr class="afc-divider" />';
}
add_shortcode( 'rt_divider', 'recipe_magazine_rt_divider' );

/**
 * [rt_outro]
 */
function recipe_magazine_rt_outro( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'title' => '',
	), $atts, 'rt_outro' );

	ob_start();
	?>
	<div class="afc-outro">
		<?php if ( ! empty( $atts['title'] ) ) : ?>
			<h2><?php echo esc_html( $atts['title'] ); ?></h2>
		<?php endif; ?>
		<p><?php echo wp_kses_post( trim( $content ) ); ?></p>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'rt_outro', 'recipe_magazine_rt_outro' );

/**
 * [rt_recipe] Parent shortcode
 */
function recipe_magazine_rt_recipe( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'number' => '1',
		'title'  => '',
		'prep'   => '',
		'cook'   => '',
		'serves' => '',
		'image'  => '',
	), $atts, 'rt_recipe' );

	// We extract nested shortcodes manually using regex or just relying on do_shortcode if they are registered.
	// We will parse them manually here to place them perfectly in the grid structure.

	$blurb = '';
	if ( preg_match( '/\[rt_blurb\](.*?)\[\/rt_blurb\]/is', $content, $matches ) ) {
		$blurb = trim( $matches[1] );
	}

	$ingredients = '';
	if ( preg_match( '/\[rt_ingredients\](.*?)\[\/rt_ingredients\]/is', $content, $matches ) ) {
		$raw_ingredients = trim( $matches[1] );
		// Parse markdown dashes
		$lines = explode( "\n", $raw_ingredients );
		$ingredients .= '<ul>';
		foreach ( $lines as $line ) {
			$line = trim( $line );
			if ( empty( $line ) ) continue;
			$line = ltrim( $line, '- ' );
			$ingredients .= '<li>' . wp_kses_post( $line ) . '</li>';
		}
		$ingredients .= '</ul>';
	}

	$instructions = '';
	if ( preg_match( '/\[rt_instructions\](.*?)\[\/rt_instructions\]/is', $content, $matches ) ) {
		$raw_instructions = trim( $matches[1] );
		// Parse numbered list
		$lines = explode( "\n", $raw_instructions );
		$instructions .= '<ol>';
		foreach ( $lines as $line ) {
			$line = trim( $line );
			if ( empty( $line ) ) continue;
			$line = preg_replace('/^\d+\.\s*/', '', $line); // strip "1. "
			$instructions .= '<li>' . wp_kses_post( $line ) . '</li>';
		}
		$instructions .= '</ol>';
	}

	$tip = '';
	if ( preg_match( '/\[rt_tip\](.*?)\[\/rt_tip\]/is', $content, $matches ) ) {
		$tip = trim( $matches[1] );
	}

	ob_start();
	?>
	<div class="afc-recipe">
		<div class="afc-recipe-head">
			<div class="afc-num"><?php echo esc_html( $atts['number'] ); ?></div>
			<h2><?php echo esc_html( $atts['title'] ); ?></h2>
		</div>

		<?php if ( ! empty( $blurb ) ) : ?>
			<p class="afc-recipe-blurb"><?php echo wp_kses_post( $blurb ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $atts['image'] ) ) : ?>
			<img src="<?php echo esc_url( $atts['image'] ); ?>" class="afc-recipe-img" alt="<?php echo esc_attr( $atts['title'] ); ?>" loading="lazy" />
		<?php endif; ?>

		<div class="afc-stats">
			<?php if ( ! empty( $atts['prep'] ) ) : ?><span class="afc-stat">Prep <?php echo esc_html( $atts['prep'] ); ?></span><?php endif; ?>
			<?php if ( ! empty( $atts['cook'] ) ) : ?><span class="afc-stat">Cook <?php echo esc_html( $atts['cook'] ); ?></span><?php endif; ?>
			<?php if ( ! empty( $atts['serves'] ) ) : ?><span class="afc-stat">Serves <?php echo esc_html( $atts['serves'] ); ?></span><?php endif; ?>
		</div>

		<div class="afc-cols">
			<div>
				<h4><?php _e( 'INGREDIENTS', 'recipe-magazine' ); ?></h4>
				<?php echo $ingredients; ?>
			</div>
			<div>
				<h4><?php _e( 'INSTRUCTIONS', 'recipe-magazine' ); ?></h4>
				<?php echo $instructions; ?>
			</div>
		</div>

		<?php if ( ! empty( $tip ) ) : ?>
			<div class="afc-tip">
				<?php echo wp_kses_post( $tip ); ?>
			</div>
		<?php endif; ?>
	</div>

	<?php
	// Dynamic JSON-LD Schema Generation for this recipe block
	$schema = array(
		'@context'    => 'https://schema.org/',
		'@type'       => 'Recipe',
		'name'        => $atts['title'],
		'description' => $blurb,
		'author'      => array(
			'@type' => 'Person',
			'name'  => get_the_author(),
		),
	);

	if ( has_post_thumbnail() ) {
		$schema['image'] = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	}

	if ( ! empty( $atts['prep'] ) ) {
		$schema['prepTime'] = recipe_magazine_parse_time_schema( $atts['prep'] );
	}
	if ( ! empty( $atts['cook'] ) ) {
		$schema['cookTime'] = recipe_magazine_parse_time_schema( $atts['cook'] );
	}
	if ( ! empty( $atts['serves'] ) ) {
		$schema['recipeYield'] = esc_html( $atts['serves'] );
	}

	if ( ! empty( $raw_ingredients ) ) {
		$schema_ing = array();
		$lines = explode( "\n", trim( $raw_ingredients ) );
		foreach ( $lines as $line ) {
			$line = trim( $line );
			if ( empty( $line ) ) continue;
			$schema_ing[] = wp_strip_all_tags( ltrim( $line, '- ' ) );
		}
		if ( ! empty( $schema_ing ) ) {
			$schema['recipeIngredient'] = $schema_ing;
		}
	}

	if ( ! empty( $raw_instructions ) ) {
		$schema_inst = array();
		$lines = explode( "\n", trim( $raw_instructions ) );
		foreach ( $lines as $line ) {
			$line = trim( $line );
			if ( empty( $line ) ) continue;
			$clean = preg_replace('/^\d+\.\s*/', '', $line);
			$schema_inst[] = array(
				'@type' => 'HowToStep',
				'text'  => wp_strip_all_tags( $clean ),
			);
		}
		if ( ! empty( $schema_inst ) ) {
			$schema['recipeInstructions'] = $schema_inst;
		}
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
	?>
	<?php
	return ob_get_clean();
}
add_shortcode( 'rt_recipe', 'recipe_magazine_rt_recipe' );

// Register the child shortcodes as dummy ones so WordPress doesn't print the raw text if `do_shortcode` hits them,
// though our parent regex grabs them first.
add_shortcode( 'rt_blurb', '__return_empty_string' );
add_shortcode( 'rt_ingredients', '__return_empty_string' );
add_shortcode( 'rt_instructions', '__return_empty_string' );
add_shortcode( 'rt_tip', '__return_empty_string' );
