(function($) {

	"use strict";

	// hide post navigation on scroll to footer.
	if ( $( '.site-footer' ).length ) {
		$( '.navigation-single' ).hideNavigation( '.site-footer' );
	} else if ( $( '.elementor-location-footer' ).length ) {
		$( '.navigation-single' ).hideNavigation( '.elementor-location-footer' );
	}

	// hide product navigation on scroll to footer.
	if ( $( '.woocommerce-tabs + *' ).length ) {
		$( '.navigation-product' ).hideNavigation( '.woocommerce-tabs + *' );
	} else if ( $( '.site-footer' ).length ) {
		$( '.navigation-product' ).hideNavigation( '.site-footer' );
	} else if ( $( '.elementor-location-footer' ).length ) {
		$( '.navigation-product' ).hideNavigation( '.elementor-location-footer' );
	}

})( jQuery );
