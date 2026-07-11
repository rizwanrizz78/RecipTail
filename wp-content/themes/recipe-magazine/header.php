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

	<!-- Main Header -->
	<header id="masthead" class="site-header sticky-header">
		<div class="container header-inner">

			<!-- Left: Custom Logo -->
			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				}
				?>
			</div>

			<!-- Mobile Menu Toggle -->
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<!-- Styled hamburger icon using SVG for consistency -->
				<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hamburger-icon"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'recipe-magazine' ); ?></span>
			</button>

			<!-- Right: Static Pages Menu + Search -->
			<div class="header-right-nav primary-menu-wrapper">

				<!-- Mobile-only Categories Section (injected into hamburger) -->
				<div class="mobile-categories-nav">
					<h3 class="mobile-nav-heading"><?php _e( 'RECIPES', 'recipe-magazine' ); ?></h3>
					<ul class="mobile-categories-list">
						<?php
						$categories = get_categories( array( 'hide_empty' => true ) );
						if ( ! empty( $categories ) ) {
							foreach ( $categories as $cat ) {
								echo '<li><a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( strtoupper( $cat->name ) ) . '</a></li>';
							}
						}
						?>
					</ul>
					<h3 class="mobile-nav-heading"><?php _e( 'PAGES', 'recipe-magazine' ); ?></h3>
				</div>

				<nav id="site-navigation" class="main-navigation">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'secondary', // Secondary handles static pages now
							'menu_class'     => 'primary-menu',
							'fallback_cb'    => false, // No Sample Page fallback
						)
					);
					?>
				</nav>

				<!-- Search Icon/Box placed directly below the menu on desktop, or stacked in mobile -->
				<div class="header-search-container">
					<form role="search" method="get" class="header-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<label>
							<span class="screen-reader-text"><?php _e( 'Search for:', 'recipe-magazine' ); ?></span>
							<input type="search" class="header-search-field" placeholder="<?php echo esc_attr_e( 'Search recipes...', 'recipe-magazine' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
						</label>
						<button type="submit" class="header-search-submit">
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
						</button>
					</form>
				</div>
			</div>

		</div>
	</header>

	<!-- Desktop Category Navigation Bar -->
	<div class="desktop-category-bar">
		<div class="container desktop-category-bar-inner">
			<?php
			if ( ! empty( $categories ) ) {
				foreach ( $categories as $cat ) {
					echo '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '" class="category-pill-link">' . esc_html( strtoupper( $cat->name ) ) . '</a>';
				}
			}
			?>
		</div>
	</div>

	<!-- Full Screen Search Overlay -->
	<div class="search-overlay">
		<button class="search-overlay-close" aria-label="<?php esc_attr_e( 'Close Search', 'recipe-magazine' ); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
		</button>
		<div class="search-overlay-content">
			<?php get_search_form(); ?>
		</div>
	</div>
