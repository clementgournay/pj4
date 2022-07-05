<?php

class GonThemes_Social_Link_Widget extends WP_Widget {

	function __construct() {
		parent::__construct( 'social_link_widget', __( 'GonThemes: Social Link', 'cosmeli' ), array( 'description' => esc_html__( 'Display a list of social links', 'cosmeli' ), ) );
	}

	// Creating widget frontend
	public function widget( $args, $instance ) {
		?>
		<div class="social-link">
			<ul>

				<?php
				if ( isset($instance['facebook']) && $instance['facebook'] != '' ) {
					echo '<li>';
					echo '<a href="' . esc_url( $instance['facebook'] ) . '"><i class="fa fa-facebook fa-lg"></i></a>';
					echo '</li>';
				}

				if ( isset($instance['twitter']) && $instance['twitter'] != '' ) {
					echo '<li>';
					echo '<a href="' . esc_url( $instance['twitter'] ) . '"><i class="fa fa-twitter fa-lg"></i></a>';
					echo '</li>';
				}

				if ( isset($instance['skype']) && $instance['skype'] != '' ) {
					echo '<li>';
					echo '<a href="' . ( $instance['skype'] ) . '"><i class="fa fa-skype fa-lg"></i></a>';
					echo '</li>';
				}

				if ( isset($instance['pinterest']) && $instance['pinterest'] != '' ) {
					echo '<li>';
					echo '<a href="' . esc_url( $instance['pinterest'] ) . '"><i class="fa fa-pinterest fa-lg"></i></a>';
					echo '</li>';
				}

				if ( isset($instance['google']) && $instance['google'] != '' ) {
					echo '<li>';
					echo '<a href="' . esc_url( $instance['google'] ) . '"><i class="fa fa-google-plus fa-lg"></i></a>';
					echo '</li>';
				}

				if ( isset($instance['tumblr']) && $instance['tumblr'] != '' ) {
					echo '<li>';
					echo '<a href="' . esc_url( $instance['tumblr'] ) . '"><i class="fa fa-tumblr fa-lg"></i></a>';
					echo '</li>';
				}

				if ( isset($instance['linkedin']) && $instance['linkedin'] != '' ) {
					echo '<li>';
					echo '<a href="' . esc_url( $instance['linkedin'] ) . '"><i class="fa fa-linkedin fa-lg"></i></a>';
					echo '</li>';
				}

				if ( isset($instance['rss']) && $instance['rss'] != '' ) {
					echo '<li>';
					echo '<a href="' . esc_url( $instance['rss'] ) . '"><i class="fa fa-rss fa-lg"></i></a>';
					echo '</li>';
				}

				if ( isset($instance['instagram']) && $instance['instagram'] != '' ) {
					echo '<li>';
					echo '<a href="' . esc_url( $instance['instagram'] ) . '"><i class="fa fa-instagram fa-lg"></i></a>';
					echo '</li>';
				}

				if ( isset($instance['youtube']) && $instance['youtube'] != '' ) {
					echo '<li>';
					echo '<a href="' . esc_url( $instance['youtube'] ) . '"><i class="fa fa-youtube fa-lg"></i></a>';
					echo '</li>';
				}
				?>
			</ul>
		</div>

		<?php
	}

	// Widget Backend
	public function form( $instance ) {
		if ( isset( $instance['facebook'] ) ) {
			$facebook = $instance['facebook'];
		} else {
			$facebook = '';
		}

		if ( isset( $instance['twitter'] ) ) {
			$twitter = $instance['twitter'];
		} else {
			$twitter = '';
		}

		if ( isset( $instance['skype'] ) ) {
			$skype = $instance['skype'];
		} else {
			$skype = '';
		}

		if ( isset( $instance['pinterest'] ) ) {
			$pinterest = $instance['pinterest'];
		} else {
			$pinterest = '';
		}

		if ( isset( $instance['google'] ) ) {
			$google = $instance['google'];
		} else {
			$google = '';
		}

		if ( isset( $instance['tumblr'] ) ) {
			$tumblr = $instance['tumblr'];
		} else {
			$tumblr = '';
		}

		if ( isset( $instance['linkedin'] ) ) {
			$linkedin = $instance['linkedin'];
		} else {
			$linkedin = '';
		}

		if ( isset( $instance['rss'] ) ) {
			$rss = $instance['rss'];
		} else {
			$rss = '';
		}

		if ( isset( $instance['instagram'] ) ) {
			$instagram = $instance['instagram'];
		} else {
			$instagram = '';
		}

		if ( isset( $instance['youtube'] ) ) {
			$youtube = $instance['youtube'];
		} else {
			$youtube = '';
		}

		// Widget admin form
		?>
		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>"><?php esc_html_e( 'Facebook URL:', 'cosmeli' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $facebook ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>"><?php esc_html_e( 'Twitter URL:', 'cosmeli' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $twitter ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'skype' ) ); ?>"><?php esc_html_e( 'Skype URL:', 'cosmeli' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'skype' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'skype' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $skype ); ?>" />
		</p>
		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>"><?php esc_html_e( 'Pinterest URL:', 'cosmeli' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'pinterest' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $pinterest ); ?>" />
		</p>
		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'google' ) ); ?>"><?php esc_html_e( 'Google Plus URL:', 'cosmeli' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'google' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'google' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $google ); ?>" />
		</p>
		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'tumblr' ) ); ?>"><?php esc_html_e( 'Tumblr URL:', 'cosmeli' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tumblr' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'tumblr' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $tumblr ); ?>" />
		</p>
		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>"><?php esc_html_e( 'Linkedin URL:', 'cosmeli' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'linkedin' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $linkedin ); ?>" />
		</p>
		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'rss' ) ); ?>"><?php esc_html_e( 'RSS URL:', 'cosmeli' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'rss' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'rss' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $rss ); ?>" />
		</p>
		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>"><?php esc_html_e( 'Instagram URL:', 'cosmeli' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $instagram ); ?>" />
		</p>
		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>"><?php esc_html_e( 'Youtube URL:', 'cosmeli' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $youtube ); ?>" />
		</p>
		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance              = array();
		$instance['facebook']  = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
		$instance['twitter']   = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
		$instance['skype']     = ( ! empty( $new_instance['skype'] ) ) ? strip_tags( $new_instance['skype'] ) : '';
		$instance['pinterest'] = ( ! empty( $new_instance['pinterest'] ) ) ? strip_tags( $new_instance['pinterest'] ) : '';
		$instance['google'] = ( ! empty( $new_instance['google'] ) ) ? strip_tags( $new_instance['google'] ) : '';
		$instance['tumblr'] = ( ! empty( $new_instance['tumblr'] ) ) ? strip_tags( $new_instance['tumblr'] ) : '';
		$instance['linkedin'] = ( ! empty( $new_instance['linkedin'] ) ) ? strip_tags( $new_instance['linkedin'] ) : '';
		$instance['rss'] = ( ! empty( $new_instance['rss'] ) ) ? strip_tags( $new_instance['rss'] ) : '';
		$instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? strip_tags( $new_instance['instagram'] ) : '';
		$instance['youtube'] = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';

		return $instance;
	}
}

// Register and load the widget
function social_link_load_widget() {
	register_widget( 'GonThemes_Social_Link_Widget' );
}

add_action( 'widgets_init', 'social_link_load_widget' );