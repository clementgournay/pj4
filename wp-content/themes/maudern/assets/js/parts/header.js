(function($) {

	"use strict";

	function setDropdownMaxHeight(dropdown) {
		var dropdown_posTop = $( '#site-header' ).position().top + $( '#site-header' ).outerHeight();
		dropdown.css( 'max-height', $( window ).height() - dropdown_posTop - 100 );
	}

	$( window ).on(
		'load',
		function () {

			if ( $( '#site-header' ).length ) {

				var header_height = $( '#site-header' ).outerHeight();
				header_height    += $( '.woocommerce-store-notice.demo_store' ).length ? $( '.woocommerce-store-notice.demo_store' ).outerHeight() : 0;
				$( '.site-header' ).css( 'height', header_height );

				$( '#site-header #primary-menu-wrapper ul.primary-menu > li.menu-item-has-children' ).on(
					{
						mouseenter: function() {
							var that = $( this );

							// close search form.
							if ( $( '#site-header' ).hasClass( 'search-open' ) ) {
								$( '#site-header #secondary-menu-wrapper ul#menu-site-tools > li#search-site-tool' ).removeClass( 'active' );
								$( '#site-header' ).removeClass( 'search-open' );
							}

							// add delayed class to the other submenus to avoid overlapping when another submenu is opening.
							$( '#site-header #primary-menu-wrapper ul.primary-menu > li.menu-item-has-children' ).each(
								function() {
									if ( ! $( this ).is( that ) ) {
										  $( this ).find( '> ul.sub-menu' ).addClass( 'delayed' );
									}
								}
							);

							// add active class to link to enable underline.
							$( this ).find( '> a' ).addClass( 'active' );

							// set submenu max-height.
							setDropdownMaxHeight( $( this ).find( '> ul.sub-menu' ) );

							// open overlay over content.
							$( '.overlay' ).addClass( 'visible' );
						},
						mouseleave: function() {

							// remove delayed class from submenus.
							setTimeout(
								function() {
									if ( ! $( '#site-header #primary-menu-wrapper ul.primary-menu > li.menu-item-has-children:hover' ).length ) {
										  $( '#site-header #primary-menu-wrapper ul.primary-menu > li.menu-item-has-children > ul.sub-menu' ).removeClass( 'delayed' );
									}
								},
								700
							);

							// remove active class from link.
							$( this ).find( '> a' ).removeClass( 'active' );

							// remove max-height from submenu.
							$( this ).find( '> ul.sub-menu' ).css( 'max-height', '' );

							// hide overlay.
							$( '.overlay' ).removeClass( 'visible' );
						}
					}
				);

				// close dropdown on link click.
				$( '#site-header #primary-menu-wrapper ul.primary-menu > li.menu-item-has-children a' ).on(
					'click touch',
					function() {
						if ( ! $( this ).attr( 'href' ).startsWith( '#' ) ) {
							// remove max-height from submenu.
							$( '#site-header #primary-menu-wrapper ul.primary-menu > li.menu-item-has-children > ul.sub-menu' ).hide();

							// hide overlay.
							$( '.overlay' ).hide();
						}
					}
				);

				$( '#site-header #primary-menu-wrapper ul.primary-menu > li.menu-item-has-children > ul.sub-menu' ).on(
					{
						mouseenter: function() {
							// add active class to link to underline it while on submenu.
							$( this ).siblings( 'a' ).addClass( 'active' );
						},
						mouseleave: function() {
							$( this ).siblings( 'a' ).removeClass( 'active' );
						}
					}
				);

				// search form
				$( '#site-header #secondary-menu-wrapper ul#menu-site-tools > li#search-site-tool .menu-icon' ).on(
					'click touch',
					function() {

						if ( ! $( '#site-header #secondary-menu-wrapper ul#menu-site-tools > li#search-site-tool' ).hasClass( 'active' ) ) {
							// open search form.
							$( '#site-header' ).addClass( 'search-open' );
							$( '#site-header #secondary-menu-wrapper ul#menu-site-tools > li#search-site-tool' ).addClass( 'active' );
							$( '.overlay' ).removeClass( 'delay' ).addClass( 'visible' );

							$( '#site-header #primary-menu-wrapper ul.primary-menu > li.menu-item-has-children > ul.sub-menu' ).each(
								function() {
									$( this ).addClass( 'delayed' );
								}
							);

							setTimeout(
								function() {
									if ( $( document ).find( '#site-header' ).hasClass( 'search-open' ) ) {
										  $( '#site-header #secondary-menu-wrapper ul#menu-site-tools > li#search-site-tool .search-wrapper form input' ).focus();
									}
								},
								900
							);
						} else {
							// close search form.
							$( '#site-header #secondary-menu-wrapper ul#menu-site-tools > li#search-site-tool' ).removeClass( 'active' );
							$( '.overlay' ).removeClass( 'visible' );

							setTimeout(
								function() {
									$( '#site-header' ).removeClass( 'search-open' );
								},
								200
							);
						}
					}
				);

				// close search form.
				$( document ).on(
					'click touch',
					'.overlay',
					function(){
						if ( $( '#site-header' ).hasClass( 'search-open' ) ) {
							$( '#site-header #secondary-menu-wrapper ul#menu-site-tools > li#search-site-tool' ).removeClass( 'active' );

							setTimeout(
								function() {
									$( '#site-header' ).removeClass( 'search-open' );
								},
								200
							);
						}
					}
				);

				// sticky header.
				$( window ).on(
					'scroll',
					function() {
						if ( $( this ).scrollTop() > header_height / 3 ) {
							$( '.site-header-wrapper' ).addClass( 'fixed' );
						} else {
							$( '.site-header-wrapper' ).removeClass( 'fixed' );

							var header_new_height = $( '#site-header' ).outerHeight();
							header_new_height    += $( '.woocommerce-store-notice.demo_store' ).length ? $( '.woocommerce-store-notice.demo_store' ).outerHeight() : 0;
							if ( header_new_height != header_height ) {
								$( '.site-header' ).css( 'height', header_new_height );
							}
						}
					}
				);

				// mobile menu dropdown open/close.
				$( '#mobile-menu-wrapper ul.mobile-menu li.menu-item.menu-item-has-children>.sub-menu-icon' ).on(
					'click touch',
					function(){
						if ( ! $( this ).parent().hasClass( 'active' )) {
							$( this ).parent().addClass( 'active' );
							$( this ).parent().siblings().removeClass( 'active' );
							$( this ).closest( 'li' ).siblings().find( '> .sub-menu:visible' ).slideUp( 700, "swing" );
							$( this ).closest( 'li' ).find( 'ul' ).slideDown( 700, "swing" );
						} else {
							$( this ).parent().removeClass( 'active' );
							$( this ).parent().siblings().removeClass( 'active' );
							$( this ).closest( 'li' ).find( '> .sub-menu' ).slideUp( 700, "swing" );
						}
					}
				);

				// fix slideDown animation jump.
				$( '.site-header-wrapper .offcanvas-mobile-menu #mobile-menu-wrapper ul.mobile-menu > li.menu-item > ul.sub-menu' ).each(
					function() {
						$( this ).css( 'height', $( this ).height() );
						$( this ).hide();
					}
				);

				// mobile menu wrapper max height.
				if( $( '.site-header-wrapper .offcanvas-mobile-menu #mobile-menu-wrapper' ).length && $( '.site-header-wrapper .bottom-fixed' ).length ) {
					$( '.site-header-wrapper .offcanvas-mobile-menu #mobile-menu-wrapper' ).css( 'max-height', $( '.site-header-wrapper .bottom-fixed' ).offset().top - $( '.site-header-wrapper .offcanvas-mobile-menu #mobile-menu-wrapper' ).offset().top );
				}
			}

			// Elementor header fix.
			if ( $( '.elementor-location-header' ).length ) {
				$( '.elementor-location-header' ).css( 'height', $( '.elementor-location-header' ).outerHeight() );
			}
		}
	);

})( jQuery );
