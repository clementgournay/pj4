<?php
/**
 * The template for diplaying the footer image
 *
 * @package maudern
 * @version Maudern 1.0
 */

$footer_image = Maudern::get_attachment_url( Maudern_Customize::get_option( 'footer_image' ) );

if ( ! empty( $footer_image ) && wp_http_validate_url( $footer_image ) ) {
	?>
	<div class="footer-element footer-image flex-1 flex items-center justify-center">
		<img src="<?php echo esc_url( $footer_image ); ?>" alt="<?php echo esc_attr__( 'Footer Image', 'maudern' ); ?>" />
	</div>
	<?php
}
?>
