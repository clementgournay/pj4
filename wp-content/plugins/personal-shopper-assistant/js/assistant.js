jQuery(function ($) {

    var that = this;
    
    that.init = function () {
        if ($('#assistant').length > 0) {
            var lookEditor = new LookEditor({
                selector: '#assistant',
                mode: 'assistant'
            });
            lookEditor.init();
        }
    }

    that.init();

});