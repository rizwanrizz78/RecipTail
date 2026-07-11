<?php
/**
 * Template part for displaying a recipe card in loops (Archive / Homepage)
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'recipe-card-loop content-card' ); ?>>
	<div class="recipe-card-image">
		<a href="<?php the_permalink(); ?>">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'recipe-card', array( 'loading' => 'lazy' ) );
			} else {
				// Fallback image
				echo '<div class="recipe-image-fallback"></div>';
			}
			?>
		</a>
		<?php
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			echo '<span class="recipe-card-category eyebrow-tag"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></span>';
		}
		?>
	</div>

	<div class="recipe-card-content">
		<header class="entry-header">
			<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
		</header>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>

		<!-- Small stat pill meta row for archive cards -->
		<div class="recipe-card-meta-row">
			<span class="stat-pill"><?php echo get_the_date( 'M j, Y' ); ?></span>
			<?php
			// We can also pull the total time from the first recipe block if available, or just use date
			$recipe_blocks = get_post_meta( get_the_ID(), '_recipe_blocks', true );
			if ( is_array( $recipe_blocks ) && ! empty( $recipe_blocks[0]['prep_time'] ) ) {
				echo '<span class="stat-pill">Prep ' . esc_html( $recipe_blocks[0]['prep_time'] ) . '</span>';
			}
			?>
		</div>

		<a href="<?php the_permalink(); ?>" class="recipe-read-more"><?php _e( 'READ RECIPE →', 'recipe-magazine' ); ?></a>
	</div>
</article>
