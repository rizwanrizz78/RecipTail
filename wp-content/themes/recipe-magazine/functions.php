<?php
/**
 * Recipe Magazine functions and definitions
 *
 * @package Recipe_Magazine
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'RECIPE_MAGAZINE_VERSION', '1.0.0' );
define( 'RECIPE_MAGAZINE_DIR', trailingslashit( get_template_directory() ) );
define( 'RECIPE_MAGAZINE_URI', trailingslashit( get_template_directory_uri() ) );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function recipe_magazine_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Custom image sizes
	add_image_size( 'recipe-featured', 1200, 800, true ); // Main featured recipe
	add_image_size( 'recipe-card', 600, 800, true ); // Recipe grid cards (portrait)
	add_image_size( 'recipe-thumbnail', 300, 300, true ); // Small thumbnails

	// Register nav menus.
	register_nav_menus(
		array(
			'primary'   => esc_html__( 'Primary Menu (Categories)', 'recipe-magazine' ),
			'secondary' => esc_html__( 'Secondary Menu (Pages)', 'recipe-magazine' ),
			'footer'    => esc_html__( 'Footer Menu', 'recipe-magazine' ),
		)
	);

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for core custom logo.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'recipe_magazine_setup' );

/**
 * Enqueue scripts and styles.
 */
function recipe_magazine_scripts() {
	// Google Fonts
	wp_enqueue_style( 'recipe-magazine-fonts', 'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Work+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap', array(), null );

	// Main stylesheet
	wp_enqueue_style( 'recipe-magazine-style', get_stylesheet_uri(), array(), RECIPE_MAGAZINE_VERSION );

	// Custom CSS
	wp_enqueue_style( 'recipe-magazine-main-css', RECIPE_MAGAZINE_URI . 'assets/css/main.css', array( 'recipe-magazine-style' ), RECIPE_MAGAZINE_VERSION );

	// Main JS
	wp_enqueue_script( 'recipe-magazine-main-js', RECIPE_MAGAZINE_URI . 'assets/js/main.js', array(), RECIPE_MAGAZINE_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'recipe_magazine_scripts' );

/**
 * Require other inc files
 */
require_once RECIPE_MAGAZINE_DIR . 'inc/helpers.php';
require_once RECIPE_MAGAZINE_DIR . 'inc/customizer.php';
require_once RECIPE_MAGAZINE_DIR . 'inc/core-functions.php';
require_once RECIPE_MAGAZINE_DIR . 'inc/meta-boxes.php';
require_once RECIPE_MAGAZINE_DIR . 'inc/shortcodes.php';
require_once RECIPE_MAGAZINE_DIR . 'inc/widgets.php';
