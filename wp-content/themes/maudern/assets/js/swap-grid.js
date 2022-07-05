jQuery.fn.swapGrid = function (options) {
    
    var $ = jQuery;
    var that = {};
    that.$grid = this;
    that.settings = $.extend({
        cellClass: 'cell',
        colClass: 'col'
    }, options);
    that.$cells = that.$grid.find('.' + that.settings.cellClass);
    that.$cols = that.$grid.find('.' + that.settings.colClass);
    that.delays = {};

    that.init = function () {
        that.initGrid();
        that.events();
    }

    that.initGrid = function () {
        that.$grid.css({
            'position': 'relative',
            '-webkit-touch-callout': 'none',
            '-webkit-user-select': 'none',
            '-khtml-user-select': 'none', 
            '-moz-user-select': 'none',
            '-ms-user-select': 'none',
            'user-select': 'none'
        });
        that.$cells.css({
            'position': 'relative',
            '-webkit-transition': 'transform 0.3s ease-out',
            'transition': 'transform 0.3s ease-out'
        });
    }

    that.events = function () {
    
        that.$grid.off('.swapEvent');
        that.$cells.off('.swapEvent');
        that.$cols.off('.swapEvent');

        that.$cells.on('mousedown.swapEvent', function (e) {
            if ($(e.target).closest('a').length === 0 && $(e.target).closest('.slick-list').length === 0) {
                var $this = $(this);
                var initialX = e.pageX - $this.offset().left;
                var initialY = e.pageY - $this.offset().top;
                var $clone = $this.clone().hide().addClass('sg-clone');
                $clone.attr('data-init-x', initialX);
                $clone.attr('data-init-Y', initialY);
                $clone.css({
                    'position': 'absolute',
                    'width': $this.outerWidth(),
                    'height': $this.outerHeight(),
                    'z-index': 10001
                });
                that.$grid.append($clone);

                var $cover = $('<div class="sg-cover"></div>');
                $cover.css({
                    'position': 'absolute',
                    'left': 0,
                    'top': 0,
                    'width': '100%',
                    'height': '100%',
                    'background': '#ecebeb',
                    'border': '2px dashed #bdbdbd',
                    'border-radius': $this.css('border-radius'),
                    'z-index': 10000
                });
                $this.addClass('sg-org').append($cover);

                that.events();
            }
        });

        that.$grid.on('mousemove.swapEvent', function (e) {
            var $clone = that.$grid.find('.sg-clone');
            var $org = that.$grid.find('.sg-org');

            if ($clone.length > 0) {
                $clone.show();
                var initialX = $clone.attr('data-init-x');
                var initialY = $clone.attr('data-init-y');
                var posX = (e.pageX  - that.$grid.offset().left) - initialX;
                var posY = (e.pageY - that.$grid.offset().top) - initialY;
                $clone.css({
                    'left': posX + 'px',
                    'top': posY + 'px'
                });
                

                // Cell hovering detection
                that.$cells.each(function () {
                    var $this = $(this);
                
                    if (!$this.hasClass('sg-org')) {

                        // If hovering cell (but different than original)
                        if (
                            e.pageX >= $this.offset().left && e.pageX <= $this.offset().left + $this.outerWidth() &&
                            e.pageY >= $this.offset().top && e.pageY <= $this.offset().top + $this.outerHeight()
                        ) {
                            var posOnCellY = e.pageY - $this.offset().top;

                            var $col = $this.parents('.' + that.settings.colClass);
                            var $cellsInCol = $col.find('.' + that.settings.cellClass);
                            var currentCellIndex = $cellsInCol.index($this);

                            // If hovering top part of cell
                            if (posOnCellY < $this.outerHeight() / 2) {

                                for (let i = currentCellIndex; i < $cellsInCol.length; i++) {
                                    var $cell = $cellsInCol.eq(i);
                                    $cell.addClass('sg-moved').css({
                                        '-webkit-transform': 'translate3d(0, ' + $org.outerHeight() + 'px, 0)',
                                        'transform': 'translate3d(0, ' + $org.outerHeight() + 'px, 0)'
                                    });
                                }   
                                
                                if (!that.delays.animating) { 
                                    that.delays.animating = setTimeout(function() {
                                        if (that.$grid.find('.sg-fake').length === 0) {
                                            that.disableAnimations($col.find('.sg-moved'));
                                            setTimeout(function () {
                                                var $fake = that.createFake();
                                                $this.before($fake);
                                                that.undoMove();
                                                that.delays.animating = null;
                                            }, 20);
                                        }
                                    }, 300);
                                }
                                
                            } else {
                                if ($cellsInCol.length <= 1) {
                                    if (that.$grid.find('.sg-fake').length === 0) {
                                        var $fake = that.createFake();
                                        $this.after($fake);
                                    }
                                }
                            }
                        } 

                    }
                });

                // Empty col detection
                that.$cols.each(function () {
                    var $this = $(this);
                    if (
                        e.pageX >= $this.offset().left && e.pageX <= $this.offset().left + $this.outerWidth() &&
                        e.pageY >= $this.offset().top && e.pageY <= $this.offset().top + $this.outerHeight()
                    ) {
                        if ($this.find('.' + that.settings.cellClass).length === 0) {
                            if (that.$grid.find('.sg-fake').length === 0) {
                                var $fake = that.createFake();
                                $this.append($fake);
                            }
                        }
                    }
                });


            }

        });

        that.$grid.on('mouseup.swapEvent', function () {
            var $org = that.$grid.find('.sg-org');
            var $clone = that.$grid.find('.sg-clone');
            $clone.remove();
            $org.find('.sg-cover').remove();
            $org.removeClass('sg-org');

            if (that.$grid.find('.sg-fake').length > 0) {
                var $fake = that.$grid.find('.sg-fake');
                var $orgCopy = $org.clone();
                $fake.after($orgCopy);
                $fake.remove();
                $org.remove();
                that.$cells = that.$grid.find('.' + that.settings.cellClass);
                that.events();
            } else {
                that.undoMove();
            }
        })
    
    }

    that.createFake = function () {
        var $org = that.$grid.find('.sg-org');
        var $fake = $('<div class="sg-fake"></div>');
        $fake.css({
            'width': '100%',
            'height': $org.outerHeight() + 'px',
            'border-radius': $org.css('border-radius'),
            'margin-bottom': $org.css('margin-bottom'),
            'background': '#ecebeb',
            'border': '2px dashed #bdbdbd',
        });
        return $fake;
    }

    that.undoMove = function () {
        var $movedCells = that.$grid.find('.sg-moved');
        $movedCells.css({
            '-webkit-transform': 'none',
            'transform': 'none'
        });
        setTimeout(function () {
            that.enableAnimations($movedCells);
            $movedCells.removeClass('sg-moved');
        }, 20);
    }


    that.disableAnimations = function ($el) {
        $el.css({
            '-webkit-transition': 'none',
            'transition': 'none'
        });
    }

    that.enableAnimations = function ($el) {
        $el.css({
            '-webkit-transition': 'transform 0.3s ease-out',
            'transition': 'transform 0.3s ease-out'
        });
    }


    //that.init();

}