<?php
/**
 * Template part for displaying a single recipe / post
 */

$post_id = get_the_ID();
$recipe_blocks = get_post_meta( $post_id, '_recipe_blocks', true );
if ( ! is_array( $recipe_blocks ) ) {
	$recipe_blocks = array();
}

// 1. Get raw content to parse it. We want to grab the first paragraph (Description)
// and the second paragraph (Disclosure) to style them specifically in the header,
// then output the rest as normal content.
$raw_content = get_the_content();
$raw_content = apply_filters( 'the_content', $raw_content );

$doc = new DOMDocument();
// Suppress warnings for HTML5 elements
libxml_use_internal_errors(true);
if ( ! empty( $raw_content ) ) {
	// Add meta tag to handle UTF-8 correctly
	$doc->loadHTML( '<?xml encoding="utf-8" ?>' . $raw_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
}
libxml_clear_errors();

$paragraphs = $doc->getElementsByTagName('p');

$desc_html = '';
$disc_html = '';

// Extract first paragraph for description
if ( $paragraphs->length > 0 ) {
	$p1 = $paragraphs->item(0);
	$desc_html = $doc->saveHTML($p1);
	$p1->parentNode->removeChild($p1);
}

// Extract second paragraph for disclosure
if ( $paragraphs->length > 0 ) {
	$p2 = $paragraphs->item(0); // It's index 0 now because the first was removed
	$disc_html = $doc->saveHTML($p2);
	$p2->parentNode->removeChild($p2);
}

// Get the remaining content
$remaining_content = $doc->saveHTML();

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'editorial-article' ); ?>>

	<!-- Custom Editorial Header -->
	<header class="entry-header article-header editorial-header">

		<?php the_title( '<h1 class="entry-title article-title">', '</h1>' ); ?>

		<?php
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			echo '<div class="editorial-category-wrapper">';
			echo '<span class="editorial-category-badge"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></span>';
			echo '</div>';
		}
		?>

		<?php if ( ! empty( $desc_html ) ) : ?>
			<div class="editorial-description">
				<?php echo $desc_html; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $disc_html ) ) : ?>
			<div class="editorial-disclosure">
				<?php echo $disc_html; ?>
			</div>
		<?php endif; ?>

	</header><!-- .entry-header -->

	<!-- Featured Image automatically after disclosure -->
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail editorial-featured-image">
			<?php the_post_thumbnail( 'full' ); ?>
		</div>
	<?php endif; ?>

	<!-- Remaining Content Flow -->
	<div class="entry-content article-content editorial-content-flow">

		<?php echo $remaining_content; ?>

		<?php if ( ! empty( $recipe_blocks ) ) : ?>

			<hr class="recipe-divider" />

			<div class="recipe-blocks-container">
				<?php foreach ( $recipe_blocks as $index => $block ) :
					$recipe_num = $index + 1;
					$b_title       = $block['title'] ?? '';
					$b_desc        = $block['description'] ?? '';
					$b_image       = $block['image'] ?? '';
					$b_prep        = $block['prep_time'] ?? '';
					$b_cook        = $block['cook_time'] ?? '';
					$b_servings    = $block['servings'] ?? '';
					$b_calories    = $block['calories'] ?? '';
					$b_ingredients = $block['ingredients'] ?? array();
					$b_instructions = $block['instructions'] ?? array();
					$b_tip         = $block['tip'] ?? '';
				?>

					<div class="recipe-card" id="recipe-<?php echo $recipe_num; ?>">

						<div class="recipe-card-header">
							<div class="recipe-number-badge"><?php echo $recipe_num; ?></div>
							<h2 class="recipe-card-title"><?php echo esc_html( $b_title ); ?></h2>
						</div>

						<?php if ( ! empty( $b_desc ) ) : ?>
							<p class="recipe-card-desc"><?php echo wp_kses_post( $b_desc ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $b_image ) ) : ?>
							<img src="<?php echo esc_url( $b_image ); ?>" alt="<?php echo esc_attr( $b_title ); ?>" class="recipe-card-image" />
						<?php endif; ?>

						<div class="recipe-card-meta">
							<?php if ( $b_prep ) : ?><span class="recipe-pill">Prep: <?php echo esc_html( $b_prep ); ?></span><?php endif; ?>
							<?php if ( $b_cook ) : ?><span class="recipe-pill">Cook: <?php echo esc_html( $b_cook ); ?></span><?php endif; ?>
							<?php if ( $b_servings ) : ?><span class="recipe-pill">Serves: <?php echo esc_html( $b_servings ); ?></span><?php endif; ?>
							<?php if ( $b_calories ) : ?><span class="recipe-pill"><?php echo esc_html( $b_calories ); ?></span><?php endif; ?>
						</div>

						<div class="recipe-card-body">
							<div class="recipe-col-left">
								<h3 class="recipe-col-heading"><?php _e( 'Ingredients', 'recipe-magazine' ); ?></h3>
								<ul class="recipe-ingredients-list">
									<?php foreach ( $b_ingredients as $ingredient ) : ?>
										<li><?php echo esc_html( $ingredient ); ?></li>
									<?php endforeach; ?>
								</ul>
							</div>

							<div class="recipe-col-right">
								<h3 class="recipe-col-heading"><?php _e( 'Instructions', 'recipe-magazine' ); ?></h3>
								<ol class="recipe-instructions-list">
									<?php foreach ( $b_instructions as $instruction ) : ?>
										<li><?php echo wp_kses_post( wpautop( $instruction ) ); ?></li>
									<?php endforeach; ?>
								</ol>
							</div>
						</div>

						<?php if ( ! empty( $b_tip ) ) : ?>
							<div class="recipe-tip-box">
								<p><?php echo wp_kses_post( $b_tip ); ?></p>
							</div>
						<?php endif; ?>

					</div><!-- .recipe-card -->

					<?php
					// JSON-LD Schema for this specific block
					$schema = array(
						'@context'    => 'https://schema.org/',
						'@type'       => 'Recipe',
						'name'        => $b_title,
						'description' => $b_desc,
						'author'      => array(
							'@type' => 'Person',
							'name'  => get_the_author(),
						),
					);

					if ( $b_image ) {
						$schema['image'] = $b_image;
					} elseif ( has_post_thumbnail() ) {
						$schema['image'] = get_the_post_thumbnail_url( $post_id, 'full' );
					}

					if ( $b_prep ) {
						$schema['prepTime'] = recipe_magazine_parse_time_schema( $b_prep );
					}
					if ( $b_cook ) {
						$schema['cookTime'] = recipe_magazine_parse_time_schema( $b_cook );
					}
					if ( $b_servings ) {
						$schema['recipeYield'] = esc_html( $b_servings );
					}
					if ( $b_ingredients ) {
						$schema['recipeIngredient'] = $b_ingredients;
					}
					if ( $b_instructions ) {
						$schema_instructions = array();
						foreach ( $b_instructions as $inst ) {
							$schema_instructions[] = array(
								'@type' => 'HowToStep',
								'text'  => wp_strip_all_tags( $inst ),
							);
						}
						$schema['recipeInstructions'] = $schema_instructions;
					}

					echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
					?>

				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'recipe-magazine' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
