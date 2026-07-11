<?php
/**
 * The template for displaying the front page
 *
 * @package Recipe_Magazine
 */

get_header();
?>

<main id="primary" class="site-main front-page-main container">

	<!-- Main Feed (Latest Recipes) -->
	<section class="latest-recipes-section" style="margin-top: 40px;">
		<div class="recipe-grid">
			<?php
			$latest_args = array(
				'post_type'      => 'post',
				'posts_per_page' => 6,
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

		<div class="view-all-wrapper" style="margin-bottom: 60px;">
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="button view-all-btn"><?php _e( 'View All Recipes', 'recipe-magazine' ); ?></a>
		</div>
	</section>

	<!-- Popular Recipes (Smaller Cards) -->
	<section class="popular-recipes-section" style="margin-top: 60px;">
		<h2 class="section-title"><?php _e( 'Popular Now', 'recipe-magazine' ); ?></h2>
		<div class="recipe-grid recipe-grid-small">
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
	</section>

</main><!-- #main -->

<?php
get_footer();
