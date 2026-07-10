<?php
/**
 * The template for displaying all pages
 *
 * @package Recipe_Magazine
 */

get_header();
?>

<main id="primary" class="site-main page-main">
	<div class="container single-container">

		<div class="single-content-area">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header article-header">
						<?php the_title( '<h1 class="entry-title article-title">', '</h1>' ); ?>
					</header>

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="post-thumbnail article-featured-image">
							<?php the_post_thumbnail( 'full' ); ?>
						</div>
					<?php endif; ?>

					<div class="entry-content article-content">
						<?php
						the_content();
						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'recipe-magazine' ),
							'after'  => '</div>',
						) );
						?>
					</div>
				</article>
				<?php
			endwhile;
			?>
		</div>

		<div class="single-sidebar-area">
			<?php get_sidebar(); ?>
		</div>

	</div>
</main>

<?php get_footer();
