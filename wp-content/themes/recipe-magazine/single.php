<?php
/**
 * The template for displaying all single posts
 *
 * @package Recipe_Magazine
 */

get_header();
?>

<main id="primary" class="site-main single-post-main">
	<div class="container single-container">

		<div class="single-content-area">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'single' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
		</div>

	</div>
</main><!-- #main -->

<?php
get_footer();
