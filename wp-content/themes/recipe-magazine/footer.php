<?php
/**
 * The template for displaying the footer
 *
 * @package Recipe_Magazine
 */
?>

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<div class="container site-info-inner">
				<div class="footer-copyright">
					<?php
					/* translators: %s: blog name */
					printf( esc_html__( 'Made with ♥️ by %s', 'recipe-magazine' ), esc_html( get_bloginfo( 'name' ) ) );
					?>
				</div>
			</div>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
