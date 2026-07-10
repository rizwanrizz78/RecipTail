<?php
/**
 * The main template file / Archive fallback
 *
 * @package Recipe_Magazine
 */

get_header();
?>

<main id="primary" class="site-main container archive-main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<?php
			if ( is_archive() ) {
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
			} elseif ( is_search() ) {
				/* translators: %s: search query. */
				printf( '<h1 class="page-title">%s <span>%s</span></h1>', esc_html__( 'Search Results for:', 'recipe-magazine' ), get_search_query() );
			} elseif ( is_home() && ! is_front_page() ) {
				echo '<h1 class="page-title">' . single_post_title( '', false ) . '</h1>';
			}
			?>
		</header><!-- .page-header -->

		<div class="recipe-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'recipe-card' );
			endwhile;
			?>
		</div>

		<?php
		the_posts_pagination(
			array(
				'prev_text' => __( 'Previous', 'recipe-magazine' ),
				'next_text' => __( 'Next', 'recipe-magazine' ),
			)
		);
		?>

	<?php else : ?>

		<section class="no-results not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'recipe-magazine' ); ?></h1>
			</header>

			<div class="page-content">
				<?php
				if ( is_search() ) {
					echo '<p>' . esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'recipe-magazine' ) . '</p>';
					get_search_form();
				} else {
					echo '<p>' . esc_html__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'recipe-magazine' ) . '</p>';
					get_search_form();
				}
				?>
			</div>
		</section>

	<?php endif; ?>

</main><!-- #main -->

<?php
get_footer();
