!function(e){"use strict";e(document).on("click",".maudern-notice .notice-dismiss",function(){e.ajax({type:"POST",url:ajaxurl,data:{nonce:maudern_admin.nonce,action:"dismiss_notice"},dataType:"json"})})}(jQuery),function(n,t){"use strict";n&&t(function(){t(document).on("click",".maudern-install-now",function(e){var a=t(e.target);if(a.hasClass("activate-now"))return!0;e.preventDefault(),a.hasClass("updating-message")||a.hasClass("button-disabled")||(n.updates.shouldRequestFilesystemCredentials&&!n.updates.ajaxLocked&&(n.updates.requestFilesystemCredentials(e),t(document).on("credential-modal-cancel",function(){t(".maudern-install-now.updating-message").removeClass("updating-message").text(n.updates.l10n.installNow),n.a11y.speak(n.updates.l10n.updateCancel,"polite")})),n.updates.installPlugin({slug:a.data("slug")}))})})}(window.wp,jQuery);


jQuery(function ($) {

    var that = this;


    that.init = function () {
        that.menuEvents();
    }

    that.menuEvents = function () {
        $('#toggle-admin-menu').on('click', function () {
            $('#wp-admin-bar-menu-toggle').click();
            $('body').toggleClass('admin-menu-open');
        });
    }

    that.init();
});