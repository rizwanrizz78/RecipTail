<?php
/**
 * The template for displaying the footer
 *
 * @package Recipe_Magazine
 */
?>

	<footer id="colophon" class="site-footer">

		<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
			<div class="footer-widgets">
				<div class="container footer-widgets-inner">
					<?php dynamic_sidebar( 'sidebar-2' ); ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="site-info">
			<div class="container site-info-inner">

				<div class="footer-branding">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<h2 class="footer-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
					<?php endif; ?>
				</div>

				<?php if ( has_nav_menu( 'footer' ) ) : ?>
					<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'recipe-magazine' ); ?>">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer',
								'menu_class'     => 'footer-menu',
								'depth'          => 1,
							)
						);
						?>
					</nav>
				<?php endif; ?>

				<div class="footer-social-icons">
					<?php
					$social_links = array(
						'instagram' => get_theme_mod( 'social_instagram' ),
						'pinterest' => get_theme_mod( 'social_pinterest' ),
						'facebook'  => get_theme_mod( 'social_facebook' ),
						'youtube'   => get_theme_mod( 'social_youtube' ),
						'tiktok'    => get_theme_mod( 'social_tiktok' ),
						'x'         => get_theme_mod( 'social_x' ),
					);

					foreach ( $social_links as $network => $url ) {
						if ( ! empty( $url ) ) {
							echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer" class="social-icon social-' . esc_attr( $network ) . '" aria-label="' . esc_attr( ucfirst( $network ) ) . '">';
							echo recipe_magazine_get_social_svg( $network );
							echo '</a>';
						}
					}
					?>
				</div>

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
