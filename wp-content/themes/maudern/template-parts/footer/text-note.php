<?php
/**
 * The template for diplaying the footer text note
 *
 * @package maudern
 * @version Maudern 1.0
 */

if ( ! empty( Maudern_Customize::get_option( 'footer_text_note' ) ) ) {
	?>
	<div class="footer-element footer-text-note text-center-xlg-down text-right-xlg-up flex-1">
		<?php
		echo do_shortcode(
			wp_kses( Maudern_Customize::get_option( 'footer_text_note' ), Maudern::get_allowed_html_tags() )
		);
		?>
	</div>
	<?php
}
?>
