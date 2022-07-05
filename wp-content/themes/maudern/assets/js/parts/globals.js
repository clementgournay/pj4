(function($) {

	"use strict";

	function findImageLinks() {
		$( document ).find( 'a' ).each(
			function() {
				if ( $( this ).find( 'img' ).length || $( this ).hasClass( 'button' ) || $( this ).hasClass( 'wp-block-button__link' ) || $( this ).hasClass( 'wp-block-file__button' ) ) {
					  $( this ).addClass( 'no-underline' );
				}
			}
		);
	}

	// fix link hovers for image links.
	findImageLinks();

	// recheck image links on cart update.
	$( document ).on(
		'updated_cart_totals',
		function() {
			findImageLinks();
		}
	);

	window.addEventListener(
		'beforeunload',
		function (e) {
			$( 'body' ).removeClass( 'fade' );
		}
	);

	$( window ).on(
		'load',
		function () {

			// No margin for last block in page.
			var last_block = $( '.entry-content > [class*=wp-block]:last-child' );
			if ( $( '.entry-content > *:last-child' ).is( last_block ) ) {
				last_block.addClass( 'no-margin-bottom' );
			}

			// Smooth transition between pages.
			$( 'body' ).addClass( 'fade' );
		}
	);

})( jQuery );
