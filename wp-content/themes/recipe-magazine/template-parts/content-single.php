<?php
/**
 * Template part for displaying a single recipe / post
 */

// Fetch recipe meta
$post_id      = get_the_ID();
$prep_time    = get_post_meta( $post_id, '_recipe_prep_time', true );
$cook_time    = get_post_meta( $post_id, '_recipe_cook_time', true );
$total_time   = get_post_meta( $post_id, '_recipe_total_time', true );
$servings     = get_post_meta( $post_id, '_recipe_servings', true );
$calories     = get_post_meta( $post_id, '_recipe_calories', true );
$ingredients  = get_post_meta( $post_id, '_recipe_ingredients', true );
$instructions = get_post_meta( $post_id, '_recipe_instructions', true );

$is_recipe = ( ! empty( $ingredients ) && ! empty( $instructions ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header article-header">
		<?php
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			echo '<span class="entry-category-badge"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></span>';
		}

		the_title( '<h1 class="entry-title article-title">', '</h1>' );
		?>
	</header><!-- .entry-header -->

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail article-featured-image">
			<?php the_post_thumbnail( 'full' ); ?>
		</div>
	<?php endif; ?>

	<div class="entry-content article-content">
		<?php
		// Output the Gutenberg content
		the_content();

		// Append the automated Recipe Card if recipe data exists
		if ( $is_recipe ) {
			?>
			<div class="recipe-card-component" id="recipe-card">

				<div class="recipe-card-header">
					<h2 class="recipe-card-title"><?php the_title(); ?></h2>
					<?php if ( has_excerpt() ) : ?>
						<p class="recipe-card-description"><?php echo get_the_excerpt(); ?></p>
					<?php endif; ?>
				</div>

				<div class="recipe-card-meta">
					<?php if ( $prep_time ) : ?>
						<span class="recipe-pill"><strong>Prep:</strong> <?php echo esc_html( $prep_time ); ?></span>
					<?php endif; ?>
					<?php if ( $cook_time ) : ?>
						<span class="recipe-pill"><strong>Cook:</strong> <?php echo esc_html( $cook_time ); ?></span>
					<?php endif; ?>
					<?php if ( $total_time ) : ?>
						<span class="recipe-pill"><strong>Total:</strong> <?php echo esc_html( $total_time ); ?></span>
					<?php endif; ?>
					<?php if ( $servings ) : ?>
						<span class="recipe-pill"><strong>Yield:</strong> <?php echo esc_html( $servings ); ?></span>
					<?php endif; ?>
					<?php if ( $calories ) : ?>
						<span class="recipe-pill"><strong>Calories:</strong> <?php echo esc_html( $calories ); ?></span>
					<?php endif; ?>
				</div>

				<div class="recipe-card-body">
					<div class="recipe-ingredients">
						<h3><?php _e( 'Ingredients', 'recipe-magazine' ); ?></h3>
						<ul>
							<?php foreach ( $ingredients as $ingredient ) : ?>
								<li><?php echo esc_html( $ingredient ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>

					<div class="recipe-instructions">
						<h3><?php _e( 'Instructions', 'recipe-magazine' ); ?></h3>
						<ol class="instruction-list">
							<?php foreach ( $instructions as $index => $instruction ) : ?>
								<li>
									<div class="instruction-step-number"><?php echo ( $index + 1 ); ?></div>
									<div class="instruction-step-text"><?php echo wp_kses_post( wpautop( $instruction ) ); ?></div>
								</li>
							<?php endforeach; ?>
						</ol>
					</div>
				</div>

				<?php
				// Output JSON-LD Schema
				$schema = array(
					'@context'    => 'https://schema.org/',
					'@type'       => 'Recipe',
					'name'        => get_the_title(),
					'description' => get_the_excerpt(),
					'author'      => array(
						'@type' => 'Person',
						'name'  => get_the_author(),
					),
				);

				if ( has_post_thumbnail() ) {
					$schema['image'] = get_the_post_thumbnail_url( $post_id, 'full' );
				}
				if ( $prep_time ) {
					$schema['prepTime'] = recipe_magazine_parse_time_schema( $prep_time );
				}
				if ( $cook_time ) {
					$schema['cookTime'] = recipe_magazine_parse_time_schema( $cook_time );
				}
				if ( $total_time ) {
					$schema['totalTime'] = recipe_magazine_parse_time_schema( $total_time );
				}
				if ( $servings ) {
					$schema['recipeYield'] = esc_html( $servings );
				}
				if ( $ingredients ) {
					$schema['recipeIngredient'] = $ingredients;
				}
				if ( $instructions ) {
					$schema_instructions = array();
					foreach ( $instructions as $inst ) {
						$schema_instructions[] = array(
							'@type' => 'HowToStep',
							'text'  => wp_strip_all_tags( $inst ),
						);
					}
					$schema['recipeInstructions'] = $schema_instructions;
				}

				echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
				?>
			</div>
			<?php
		}

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'recipe-magazine' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer article-footer">
		<?php
		// Tags, categories, etc could go here.
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
