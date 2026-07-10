<?php
/**
 * The header for our theme
 *
 * @package Recipe_Magazine
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'recipe-magazine' ); ?></a>

	<!-- Top Navigation Bar -->
	<div class="top-bar">
		<div class="container top-bar-inner">
			<?php if ( has_nav_menu( 'secondary' ) ) : ?>
				<nav class="secondary-navigation" aria-label="<?php esc_attr_e( 'Secondary Menu', 'recipe-magazine' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'secondary',
							'menu_class'     => 'secondary-menu',
							'depth'          => 1,
						)
					);
					?>
				</nav>
			<?php endif; ?>

			<div class="header-social-icons">
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
		</div>
	</div>

	<!-- Main Header -->
	<header id="masthead" class="site-header sticky-header">
		<div class="container header-inner">

			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
					$recipe_magazine_description = get_bloginfo( 'description', 'display' );
					if ( $recipe_magazine_description || is_customize_preview() ) {
						?>
						<p class="site-description"><?php echo $recipe_magazine_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
						<?php
					}
				}
				?>
			</div>

			<!-- Mobile Menu Toggle -->
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'recipe-magazine' ); ?></span>
			</button>

			<nav id="site-navigation" class="main-navigation">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'primary-menu',
					)
				);
				?>
			</nav>

			<!-- Search Icon -->
			<button class="header-search-toggle" aria-label="<?php esc_attr_e( 'Open Search', 'recipe-magazine' ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
			</button>

		</div>
	</header>

	<!-- Full Screen Search Overlay -->
	<div class="search-overlay">
		<button class="search-overlay-close" aria-label="<?php esc_attr_e( 'Close Search', 'recipe-magazine' ); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
		</button>
		<div class="search-overlay-content">
			<?php get_search_form(); ?>
		</div>
	</div>
