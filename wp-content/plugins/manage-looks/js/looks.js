jQuery(function ($) {

    var that = this;
    that.rootURL = $('.looks').attr('data-root-url');
    that.modals = {};
    that.look = {};
    
    that.init = function () {
        that.update();
        that.createModals();
        that.searchEvents();
        that.lookEvents();
    }

    that.searchEvents = function () {
        $('.search input').on('input', function (e) {
            var val = $(this).val();
            if (val.length > 0) {
                $('.looks .look').hide();
                $('.looks .look:contains(' + val + ')').show();
                $('.looks .look:contains(' + val.toUpperCase() + ')').show();
                $('.looks .look:contains(' + val.toLowerCase() + ')').show();
            } else {
                $('.looks .look').show();
            }
            that.update();
        });
    }

    that.update = function () {
        if ($('.looks').length > 0) {
            if ($('.looks .look:visible').length === 0) {
                $('.no-result').show();
            } else {
                $('.no-result').hide();
            }
        }
    }

    that.createModals = function () {
        that.modals.confirmValidation = new Modal({
            selector: '#confirm-validation'
        });
        that.modals.confirmRemove = new Modal({
            selector: '#confirm-removal'
        });
        that.modals.confirmRemove.reset();
        that.modals.confirmRemove.addButton('Oui', function ($btn) {
            var lookID = that.modals.confirmRemove.data['lookID'];
            var $look = $('.looks .look[data-id="' + lookID + '"]');

            if (!$btn.hasClass('in-progress')) {
                $btn.prop('disabled', true);
                $btn.css('opacity', 0.5);
                $btn.addClass('in-progress');
                $.ajax({
                    url: that.rootURL + 'includes/remove-look.php',
                    method: 'POST',
                    data: {
                        id: lookID
                    },
                    dataType: 'json',
                    success: function () {
                        $look.remove();
                        that.update();
                        that.modals.confirmRemove.close();
                    },
                    error: function (xhr, statusText) {
                        alert('Une erreur est survenue, veuillez réessayer.');
                        console.error(statusText);
                    },
                    complete: function () {
                        $look.removeClass('in-progress');
                        $btn.prop('disabled', false);
                        $btn.css('opacity', 1);
                    }
                })
            }
        });


        that.modals.confirmValidation.reset();
        that.modals.confirmValidation.addButton('Oui', function ($btn) {
            var lookID = that.modals.confirmValidation.data['lookID'];
            var $look = $('.looks .look[data-id="' + lookID + '"]');

            if (!$btn.hasClass('in-progress')) {
                $btn.prop('disabled', true);
                $btn.css('opacity', 0.5);
                $btn.addClass('in-progress');
                $.ajax({
                    url: that.rootURL + 'includes/validate-look.php',
                    method: 'POST',
                    data: {
                        id: lookID
                    },
                    dataType: 'json',
                    success: function () {
                        $look.remove();
                        that.update();
                        that.modals.confirmValidation.close();
                    },
                    error: function (xhr, statusText) {
                        alert('Une erreur est survenue, veuillez réessayer.');
                        console.error(statusText);
                    },
                    complete: function () {
                        $look.removeClass('in-progress');
                        $btn.prop('disabled', false);
                        $btn.css('opacity', 1);
                    }
                })
            }
        });
    }

    that.lookEvents = function () {

            $('.look .remove').on('click', function (e) {
                e.preventDefault();
                var $look = $(this).parents('.look');
                that.modals.confirmRemove.setData('lookID', $look.attr('data-id'));
                that.modals.confirmRemove.open($look);
            });

            $('.look .validation').on('click', function (e) {
                e.preventDefault();
                var $look = $(this).parents('.look');
                that.modals.confirmValidation.setData('lookID', $look.attr('data-id'));
                that.modals.confirmValidation.open($look);
            });

    }


    that.init();

});