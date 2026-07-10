<?php
/**
 * The template for displaying the front page
 *
 * @package Recipe_Magazine
 */

get_header();
?>

<main id="primary" class="site-main front-page-main">

	<?php
	// 1. Main Featured Recipe (1 post)
	$featured_args = array(
		'post_type'      => 'post',
		'posts_per_page' => 1,
		'meta_key'       => '_recipe_is_featured',
		'meta_value'     => 'yes',
	);
	$featured_query = new WP_Query( $featured_args );

	if ( $featured_query->have_posts() ) :
		while ( $featured_query->have_posts() ) :
			$featured_query->the_post();
			?>
			<section class="hero-featured-recipe">
				<div class="container hero-inner">
					<div class="hero-image">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'recipe-featured' ); ?>
						</a>
					</div>
					<div class="hero-content">
						<?php
						$categories = get_the_category();
						if ( ! empty( $categories ) ) {
							echo '<span class="hero-category">' . esc_html( $categories[0]->name ) . '</span>';
						}
						?>
						<?php the_title( '<h2 class="hero-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
						<div class="hero-excerpt">
							<?php the_excerpt(); ?>
						</div>
						<a href="<?php the_permalink(); ?>" class="button hero-read-more"><?php _e( 'Get Recipe', 'recipe-magazine' ); ?></a>
					</div>
				</div>
			</section>
			<?php
		endwhile;
		wp_reset_postdata();
	endif;
	?>

	<!-- Additional Featured Grid -->
	<?php
	$secondary_featured_args = array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'meta_key'       => '_recipe_is_featured',
		'meta_value'     => 'yes',
		'offset'         => 1, // Skip the main featured
	);
	$secondary_featured_query = new WP_Query( $secondary_featured_args );

	if ( $secondary_featured_query->have_posts() ) :
		?>
		<section class="secondary-featured-section">
			<div class="container">
				<div class="recipe-grid">
					<?php
					while ( $secondary_featured_query->have_posts() ) :
						$secondary_featured_query->the_post();
						get_template_part( 'template-parts/content', 'recipe-card' );
					endwhile;
					?>
				</div>
			</div>
		</section>
		<?php
		wp_reset_postdata();
	endif;
	?>

	<!-- Category Section Example (e.g. Breakfast) -->
	<?php
	// Example to dynamically grab a category if one exists, fallback to first category
	$cats = get_categories( array( 'number' => 1, 'hide_empty' => true ) );
	if ( ! empty( $cats ) ) :
		$cat = $cats[0];
		$cat_args = array(
			'post_type'      => 'post',
			'posts_per_page' => 3,
			'cat'            => $cat->term_id,
		);
		$cat_query = new WP_Query( $cat_args );
		if ( $cat_query->have_posts() ) :
			?>
			<section class="category-highlight-section">
				<div class="container">
					<h2 class="section-title"><?php echo esc_html( $cat->name ); ?> <?php _e( 'Recipes', 'recipe-magazine' ); ?></h2>
					<div class="recipe-grid">
						<?php
						while ( $cat_query->have_posts() ) :
							$cat_query->the_post();
							get_template_part( 'template-parts/content', 'recipe-card' );
						endwhile;
						?>
					</div>
					<div class="view-all-wrapper">
						<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="button view-all-btn"><?php printf( __( 'More %s', 'recipe-magazine' ), esc_html( $cat->name ) ); ?></a>
					</div>
				</div>
			</section>
			<?php
			wp_reset_postdata();
		endif;
	endif;
	?>

	<!-- Latest Recipes Grid -->
	<section class="latest-recipes-section">
		<div class="container">
			<h2 class="section-title"><?php _e( 'Latest Recipes', 'recipe-magazine' ); ?></h2>

			<div class="recipe-grid">
				<?php
				$latest_args = array(
					'post_type'      => 'post',
					'posts_per_page' => 6,
					// Exclude the main featured recipe to avoid duplication if desired
					// 'post__not_in'   => isset( $featured_query->posts[0] ) ? array( $featured_query->posts[0]->ID ) : array(),
				);
				$latest_query = new WP_Query( $latest_args );

				if ( $latest_query->have_posts() ) :
					while ( $latest_query->have_posts() ) :
						$latest_query->the_post();
						get_template_part( 'template-parts/content', 'recipe-card' );
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p>' . esc_html__( 'No recipes found.', 'recipe-magazine' ) . '</p>';
				endif;
				?>
			</div>

			<div class="view-all-wrapper">
				<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="button view-all-btn"><?php _e( 'View All Recipes', 'recipe-magazine' ); ?></a>
			</div>
		</div>
	</section>

	<!-- Popular Recipes -->
	<section class="popular-recipes-section">
		<div class="container">
			<h2 class="section-title"><?php _e( 'Popular Now', 'recipe-magazine' ); ?></h2>

			<div class="recipe-grid">
				<?php
				$popular_limit = get_theme_mod( 'popular_recipes_limit', 5 );
				$popular_args = array(
					'post_type'      => 'post',
					'posts_per_page' => $popular_limit,
					'meta_key'       => RECIPE_MAGAZINE_VIEWS_KEY,
					'orderby'        => 'meta_value_num',
					'order'          => 'DESC',
				);
				$popular_query = new WP_Query( $popular_args );

				if ( $popular_query->have_posts() ) :
					while ( $popular_query->have_posts() ) :
						$popular_query->the_post();
						get_template_part( 'template-parts/content', 'recipe-card' );
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p>' . esc_html__( 'No popular recipes yet. Start reading!', 'recipe-magazine' ) . '</p>';
				endif;
				?>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();
