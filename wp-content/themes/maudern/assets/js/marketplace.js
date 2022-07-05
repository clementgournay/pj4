jQuery(function ($) {

    var that = this;

    that.init = function () {
        var editor = new LookEditor({
            selector: '#assistant',
            mode: 'assistant'
        });
        editor.init();

        var scene = $('#lcd')[0];
        new Parallax(scene);
    }

    that.init();
})