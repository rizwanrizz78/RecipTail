<?php
/**
 * Simple Views Counter
 * Tracks post views for the Popular Recipes functionality.
 */

// Key to store views
define( 'RECIPE_MAGAZINE_VIEWS_KEY', 'recipe_magazine_post_views' );

/**
 * Increment view count for a post when a single post is loaded.
 */
function recipe_magazine_track_post_views() {
	if ( ! is_single() ) {
		return;
	}

	global $post;
	$post_id = $post->ID;

	// Simple cookie to prevent counting same user on refresh for a little while (optional but good practice)
	// For this scope we will just increment on every page load as requested (simple lightweight counter)

	$current_views = get_post_meta( $post_id, RECIPE_MAGAZINE_VIEWS_KEY, true );

	if ( $current_views === '' ) {
		$current_views = 0;
		delete_post_meta( $post_id, RECIPE_MAGAZINE_VIEWS_KEY );
		add_post_meta( $post_id, RECIPE_MAGAZINE_VIEWS_KEY, 1 );
	} else {
		$current_views++;
		update_post_meta( $post_id, RECIPE_MAGAZINE_VIEWS_KEY, $current_views );
	}
}
add_action( 'wp_head', 'recipe_magazine_track_post_views' );

/**
 * Helper function to get post views
 */
function recipe_magazine_get_post_views( $post_id ) {
	$count = get_post_meta( $post_id, RECIPE_MAGAZINE_VIEWS_KEY, true );
	if ( $count === '' ) {
		return 0;
	}
	return (int) $count;
}

/**
 * Register Widget Areas
 */
function recipe_magazine_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'recipe-magazine' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'recipe-magazine' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s card-widget">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'recipe-magazine' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Add footer widgets here.', 'recipe-magazine' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s footer-widget">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'recipe_magazine_widgets_init' );
