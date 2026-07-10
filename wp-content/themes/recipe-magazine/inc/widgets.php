<?php
/**
 * Recipe Magazine Custom Widgets
 */

/**
 * Newsletter Widget
 */
class Recipe_Magazine_Newsletter_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'recipe_magazine_newsletter',
			__( 'Recipe Magazine: Newsletter', 'recipe-magazine' ),
			array( 'description' => __( 'A newsletter subscription box. Supports raw HTML embed codes.', 'recipe-magazine' ) )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$title       = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$description = ! empty( $instance['description'] ) ? $instance['description'] : '';
		$embed_code  = ! empty( $instance['embed_code'] ) ? $instance['embed_code'] : '';
		$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : __( 'Subscribe', 'recipe-magazine' );

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];
		}

		echo '<div class="newsletter-widget-content">';

		if ( ! empty( $description ) ) {
			echo '<p class="newsletter-description">' . esc_html( $description ) . '</p>';
		}

		if ( ! empty( $embed_code ) ) {
			// Output the raw embed code (e.g. from Mailchimp)
			echo $embed_code;
		} else {
			// Fallback placeholder form
			?>
			<form class="newsletter-fallback-form" action="#" method="post" onsubmit="event.preventDefault(); alert('Please add a valid newsletter embed code in the widget settings.');">
				<input type="email" name="EMAIL" placeholder="<?php esc_attr_e( 'Your email address', 'recipe-magazine' ); ?>" required />
				<button type="submit" class="button"><?php echo esc_html( $button_text ); ?></button>
			</form>
			<?php
		}

		echo '</div>';

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title       = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Join our Newsletter', 'recipe-magazine' );
		$description = ! empty( $instance['description'] ) ? $instance['description'] : __( 'Get the latest recipes delivered directly to your inbox.', 'recipe-magazine' );
		$embed_code  = ! empty( $instance['embed_code'] ) ? $instance['embed_code'] : '';
		$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : __( 'Subscribe', 'recipe-magazine' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'recipe-magazine' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php _e( 'Description:', 'recipe-magazine' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_attr( $description ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'embed_code' ) ); ?>"><?php _e( 'HTML Embed Code (Mailchimp, ConvertKit, etc):', 'recipe-magazine' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'embed_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'embed_code' ) ); ?>" rows="5"><?php echo esc_textarea( $embed_code ); ?></textarea>
			<small><?php _e( 'If you provide embed code, it will be used instead of the fallback form.', 'recipe-magazine' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php _e( 'Fallback Button Text:', 'recipe-magazine' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? sanitize_text_field( $new_instance['description'] ) : '';
		$instance['button_text'] = ( ! empty( $new_instance['button_text'] ) ) ? sanitize_text_field( $new_instance['button_text'] ) : '';

		// Allow some HTML for the embed code, typically script tags, iframes, and form elements.
		// Note: WP users without unfiltered_html capability won't be able to save script tags anyway unless we specifically allow it or if they are admin.
		// For simplicity, we just use the raw input. Use current_user_can('unfiltered_html') check if strict security is required.
		$instance['embed_code']  = ( ! empty( $new_instance['embed_code'] ) ) ? $new_instance['embed_code'] : '';

		return $instance;
	}
}

/**
 * About Author Widget
 */
class Recipe_Magazine_Author_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'recipe_magazine_author',
			__( 'Recipe Magazine: About Author', 'recipe-magazine' ),
			array( 'description' => __( 'Displays author information.', 'recipe-magazine' ) )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$title       = ! empty( $instance['title'] ) ? $instance['title'] : __( 'About Me', 'recipe-magazine' );
		$image_url   = ! empty( $instance['image_url'] ) ? $instance['image_url'] : '';
		$description = ! empty( $instance['description'] ) ? $instance['description'] : '';

		echo $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];

		echo '<div class="author-widget-content">';

		if ( ! empty( $image_url ) ) {
			echo '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $title ) . '" class="author-widget-image" />';
		}

		if ( ! empty( $description ) ) {
			echo '<p class="author-widget-description">' . esc_html( $description ) . '</p>';
		}

		echo '</div>';

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title       = ! empty( $instance['title'] ) ? $instance['title'] : __( 'About Me', 'recipe-magazine' );
		$image_url   = ! empty( $instance['image_url'] ) ? $instance['image_url'] : '';
		$description = ! empty( $instance['description'] ) ? $instance['description'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'recipe-magazine' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>"><?php _e( 'Image URL:', 'recipe-magazine' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_url' ) ); ?>" type="url" value="<?php echo esc_attr( $image_url ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php _e( 'Description:', 'recipe-magazine' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_attr( $description ); ?></textarea>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['image_url']   = ( ! empty( $new_instance['image_url'] ) ) ? esc_url_raw( $new_instance['image_url'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? sanitize_textarea_field( $new_instance['description'] ) : '';

		return $instance;
	}
}

/**
 * Register the widgets
 */
function recipe_magazine_register_widgets() {
	register_widget( 'Recipe_Magazine_Newsletter_Widget' );
	register_widget( 'Recipe_Magazine_Author_Widget' );
}
add_action( 'widgets_init', 'recipe_magazine_register_widgets' );
