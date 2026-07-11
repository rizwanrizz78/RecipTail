<?php
/**
 * Recipe Magazine Theme Customizer
 *
 * @package Recipe_Magazine
 */

function recipe_magazine_customize_register( $wp_customize ) {

	// Social Media Section
	$wp_customize->add_section( 'recipe_magazine_social', array(
		'title'       => __( 'Social Media Links', 'recipe-magazine' ),
		'description' => __( 'Enter URLs for your social media profiles. Icons will only appear if a URL is provided.', 'recipe-magazine' ),
		'priority'    => 30,
	) );

	// Instagram
	$wp_customize->add_setting( 'social_instagram', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'social_instagram', array(
		'label'   => __( 'Instagram URL', 'recipe-magazine' ),
		'section' => 'recipe_magazine_social',
		'type'    => 'url',
	) );

	// Pinterest
	$wp_customize->add_setting( 'social_pinterest', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'social_pinterest', array(
		'label'   => __( 'Pinterest URL', 'recipe-magazine' ),
		'section' => 'recipe_magazine_social',
		'type'    => 'url',
	) );

	// Facebook
	$wp_customize->add_setting( 'social_facebook', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'social_facebook', array(
		'label'   => __( 'Facebook URL', 'recipe-magazine' ),
		'section' => 'recipe_magazine_social',
		'type'    => 'url',
	) );

	// YouTube
	$wp_customize->add_setting( 'social_youtube', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'social_youtube', array(
		'label'   => __( 'YouTube URL', 'recipe-magazine' ),
		'section' => 'recipe_magazine_social',
		'type'    => 'url',
	) );

	// TikTok
	$wp_customize->add_setting( 'social_tiktok', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'social_tiktok', array(
		'label'   => __( 'TikTok URL', 'recipe-magazine' ),
		'section' => 'recipe_magazine_social',
		'type'    => 'url',
	) );

	// X/Twitter
	$wp_customize->add_setting( 'social_x', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'social_x', array(
		'label'   => __( 'X/Twitter URL', 'recipe-magazine' ),
		'section' => 'recipe_magazine_social',
		'type'    => 'url',
	) );

	// Popular Recipes Settings
	$wp_customize->add_section( 'recipe_magazine_popular', array(
		'title'       => __( 'Popular Recipes Settings', 'recipe-magazine' ),
		'priority'    => 35,
	) );

	$wp_customize->add_setting( 'popular_recipes_limit', array(
		'default'           => 5,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'popular_recipes_limit', array(
		'label'       => __( 'Number of Popular Recipes to show', 'recipe-magazine' ),
		'section'     => 'recipe_magazine_popular',
		'type'        => 'number',
		'input_attrs' => array(
			'min' => 1,
			'max' => 20,
		),
	) );

	// Disclosure Settings
	$wp_customize->add_section( 'recipe_magazine_disclosure', array(
		'title'       => __( 'Disclosure Settings', 'recipe-magazine' ),
		'priority'    => 40,
	) );

	$wp_customize->add_setting( 'rt_disclosure_text_top', array(
		'default'           => 'This post contains affiliate links. As an Amazon Associate, we earn from qualifying purchases.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'rt_disclosure_text_top', array(
		'label'       => __( 'Top Disclosure Text', 'recipe-magazine' ),
		'description' => __( 'Used by [rt_disclosure position="top"]. Short plain text version.', 'recipe-magazine' ),
		'section'     => 'recipe_magazine_disclosure',
		'type'        => 'textarea',
	) );

	$wp_customize->add_setting( 'rt_disclosure_text_bottom', array(
		'default'           => '<strong>Affiliate Disclosure:</strong> This post contains affiliate links, including links to Amazon. As an Amazon Associate, we earn from qualifying purchases at no extra cost to you. We only recommend products we believe add real value to your cooking.',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'rt_disclosure_text_bottom', array(
		'label'       => __( 'Bottom Disclosure Text', 'recipe-magazine' ),
		'description' => __( 'Used by [rt_disclosure position="bottom"]. Can be longer and contain basic HTML like strong tags.', 'recipe-magazine' ),
		'section'     => 'recipe_magazine_disclosure',
		'type'        => 'textarea',
	) );

}
add_action( 'customize_register', 'recipe_magazine_customize_register' );
