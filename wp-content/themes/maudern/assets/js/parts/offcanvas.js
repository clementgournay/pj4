(function($) {

	"use strict";

	// open comments.
	$( document ).on(
		'click touch',
		'.post-comment-link .comment-icon',
		function(){

			$( 'html, body' ).addClass( 'noscroll' );
			$( '.offcanvas.offcanvas-comments' ).addClass( 'open' );
			$( '.overlay' ).addClass( 'visible right' ).removeClass( 'delay' );
		}
	);

	// open mobile menu.
	$( document ).on(
		'click touch',
		'#site-header ul.mobile-menu #mobile-menu-tool .menu-icon',
		function(){

			$( 'html, body' ).addClass( 'noscroll' );
			$( '.offcanvas.offcanvas-mobile-menu' ).addClass( 'open' );
			$( '.overlay' ).addClass( 'visible left' ).removeClass( 'delay' );
		}
	);

	// open minicart.
	$( document ).on(
		'click touch',
		'#site-header #secondary-menu-wrapper ul#menu-site-tools > li#shopping-bag-site-tool',
		function(){
			$( 'html, body' ).addClass( 'noscroll' );

			if ( $( document ).find( '#site-header' ).hasClass( 'search-open' ) ) {
				// close search form.
				$( '#site-header #secondary-menu-wrapper ul#menu-site-tools > li#search-site-tool' ).removeClass( 'active' );
				$( '.overlay' ).removeClass( 'visible' );

				setTimeout(
					function() {
						$( '#site-header' ).removeClass( 'search-open' );
					},
					200
				);

				setTimeout(
					function() {
						$( '.offcanvas.offcanvas-minicart' ).addClass( 'open' );
						$( '.overlay' ).addClass( 'visible right' );
					},
					800
				);
			} else {
				$( '.offcanvas.offcanvas-minicart' ).addClass( 'open' );
				$( '.overlay' ).addClass( 'visible right' ).removeClass( 'delay' );
			}
		}
	);

	$( document.body ).on(
		'added_to_cart',
		function(){
			$( '#site-header #secondary-menu-wrapper ul#menu-site-tools > li#shopping-bag-site-tool' ).trigger( 'click' );
		}
	);

	// close offcanvas.
	$( document ).on(
		'click touch',
		'.overlay, .offcanvas-close',
		function(){

			$( 'html, body' ).removeClass( 'noscroll' );
			$( '.offcanvas' ).removeClass( 'open' );
			$( '.overlay' ).removeClass( 'visible right left' ).addClass( 'delay' );
		}
	);

	// close offcanvas on link click.
	$( document ).on(
		'click touch',
		'.offcanvas a',
		function(){
			// check for internal links.
			if ( ! $( this ).attr( 'href' ).startsWith( '#' ) &&
			! $( this ).attr( 'href' ).startsWith( '/' ) &&
			! $( this ).attr( 'href' ).startsWith( './' ) &&
			! $( this ).attr( 'href' ).startsWith( '../' ) &&
			! $( this ).attr( 'href' ).startsWith( $( location ).attr( "href" ) ) &&
			! $( this ).hasClass( 'remove' ) ) {

				// hide offcanvas.
				$( '.offcanvas' ).hide();
				// hide overlay.
				$( '.overlay' ).hide();
			}
		}
	);

})( jQuery );
