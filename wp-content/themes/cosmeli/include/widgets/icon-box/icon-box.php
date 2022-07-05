<?php

class GonThemes_Icon_Box_Widget extends WP_Widget {

	function __construct() {
		parent::__construct( 'icon_box_widget', __( 'GonThemes: Icon Box', 'cosmeli' ), array( 'description' => esc_html__( 'Display a icon box', 'cosmeli' ), ) );
	}
	// Creating widget frontend
	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$description = ! empty( $instance['description'] ) ? $instance['description'] : '';
		
		$type = ! empty( $instance['type'] ) ? $instance['type'] : 'font_awesome';
		$icon = ! empty( $instance['icon'] ) ? $instance['icon'] : 'fa-home';
		$instance['image_uri'] = ! empty( $instance['image_uri'] ) ? $instance['image_uri'] : '';
		$class_widget = ! empty( $instance['widget-class'] ) ? $instance['widget-class'] : '';
		?>
		<div class="<?php echo esc_attr($class_widget); ?> icon-box-widget">
			<div class="icon-box">
				<?php
				if($type == 'font_awesome') {
					echo '<div class="image-block"><i class="fa '.$icon.'" style="font-family: FontAwesome"></i></div>';
				} else if ($type == 'simple_line_icons') {
					echo '<div class="image-block"><i class="'.$icon.' icons" style="font-family: Simple-line-icons"></i></div>';
				} else if ($type == 'image') {
					echo '<div class="image-block"><img src="'. $instance['image_uri'] .'" /></div>';
				}
				?>
				<h3><?php echo esc_html($title); ?></h3>
				<p class="des"><?php echo esc_html($description); ?></p>
			</div>
		</div>
		<?php
	}
	// Widget Backend
	public function form( $instance ) {
		$instance['title'] = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$instance['description'] = ! empty( $instance['description'] ) ? $instance['description'] : '';
		$instance['type'] = ! empty( $instance['type'] ) ? $instance['type'] : 'font_awesome';
		$instance['icon'] = ! empty( $instance['icon'] ) ? $instance['icon'] : 'fa-home';
		$instance['image_uri'] = ! empty( $instance['image_uri'] ) ? $instance['image_uri'] : '';
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo esc_html__('Title', 'cosmeli'); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"><?php echo esc_html__('Description', 'cosmeli'); ?></label><br />
			<textarea rows="4" cols="5" name="<?php echo $this->get_field_name('description'); ?>" id="<?php echo $this->get_field_id('description'); ?>" class="widefat"><?php echo esc_textarea( $instance['description'] ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_html__( 'Type:', 'cosmeli' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" class="widefat">
				<option value="font_awesome"<?php selected( $instance['type'], 'font_awesome' ); ?>><?php echo esc_html__('Font Awesome', 'cosmeli'); ?></option>
				<option value="simple_line_icons"<?php selected( $instance['type'], 'simple_line_icons' ); ?>><?php echo esc_html__('Simple Line Icons', 'cosmeli'); ?></option>
				<option value="image"<?php selected( $instance['type'], 'image' ); ?>><?php echo esc_html__( 'Image', 'cosmeli' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('icon'); ?>"><?php echo esc_html__('Icon', 'cosmeli'); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name('icon'); ?>" id="<?php echo $this->get_field_id('icon'); ?>" value="<?php echo $instance['icon']; ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php echo esc_html__('Image', 'cosmeli'); ?></label><br />

			<?php
				if ( $instance['image_uri'] != '' ) :
					echo '<img class="custom_media_image" src="' . $instance['image_uri'] . '" style="margin:0;padding:0;max-width:100px;float:left;display:inline-block" /><br />';
				endif;
			?>

			<input type="text" class="widefat custom_media_url" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $instance['image_uri']; ?>" style="margin-top:5px;">

			<input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo $this->get_field_name('image_uri'); ?>" value="Upload Image" style="margin-top:5px;" />
		</p>
		<?php
	}

	// Updating widget replacing old instances with new
	function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
		$instance['icon'] = strip_tags( $new_instance['icon'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['description'] = $new_instance['description'];
		} else {
			$instance['description'] = wp_kses_post( $new_instance['description'] );
		}
		if ( in_array( $new_instance['type'], array( 'font_awesome', 'simple_line_icons', 'image' ) ) ) {
			$instance['type'] = $new_instance['type'];
		} else {
			$instance['type'] = 'font_awesome';
		}
        $instance['image_uri'] = strip_tags( $new_instance['image_uri'] );
        return $instance;
    }
}

// Register and load the widget
function icon_box_load_widget() {
	register_widget( 'GonThemes_Icon_Box_Widget' );
}

add_action( 'widgets_init', 'icon_box_load_widget' );

add_action('admin_enqueue_scripts', 'icon_box_wdscript');
function icon_box_wdscript() {
    wp_enqueue_media();
    wp_enqueue_script('ads_script', get_template_directory_uri() . '/include/widgets/icon-box/js/icon-box.js', false, '1.0', true);
}