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
	</div>

	<div class="recipe-card-content">
		<header class="entry-header">
			<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
		</header>

		<a href="<?php the_permalink(); ?>" class="button recipe-read-more-btn"><?php _e( 'READ FULL RECIPE →', 'recipe-magazine' ); ?></a>
	</div>
</article>
