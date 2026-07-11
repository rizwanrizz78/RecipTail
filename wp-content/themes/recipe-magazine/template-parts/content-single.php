<?php
/**
 * Template part for displaying a single recipe / post
 */

$post_id = get_the_ID();
$recipe_blocks = get_post_meta( $post_id, '_recipe_blocks', true );
if ( ! is_array( $recipe_blocks ) ) {
	$recipe_blocks = array();
}

// Extract specific paragraphs to emulate the AFC structure
$raw_content = get_the_content();
$raw_content = apply_filters( 'the_content', $raw_content );

$doc = new DOMDocument();
libxml_use_internal_errors(true);
if ( ! empty( $raw_content ) ) {
	$doc->loadHTML( '<?xml encoding="utf-8" ?>' . $raw_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
}
libxml_clear_errors();

// Helper to get inner HTML of a DOMNode to preserve tags
function rm_get_inner_html( $node ) {
	$innerHTML = '';
	$children = $node->childNodes;
	foreach ( $children as $child ) {
		$innerHTML .= $node->ownerDocument->saveHTML( $child );
	}
	return $innerHTML;
}

$paragraphs = $doc->getElementsByTagName('p');

$desc_html = '';
$disc_top_html = '';
$disc_bottom_html = '';

// 1st paragraph -> .afc-dek
if ( $paragraphs->length > 0 ) {
	$p1 = $paragraphs->item(0);
	$desc_html = rm_get_inner_html( $p1 );
	$p1->parentNode->removeChild($p1);
}

// 2nd paragraph -> .afc-disclosure-top (if it contains disclosure-like keywords, or just default to 2nd para)
if ( $paragraphs->length > 0 ) {
	$p2 = $paragraphs->item(0);
	$disc_top_html = rm_get_inner_html( $p2 );
	$p2->parentNode->removeChild($p2);
}

// Check the last paragraph for a bottom disclosure
$paragraphs_remaining = $doc->getElementsByTagName('p');
if ( $paragraphs_remaining->length > 0 ) {
	$last_p = $paragraphs_remaining->item($paragraphs_remaining->length - 1);
	$last_p_text = strtolower($last_p->nodeValue);
	if ( strpos($last_p_text, 'affiliate') !== false || strpos($last_p_text, 'disclosure') !== false ) {
		$disc_bottom_html = rm_get_inner_html( $last_p );
		$last_p->parentNode->removeChild($last_p);
	}
}

// Add class `afc-intro` to the new "first" paragraph (which was the 3rd paragraph originally)
$paragraphs_after = $doc->getElementsByTagName('p');
if ( $paragraphs_after->length > 0 ) {
	$p_intro = $paragraphs_after->item(0);
	$existing_class = $p_intro->getAttribute('class');
	$p_intro->setAttribute('class', trim($existing_class . ' afc-intro'));
}

// For headings inside the content to look right if placed at the end
$headings2 = $doc->getElementsByTagName('h2');
if ( $headings2->length > 0 ) {
	// The last h2 is typically the outro heading
	$last_h2 = $headings2->item($headings2->length - 1);
	// We could wrap the last elements in .afc-outro but for safety we'll rely on global CSS matching
}

$remaining_content = $doc->saveHTML();
$remaining_content = str_replace( '<?xml encoding="utf-8" ?>', '', $remaining_content );
$remaining_content = trim( $remaining_content );

?>

<div id="post-<?php the_ID(); ?>" <?php post_class( 'afc-article' ); ?>>

	<!-- Hero Section -->
	<div class="afc-hero">
		<?php
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			echo '<span class="afc-eyebrow">' . esc_html( strtoupper($categories[0]->name) ) . '</span>';
		}

		the_title( '<h1>', '</h1>' );
		?>

		<?php if ( ! empty( $desc_html ) ) : ?>
			<p class="afc-dek"><?php echo wp_kses_post( $desc_html ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $disc_top_html ) ) : ?>
		<p class="afc-disclosure-top"><?php echo wp_kses_post( $disc_top_html ); ?></p>
	<?php endif; ?>

	<!-- Featured Image -->
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="afc-featured-image">
			<?php the_post_thumbnail( 'full', array( 'loading' => 'lazy' ) ); ?>
		</div>
	<?php endif; ?>

	<!-- Article Content Flow -->
	<?php echo $remaining_content; ?>

	<!-- Recipe Cards -->
	<?php if ( ! empty( $recipe_blocks ) ) : ?>

		<hr class="afc-divider" />

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

			<div class="afc-recipe" id="recipe-<?php echo $recipe_num; ?>">

				<div class="afc-recipe-head">
					<div class="afc-num"><?php echo $recipe_num; ?></div>
					<h2><?php echo esc_html( $b_title ); ?></h2>
				</div>

				<?php if ( ! empty( $b_desc ) ) : ?>
					<p class="afc-recipe-blurb"><?php echo wp_kses_post( $b_desc ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $b_image ) ) : ?>
					<img src="<?php echo esc_url( $b_image ); ?>" alt="<?php echo esc_attr( $b_title ); ?>" class="afc-recipe-img" loading="lazy" />
				<?php endif; ?>

				<div class="afc-stats">
					<?php if ( $b_prep ) : ?><span class="afc-stat">Prep <?php echo esc_html( $b_prep ); ?></span><?php endif; ?>
					<?php if ( $b_cook ) : ?><span class="afc-stat">Cook <?php echo esc_html( $b_cook ); ?></span><?php endif; ?>
					<?php if ( $b_servings ) : ?><span class="afc-stat">Serves <?php echo esc_html( $b_servings ); ?></span><?php endif; ?>
					<?php if ( $b_calories ) : ?><span class="afc-stat"><?php echo esc_html( $b_calories ); ?></span><?php endif; ?>
				</div>

				<div class="afc-cols">
					<div>
						<h4><?php _e( 'INGREDIENTS', 'recipe-magazine' ); ?></h4>
						<ul>
							<?php foreach ( $b_ingredients as $ingredient ) : ?>
								<li><?php echo esc_html( $ingredient ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>

					<div>
						<h4><?php _e( 'INSTRUCTIONS', 'recipe-magazine' ); ?></h4>
						<ol>
							<?php foreach ( $b_instructions as $instruction ) : ?>
								<li><?php echo wp_strip_all_tags( $instruction ); ?></li>
							<?php endforeach; ?>
						</ol>
					</div>
				</div>

				<?php if ( ! empty( $b_tip ) ) : ?>
					<div class="afc-tip">
						<?php echo wp_kses_post( $b_tip ); ?>
					</div>
				<?php endif; ?>

			</div><!-- .afc-recipe -->

			<?php
			// JSON-LD Schema
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
	<?php endif; ?>

	<?php if ( ! empty( $disc_bottom_html ) ) : ?>
		<div class="afc-disclosure-bottom">
			<?php echo wp_kses_post( $disc_bottom_html ); ?>
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

</div><!-- .afc-article -->
