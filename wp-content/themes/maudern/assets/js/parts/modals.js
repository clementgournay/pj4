function Modal(options) {

    var $ = jQuery;
    var that = this;
    that.selector = options.selector;    
    that.$el = $(that.selector);
    that.data = {};
    that.callback = options.callback;
    that.endpoint = that.$el.attr('data-endpoint');
    that.method = (that.$el.attr('data-method')) ? that.$el.attr('data-method') : 'GET';
    that.inProgress = false;

    that.init = function () {


        that.$el.find('.close').on('click', function() {
            that.close();
        });

        that.$el.on('click', function (e) {
            if ($(e.target).parents('.window').length === 0 && !that.inProgress) {
                that.close();
            }
        });

        that.$el.find('.submit').on('click', function (e) {
            if (!that.inProgress) {
                if (that.endpoint) {
                    that.inProgress = true;
                    $(this).css('opacity', 0.5);
                    $(this).prop('disabled', true);
                    $.ajax({
                        url: that.endpoint,
                        method: that.method,
                        data: that.data,
                        dataType: 'json',
                        success: function (resp) {
                            that.close();
                            if (that.callback) that.callback(resp);
                        }, 
                        error: function (xhr, statusText) {
                            console.log(statusText);
                            alert('Une erreur est survenue, veuillez réessayer.');
                        },
                        complete: function() {
                            that.inProgress  = false;
                            $(this).css('opacity', 1);
                            $(this).prop('disabled', false);
                        }
                    });
                } else {
                    that.close();
                    if (that.callback) that.callback();
                }
            }
        });

        if (options.init) options.init();
    }

    that.open = function() {
        that.$el.show();
        setTimeout(function () {
            that.$el.addClass('open');
        }, 20);
    }

    that.setData = function (key, value, attr, update) {
        if (attr) {
            that.data[key] = {value: value, attr: attr};
        } else {
            that.data[key] = value;
        }
        if (update!==false) that.updateView();
    }

    that.getData = function (key) {
        return that.data[key];
    }

    that.close = function () {
        that.$el.removeClass('open');
        setTimeout(function () {
            that.$el.hide();
        }, 300);
    }

    that.addButton = function (title, action) {
        var $button = $('<button typ="button" class="btn btn-primary additional-btn">' + title + '</button>');
        that.$el.find('.footer').prepend($button);
        $button.on('click', function () {
            if (action) action($button);
        });
    }

    that.updateView = function () {
        for (let key in that.data) {
            if (that.data[key].attr) {
                $('[data-' + key + ']').attr(that.data[key].attr, that.data[key].value);
            } else {
                $('[data-' + key + ']').html(that.data[key]);
            }
        }
    }

    that.startLoading = function () {
        that.$el.addClass('loading');
        that.inProgress = true;
    }

    that.endLoading = function () {
        that.$el.removeClass('loading');
        that.inProgress = false;
    }

    that.reset = function () {
        that.$el.find('.additional-btn').remove();
    }

    that.init();

}