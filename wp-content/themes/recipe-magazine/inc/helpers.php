<?php
/**
 * Helper Functions
 */

/**
 * Returns SVG icons for social networks
 */
function recipe_magazine_get_social_svg( $network ) {
	$svgs = array(
		'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>',
		'pinterest' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="12" x2="12" y2="22"></line><line x1="12" y1="12" x2="12" y2="22"></line><path d="M12 2a5.5 5.5 0 0 0-5.5 5.5 6.5 6.5 0 0 0 2.22 4.96c.64.55.93 1.45.92 2.3v1a8.5 8.5 0 0 0 1.25.1c4.68-.3 8.35-4.22 8.11-8.91C18.78 4.25 15.68 2 12 2z"></path></svg>',
		'facebook'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>',
		'youtube'   => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>',
		'tiktok'    => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>',
		'x'         => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4l11.733 16h4.267l-11.733 -16z"></path><path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"></path></svg>',
	);

	return isset( $svgs[ $network ] ) ? $svgs[ $network ] : ucfirst( $network );
}

/**
 * Basic time string parser to ISO 8601 duration (PT15M) for schema
 * Note: Highly basic. Looks for numbers and 'm', 'h' logic.
 */
function recipe_magazine_parse_time_schema( $time_string ) {
	$time_string = strtolower( trim( $time_string ) );
	if ( empty( $time_string ) ) return '';

	$hours = 0;
	$minutes = 0;

	// Extract hours
	if ( preg_match( '/(\d+)\s*(h|hr|hour)/', $time_string, $matches ) ) {
		$hours = (int) $matches[1];
	}
	// Extract minutes
	if ( preg_match( '/(\d+)\s*(m|min)/', $time_string, $matches ) ) {
		$minutes = (int) $matches[1];
	}

	if ( $hours === 0 && $minutes === 0 ) {
		// If basic parsing failed, return raw so it's not totally lost, though invalid ISO
		return $time_string;
	}

	$iso = 'PT';
	if ( $hours > 0 ) $iso .= $hours . 'H';
	if ( $minutes > 0 ) $iso .= $minutes . 'M';

	return $iso;
}
