(function($) {

	"use strict";

	// Dismiss starter content notice.
	$( document ).on(
		'click',
		'.maudern-notice .notice-dismiss',
		function () {
			$.ajax(
				{
					type: 'POST',
					url: ajaxurl,
					data: {
						nonce: maudern_admin.nonce,
						action: 'dismiss_notice',
					},
					dataType: 'json',
				}
			);
		}
	);

})( jQuery );
