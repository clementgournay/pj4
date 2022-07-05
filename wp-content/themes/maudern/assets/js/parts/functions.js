(function($) {

	"use strict";

	var MutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;
	$.fn.attrChange      = function(callback) {
		if (MutationObserver) {
			var options = {
				subtree: false,
				attributes: true
			};

			var observer = new MutationObserver(
				function(mutations) {
					mutations.forEach(
						function(e) {
							callback.call( e.target, e.attributeName );
						}
					);
				}
			);

			return this.each(
				function() {
					observer.observe( this, options );
				}
			);

		}
	}

	$.fn.resizeSelect = function(settings) {
		return this.each(
			function() {

				$( this ).change(
					function(){
						var $this = $( this );

						// create test element.
						var text = $this.find( "option:selected" ).text();

						var $test = $( "<span>" ).html( text ).css(
							{
								"font-size": $this.css( "font-size" ), // ensures same size text.
								"visibility": "hidden" 							 // prevents FOUC.
							}
						);

						// add to body, get width, and get out.
						$test.appendTo( $this.parent() );
						var width = $test.width();
						$test.remove();

						// set select width.
						$this.width( width );

						// run on start.
					}
				).change();
			}
		);
	};

	$.fn.floatingLabels = function(wrapper) {
		return this.each(
			function() {
				if ( $( this ).val() ) {
					$( this ).parents( wrapper ).addClass( 'is-active' );
				}

				if ( $( this ).is( ":-webkit-autofill" ) ) {
					$( this ).parents( wrapper ).addClass( 'is-active' );
				}

				$( this ).on(
					'focusin',
					function() {
						$( this ).parents( wrapper ).addClass( 'is-active' );
					}
				);

				$( this ).on(
					'focusout change paste keyup input',
					function() {
						if ( ! $( this ).val() ) {
							$( this ).parents( wrapper ).removeClass( 'is-active' );
						} else {
							$( this ).parents( wrapper ).addClass( 'is-active' );
						}
					}
				);
			}
		);
	}

	$.fn.isScrolledIntoView = function() {
		var $elem   = this;
		var $window = $( window );

		var docViewTop    = $window.scrollTop();
		var docViewBottom = docViewTop + $window.height();

		var elemTop    = $elem.offset().top;
		var elemBottom = elemTop + $elem.height();

		return ( docViewTop + ( $( window ).height() - 150 ) >= elemTop );
	}

	$.fn.hideNavigation = function( scroll_element ) {
		var navigation = this;

		// hide navigation on scroll to element.
		if ( navigation.length ) {
			$( window ).on(
				'scroll',
				function() {
					if ( $( document ).find( scroll_element ).isScrolledIntoView() ) {
						navigation.addClass( 'fadeOut' );
					} else {
						navigation.removeClass( 'fadeOut' );
					}
				}
			);
		}

		return;
	}

})( jQuery );
