<?php
/**
 * The template for diplaying the footer widgets area
 *
 * @package maudern
 * @version Maudern 1.0
 */

if ( is_active_sidebar( 'footer-widgets' ) ) {
	?>
	<div class="widgets-area flex">
		<?php dynamic_sidebar( 'footer-widgets' ); ?>
	</div>
	<?php
}
?>
