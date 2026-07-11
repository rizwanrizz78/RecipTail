<?php
/**
 * Template part for displaying a single recipe / post
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class( 'afc-article' ); ?>>

	<!-- Title -->
	<div class="afc-hero">
		<?php the_title( '<h1>', '</h1>' ); ?>
		<?php
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="afc-eyebrow">' . esc_html( strtoupper( $categories[0]->name ) ) . '</a>';
		}
		?>
	</div>

	<!-- The core content, fully driven by native blocks and [rt_*] shortcodes -->
	<div class="entry-content">
		<?php
		$content = get_the_content();
		$content = apply_filters( 'the_content', $content );

		// We need to inject the featured image directly after the top disclosure shortcode,
		// because the user types [rt_eyebrow] -> [rt_dek] -> [rt_disclosure position="top"].
		// We remove the featured image from the top of the post and place it inside the content instead.

		if ( has_post_thumbnail() ) {
			$img_html = '<div class="afc-featured-image">' . get_the_post_thumbnail( null, 'full', array( 'loading' => 'lazy' ) ) . '</div>';
			// Look for the end of the top disclosure paragraph in the processed output
			$pattern = '/(<p class="afc-disclosure-top">.*?<\/p>)/s';
			if ( preg_match( $pattern, $content, $matches ) ) {
				// Use str_replace instead of preg_replace to avoid backreference risks (e.g. if $img_html contains "$1")
				$content = str_replace( $matches[1], $matches[1] . $img_html, $content );
			} else {
				// Fallback if disclosure isn't found
				echo $img_html;
			}
		}

		echo $content;

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'recipe-magazine' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

</div><!-- .afc-article -->
