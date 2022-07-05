(function($) {

	"use strict";

	function findMinicartImageLinks() {
		setTimeout(
			function() {
				$( document ).find( '.widget_shopping_cart a' ).each(
					function() {
						if ( $( this ).find( 'img' ).length || $( this ).hasClass( 'button' ) || $( this ).hasClass( 'wp-block-button__link' ) || $( this ).hasClass( 'wp-block-file__button' ) ) {
							  $( this ).addClass( 'no-underline' );
							  $( this ).wrapInner( '<span></span>' );
						}
					}
				);
			},
			500
		);
	}

	// Product Page - Vertical Thumbs Gallery.
	$( '.woocommerce.single-product .site-main div.product .product-summary .woocommerce-product-gallery' ).on(
		'wc-product-gallery-before-init',
		function() {
			var gallery = $( '.woocommerce.single-product .site-main div.product .product-summary .woocommerce-product-gallery' );

			if ( gallery.find( '.woocommerce-product-gallery__image' ).length > 1 ) {
				gallery.find( '.woocommerce-product-gallery__wrapper' ).addClass( 'with-thumbs' );
			}
		}
	);

	// Product Page - Vertical Thumbs Gallery.
	$( '.woocommerce.single-product .site-main div.product .product-summary .woocommerce-product-gallery' ).on(
		'wc-product-gallery-after-init',
		function() {
			var gallery = $( '.woocommerce.single-product .site-main div.product .product-summary .woocommerce-product-gallery' );

			gallery.find( '.flex-viewport' ).attrChange(
				function(attrName) {
					if ( 'style' === attrName ) {
						gallery.css( 'height', gallery.find( '.flex-viewport' ).css( 'height' ) );
					}
				}
			);

			if ( gallery.find( '.flex-control-thumbs' ).length ) {

				setTimeout(
					function() {

						gallery.find( '.flex-control-thumbs' ).animate(
							{
								scrollTop: gallery.find( '.flex-control-thumbs' ).scrollTop() + gallery.find( '.flex-control-thumbs .flex-active' ).position().top
							},
							400
						);

						gallery.find( '.woocommerce-product-gallery__image' ).attrChange(
							function(attrName) {
								if ( 'class' === attrName ) {
									gallery.find( '.flex-control-thumbs' ).animate(
										{
											scrollTop: gallery.find( '.flex-control-thumbs' ).scrollTop() + gallery.find( '.flex-control-thumbs .flex-active' ).position().top
										},
										400
									);
								}
							}
						);

					},
					300
				);
			}
		}
	);

	// Product Page - Add to cart button width.
	$( '.woocommerce .site-main div.product .product-summary .summary form.cart button.button' ).css( 'width', 'calc( 100% - 1.25rem - ' + $( '.woocommerce .site-main div.product .product-summary .summary form.cart .quantity' ).outerWidth() + 'px )' );

	// Product Page - scroll to reviews tab.
	$( '.woocommerce .product-summary .woocommerce-product-rating .star-rating' ).off( 'click' ).on(
		'click touch',
		function() {
			$( '.woocommerce-tabs ul.tabs li.reviews_tab a' ).trigger( 'click' );

			var tab_reviews_topPos = $( '.woocommerce-tabs' ).offset().top;
			if ( $( 'body' ).hasClass( 'admin-bar' ) ) {
				tab_reviews_topPos -= 32;
			}

			$( 'html, body' ).animate(
				{
					scrollTop: tab_reviews_topPos
				},
				1000
			);
		}
	);

	// Product Page - Tabs animation.
	$( '.single-product .woocommerce-tabs ul.tabs li a' ).off( 'click' ).on(
		'click touch',
		function(){
			var currentPanel = $( this ).attr( 'href' );

			$( this ).parent().siblings().removeClass( 'active' ).end().addClass( 'active' );

			if ( $( '.single-product .woocommerce-tabs' ).find( currentPanel ).siblings( '.panel' ).filter( ':visible' ).length ) {
				$( '.single-product .woocommerce-tabs' ).find( currentPanel ).siblings( '.panel' ).filter( ':visible' ).fadeOut(
					500,
					function() {
						$( '.single-product .woocommerce-tabs' ).find( currentPanel ).fadeIn( 500 );
					}
				);
			} else {
				$( '.single-product .woocommerce-tabs' ).find( currentPanel ).fadeIn( 500 );
			}

			return false;
		}
	);

	// Product Archives - open/close filters area.

	// get area height, then hide it.
	var filters_height = $( '.woocommerce .woocommerce-filters-area' ).height();
	$( '.woocommerce .woocommerce-filters-area' ).addClass( 'close' );

	$( '.woocommerce .woocommerce-product-filters span.filters-toggle' ).on(
		'click touch',
		function(){
			$( '.woocommerce .woocommerce-filters-area' ).toggleClass( 'close open' );

			if ( $( '.woocommerce .woocommerce-filters-area' ).hasClass( 'open' ) ) {
				$( '.woocommerce .woocommerce-filters-area' ).css( 'max-height', filters_height );
			} else {
				$( '.woocommerce .woocommerce-filters-area' ).css( 'max-height', '' );
			}
		}
	);

	// Product Archives - set product loop ordering select width based on the selected option.
	$( ".woocommerce .woocommerce-product-filters form.woocommerce-ordering select" ).resizeSelect();

	$( window ).on(
		'load',
		function() {
			$( ".wp-block-woocommerce-all-products .wc-block-sort-select .wc-block-sort-select__select" ).resizeSelect();
		}
	);

	// My Account - detect my account dashboard page.
	if ( $( '.woocommerce-account .woocommerce-MyAccount-navigation ul li.woocommerce-MyAccount-navigation-link--dashboard' ).hasClass( 'is-active' ) ) {
		$( '.woocommerce-account' ).addClass( 'woocommerce-myaccount-dashboard' );
	}

	// Minicart - fix link hovers for minicart image links.
	$( window ).on(
		'load',
		function () {
			findMinicartImageLinks();
		}
	);

	// Minicart - recheck image links on cart update.
	$( document ).on(
		'added_to_cart removed_from_cart',
		function() {
			findMinicartImageLinks();
		}
	);

	// My Account - alignment fix.
	if ( $( 'body.woocommerce-account .woocommerce-login-form-wrapper' ).length ) {
		$( 'body.woocommerce-account .entry-content > .woocommerce > .woocommerce-notices-wrapper' ).addClass( 'login-notices' );
	}

	// Product Card - Sale Badge position fix - HookMeUp compatibility.
	if ( $( 'ul.products li.product #woocommerce_before_shop_loop_item' ).length ) {
		if ( $( window ).width() >= 768 ) {
			$( '.woocommerce ul.products li.product .onsale' ).css( 'top', 'calc( ' + $( 'ul.products li.product #woocommerce_before_shop_loop_item' ).outerHeight() + 'px + 1.25rem + 20px )' );
		} else {
			$( '.woocommerce ul.products li.product .onsale' ).css( 'top', 'calc( ' + $( 'ul.products li.product #woocommerce_before_shop_loop_item' ).outerHeight() + 'px + 1.25rem + 10px )' );
		}
	}

})( jQuery );
