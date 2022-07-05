(function($) {

	"use strict";

	// comments.
	$( '.comment-form-comment textarea, .comment-form-author input, .comment-form-email input, .comment-form-url input' ).floatingLabels( 'p' );

	// checkout.
	$( 'form.woocommerce-form-login input, form.woocommerce-checkout input, form.woocommerce-checkout select, form.woocommerce-checkout textarea, .comment-form-comment textarea' ).floatingLabels( '.form-row' );

	// my account addresses.
	$( '.woocommerce-MyAccount-content form .woocommerce-address-fields input, .woocommerce-MyAccount-content form .woocommerce-address-fields select, .woocommerce-MyAccount-content form .woocommerce-address-fields textarea' ).floatingLabels( '.form-row' );

	// my account edit account.
	$( '.woocommerce-MyAccount-content form.edit-account input, .woocommerce-MyAccount-content form.edit-account select, .woocommerce-MyAccount-content form.edit-account textarea' ).floatingLabels( '.form-row' );

	// product page reviews.
	$( '#reviews.woocommerce-Reviews #review_form_wrapper #review_form .comment-respond form.comment-form p.comment-form-comment textarea, #reviews.woocommerce-Reviews #review_form_wrapper #review_form .comment-respond form.comment-form p input[type="text"]' ).floatingLabels( 'p' );

	// login forms.
	// 100ms delay to fix autofill issue.
	setTimeout(
		function() {
			$( '.woocommerce #customer_login .woocommerce-form .input-text' ).floatingLabels( 'p' );
		},
		100
	);

	// lost/reset password forms.
	$( '.woocommerce-login-form-wrapper .lost_reset_password p.woocommerce-form-row .input-text' ).floatingLabels( 'p' );

})( jQuery );
