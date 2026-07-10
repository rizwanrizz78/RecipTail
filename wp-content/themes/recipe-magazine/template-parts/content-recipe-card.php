<?php
/**
 * Template part for displaying a recipe card in loops
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'recipe-card-loop' ); ?>>
	<div class="recipe-card-image">
		<a href="<?php the_permalink(); ?>">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'recipe-card' );
			} else {
				// Fallback image
				echo '<div class="recipe-image-fallback"></div>';
			}
			?>
		</a>
		<?php
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			echo '<span class="recipe-card-category"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></span>';
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

		<a href="<?php the_permalink(); ?>" class="recipe-read-more"><?php _e( 'Read More', 'recipe-magazine' ); ?></a>
	</div>
</article>
