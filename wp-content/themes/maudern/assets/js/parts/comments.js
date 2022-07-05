(function($) {

	"use strict";

	// comments pagination.
	$( document ).on(
		'click touch',
		'.offcanvas-comments .comments-pagination.pagination .nav-links a.page-numbers',
		function(e) {
			e.preventDefault();
			e.stopPropagation();

			var href      = $( this ).attr( 'href' );
			var offcanvas = $( document ).find( '.offcanvas-comments' );

			offcanvas.addClass( 'loading' );
			setTimeout(
				function() {
					offcanvas.animate(
						{
							scrollTop: offcanvas.offset().top
						},
						500
					);
				},
				10
			);

			$.get(
				href,
				function(response) {
					setTimeout(
						function() {
							offcanvas.html( $( response ).find( '.offcanvas-comments' ).html() );
							offcanvas.removeClass( 'loading' );
						},
						501
					);
				}
			);
		}
	);

	// comments submit refresh.
	$( document ).on(
		'submit',
		'.offcanvas-comments .comment-respond form#commentform',
		function(e) {
			e.preventDefault();
			e.stopPropagation()

			var formData  = $( this ).serialize();
			var action    = $( this ).attr( 'action' );
			var offcanvas = $( document ).find( '.offcanvas-comments' );

			offcanvas.addClass( 'loading' );

			$.post( action, formData )
			.success(
				function(response) {
					setTimeout(
						function() {
							offcanvas.html( $( response ).find( '.offcanvas-comments' ).html() );
							$( document ).find( '.entry-header .post-comment-link span.bold' ).html( $( response ).find( '.entry-header .post-comment-link span.bold' ).html() );
							offcanvas.removeClass( 'loading' );
						},
						20
					);
					$.get( window.location.href, function() {} );
				}
			)
			.fail(
				function(response) {
					offcanvas.find( '.comment-respond' ).prepend( $( response.responseText )[11].innerText );
					offcanvas.removeClass( 'loading' );
				}
			);
		}
	);

})( jQuery );
