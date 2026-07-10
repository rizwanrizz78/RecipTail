<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Recipe_Magazine
 */

get_header();
?>

<main id="primary" class="site-main error-404 not-found container">
	<section class="error-404-content">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'recipe-magazine' ); ?></h1>
		</header>

		<div class="page-content">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'recipe-magazine' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</section>
</main>

<?php get_footer();
