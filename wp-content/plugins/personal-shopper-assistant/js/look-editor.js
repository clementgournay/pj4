
function LookEditor(settings) {

    var that = this;
    var $ = jQuery;

    that.id = (settings && settings.id) ? settings.id : 'look-editor';
    that.mode = (settings && settings.mode) ? settings.mode : 'seller';
    that.modals = {};
    that.$el = $('#' + that.id);
    that.userID = $('[name=user_id]').val();
    that.sellerID = $('[name=seller_id]').val();
    that.token = $('[name=token]').val();
    that.rootURL = $('[name=root_url]').val();
    that.brandID = ($('[name=brand_id]').val() !== 'smart-personal-shopper') ? $('[name=brand_id]').val() : '';
    that.modelType = 1;
    that.modelSize = 36;
    that.apiURL = that.rootURL + '/wp-json/wp/v2';
    that.calibrationURL = $('[name=calibration_url]').val();
    that.suggestedLooks = [];
    that.favorites = [];
    that.selectedLookID = $('[name=selected_look]').val();
    that.products = [];
    that.blacklist = [];
    that.clothes = {};
    that.looks = [];
    that.looksOffset = 0;
    that.tab = 'proposed';
    that.favoritesOffset = 0;
    that.looksLoadCount = 20;
    that.clothPos = {};
    that.results = {};
    that.partProducts = [];
    that.canClosePopup = false;
    that.canCloseProduct = false;
    that.mediaRecorder = null;
    that.vocalMessage = null;
    that.view = $('.editor .view.active');
    that.constantLooks = (localStorage.constant_looks) ? JSON.parse(localStorage.constant_looks) : [];
    that.mainCategories = {
        coat_vest: ['coat', 'vest'],
        full: ['dress', 'jumpsuit'],
        top: ['cardigan', 'shirt', 'tshirt'],
        bottom: ['short', 'pants', 'skirt']
    };
    that.sceneRules = [
        'if+top_tshirt+color+is+white+then+scene+background+is+beach',
        'if+shirt+color+is+white+then+scene+background+is+beach',
        'if+pants+color+is+white+then+scene+background+is+beach',
        'if+skirt+color+is+white+then+scene+background+is+beach',
        'if+short+color+is+white+then+scene+background+is+beach',
        'if+vest+color+is+white+then+scene+background+is+beach'
    ];

    that.colors = {
        '250': {name: 'white', label: 'blanc', hex: '#ffffff'},
        '251': {name: 'white', label: 'blanc', hex: '#dddcda'},

        '252': {name: 'white', label: 'blanc', hex: '#e1e0dc'},

        '301': {name: 'yellow', label: 'jaune', hex: 'yellow'},
        '302': {name: 'yellow', label: 'jaune', hex: '#f0cd33'},

        '402': {name: 'blue', label: 'bleu', hex: 'blue'},
        '404': {name: 'blue', label: 'bleu', hex: '#759ecd'},
        '407': {name: 'blue', label: 'bleu', hex: '#9fcfeb'},
        '409': {name: 'blue', label: 'bleu', hex: '#94a3c2'},

        
        '601': {name: 'red', label: 'rouge', hex: '#8f0127'},
        '602': {name: 'red', label: 'rouge', hex: '#cb140f'},

        '602': {name: 'pink', label: 'rose', hex: '#cd4945'},
        '605': {name: 'pink', label: 'rose', hex: '#722F37'},
        '607': {name: 'pink', label: 'rose', hex: '#ba2f6e'},
        '617': {name: 'pink', label: 'rose', hex: 'salmon'},
        '621': {name: 'pink', label: 'rose', hex: 'pink'},
        '630': {name: 'pink', label: 'rose', hex: '#c85872'},

        '705': {name: 'grey', label: 'gris', hex: 'grey'},

        '900': {name: 'black', label: 'noir', hex: 'black'}
    };

    that.init = function () {
        $('body').addClass('look-editor-page');
        that.getBlacklist(function () {
            that.getModels();
            if (that.mode !== 'assistant') {
                that.getSuggestions();
                that.getFavorites();
            }
        });
        that.initCounts();
        that.initModals();
        that.initUI();
        that.formatSceneRules();
        that.profilingEvents();
        that.filterEvents();
        that.productEvents();
        that.lookEvents();
        that.optionEvents();
        that.updateLayout();
        that.orientationCheck();
        that.UIEvents();
        that.wizardEvents();
        that.swipeEvents();

        if (that.mode === 'assistant') {
            that.assistantEvents();
        }

        if (that.isSP() && that.mode === 'client') {
            that.showSPMode();
        }
    }

    window.addConstantLook = function () {
        var $current = $('.related-looks .item.selected');
        var lookID = $current.attr('data-look');
        var look = that.getLookByID(lookID);
        that.constantLooks.push(look);
        localStorage.constant_looks = JSON.stringify(that.constantLooks);
        console.log('Look sauvegardé')
    }

    window.resetConstantLooks = function () {
        that.constantLooks = [];
        localStorage.constant_looks = JSON.stringify(that.constantLooks);
        console.log('Looks réinitialisés')
    }

    window.showConstantLooks = function () {
        that.looks = that.constantLooks;
        that.showLooks(that.looks, 'proposed');
        that.lookEvents();
        $('.related-looks .count').html(that.looks.length);
        $('.related-looks .active .item').eq(0).click();
        $('.related-looks .no-result').hide();
    }

    window.removeConstantLook = function (i) {
        that.constantLooks.splice(i, 1);
        localStorage.constant_looks = JSON.stringify(that.constantLooks);
        console.log('Look à l\'index ' + i + ' supprimé');
    }
    
    that.formatSceneRules = function () {
        that.sceneRules.forEach(function (ruleSTR, index) {
            that.sceneRules[index] = new Rule(ruleSTR);
        });
        console.log(that.sceneRules);
    }

    that.wizardEvents = function () {
        $('.character-wizard').off('.wizardEvents');
        $('.character-wizard').on('click.wizardEvents', function () {
            var $wizard = $(this);
            var $prev = $wizard.find('.step.active');
            if ($wizard.find('.step').index($prev) === 0) {
                that.results = {};
                $('.wizard .view').removeClass('active');
                $('.wizard .view[data-view="selection"]').addClass('active');
            }
            if (!$wizard.hasClass('locked')) {
                $('.focus').removeClass('focus');
                var $next = $prev.next();
                
                if ($next.length > 0) {
                    var $focus = $($next.attr('data-focus'));
                    $next.addClass('active');
                    $prev.removeClass('active');
                    $focus.addClass('focus');
                    $('html, body').animate({
                        scrollTop: $focus.offset().top - 200
                    });

                    if ($next.attr('data-wait-actions')) {
                        var scenario = $next.attr('data-wait-actions');
                        var stepsSTR = scenario.split('|');
                        var steps = [];
                        stepsSTR.forEach(function (stepSTR) {
                            var parts = stepSTR.split('{');
                            var action = parts[0];
                            var target = parts[1].replace('}', '');
                            steps.push({
                                action: action,
                                selector: target
                            });
                        });
                        var index = 0;

                        var executeStep = function() {
                            $wizard.addClass('locked');
                            var step = steps[index];
                            console.log(step);
                            if (step) {

                                var onLoaded = function () {
                                    console.log('target found, wait for click')
                                    var $target = $(step.selector);
                                    console.log($target)
                                    $target.off('.wizardEvents');
                                    $target.on(step.action + '.wizardEvents', function () {
                                        console.log('CLICK, go next step');
                                        $target.off('.wizardEvents');
                                        index++;
                                        executeStep();
                                    });
                                }


                                if ($(step.selector).length === 0) {
                                    var checkPresence = setInterval(function () {
                                        console.log('Wait for target to appear')
                                        if ($(step.selector).length > 0) {
                                            onLoaded();
                                            clearInterval(checkPresence);
                                        } 
                                    }, 100);
                                } else {
                                    onLoaded();
                                }

                                
                            } else {
                                console.log('End');
                                $wizard.removeClass('locked');
                                $wizard.click();
                            }
                        }

                        executeStep();
                    }


                } else {
                    console.log('end')
                    $wizard.fadeOut();
                }
            }
        });
    }

    that.showSPMode = function () {
        $('.sp-menu').hide();
        $('.model-cont').css('transition', 'none');
        $('.related-looks').css('transition', 'none');
        $('.product-selection').css('transition', 'none');
        that.switchView('model');
        setTimeout(function () {
            $('.model-cont').css('transition', 'all 0.3s ease-out');
            $('.related-looks').css('transition', 'all 0.3s ease-out');
            $('.product-selection').css('transition', 'all 0.3s ease-out');
        }, 100);
    }

    that.getModels = function () {
        fetch(that.calibrationURL + '/data/models.json').then(function (resp) {
            return resp.json();
        }).then(function (resp) {
            that.clothPos = resp;
        });
    }

    that.getBlacklist = function (callback) {
        fetch(that.rootURL + '/data/look-blacklist.json').then(function (resp) {
            return resp.json();
        }).then(function (resp) {
            that.blacklist = resp;
            if (callback) callback();
        });
    }

    that.getSuggestions = function () {
        var url;
        if (that.mode === 'client') {
            url = that.apiURL + '/user/suggested-looks?user_id=' + that.userID;
        } else {
            url = that.apiURL + '/user/suggestions?user_id=' + that.userID + '&seller_id=' + that.sellerID;
        }

        $.ajax({
            method: 'GET',
            url: url,
            success: function (resp) {
                that.suggestedLooks = resp.data;
                that.removeVotedLooks();
                that.suggestedLooks.reverse();
                that.looks = that.suggestedLooks;
                
                console.log('[SUGGESTIONS]', that.suggestedLooks);

                if (that.mode === 'client' && that.suggestedLooks.length > 0) {
                    that.showLooks(that.suggestedLooks, 'proposed');
                    that.lookEvents();
                    that.selectLookInURL();
                    that.initCounts();
                    if (that.isSP()) {
                        $('.related-looks .looks.proposed .product').eq(0).click();
                    }
                }
            },
            complete: function () {
                $('.related-looks').removeClass('loading');
            }
        });
    }

    that.removeVotedLooks = function () {
        var newLooks = [];
        that.suggestedLooks.forEach(function (look) {
            if (!look.voted) newLooks.push(look);
        });
        that.suggestedLooks = newLooks;
    }
    

    that.getFavorites = function () {

        var url = that.apiURL + '/favorites?user_id=';
        if (that.mode === 'client') url += that.userID;
        else url += that.sellerID + '&for=' + that.userID;
        $.ajax({
            method: 'GET',
            url: url,
            success: function (resp) {
                that.favorites = []
                resp.data.forEach(function(favorite) {
                    that.favorites.push(favorite.look);
                });
                $('.related-looks .favorites .loading').hide();
                if (that.favorites.length > 0) {
                    $('.related-looks .favorites .no-result').hide();
                    that.showLooks(that.favorites, 'favorites');
                    that.lookEvents();
                } else {
                    $('.related-looks .favorites .no-result').show();
                }
                console.log('[LIKES]', that.favorites);
            }
        });
    }

    that.profilingEvents = function () {
        $('.profiling .category').off('.profilingEvents');
        $('.profiling .category').on('change.profilingEvents', function () {
            var category = $(this).val();
            switch(category) {
                case 'clothes':
                    $('.wizard .view').removeClass('active');
                    $('.wizard .view[data-view="selection"]').addClass('active');
                    break;
                case 'shoes':
                    $('.wizard .view[data-view="products"] .back').hide();
                    that.showCategoryProducts('shoes', 'Chaussures');
                    break;
                case 'bags':
                    $('.wizard .view[data-view="products"] .back').hide();
                    that.showCategoryProducts('bag', 'Sacs');
                    break;
                case 'accessories':
                    $('.wizard .view[data-view="products"] .back').hide();
                    that.showCategoryProducts('accessory', 'Accessoires');
                    break;
            }
        });

        $('.profiling .size').off('.profilingEvents');
        $('.profiling .size').on('change.profilingEvents', function () {
            var size =　$(this).val();
            that.updateModelSize(size);
        });
    }

    that.initUI = function () {
        $('body').append('<div id="turn-device"><span>Veuillez mettre votre appareil en mode paysage</span></div>');
        $('body').append('<div id="toggle-menu"><i class="fas fa-arrow-right"></i></div>');

        if (that.isSP()) {
            var hintHTML = '<div id="hint-clothes">';
                hintHTML += '<div class="content">';
                    hintHTML += '<i class="fas fa-hand-point-up"></i>';
                    hintHTML += '<p class="desc">Touchez un vêtement pour le changer</p>';
                hintHTML += '</div>';
            hintHTML += '</div>';
            $('body').append(hintHTML); 
        }
    }

    that.initModals = function () {
        that.modals.proposalSuccess = new Modal({
            selector: '#proposal-success'
        });
        that.modals.unproposalSuccess = new Modal({
            selector: '#unproposal-success'
        });

        that.modals.commentLook = new Modal({
            selector: '#comment-look'
        });

        that.modals.confirmProposal = new Modal({
            selector: '#confirm-proposal'
        });
        that.modals.confirmProposal.addButton('Oui', function ($btn) {
            that.modals.confirmProposal.startLoading();
            $.ajax({
                method: 'POST',
                url: that.apiURL + '/look/send?user_id=' + that.userID,
                headers: {
                    'Authorization': 'Bearer ' + that.token,
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(that.modals.confirmProposal.getData('look-data')),
                success: function (resp) {
                    $('.model-cont .propose').hide();
                    $('.model-cont .unpropose').show();
                    that.modals.proposalSuccess.open();
                },
                error: function (xhr, statusText) {
                    alert('Une erreur est survenue.');
                },
                complete: function () {
                    that.modals.confirmProposal.endLoading();
                    that.modals.confirmProposal.close();
                }
            });
        });
        that.modals.confirmUnproposal = new Modal({
            selector: '#confirm-unproposal'
        });
        that.modals.confirmUnproposal.addButton('Oui', function ($btn) {
            that.modals.confirmUnproposal.startLoading();
            $.ajax({
                method: 'DELETE',
                url: that.apiURL + '/look/send?user_id=' + that.userID,
                headers: {
                    'Authorization': 'Bearer ' + that.token,
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(that.modals.confirmUnproposal.getData('look-data')),
                success: function (resp) {
                    $('.model-cont .unpropose').hide();
                    $('.model-cont .propose').show();
                    that.modals.unproposalSuccess.open();
                },
                error: function (xhr, statusText) {
                    alert('Une erreur est survenue.');
                },
                complete: function () {
                    that.modals.confirmUnproposal.endLoading();
                    that.modals.confirmUnproposal.close();
                }
            });
        });

        that.modals.subscribe = new Modal({
            selector: '#subscribe'
        });

        that.modals.subscribe.addButton('Créer un compte et envoyer le look', function ($btn) {
            var look = $('.related-looks .item.selected').attr('data-look');  
            var body = {look: look};
            $('#subscribe form input').each(function () {
                var name = $(this).attr('name');
                var value = $(this).val();
                body[name] = value;
            });
            if (!that.modals.subscribe.inProgress) {
                that.modals.subscribe.startLoading();
                $.ajax({
                    method: 'POST',
                    url: that.apiURL + '/user',
                    headers: {
                        'Authorization': 'Bearer ' + that.token,
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(body),
                    success: function (resp) {
                    },
                    error: function (xhr, statusText) {
                        alert('Une erreur est survenue.');
                    },
                    complete: function () {
                        that.modals.subscribe.endLoading();
                    }
                });
            }
        });

        that.modalEvents();
    }

    that.modalEvents = function () {
        $('#comment-look .record').off('.modalEvents');
        $('#comment-look .record').on('click.modalEvents', function () {
            $(this).hide();
            $('#comment-look .stop').show();
            $('#comment-look .play').hide();
            $('#comment-look .pause').hide();
            navigator.mediaDevices.getUserMedia({audio: true})
            .then(stream => {
                that.mediaRecorder = new MediaRecorder(stream);
                that.mediaRecorder.start();
    
                const audioChunks = [];
                that.mediaRecorder.addEventListener("dataavailable", event => {
                    audioChunks.push(event.data);
                });
    
                that.mediaRecorder.addEventListener("stop", () => {
                    $('#comment-look .stop').hide();
                    $('#comment-look .record').show();
                    $('#comment-look .play').show();
                    $('#comment-look .send').show();
                    const audioBlob = new Blob(audioChunks);
                    const audioUrl = URL.createObjectURL(audioBlob);
                    that.vocalMessage = new Audio(audioUrl);

                    that.vocalMessage.onended = function () {
                        $('#comment-look .pause').hide();
                        $('#comment-look .play').show();
                        $('#comment-look .record').show();
                    }
                });
    
                setTimeout(() => {
                    if (that.mediaRecorder) that.mediaRecorder.stop();
                }, 60000);
            });
        });

        $('#comment-look .stop').off('.modalEvents');
        $('#comment-look .stop').on('click.modalEvents', function () {
            that.mediaRecorder.stop();
        });

        $('#comment-look .play').off('.modalEvents');
        $('#comment-look .play').on('click.modalEvents', function () {
            that.vocalMessage.play();
            $('#comment-look .play').hide();
            $('#comment-look .pause').show();
        });

        $('#comment-look .pause').off('.modalEvents');
        $('#comment-look .pause').on('click.modalEvents', function () {
            that.vocalMessage.pause();
            $('#comment-look .play').show();
            $('#comment-look .pause').hide();
        });

    }

    that.selectLookInURL = function () {
        setTimeout(function () {
            if (that.selectedLookID && that.selectedLookID !== 'none') {
                var $look = $('.related-looks .proposed .item[data-look=' + that.selectedLookID + ']');
                $look.click();
                const scrollTop = $look.offset().top - $look.outerHeight() - 100;
                if (scrollTop > 0) {
                    $('.related-looks .looks.active').scrollTop(scrollTop);
                }
                if (!(that.isSP() && that.mode === 'client')) {
                    $('.model-cont .vote').fadeIn();
                }
                $('.model-cont .book').fadeIn();
                $('.model-cont .comment').fadeIn();
                that.showProposal();
            }
        }, 500);
    }

    that.initCounts = function () {
        $('.product-selection .count').html($('.product-selection > .items .item').length);
        $('.related-looks .count').html($('.related-looks .active .item').length);
    }

    that.filterEvents = function () {

        $('.product-selection .filter').off('.filterEvents');

        $('.product-selection .filter.color select').on('change.filterEvents', function () {
            var color = $(this).val();
            console.log(color);
        });

    }

    that.UIEvents = function () {

        that.$el.find('.toolbar .tool').off('.UIEvents');
        that.$el.find('.toolbar .tool').on('click.UIEvents', function () {

        })

        that.$el.find('.modal .close').off('.UIEvents');
        that.$el.find('.modal .close').on('click.UIEvents', function() {
            if ($(this).parents('.modal').length === 0) that.close();
        });

        $('.model-cont .vote div').off('.UIEvents');
        $('.model-cont .vote div').on('click.UIEvents', function () {
            var $this = $(this);
            if (!$this.hasClass('in-progress')) {
                $this.addClass('in-progress');
                var looks = (that.tab === 'proposed') ? that.looks : that.favorites;
                var look = that.getLook(looks, that.selectedLookID);
                var status = $this.hasClass('like') ? 'like' : 'dislike';
                $('.model-cont .vote div:not(.' + status + ')').removeClass('selected');
                var data = {look: look, for: that.userID, user_id: that.sellerID};
                if (!$this.hasClass('selected')) {
                    $this.addClass('selected');
                    if (status === 'like') {
                        that.like(data, function () {
                            $this.removeClass('in-progress');
                        });
                    } else {
                        var favIndex = that.getFavoriteIndex(that.selectedLookID);
                        if (favIndex > 0) {
                            that.removeLike(that.selectedLookID, function () {
                                that.dislike(that.selectedLookID, function () {
                                    $this.removeClass('in-progress');
                                });
                            });
                        } else {
                            that.removeCurrentFromFavorites();
                            that.dislike(that.selectedLookID, function () {
                                $this.removeClass('in-progress');
                            });
                        }                      
                    }
                    if (that.isSuggested(that.selectedLookID)) {
                        //todo remove 
                    }
                } else {
                    $this.removeClass('selected');
                    if (status === 'like') {
                        that.removeLike(that.selectedLookID, function () {
                            $this.removeClass('in-progress');
                        });     
                    }
                }
            }
        });
        
        $('.model-cont .comment').off('.UIEvents');
        $('.model-cont .comment').on('click.UIEvents', function () {
            that.modals.commentLook.open();
        });


        $('.filter-selection .filter-btn').off('.UIEvents');
        $('.filter-selection .filter-btn').on('click.UIEvents', function () {
            if ($(this).parents('.scenes').length === 0) {
                $('.model-cont .model').removeClass('selected');
                $('.filter-selection .filter-btn').removeClass('selected');
                var model = $(this).attr('data-filter');
                if (model.indexOf('36') >= 0) that.modelSize = 36;
                else if (model.indexOf('38') >= 0) that.modelSize = 38;
                else if (model.indexOf('42') >= 0) that.modelSize = 42;

                if ($(this).parents('.face').length > 0) {
                    const parts = model.split('-');
                    that.modelType = parseInt(parts[0]);
                }
                
                $(this).addClass('selected');
                $('.model-cont .model[data-model="' + model + '"]').addClass('selected');
                $('.related-looks .item.selected').click();
            }
        });

        $('.filter-selection.scenes .filter-btn').off('.UIEvents');
        $('.filter-selection.scenes .filter-btn').on('click.UIEvents', function () {
            var scene = $(this).attr('data-scene');
            $('.filter-selection.scenes .filter-btn').removeClass('selected');
            $(this).addClass('selected');
            $('.model-outer').attr('data-scene', scene);
        });


        $('.model-cont .propose').off('.UIEvents');
        $('.model-cont .propose').on('click.UIEvents', function () {
            var look = $('.related-looks .item.selected').attr('data-look');  
            var data = {look: look, seller_id: that.sellerID};
            that.modals.confirmProposal.setData('look-data', data);
            that.modals.confirmProposal.open();
        });

        $('.model-cont .unpropose').off('.UIEvents');
        $('.model-cont .unpropose').on('click.UIEvents', function () {
            var look = $('.related-looks .item.selected').attr('data-look');  
            var data = {look: look, seller_id: that.sellerID};
            that.modals.confirmUnproposal.setData('look-data', data);
            that.modals.confirmUnproposal.open();
        });


        $('.window .item').off('.UIEvents');
        $('.window .item').on('click.UIEvents', function () {
            var $window = $(this).parents('.window');
            if (!$window.hasClass('full-screen')) {
                $window.addClass('full-screen');
                $('.model-outer').addClass('window-open');
                var category = $window.attr('data-category');
        
                if (!that.results[category]) {
                    $.ajax({
                        method: 'GET',
                        url: that.rootURL + '/wp-json/wp/v2/products-category?category=' + category,
                        headers: {
                            'Authorization': 'Bearer ' + that.token,
                            'Content-Type': 'application/json'
                        },
                        success: function (resp) {
                            that.results[category] = resp.data;
                            that.showWindowProducts($window, resp.data);
                            that.windowProductEvents();
                        },
                        complete: function (resp) {
                            $window.find('.loading').hide();
                        }
                    });
                } else {
                    $window.find('.loading').hide();
                    that.showWindowProducts($window, that.results[category]);
                }
            }
        }); 

        $('.model-cont .window .close').off('.UIEvents');
        $('.model-cont .window .close').on('click.UIEvents', function (e) {
            e.stopPropagation();
            $(this).parents('.window').removeClass('full-screen');
            $('.model-outer').removeClass('window-open');
        });

        $('.model-cont .window .replace').off('.UIEVents');
        $('.model-cont .window .replace').on('click.UIEvents', function () {
            var $selected = $(this).parents('.window').find('.product.selected');
            var src = $selected.attr('data-image');
            $(this).parents('.window').find('.item').attr('src', src);
            $(this).parents('.window').find('.product').removeClass('selected');
            $(this).parents('.window').removeClass('full-screen');
            $('.model-outer').removeClass('window-open');

            var $selectedCloth = $('.model-cont .cloth.selected');
            if ($selectedCloth.length) {
                var selectedRef = $selectedCloth.attr('data-ref');
                var replaceRef = $selected.attr('data-ref');
                that.replaceCloth(selectedRef, replaceRef);
            }
        });

        $('.model-cont .mensurations .toggle-btn').off('.UIEVents');
        $('.model-cont .mensurations .toggle-btn').on('click.UIEVents', function () {
            $(this).parents('.mensurations').toggleClass('shown');
        });

        $(window).off('.UIEvents');
        $(window).on('resize.UIEvents', that.updateLayout);

        $('#toggle-menu').off('.UIEvents');
        $('#toggle-menu').on('click.UIEvents', function () {
            $('body').toggleClass('menu-hide');
            $('body').toggleClass('view-translated');
            $('#toggle-menu i').toggleClass('fa-arrow-left');
            $('#toggle-menu i').toggleClass('fa-arrow-right');
        });

        $(window).off('.UIEvents');
        $(window).on('orientationchange.UIEvents', function () {
            setTimeout(function () {
                that.orientationCheck();
            }, 300);
        });

        $('.sp-menu .item').off('.UIEvents');
        $('.sp-menu .item').on('click.UIEvents', function () {
            var view = $(this).attr('data-view');
            that.switchView(view);
        });


        $('.main-title .toggle-filter').off('.UIEvents');
        $('.main-title .toggle-filter').on('click.UIEvents', function () {
            var filter = $(this).attr('data-filter');
            $(this).toggleClass('active');
            $('.filter-window[data-filter="' + filter + '"]').toggleClass('shown');
        })
        

        $('.model-cont .zoom').off('.UIEvents');
        $('.model-cont .zoom').on('click.UIEvents', function () {
            $('.model-outer').toggleClass('zoom-out');
            $(this).find('i').toggleClass('fa-search-plus');
            $(this).find('i').toggleClass('fa-search-minus');   
            that.updateLayout();
        });;

        $('.window.coat-vest .toggle').off('.UIEvents');
        $('.window.coat-vest .toggle').on('click.UIEvents', function () {
            $('.model-cont .cloth[data-category="coat"]').toggle();
            $('.model-cont .cloth[data-category="vest"]').toggle();
            $(this).find('i').toggleClass('fas fa-eye');
            $(this).find('i').toggleClass('fas fa-eye-slash');
            $('.model-cont .cloth[data-category="shirt"]').toggle();
            $('.model-cont .cloth[data-category="top"]').toggle();
            $('.model-cont .cloth[data-category="cardigan"]').toggle();
        });

        $('.model-cont .model-settings').off('.UIEvents');
        $('.model-cont .model-settings').on('click.UIEvents', function () {
            $('.window.edit-model').show();
            setTimeout(function() {
                $('.window.edit-model').addClass('full-screen');
            }, 100);
        });

        $('.model-cont .scene-settings').off('.UIEzvents');
        $('.model-cont .scene-settings').on('click.UIEvents', function () {
            $('.window.edit-scene').show();
            setTimeout(function () {
                $('.window.edit-scene').addClass('full-screen');
            }, 100);
        });

      
        $('.model-cont .cloth').off('.UIEvents');
        $('.model-cont .cloth').on('mouseover.UIEvents', function () {
            that.showProductDetail($(this).attr('data-ref'));
        });

        $('.window .item').off('.UIEvents');
        $('.window .item').on('mouseover.UIEvents', function () {
            that.showProductDetail($(this).attr('data-ref'));
        });

        $('#product-detail .back').off('.UIEvents');
        $('#product-detail .back').on('click.UIEvents', function () {
            $('.related-looks [data-view="looks"]').addClass('active');
            $('.related-looks [data-view="product-detail"]').removeClass('active');
        });

        $('.advanced-search .toggle-btn').off('.UIEvents');

        $('.advanced-search .toggle-btn').on('click.UIEvents', function () {
            var toggle = $(this).attr('data-toggle');
            var $toggleGroup = $(this).parents('.toggle-group');
            $toggleGroup.find('.toggle-btn').removeClass('selected');
            $(this).addClass('selected');
            $toggleGroup.find('.toggle-area').hide();
            $toggleGroup.find('.toggle-area[data-toggle=' + toggle + ']').show();
        });

        $('.advanced-search select').off('.UIEvents');
        $('.advanced-search select').on('change.UIEvents', function () {
            if ($(this).val() !== 'all') {
                $(this).addClass('selected');
            } else {
                $(this).removeClass('selected');
            }
        }); 
    

    }

    that.updateModelSize = function (size) {
        var model = that.modelType + '-' + size;
        console.log(model);
        $('.model-cont .filter-btn[data-filter="' + model + '"]').click();
    }

    that.getSimilarProducts = function (targetProduct) {
        var similarProducts = [];
        for (var ref in that.products) {
            if (ref.substring(0, 16) === targetProduct.reference.substring(0, 16)) {
                similarProducts.push(that.products[ref]);
            }
        }
        return similarProducts;
    }

    that.showProductDetail = function(ref) {
        var product = that.products[ref];
        if (product) {

            console.log('[PRODUCT DETAIL]', product);
            const countries = {
                'serbia': 'Serbia'
            }

            const categories = {
                'pants': 'Pantalons',
                'dress': 'Robes',
                'skirt': 'Jupes',
                'short': 'Shorts',
                'coat': 'Manteaux',
                'vest': 'Vestes',
                'cardigan': 'Gilets',
                'shirt': 'Blouses et chemises',
                'top_tshirt': 'Hauts et T-shirts',
                'accessory': 'Accessoires',
                'jumpsuit': 'Combinaisons'
            }

            const brands = {
                'dika': 'DiKa'
            }

            const collections = {
                'spring-summer-2022': 'Printemps été 2022'
            }

            const cuts = {
                'regular': 'Regular',
                'skinny': 'Skinny',
                'slim': 'Slim'
            }            

            var $detail = $('#product-detail');
            var price = (product.sale_price && product.sale_price !== product.price && product.sale_price !== 0) ? product.sale_price : product.price;

            var similarProducts = that.getSimilarProducts(product);
            if (similarProducts.length > 0) {
                $detail.find('.color-block').show();
                $detail.find('[data-colors]').html('');            
                similarProducts.forEach(function (prod) {
                    var selected = (prod.reference === product.reference) ? 'selected' : '';
                    $detail.find('[data-colors]').append('<div class="bullet ' + selected + '" data-ref="' + prod.reference + '" data-color="' + prod.color.replace(/\D/g, '') + '"></div>');
                });
            } else {
                $detail.find('.color-block').hide();
            } 

            if (product.composition.toUpperCase().indexOf('WOOL') >= 0) {
                $detail.find('.label-block .woolmark').show();
            } else {
                $detail.find('.label-block .woolmark').hide();
            }

            $detail.find('.bar .title').html(product.name);

            product.origin = 'serbia';
            if (product.origin !== '') {
                $detail.find('.origin-block').show();
                $detail.find('[data-origin]').html('Made in ' + countries[product.origin]);
            } else {
                $detail.find('.origin-block').hide();
            } 

            if (product.composition !== '') {
                $detail.find('.composition-block').show();
                $detail.find('[data-composition]').html(product.composition);
            } else {
                $detail.find('.composition-block').hide();
            }
            product.advices = 'Repassage à 150 degrés, Repassage à 150 degrés, Sèche linge interdit';
            if (product.advices !== '') {
                $detail.find('.advice-block').show();
                var html = '';
                product.advices.split(', ').forEach(function(advice) {
                    html += '<li>' + advice + '</li>';
                });
                $detail.find('[data-advices]').html(html);
            } else {
                $detail.find('.advice-block').hide();
            }


            $detail.find('[data-price]').html(price + '€');

            $detail.removeClass('has-gallery');
            $detail.find('.photos .main .photo').html('');
            $detail.find('.photos .main .zoom').html('');
            $detail.find('.photos .main .brand').html('');
            $detail.find('[data-ref]').html(product.reference);
            $detail.find('[data-category]').html(categories[product.category]);

            if (product.size_range !== '') {
                var americanSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                var sizes = product.size_range.split(',');
                if (sizes.length < 2) {
                    var range = product.size_range.split('-');
                    if (parseInt(range[0]) == range[0]) {
                        sizes = [];
                        for (let i = parseInt(range[0]); i <= parseInt(range[1]); i+=2) {
                            sizes.push(i);
                        }
                    } else {
                        var startIndex = americanSizes.indexOf(range[0]);
                        var endIndex = americanSizes.indexOf(range[1]);
                        if (startIndex >= 0 && endIndex >= 0) {
                            sizes = [];
                            for (let i = startIndex; i <= endIndex; i++) {
                                sizes.push(americanSizes[i]);
                            }
                        }
                    }
                }

                if (sizes.length > 0) {
                    var sizeHTML = '<div id="size-selection"></di>';
                    sizes.forEach(function (size) {
                        var selected = (size === 36 || size === 'M') ? 'selected' : '';
                        sizeHTML += '<div class="size ' + selected + '" data-size="' + size + '">' + size + '</div>';
                    });
                    $detail.find('[data-size]').html(sizeHTML);
                    $detail.find('.size-block').show();
                } else {
                    $detail.find('.size-block').hide();
                }
            } else {
                $detail.find('.size-block').hide();
            }

            if (product.cut !== '') {
                $detail.find('.cut-block').show();
                $detail.find('[data-cut]').html(cuts[product.cut]);
            } else {
                $detail.find('.cut-block').hide();
            }
            $detail.find('[data-brand]').html(brands[product.brand]);

            if (product.collection !== '') {
                $detail.find('.collection-block').show();
                $detail.find('[data-collection]').html(collections[product.collection]);
            } else {
                $detail.find('.collection-block').hide();
            }      

            var mainImage = new Image();
            mainImage.src = product.image;

            $detail.find('.photos .main .photo').append(mainImage);
            $detail.find('.photos .others').html('');

            if (product.gallery && product.gallery.length > 0) {
                $detail.addClass('has-gallery');
                var image = new Image();
                image.src = product.image;
                image.classList.add('photo');
                $detail.find('.photos .others').append(image);
                product.gallery.forEach(function (imageURL) {
                    var image = new Image();
                    image.src = imageURL;
                    image.classList.add('photo');
                    $detail.find('.photos .others').append(image);
                });
            }

            var brandImage = new Image();
            brandImage.src = that.rootURL + '/wp-content/plugins/personal-shopper-assistant/images/logos/' + product.brand + '.png';
            brandImage.classList.add('brand');
            $detail.find('.photos .main .brand').append(brandImage);

            let i = 0, limit = 500;
            that.relatedItems = [];
            while (that.relatedItems.length < limit && i < that.looks.length) {
                const look = that.looks[i];
                look.forEach(function (item) {
                    let x = 0, found = false;
                    while (!found && x < that.relatedItems.length) {
                        if (that.relatedItems[x].id === item.id) found = true;
                        else x++;
                    }
                    if (!found && item.id !== product.id && that.relatedItems.length < limit) {
                        that.relatedItems.push(item);
                    }
                });
                i++;
            }

            $detail.find('.related-items .inner').html('');
            that.relatedItems.forEach(function (item) {
                $detail.find('.related-items .inner').append('<a class="product" data-ref="' + item.reference + '" title="' + item.name + '" style="background-image: url(\'' + item.image + '\')"></a>');
            });

            $detail.find('.related-items .item-count').html(that.relatedItems.length);
            $detail.find('.related-items .inner').css('width', (that.relatedItems.length * 120) + 'px');
            
            $('.related-looks [data-view="looks"]').removeClass('active');
            $('.related-looks [data-view="product-detail"]').addClass('active');

            that.productDetailEvents();
        }
        
    }

    that.applyLookSceneRule = function() {
        var looks = (that.tab === 'proposed') ? that.looks : that.favorites;
        var look = that.getLook(looks, that.selectedLookID);        

        var matchingRules = [];
        that.sceneRules.forEach(function (rule) {
            var i = 0, foundSubject = false;
            while (!foundSubject && i < look.length) {
                var product = look[i];
                if (product.category === rule.condition.subject) foundSubject = true;
                else i++;
            }

            if (foundSubject) {
                var product = look[i];
                var productCopy = JSON.parse(JSON.stringify(product));
                if (that.colors[product.color]) {
                    productCopy.color = that.colors[product.color].name;
                }
                var productFitCondition = SubjectFitPhrase(productCopy, rule.condition);
                if (productFitCondition) matchingRules.push(rule);
            }
        });
  
        var rule = null;
        if (matchingRules.length === 1) {
            rule = matchingRules[0];
            
        } else {
            var topRuleIndex = findRuleBySubject(matchingRules, 'top');
            if (topRuleIndex >= 0) {
                rule = matchingRules[topRuleIndex];
            } else {
                var bottomRuleIndex = findRuleBySubject(matchingRules, 'bottom');
                if (bottomRuleIndex >= 0) {
                    rule = matchingRules[bottomRuleIndex];
                } else {
                    rule = matchingRules[0];
                }
            }
        }

        if (rule) {
            if (rule.result.subject === 'scene' && rule.result.operand === 'is') {
                $('.filter-selection [data-scene="' + rule.result.value + '"]').click();
            }
        } else {
            $('.filter-selection [data-scene="dressing"]').click();
        }
    }


    that.productDetailEvents = function () {

        var mouseX = 0, mouseY = 0;

        $('#product-detail .main').off('.productDetailEvents');
        $('#product-detail .main').on('mouseenter.productDetailEvents', function (e) {
            mouseX = e.pageX;
            mouseY = e.pageY;
            var $this = $(this);
            var height = $this.outerHeight();
            if ($this.find('.zoom-clone').length === 0) {
                var $img = $this.find('.photo img');
                var img = new Image();
                img.src = $img.attr('src');
                img.onload = function () {
                    var $copy = $img.clone();
                    $copy.addClass('zoom-clone');
                    $this.find('.zoom').append($copy);
                    $this.find('.zoom').css('height', height + 'px');
                    $copy.show();
                    $this.addClass('hover');
                }
            } else {
                $this.addClass('hover');
            }
        });

        $('#product-detail .main').on('mousemove.productDetailEvents', function (e) {
            
            var $zoom = $(this).find('.zoom');
            var translateX = ($zoom.attr('data-translate-x')) ? parseInt($zoom.attr('data-translate-x')) : 0;
            var translateY = ($zoom.attr('data-translate-y')) ? parseInt($zoom.attr('data-translate-y')) : 0;

            var diffX = e.pageX - mouseX;
            var diffY = e.pageY - mouseY;
            translateX = translateX - diffX;
            translateY = translateY - diffY;


            $zoom.css('transform', 'translate3d(' + translateX + 'px, ' + translateY + 'px, 0)');
            $zoom.attr('data-translate-x', translateX);
            $zoom.attr('data-translate-y', translateY);
            
            mouseX = e.pageX;
            mouseY = e.pageY;
        });

        $('#product-detail .main').on('mouseleave.productDetailEvents', function () {
            $(this).removeClass('hover');
            var $zoom = $(this).find('.zoom');
            $zoom.css('transform', 'translate3d(0, 0, 0)');
            $zoom.attr('data-translate-x', 0);
            $zoom.attr('data-translate-y', 0);
        });

        $('#product-detail .photos .others').off('.productDetailEvents');
        $('#product-detail .photos .others').on('.productDetailEvents', function () {

        });

        $('#product-detail .related-items .product').off('.productDetailEvents');
        $('#product-detail .related-items .product').on('click.productDetailEvents', function () {
            var $product = $(this);
            var productIndex = $('#product-detail .related-items .product').index($product);
            var product = that.relatedItems[productIndex];
            var $look = $('.related-looks .item.selected');
            var looks = (that.tab === 'proposed') ? that.looks : that.favorites;
            var look = looks[that.lookIndex];

            var $lookProduct = $look.find('.product[data-category="' + product.category + '"]');

            if ($lookProduct.length === 0) {

                var productMainCat = that.getMainCategory(product.category);
    
                var foundSiblings = false, i = 0;
                while (!foundSiblings && i < look.length) {
                    var lookProd  = look[i];
                    var lookProdMainCat = that.getMainCategory(lookProd.category);
            
                    if (lookProdMainCat !== '' && lookProdMainCat === productMainCat) foundSiblings = true;
                    else i++;
                }

                if (foundSiblings) {
                    $lookProduct = $look.find('.product').eq(i);
                }
            }                

            if ($lookProduct.length > 0) {
                var selectedRef = $lookProduct.attr('data-ref');
                var replaceRef = product.reference;
                that.replaceCloth(selectedRef, replaceRef);
                setTimeout(function () {
                    $('.model-cont .cloth[data-ref="' + product.reference + '"]').trigger('mouseenter');         
                }, 500);
            } else {
                looks[that.lookIndex].push(product);
                that.refreshCurrentLook();
                $('.related-looks .item.selected').click();
                setTimeout(function () {
                    $('.model-cont .cloth[data-ref="' + product.reference + '"]').trigger('mouseenter');         
                }, 500);
            }
            
        });

        $('#product-detail .colors .bullet').off('.productDetailEvent');
        $('#product-detail .colors .bullet').on('click.productDetailEvent', function () {
            var targetRef = $('#product-detail .colors .bullet.selected').attr('data-ref');
            var ref = $(this).attr('data-ref');
            that.replaceCloth(targetRef, ref);
            $('#product-detail .colors .bullet').removeClass('selected');
            $(this).addClass('selected');
        });

        $('#product-detail .sizes .size').off('.productDetailEvent');
        $('#product-detail .sizes .size').on('click.productDetailEvent', function () {
            $('#product-detail .sizes .size').removeClass('selected');
            $(this).addClass('selected');
            var size = $(this).attr('data-size');
            switch(size) {
                case 'XS':
                case 'S':
                case 'M':
                case '34':
                case '36':
                    $('.filter-selection.size [data-filter="1-36"]').click();
                    break;
                case 'L':
                case '38':
                case '40':
                    $('.filter-selection.size [data-filter="1-38"]').click();
                    break;
                case 'L':
                case 'XL':
                case 'XXL':
                case '42':
                case '44':
                case '46':
                    $('.filter-selection.size [data-filter="1-42"]').click();
                    break;
            }
        });

        $('#product-detail .model-selection .model').off('.productDetailEvent');
        $('#product-detail .model-selection .model').on('click.productDetailEvent', function () {
            $('#product-detail .model-selection .model').removeClass('selected');
            $(this).addClass('selected');
            var face = $(this).attr('data-filter');
            $('.filter-selection.face [data-filter="' + face + '"]').click();
        });

        $('#product-detail .photos .main .expand').off('.productDetailEvent');
        $('#product-detail .photos .main .expand').on('click.productDetailEvent', function() {
            $(this).parents('.main').addClass('expanded-mode');
        });

        $('#product-detail [name=delivery-type]').off('.productDetailEvent');
        $('#product-detail [name=delivery-type]').on('change.productDetailEvent', function () {
            if ($(this).val() === 'store') {
                $('#product-detail .stores').slideDown();
                $('#product-detail .delivery-delay').fadeOut();
            } else {
                $('#product-detail .stores').slideUp();
                $('#product-detail .delivery-delay').fadeIn();
            }
        });

        $('#product-detail .stores .store').off('.productDetailEvent');
        $('#product-detail .stores .store').on('click.productDetailEvent', function () {
            $(this).parents('.stores').find('.store').removeClass('selected');
            $(this).addClass('selected');
        });

        $('#product-detail .label-block .label').off('.productDetailEvent');
        $('#product-detail .label-block .label').on('click.productDetailEvent', function () {
            var label = $(this).attr('data-label');
            console.log(label);
            $('.model-cont .label-desc .desc').hide();
            $('.model-cont .label-desc .desc[data-label="' + label + '"]').show();
            $('.model-cont .label-desc').show();
            setTimeout(function () {
                $('.model-cont .label-desc').addClass('full-screen');
            },50);
        });

        $('#product-detail .store .actions .vocal-message').off('.productDetailEvent');
        $('#product-detail .store .actions .vocal-message').on('click.productDetailEvent', function () {
            that.modals.commentLook.open();
        });
    }

    that.getMainCategory = function(category) {
        var mainCat = null;
        for (let key in that.mainCategories) {
            if (that.mainCategories[key].indexOf(category) >= 0) mainCat = key;
        }
        return mainCat;
    }

    that.getSiblingCategories = function(category) {
        var mainCat = that.getMainCategory(category);
        return that.mainCategories[mainCat];
    }

    that.isSuggested = function (searchLookID) {
        var found = false; var i = 0;
        while(!found && i < that.suggestedLooks.length) {
            var lookID = that.suggestedLooks[i];
            if (lookID === searchLookID) found = true;
            else i++;
        }
        return found;
    }

    that.switchView = function (view) {

        that.view = view;
        $('.sp-menu .item').removeClass('active');
        $('.sp-active').removeClass('sp-active');
        
        switch(view) {
            case 'dressing':
                $('.product-selection').addClass('sp-active');
                $('.product-selection .result.items').addClass('sp-active');

                $('.related-looks').css('transform', 'translate3d(100%, 0, 0)');
                $('.model-cont').css('transform', 'translate3d(200%, 0, 0)');
                break;
            case 'looks':
                $('.related-looks').addClass('sp-active');
                $('.related-looks .result.items').addClass('sp-active');

                $('.product-selection').css('transform', 'translate3d(-100%, 0, 0)');
                $('.model-cont').css('transform', 'translate3d(100%, 0, 0)');
                break;
            case 'model':
                $('.model-cont').addClass('sp-active');
                $('.product-selection').css('transform', 'translate3d(-200%, 0, 0)');
                $('.related-looks').css('transform', 'translate3d(-100%, 0, 0)');
                if (!that.hintShown && that.mode !== 'client') {
                    setTimeout(function () {
                        if ($('.model-cont').hasClass('sp-active') && $('.model-cont .cloth').length > 0) {
                            that.hintShown = true;
                            $('#hint-clothes').fadeIn(500);
                            setTimeout(function () {
                                $('#hint-clothes').fadeOut(500);
                            }, 3000);
                        }
                    }, 2000);
                    
                }
                break;
        }

        $('.sp-menu [data-view=' + view + ']').addClass('active');

    }

    that.updateLayout = function () {
        if (!that.isSP() && window.innerWidth < 1440) {
            $('body').addClass('menu-hide');
        } else {
            $('body').removeClass('menu-hide');
        }

        if (that.isSP()) {
            $('.model-outer').css('width', ((500 * $('.model-outer').outerHeight())/1024) + 'px');
            var diffX = $('.model-outer').outerWidth() - 500;
            var scale = $('.model-outer').hasClass('zoom-out') ? 0.8 : 1;
            $('.clothing').css('transform', 'translate3d(' + (diffX/2) + 'px, 0, 0) scale(' + scale + ')');
        }
    }


    that.orientationCheck = function () {
        const userAgent = navigator.userAgent.toLowerCase();
        const isTablet = /(ipad|tablet|(android(?!.*mobile))|(windows(?!.*phone)(.*touch))|kindle|playbook|silk|(puffin(?!.*(IP|AP|WP))))/.test(userAgent);

        if (isTablet && window.innerWidth >= 1024 && window.innerWidth < 1560 && window.innerHeight > window.innerWidth) {
            $('#turn-device').show();
        } else {
            $('#turn-device').hide();
        }

    }

    that.removeCurrentFromFavorites = function () {
        var looks = (that.tab === 'proposed') ? that.looks : that.favorites;
        var lookIndex = that.getLookIndex(looks, that.selectedLookID);
        looks.splice(lookIndex, 1);
        $('[data-look="' + that.selectedLookID + '"]').remove();
        if (lookIndex > looks.length - 1) lookIndex = looks.length - 1;
        $active.find('.item').eq(lookIndex).click();
        if ($active.find('.item').length === 0) {
            $active.find('.loading').hide();
            $active.find('.no-result').show();
            that.resetModelView();
        }
    }

    that.assistantEvents = function () {
        $('.wizard .category').off('.assistantEvents');
        $('.wizard .category').on('click.assistantEvents', function () {
            var category = $(this).attr('data-category');
            var label = $(this).find('.name').text();
            $('.wizard [data-view="products"] .back').show();
            that.showCategoryProducts(category, label);
        });

        $('.wizard .view .back').off('.assistantEvents');
        $('.wizard .view .back').on('click.assistantEvents', function () {
            $('.wizard .view').removeClass('active');
            $('.wizard .view[data-view="selection"]').addClass('active');
        });

        $('.model-cont .buy').off('.assistantEvents');
        $('.model-cont .buy').on('click.assistantEvents', function () {
            that.modals.subscribe.open();
        });
    }

    that.showCategoryProducts = function (category, label) {
        $('.wizard .view').removeClass('active');
        var $view = $('.wizard .view[data-view="products"]');
        $view.addClass('active');
        $('.wizard [data-view="products"] .title').html(label);
        if (that.results['specific-' + category]) {
            var clothes = that.results['specific-' + category];
            that.clothes = clothes;
            that.showAssistantProducts(clothes);
            that.productEvents();
            var title = label + ' (' + clothes.length + ')';
            $('.wizard [data-view="products"] .title').html(title);
        } else {
            var data = {brand: that.brandID, category: category};
            $view.addClass('loading');
            $view.find('.products').html('');
            $.ajax({
                method: 'GET',
                url: that.rootURL + '/wp-json/wp/v2/specific-clothes',
                headers: {
                    'Authorization': 'Bearer ' + that.token,
                    'Content-Type': 'application/json'
                },
                data: data,
                success: function (resp) {
                    var clothes = resp.clothes;
                    that.clothes = clothes;
                    clothes.forEach(function (product) {
                        if (!that.products[product.reference]) {
                            that.products[product.reference] = product;
                        }
                    });
                    that.results['specific-' + category] = clothes;
                    var title = label + ' (' + clothes.length + ')';
                    $('.wizard [data-view="products"] .title').html(title);
                    that.showAssistantProducts(clothes);
                    that.productEvents();
                },
                error: function (xhr, statusText) {
                    alert('Une erreur est survenue.');
                },
                complete: function () {
                    $view.removeClass('loading');
                }
            });
        }
    }

    that.showAssistantProducts = function (products) {
        var $view = $('.wizard [data-view="products"]');
        var $products = $view.find('.products');
        $products.html('');
        products.forEach(function (product) {
            var productHTML = '<div class="product" data-id="' + product.id + '" data-ready="true" data-price="' + product.price + '" data-sale-price="' + product.sale_price + '" data-image="' + product.image + '" data-category="' + product.category + '" data-org-category="' + product.org_category + '" data-ref="' + product.reference + '">';
            if (product.image) {
                productHTML += '<div class="image" style="background-image: url(\'' + product.image + '\')"></div>';
            } else {
                productHTML += '<div class="image"></div>';
            }
            productHTML += '<div class="name"><span>' + product.name + '</span></div>';
            productHTML += '</div>';
            $products.append(productHTML);
        }); 
    }

    that.showWindowProducts = function ($window, products) {
        $window.find('.products .product-list').html('');
        products.forEach(function (product) {
            var productHTML = '<div class="product" data-ref="' + product.reference + '" data-image="' + product.image + '">';
            productHTML += '<div class="image" style="background-image: url(\'' + product.image + '\')"></div>';
            productHTML += '<div class="name">' + product.name + '</div>';
            productHTML += '</div>';
            $window.find('.products .product-list').append(productHTML);
        }); 
    }

    that.windowProductEvents = function () {
        $('.model-cont .window .product').off('.windowProductEvent');
        $('.model-cont .window .product').on('click.windowProductEvent', function () {
            $(this).parents('.window').find('.product').removeClass('selected');
            $(this).addClass('selected');
            $('.related-looks [data-view="looks"]').addClass('active');
            $('.related-looks [data-view="product-detail"]').removeClass('active');
        })
    }

    that.like = function (data, callback) {
        $('.related-looks .no-result').hide();
        var looks = (that.tab === 'proposed') ? that.looks : that.favorites;
        var index = that.getLookIndex(looks, that.selectedLookID);
        that.favorites.push(that.looks[index]);
        that.showLook(that.favorites.length - 1, that.looks[index], 'favorites');
        that.lookEvents();
        $.ajax({
            method: 'POST',
            url: that.rootURL + '/wp-json/wp/v2/look/like',
            headers: {
                'Authorization': 'Bearer ' + that.token,
                'Content-Type': 'application/json'
            },
            data: JSON.stringify(data),
            success: function (resp) {
                
            },
            error: function (xhr, statusText) {
                alert('Une erreur est survenue.');
            },
            complete: function () {
                if (callback) callback();
            }
        });
    }

    that.swipeEvents = function () {
        let touchstartX = 0
        let touchendX = 0


        function handleGesture() {

            var currentView = $('.sp-menu .item.active').attr('data-view');
            var views = ['dressing', 'looks', 'model'];
            var index = views.indexOf(currentView);
            
            if (that.isSP() && that.mode !== 'client') {

                // Swipe Left
                if (touchendX < touchstartX) {
                    
                    if (index < views.length - 1) {
                        index++;
                        $('.sp-menu [data-view="' + views[index] + '"]').click();
                    }
                    
            
                }

                // Swipe Right
                if (touchendX > touchstartX) {
                    if (index >= 1) {
                        index--;
                        $('.sp-menu [data-view="' + views[index] + '"]').click();
                    }  
                }
            } else if (that.isSP() && that.mode === 'client') {

                var $currentSuggestion = $('.related-looks .looks.proposed .item.selected');
                var currIndex = $('.related-looks .looks.proposed .item').index($currentSuggestion);

                
                if (touchendX < touchstartX) {
                    var nextIndex = currIndex+1;
                    $('.vote .dislike').click();
                    //$('.related-looks .looks.proposed .item').eq(nextIndex).click();
                }

                if (touchendX > touchstartX) {
                    var prevIndex = currIndex-1;
                    $('.vote .like').click();
                    //$('.related-looks .looks.proposed .item').eq(prevIndex).click();
                }
            }
        }

        document.addEventListener('touchstart', e => {
            touchstartX = e.changedTouches[0].screenX
        });

        document.addEventListener('touchend', e => {
            touchendX = e.changedTouches[0].screenX
            handleGesture()
        });
    }

    that.removeLike = function (lookID, callback) {
        that.removeCurrentFromFavorites();
        
        $.ajax({
            method: 'DELETE',
            url: that.rootURL + '/wp-json/wp/v2/look/like?user_id=' + that.userID + '&look_id=' + lookID,
            headers: {
                'Authorization': 'Bearer ' + that.token,
                'Content-Type': 'application/json'
            },
            success: function (resp) {
            },
            error: function (xhr, statusText) {
                alert('Une erreur est survenue.');
            },
            complete: function () {
                if (callback) callback();
            }
        });
    }

    that.dislike = function (lookID, callback) {
        var index = that.blacklist.indexOf(lookID);
        if (index < 0) {
            $.ajax({
                method: 'POST',
                url: that.rootURL + '/wp-json/wp/v2/look/dislike?look_id=' + lookID,
                headers: {
                    'Authorization': 'Bearer ' + that.token,
                    'Content-Type': 'application/json'
                },
                success: function (resp) {
                },
                error: function (xhr, statusText) {
                    alert('Une erreur est survenue.');
                },
                complete: function () {
                    if (callback) callback();
                }
            });
        } else {
            if (callback) callback();
        }
        
    }

    that.replaceCloth = function (targetRef, replaceRef) {
        let i = 0, foundTarget = false;
        var cat = (that.tab === 'proposed') ? 'looks' : 'favorites';
        var looks = that[cat];
        var look = looks[that.lookIndex];
        while (!foundTarget && i < look.length) {
            if (look[i].reference === targetRef) foundTarget = true;
            else i++;
        }
        if (foundTarget) {
            that[cat][that.lookIndex][i] = that.products[replaceRef];
        }
        that.refreshCurrentLook();
        that.UIEvents();
        that.clothEvents();
        $('.related-looks .item.selected').click();
    }

    that.refreshCurrentLook = function () {
        var $look = $('.related-looks .item.selected');
        var cat = (that.tab === 'proposed') ? 'looks' : 'favorites';
        var look = that[cat][that.lookIndex];
        var lookHTML = that.getLookHTML(that.lookIndex, look);
        $look.attr('data-look', that.getLookID(look));
        $look[0].outerHTML = lookHTML;
        $('.related-looks .active .item').eq(that.lookIndex).addClass('selected');
        that.lookEvents();
    }


    that.resetLooks = function () {
        $('.related-looks .looks.proposed').html('');
        $('.model-cont .window .list').html('');
        $('.model-cont .cloth').remove();
        $('.model-cont .window:not(.settings-cont)').hide();
        $('.model-cont .vote').hide();
        $('.model-cont .comment').hide();
        $('.model-cont .vote div').removeClass('selected');
        $('.model-cont .window').removeClass('full-screen');
        $('.model-outer').removeClass('window-open');
    }

    that.getLooks = function (category) {
        that.resetLooks();

        if (that.results[category]) {
            that.clothes = that.results[category];
            that.clothesLoaded(category);
            that.productEvents();
        } else {
            $('.related-looks').addClass('loading');
            $.ajax({
                method: 'GET',
                url: that.rootURL + '/wp-json/wp/v2/products?category=' + category,
                headers: {
                    'Authorization': 'Bearer ' + that.token,
                    'Content-Type': 'application/json'
                },
                success: function (resp) {
                    that.clothes = resp.clothes;
                    for (let cat in that.clothes) {
                        that.clothes[cat].forEach(function (product) {
                            if (!that.products[product.reference]) that.products[product.reference] = product;
                        })
                    }

                    that.results[category] = resp.clothes;
                    that.clothesLoaded(category);
                },
                complete: function (resp) {
                    $('.related-looks').removeClass('loading');
                    that.productEvents();
                }
            });
        }
        
    }

    that.clothesLoaded = function (category) {
        if (!(that.isSP() && that.mode === 'client')) $('.model-cont .vote').fadeIn();
        $('.model-cont .comment').fadeIn();
        $('.model-cont .action-btn').fadeIn();

        that.looks = [];
        that.looksOffset = 0;

        switch (category) {
            case 'coat':
            case 'vest':
                that.looks = that.get_fullbody_looks();
                break;
            case 'top_tshirt':
            case 'shirt':
            case 'cardigan':
                that.looks = that.get_torse_looks();
                break;
            case 'pants':
            case 'skirt':
            case 'short':
                that.looks = that.get_legs_looks();
                break;
            case 'accessory':
                that.looks = that.get_accessory_looks();
                break;
            case 'jumpsuit':
            case 'dress':
                that.looks = that.get_rest_looks();
                break;
        }
                
        that.looks = that.shuffle(that.looks);
        that.addSelectionToLooks();
        that.removeBlacklisted();
        
        //that.looks = that.constantLooks.concat(that.looks);

        that.showLooks(that.looks, 'proposed');
        that.addTags();
        that.lookEvents();
        that.tagEvents();
        $('.related-looks .count').html(that.looks.length);
        $('.related-looks .active .item').eq(0).click();
    }

    that.addTags = function () {
        var $selectedProduct = $('.product-selection .selected');
        var selectedRef = $selectedProduct.attr('data-ref');
        var product = that.products[selectedRef];
        var label = '';
        if (that.colors[product.color]) label = that.colors[product.color].label;
        //$('.related-looks .tags').append('<div class="tag total-look">Total look ' + label +'</div>');
    }

    that.addSelectionToLooks = function () {
        that.looks.forEach(function (look) {
            var $selectedProduct = $('.product-selection .selected');
            var selectedRef = $selectedProduct.attr('data-ref');
            var product = that.products[selectedRef];
            if (product) {
                product.is_owned = (that.mode === 'assistant') ? false : true;
                look.unshift(product);
            } else {
                console.error('PRODUCT NOT FOUND: ' + selectedRef)
            }

        });
    }

    that.optionEvents = function () {

        $('.option .item').off('.optionEvents');
        $('.option .item').on('click.optionEvents', function () {
            var cat = $(this).attr('data-category');
            $(this).addClass('active');
            var $popup = $('.popup[data-category="' + cat +  '"]');

            if (!$popup.hasClass('shown')) {
                var $item = $(this);
                var itemL = $item.offset().left;
                if ($('#adminmenuback').length > 0) itemL -= $('#adminmenuback').outerWidth() + 20;
                var itemT = $item.offset().top;
                var itemW = $item.outerWidth();
                $popup.css({
                    left: (itemL + itemW) + 'px',
                    top:  itemT + 'px',
                });
                
                $popup.addClass('shown').fadeIn(300, function () {
                    that.canClosePopup = true;
                });
                
                if (!that.results[cat]) {
                    var data = {};
                    switch(cat) {
                        case 'dress-black':
                            data = {
                                category: 'dress',
                                color: 900
                            }
                            break;
                        case 'total-white':
                            data = {
                                category: 'clothes',
                                color: 250
                            }
                            break;
                        case 'plain-tshirt':
                            data = {
                                category: 'shirt'
                            }
                            break;
                        
                        case 'vest-jean':
                            data = {
                                category: 'vest',
                                color: 400
                            }
                            break;
                    }
                    $.ajax({
                        method: 'GET',
                        url: that.rootURL + '/wp-json/wp/v2/specific-clothes',
                        headers: {
                            'Authorization': 'Bearer ' + that.token,
                            'Content-Type': 'application/json'
                        },
                        data: data,
                        success: function (resp) {
                            const clothes = resp.clothes;
                            that.results[cat] = clothes;
                            clothes.forEach(function (product) {
                                if (!that.products[product.reference]) {
                                    that.products[product.reference] = product;
                                }
                            })
                            that.showPopupClothes($popup, clothes);
                            that.popupClothEvents($popup);
                        },
                        error: function (xhr, statusText) {
                            alert('Une erreur est survenue.');
                        }
                    });
                }
            }
        });

        $('body').off('.popupEvents');
        $('body').on('click.popupEvents', function(e) {
            if (that.canClosePopup) {
                if ($(e.target).parents('.popup').length === 0) {
                    var $popup = $('.popup.shown');
                    var cat = $popup.attr('data-category');
                    $('.option .item[data-category=' + cat + ']').removeClass('active');
                    $popup.fadeOut().removeClass('shown');
                    that.canClosePopup = false;
                }
            }
        });
        
    }

    that.showPopupClothes = function ($popup, clothes) {
        $popup.find('.products').html('');
        clothes.forEach(function (cloth) {
            var productHTML = '<div class="product" data-id="' + cloth.id + '">';
                productHTML += '<div class="image" style="background-image: url(\'' + cloth.image + '\')"></div>';
                productHTML += '<div class="name">' + cloth.name + '</div>';
            productHTML += '</div>';
            $popup.find('.products').append(productHTML);
        })
    }

    that.popupClothEvents = function ($popup) {
        $popup.find('.product').on('click', function () {
            $('.product-selection .item').removeClass('selected');
            $('.wizard .product').removeClass('selected');
            $popup.find('.product').removeClass('selected');
            $(this).addClass('selected');
        });
    }

    that.productEvents = function () {
        $('.product-selection .result.items .item, .wizard .product').off('.productEvents');
        $('.product-selection .result.items .item, .wizard .product').on('click.productEvents', function () {
            if (!$('.model-cont').hasClass('loading')) {
                var category = $(this).attr('data-category');
                $('.product-selection .result.items .item, .wizard .product').removeClass('selected');
                $(this).addClass('selected');
                that.getLooks(category);
                if (that.isSP()) {
                    $('.sp-menu [data-view=looks]').click();
                }
            }
        });
    }


    that.showLooks = function(looks, tab) {
        var offset = (tab === 'proposed') ? that.looksOffset : that.favoritesOffset;
        
        for(var i = offset; i < offset+that.looksLoadCount; i++) {
            if (looks[i]) {
                that.showLook(i, looks[i], tab);
            }
        }
        if (tab === 'proposed') that.looksOffset += that.looksLoadCount;
        else that.favoritesOffset += that.looksLoadCount;
    }

    that.showLook = function (i, look, tab) {
        var lookHTML = that.getLookHTML(i, look);
        $('.related-looks .looks.' + tab).append(lookHTML);
     
        if ($('.window:not(.setttings) .list .item').length === 0) {
            $(this).parents('.window').hide();
        }
    }

    that.getLookHTML = function (i, look) {
        var totalPrice = that.calculatePrice(look);
        var lookID = that.getLookID(look);
        var lookHTML = '<div class="item" data-look="' + lookID + '">';
        lookHTML += '<div class="title">Look ' + (i+1) + '</div>';

        if (that.isSP()) {
            lookHTML += '<div class="show-look">';
            lookHTML += '<button type="button"><i class="fas fa-eye"></i> Voir</button>';
            lookHTML += '</div>';
        }
    
        look.forEach(function (product) {
            if (!that.products[product.reference]) that.products[product.reference] = product;
            lookHTML += that.getProductHTML(product);
        });
        
        lookHTML += '<div class="price">' + totalPrice + '€</div>'
        lookHTML += '</div>';

        return lookHTML;
    }

    that.getProductHTML = function (product) {
        var lookHTML = '';
        var selectionClass = (product.is_owned) ? 'selection' : '';
        lookHTML += '<div class="product ' + selectionClass + '" data-id="' + product.id + '" data-ref="' + product.reference + '" data-category="' + product.category + '" data-image="' + product.image + '">';
        lookHTML += '<div class="image" style="background-image: url(\'' + product.image + '\')"></div>';
        lookHTML += '<div class="name">' + product.name + '</div>';
        if (product.sale_price !== '' && product.sale_price !== '0' && product.sale_price !== product.price) {
            lookHTML += '<div class="tip sale">En solde</div>';
        }
        if (product.is_owned) {
            lookHTML += '<div class="tip sold">Green</div>';
        }
        lookHTML += '</div>';
        return lookHTML;
    }

    that.calculatePrice = function (look) {
        var total = 0;
        look.forEach(function (product) {
            if (!product.is_owned) {
                total += (product.sale_price !== '' && product.sale_price !== '0') ? parseFloat(product.sale_price) : parseFloat(product.price);
            }
        });
        return total.toFixed(2);
    }

    that.lookEvents = function () {

        $('.related-looks .looks').off('.lookEvents');
        $('.related-looks .looks').on('scroll.lookEvents', function () {
            var limit = ($(this)[0].scrollHeight - $(this).outerHeight()) - 50;
            var looks = (that.tab === 'proposed') ? that.looks : that.favorites;
            var offset = (that.tab === 'proposed') ? that.looksOffset : that.favoritesOffset;
            if (offset < looks.length && $(this).scrollTop() >= limit) {
                that.showLooks(looks, that.tab);
                setTimeout(that.lookEvents, 20);
            }
        });

        $('.related-looks .item').off('.lookEvents');
        $('.related-looks .item').on('click.lookEvents', function () {

            that.selectedLookID = $(this).attr('data-look');
            var looks = (that.tab === 'proposed') ? that.looks : that.favorites;
            that.lookIndex = that.getLookIndex(looks, that.selectedLookID);

            that.resetModelView();

            var $item = $(this);
            $item.addClass('selected');
            var look = $item.attr('data-look');
            var $replace = $('#replace-cloth');
 
            if (!that.isSP() && $replace.attr('data-look') !== look) {
                $replace.hide();
                $('.related-looks .item .product.selected').removeClass('selected');
            }
            
            var $products = $item.find('.product:not(.selection)');

            if (that.tab === 'proposed') {
                var $selectedProduct = (that.mode === 'assistant') ? $('.wizard .product.selected') : $('.product-selection .item.selected');
                var selectedRef = $selectedProduct.attr('data-ref');
                var selectedCat = $selectedProduct.attr('data-category');
            
                if (that.mode !== 'assistant' && $selectedProduct.attr('data-ready') === 'true') {
                    if (selectedCat === 'accessory') {
                        that.attachAccessory(selectedRef);
                    } else if (selectedCat === 'coat' || selectedCat === 'vest') {
                        that.attachCoatVest(selectedRef);
                        that.attachCloth(selectedRef);
                    } else {
                        that.attachCloth(selectedRef);
                    }
                }
            }

            var onLookLoaded = function () {
                $('.model-cont').removeClass('loading');

                $products.each(function () {
                    var $product = $(this);
                    var ref = $product.attr('data-ref');
                    var category = $product.attr('data-category');
    
                    if (category === 'accessory') {
                        that.attachAccessory(ref);
                    } else if (category === 'vest' || category === 'coat') {
                        that.attachCoatVest(ref);
                        that.attachCloth(ref);
                    } else {
                        that.attachCloth(ref);
                    }
                });
    
                if (!(that.isSP() && that.mode === 'client')) $('.model-cont .vote').show();
                $('.model-cont .comment').show();
                $('.model-cont .action-btn').show();
                $('.model-cont .window').show();
                that.showVote();
                that.showProposal();
                $('.model-cont .book').show();
                that.lookProductEvents();
                that.UIEvents();
                that.clothEvents();
                that.applyLookSceneRule();
                $('.model-cont .window').each(function () {
                    if ($(this).find('.item').length === 0) {
                        $(this).hide();
                    }
                })
             
            }


            $('.model-cont').addClass('loading');
            var loadedCount = 0;
            $products.each(function() {
                var img = new Image();
                var category = $(this).attr('data-category');
                var reference = $(this).attr('data-ref');
                if (category !== 'accessory') {
                    img.src = that.calibrationURL + '/assets/images/clothes/' + reference + '.png';
                    img.onload = function () {
                        loadedCount++;
                        if (loadedCount === $products.length) onLookLoaded();
                    }
                } else {
                    loadedCount++;
                }
            });

            
        });

        $('.related-looks .item .show-look button').off('.lookEvents');
        $('.related-looks .item .show-look button').on('click.lookEvents', function (e) {
            $('.sp-menu .item[data-view="model"]').click();
        });
    
    }

    that.tagEvents = function () {
        $('.related-looks .tags .tag').off('.tagEvents');
        $('.related-looks .tags .tag.total-look').on('click.tagEvents', function () {

            if (!$(this).hasClass('selected')) {
                $(this).addClass('selected');
                var $selectedProduct = $('.product-selection .selected');
                var selectedRef = $selectedProduct.attr('data-ref');
                var product = that.products[selectedRef];
                var productColor = (that.colors[product.color]) ? that.colors[product.color].name : product.color;
                var newLooks = [];
                that.looks.forEach(function (look) {
                    let topFit = false, i = 0;
                    while (!topFit && i < look.length) {
                        var prod = look[i];
                        var prodColor = (that.colors[prod.color]) ? that.colors[prod.color].name : prod.color;
                        if (
                            (prod.category === 'top_tshirt' || prod.category === 'shirt' || prod.category === 'cardigan') 
                            && prodColor === productColor
                        ) topFit = true;
                        else i++;
                    }
                    let bottomFit = false, j = 0;
                    while(!bottomFit && j < look.length) {
                        var prod = look[j];
                        var prodColor = (that.colors[prod.color]) ? that.colors[prod.color].name : prod.color;
                        if (
                            (prod.category === 'pants' || prod.category === 'short' || prod.category === 'skirts') 
                            && prodColor === productColor
                        ) bottomFit = true;
                        else j++;
                    }
                    if (topFit && bottomFit) {
                        newLooks.push(look);
                    } else {
                        let fullFit = false, x = 0;
                        while (!fullFit && x < look.length) {
                            var prod = look[x];
                            var prodColor = (that.colors[prod.color]) ? that.colors[prod.color].name : prod.color;
                            if (
                                (prod.category === 'dress' || prod.category === 'jumpsuit') 
                                && prodColor === productColor
                            ) fullFit = true;
                            else x++;
                        }
                        if (fullFit) newLooks.push(look);
                    }
                });
                that.orgLooks = JSON.parse(JSON.stringify(that.looks));
                that.looks = newLooks;
                
            } else {
                $(this).removeClass('selected');
                that.looks = JSON.parse(JSON.stringify(that.orgLooks));
            }

            that.resetLooks();
            that.showLooks(that.looks, 'proposed');
            that.lookEvents();
            $('.related-looks .count').html(that.looks.length);
            $('.related-looks .active .item').eq(0).click();
            $('.related-looks .no-result').hide();

        });
    }

    that.resetModelView = function () {
        $('.related-looks .item').removeClass('selected');
        $('.model-cont .cloth').remove();
        $('.model-cont .window:not(.settings-cont)').hide();
        $('.model-cont .window .list').html('');
        $('.model-cont .vote div').removeClass('selected');
        $('.model-cont .vote').hide();
        $('.model-cont .comment').hide();
        $('.model-cont .action-btn').hide();
        $('.model-cont .window:not(.settings-cont)').removeClass('full-screen');
        $('.model-outer').removeClass('window-open');
        $('.model-cont .composition').remove();
    }

    that.lookProductEvents = function () {

        var positionning = function ($product) {
            var $replace = $('#replace-cloth');
            var $looks = $('.related-looks .looks');
            var top = ($product.offset().top - $looks.offset().top) + $product.outerHeight() + 85;
            var left = $product.offset().left - $looks.offset().left;
            var width = $product.outerWidth();
            $replace.css({
                top: top  + 'px'
            });
            $replace.find('.triangle').css('left', (left + (width/2) - 20) + 'px');
        }

        $('.related-looks .item.selected .product').off('.lookProductEvents');
        $('.related-looks .item.selected .product').on('click.lookProductEvents', function () {
            if (!that.isSP()) {
                var $this = $(this);
                $('.related-looks .item.selected .product.selected').removeClass('selected');
                $this.addClass('selected');
                var $look = $this.parents('.item');
                var look = $look.attr('data-look');
                var productID = $this.attr('data-id'); 
                var category = $this.attr('data-category');
                var siblingCategories = that.getSiblingCategories(category);

                var $replace = $('#replace-cloth');
                $replace.attr('data-look', look);
                $replace.attr('data-product-id', productID);
                $replace.find('.products').html('');

                positionning($this);

                $replace.addClass('loading');
                $replace.fadeIn(function () {
                    that.canCloseProduct = true;
                });

                if (!that.results['part-' + category]) {
                    $.ajax({
                        method: 'GET',
                        url: that.apiURL + '/products-category/?category=' + siblingCategories.join(','),
                        success: function (resp) {
                            var products = resp.data;
                            that.results['part-' + category] = products;
                            that.partProducts = products;
                            that.showProductPart(look, products);
                        }, 
                        error: function () {
                            
                        }, 
                        complete: function () {
                            $replace.removeClass('loading');
                        }
                    });
                } else {
                    $replace.removeClass('loading');
                    that.showProductPart(look, that.results['part-' + category]);
                    that.partProducts = that.results['part-' + category];
                }
            } else {
            }
        });

        $('.related-looks .looks').off('.lookProductEvents');
        $('.related-looks .looks').on('scroll.lookProductEvents', function () {
            var $replace = $('#replace-cloth');
            var look = $replace.attr('data-look');
            var productID = $replace.attr('data-product-id');
            var $look = $('.related-looks .active .item[data-look="' + look + '"]');
            var $product = $look.find('.product[data-id="' + productID + '"]');
            if ($look && $product.length > 0) {
                positionning($product);
            }
            
        });

        $('body').off('.lookProductEvents');
        $('body').on('click.lookProductEvents', function(e) {
            if (that.canCloseProduct) {
                if ($(e.target).parents('#replace-cloth').length === 0) {
                    $('.related-looks .item.selected .product.selected').removeClass('selected');
                    $('#replace-cloth').fadeOut();
                    that.canCloseProduct = false;
                } 
            }
        });

    }
    
    that.showProductPart = function (look, products) {
        var $replace = $('#replace-cloth');
        products.forEach(function (product) {
            var productHTML = '<div class="product" data-ref="' + product.reference + '" data-id="' + product.id + '" data-look="' + look + '">';
            productHTML += '<div class="image" style="background-image: url(\'' + product.image + '\')"></div>';
            productHTML += '<div class="name">' + product.name + '</div>';
            productHTML += '</div>';
            $replace.find('.products').append(productHTML);
        });

        $('#replace-cloth .product').off('.productPartEvent');
        $('#replace-cloth .product').on('click.productPartEvent', function () {
            $('#replace-cloth .selected').removeClass('selected');
            $(this).addClass('selected');
            $('#replace-cloth .replace').attr('disabled', false);
        });

        $('#replace-cloth .replace').off('.productPartEvent');
        $('#replace-cloth .replace').on('click.productPartEvent', function () {
            var selectedRef = $('.related-looks .item.selected .product.selected').attr('data-ref');
            var replaceRef = $('#replace-cloth .product.selected').attr('data-ref');
            that.replaceCloth(selectedRef, replaceRef);
            $replace.hide();
        });
    }

    that.showVote = function () {
        $('.model-cont .vote div').removeClass('selected');

        var looks = (that.tab === 'proposed') ? that.looks : that.favorites;
        var look = that.getLook(looks, that.selectedLookID);
        var lookID = that.getLookID(look);

        var found = false; i = 0;
        while (!found && i < that.favorites.length) {
            var look = that.favorites[i];
            var favoriteLookID = that.getLookID(look);
            if (favoriteLookID === lookID) found = true;
            else i++;
        }

        if (found) {
            $('.model-cont .vote div.like').addClass('selected');
        } 

        var blacklistIndex = that.blacklist.indexOf(lookID);
        if (blacklistIndex >= 0) {
            $('.model-cont .vote div.dislike').addClass('selected');
        }
        
    }

    that.showProposal = function () {
        $('.model-cont .propose').hide();
        $('.model-cont .unpropose').hide();

        var looks = (that.tab === 'proposed') ? that.looks : that.favorites;
        var look = that.getLook(looks, that.selectedLookID);
        var lookID = that.getLookID(look);

        if (that.mode !== 'client') {
            var i = 0; var found = false;
            while (!found && i < that.suggestedLooks.length) {
                if (that.suggestedLooks[i].products === lookID) found = true;
                else i++;
            }
            if (found) {
                $('.model-cont .unpropose').fadeIn();
            } else {
                $('.model-cont .propose').fadeIn();
            }
        }
    }

    that.attachCloth = function (reference) {
        var product = that.products[reference];
        var category = product.category;
         var image = new Image();
        $(image).addClass('cloth').addClass('before-move');
        $(image).attr('data-category', product.category);
        $(image).attr('data-ref', reference);
        $(image).attr('data-id', product.id);
        image.src = that.calibrationURL + '/assets/images/clothes/' + reference + '.png';
        if (category === 'coat' || category === 'vest') $(image).hide();
        $('.model-outer .clothing').append(image);

        var clothPos = that.clothPos['default' + that.modelSize][reference];

        if (clothPos) {
            $(image).css({
                left: clothPos.left + 'px',
                top: clothPos.top + 'px',
                width: clothPos.width + 'px',
                height: clothPos.height + 'px'
            });
        } else {
            console.error('CLOTH DATA NOT FOUND :' + reference);
        }

        var bodyPart = 'top';
        switch (category) {
            case 'coat':
            case 'vest':
                image.style.zIndex = 4;
                bodyPart = 'top';
                break;
            case 'dress':
                image.style.zIndex = 3;
                boyPart = 'full';
                break;
            case 'top_tshirt':
            case 'shirt':
            case 'cardigan':
                image.style.zIndex = 2;
                $(image).css('transition-delay', '300ms');
                bodyPart = 'top';
                break;
            case 'pants':
            case 'skirt':
            case 'short':
                image.style.zIndex = 1;
                bodyPart = 'bottom';
                break;
            default: 
                image.style.zIndex = 1;
                bodyPart = 'bottom';
                break;
        }

        if (category !== 'coat' && category !== 'vest' && product.composition) {
            var composition = product.composition;
            composition = composition.replace('[1] Main Fabric: ', '');
            composition = composition.replace(/[0-9]/g, '');
            composition = composition.replace(/\%/g, '');
            composition = composition.replace(/\[\]/g, '');

            var $comp = $('<div class="composition">' + composition + '</div>');
            $comp.addClass(bodyPart);
            $comp.addClass('before-show');
            $('.clothing').append($comp);

            var delay = (bodyPart === 'top') ? 900 : 1200;
            setTimeout(function () {
                $comp.removeClass('before-show');

                setTimeout(function () {
                    $comp.fadeOut(function () {
                        $comp.remove();
                    });
                }, 5000)
            }, delay);
            
        }
        
        setTimeout(function () {
            $(image).removeClass('before-move');
            that.updateLayout();
        }, 100);
    }

    that.clothEvents = function () {

        $('.model-cont .cloth').off('.clothEvents');
        $('.model-cont .cloth').on('click.clothEvents', function () {
            $('.model-cont .cloth').removeClass('selected');
            $(this).addClass('selected');
            var category = $(this).attr('data-category');
            var siblingCategories = that.getSiblingCategories(category);
            var $window = $('.model-outer .cloth-replace');
            $window.show();
            setTimeout(function () {
                $window.addClass('full-screen');
            }, 100);
            $('.model-outer').addClass('window-open');
            $('.window.cloth-replace .product-list').html('');
            $('.window.cloth-replace .loading').show();
            if (!that.results['part-' + category]) {
                $.ajax({
                    method: 'GET',
                    url: that.apiURL + '/products-category/?category=' + siblingCategories.join(','),
                    success: function (resp) {
                        var products = resp.data;
                        that.results['part-' + category] = products;
                        that.partProducts = products;
                        that.showWindowProducts($window, products);
                        that.windowProductEvents();
                    }, 
                    error: function () {
                        
                    }, 
                    complete: function () {
                        $window.find('.loading').fadeOut();
                    }
                });
            } else {
                that.partProducts = that.results['part-' + category];
                var products = that.partProducts;
                $window.find('.loading').fadeOut();
                that.showWindowProducts($window, products);
                that.showWindowProducts($window, products);
                that.windowProductEvents().acces
            }
        });
    }

    that.getFavoriteIndex = function (lookID) {
        var i = 0; var found = false;
        while (!found && i < that.favorites.length) {
            var favoriteLookID = that.getLookID(that.favorites[i]);
            if (favoriteLookID === lookID) found = true;
            else i++;
        }
        return (found) ? i : -1;
    }

    that.attachAccessory = function (ref) {
        var product = that.products[ref];
        var image = new Image();
        $(image).addClass('item');
        $(image).attr('data-id', product.id);
        $(image).attr('data-ref', product.reference);
        $(image).attr('data-src', product.image);
        image.src = product.image;
        $('.model-cont .accessories .list').append(image);
        $('.model-cont .window.accessories').show();
    }

    that.attachCoatVest = function (ref) {
        var product = that.products[ref];
        var image = new Image();
        $(image).addClass('item');
        $(image).attr('data-id', product.id);
        $(image).attr('data-ref', product.reference);
        image.src = product.image;
        $('.model-cont .coat-vest .list').append(image);
        $('.model-cont .window.coat-vest').show();
    }

    that.removeBlacklisted = function () {
        var newLooks = [];
        that.looks.forEach(function (look) {
            var lookID = that.getLookID(look);
            var blacklistIndex = that.blacklist.indexOf(lookID);
            if (blacklistIndex < 0) newLooks.push(look);
            else console.log('[BLACKLIST] remove blacklisted look ' + lookID);
        });
        that.looks = newLooks;
    }

    that.shuffle = function (array) {
        let currentIndex = array.length,  randomIndex;
        while (currentIndex != 0) {
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex--;
        
            [array[currentIndex], array[randomIndex]] = [
            array[randomIndex], array[currentIndex]];
        }
        return array;
    }

    that.getLookID = function (look) {
        var lookID = '';
        look.forEach(function (product, index) {
            lookID += product.id;
            if (index < look.length - 1) lookID += '-';
        });

        return lookID;
    }

    that.getLookIndex = function (looks, wantedLookID) {
        var found = false; i = 0;
        while (!found && i < looks.length) {
            var lookID = that.getLookID(looks[i]);
            if (lookID === wantedLookID) found = true;
            else i++;
        }
        return (found) ? i : -1;
    }

    that.getLook = function (looks, wantedLookID) {
        var lookIndex = that.getLookIndex(looks, wantedLookID);
        return (lookIndex >= 0) ? looks[lookIndex] : null;
    }

    that.getLookByID = function (lookID) {
        var productIDs = lookID.split('-');
        var look = [];
        productIDs.forEach(function (productID) {
            productID = parseInt(productID);
            var product = that.getProductByID(productID);
            if (product) look.push(product);
        });
        return look;
    }

    that.getProductByID = function (productID) {
        let i = 0, found = false;
        let references = Object.keys(that.products);
        while (!found && i < references.length) {
            var ref = references[i];
            var product = that.products[ref];
            if (product.id === productID) found = true;
            else i++;
        }
        return (found) ? that.products[references[i]] : null;
    }

    that.get_fullbody_looks = function() {

        var looks = [];
    
        if (that.clothes.pants) {
    
            if (that.clothes.top_tshirt) {
                for (i = 0; i < that.clothes.pants.length; i++) {
                    for (j = 0; j < that.clothes.top_tshirt.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.top_tshirt[j], that.clothes.pants[i], that.clothes.accessory[k]]);
                        }
                    }
                }
            }
    
            if (that.clothes.shirt) {
                for (i = 0; i < that.clothes.pants.length; i++) {
                    for (j = 0; j < that.clothes.shirt.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.shirt[j], that.clothes.pants[i], that.clothes.accessory[k]]);
                        }
                    }
                }
            }
    
            if (that.clothes.cardigan) {
                for (i = 0; i < that.clothes.pants.length; i++) {
                    for (j = 0; j < that.clothes.cardigan.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.cardigan[j], that.clothes.pants[i], that.clothes.accessory[k]]);
                        }
                    }
                }
            }
    
        }
    
        if (that.clothes.skirt) {
            if (that.clothes.top_tshirt) {
                for (i = 0; i < that.clothes.skirt.length; i++) {
                    for (j = 0; j < that.clothes.top_tshirt.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.top_tshirt[j], that.clothes.skirt[i], that.clothes.accessory[k]]);
                        }
                    }
                }
            }
    
            if (that.clothes.shirt) {
                for (i = 0; i < that.clothes.skirt.length; i++) {
                    for (j = 0; j < that.clothes.shirt.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.shirt[j], that.clothes.skirt[i], that.clothes.accessory[k]]);
                        }
                    }
                }
            }
    
            if (that.clothes.cardigan) {
                for (i = 0; i < that.clothes.skirt.length; i++) {
                    for (j = 0; j < that.clothes.cardigan.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.cardigan[j], that.clothes.skirt[i], that.clothes.accessory[k]]);
                        }
                    }
                }
            }
        }
    
        if (that.clothes.short) {
            if (that.clothes.top_tshirt) {
                for (i = 0; i < that.clothes.short.length; i++) {
                    for (j = 0; j < that.clothes.top_tshirt.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.top_tshirt[j], that.clothes.short[i], that.clothes.accessory[k]]);
                        }
                    }
                }
            }
    
            if (that.clothes.shirt) {
                for (i = 0; i < that.clothes.short.length; i++) {
                    for (j = 0; j < that.clothes.shirt.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.shirt[j], that.clothes.short[i], that.clothes.accessory[k]]);
                        }
                    }
                }
            }
    
            if (that.clothes.cardigan) {
                for (i = 0; i < that.clothes.short.length; i++) {
                    for (j = 0; j < that.clothes.cardigan.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.cardigan[j], that.clothes.short[i], that.clothes.accessory[k]]);
                        }
                    }
                }
            }
        }
    
        return looks;
    }

    that.get_accessory_looks = function() {

        var looks = [];

        if (that.clothes.coat) {
            if (that.clothes.pants) {
    
                if (that.clothes.top_tshirt) {
                    for (i = 0; i < that.clothes.pants.length; i++) {
                        for (j = 0; j < that.clothes.top_tshirt.length; j++) {
                            for (k = 0; k < that.clothes.coat.length; k++) {
                                looks.push([that.clothes.top_tshirt[j], that.clothes.pants[i], that.clothes.coat[k]]);
                            }
                        }
                    }
                }
        
                if (that.clothes.shirt) {
                    for (i = 0; i < that.clothes.pants.length; i++) {
                        for (j = 0; j < that.clothes.shirt.length; j++) {
                            for (k = 0; k < that.clothes.coat.length; k++) {
                                looks.push([that.clothes.shirt[j], that.clothes.pants[i], that.clothes.coat[k]]);
                            }
                        }
                    }
                }
        
                if (that.clothes.cardigan) {
                    for (i = 0; i < that.clothes.pants.length; i++) {
                        for (j = 0; j < that.clothes.cardigan.length; j++) {
                            for (k = 0; k < that.clothes.coat.length; k++) {
                                looks.push([that.clothes.cardigan[j], that.clothes.pants[i], that.clothes.coat[k]]);
                            }
                        }
                    }
                }
        
            }
        
            if (that.clothes.skirt) {
                if (that.clothes.top_tshirt) {
                    for (i = 0; i < that.clothes.skirt.length; i++) {
                        for (j = 0; j < that.clothes.top_tshirt.length; j++) {
                            for (k = 0; k < that.clothes.coat.length; k++) {
                                looks.push([that.clothes.top_tshirt[j], that.clothes.skirt[i], that.clothes.coat[k]]);
                            }
                        }
                    }
                }
        
                if (that.clothes.shirt) {
                    for (i = 0; i < that.clothes.skirt.length; i++) {
                        for (j = 0; j < that.clothes.shirt.length; j++) {
                            for (k = 0; k < that.clothes.coat.length; k++) {
                                looks.push([that.clothes.shirt[j], that.clothes.skirt[i], that.clothes.coat[k]]);
                            }
                        }
                    }
                }
        
                if (that.clothes.cardigan) {
                    for (i = 0; i < that.clothes.skirt.length; i++) {
                        for (j = 0; j < that.clothes.cardigan.length; j++) {
                            for (k = 0; k < that.clothes.coat.length; k++) {
                                looks.push([that.clothes.cardigan[j], that.clothes.skirt[i], that.clothes.coat[k]]);
                            }
                        }
                    }
                }
            }
        
            if (that.clothes.short) {
                if (that.clothes.top_tshirt) {
                    for (i = 0; i < that.clothes.short.length; i++) {
                        for (j = 0; j < that.clothes.top_tshirt.length; j++) {
                            for (k = 0; k < that.clothes.coat.length; k++) {
                                looks.push([that.clothes.top_tshirt[j], that.clothes.short[i], that.clothes.coat[k]]);
                            }
                        }
                    }
                }
        
                if (that.clothes.shirt) {
                    for (i = 0; i < that.clothes.short.length; i++) {
                        for (j = 0; j < that.clothes.shirt.length; j++) {
                            for (k = 0; k < that.clothes.coat.length; k++) {
                                looks.push([that.clothes.shirt[j], that.clothes.short[i], that.clothes.coat[k]]);
                            }
                        }
                    }
                }
        
                if (that.clothes.cardigan) {
                    for (i = 0; i < that.clothes.short.length; i++) {
                        for (j = 0; j < that.clothes.cardigan.length; j++) {
                            for (k = 0; k < that.clothes.coat.length; k++) {
                                looks.push([that.clothes.cardigan[j], that.clothes.short[i], that.clothes.coat[k]]);
                            }
                        }
                    }
                }
            }
        }

        if (that.clothes.vest) {
            if (that.clothes.pants) {
    
                if (that.clothes.top_tshirt) {
                    for (i = 0; i < that.clothes.pants.length; i++) {
                        for (j = 0; j < that.clothes.top_tshirt.length; j++) {
                            for (k = 0; k < that.clothes.vest.length; k++) {
                                looks.push([that.clothes.top_tshirt[j], that.clothes.pants[i], that.clothes.vest[k]]);
                            }
                        }
                    }
                }
        
                if (that.clothes.shirt) {
                    for (i = 0; i < that.clothes.pants.length; i++) {
                        for (j = 0; j < that.clothes.shirt.length; j++) {
                            for (k = 0; k < that.clothes.vest.length; k++) {
                                looks.push([that.clothes.shirt[j], that.clothes.pants[i], that.clothes.vest[k]]);
                            }
                        }
                    }
                }
        
                if (that.clothes.cardigan) {
                    for (i = 0; i < that.clothes.pants.length; i++) {
                        for (j = 0; j < that.clothes.cardigan.length; j++) {
                            for (k = 0; k < that.clothes.vest.length; k++) {
                                looks.push([that.clothes.cardigan[j], that.clothes.pants[i], that.clothes.vest[k]]);
                            }
                        }
                    }
                }
        
            }
        
            if (that.clothes.skirt) {
                if (that.clothes.top_tshirt) {
                    for (i = 0; i < that.clothes.skirt.length; i++) {
                        for (j = 0; j < that.clothes.top_tshirt.length; j++) {
                            for (k = 0; k < that.clothes.vest.length; k++) {
                                looks.push([that.clothes.top_tshirt[j], that.clothes.skirt[i], that.clothes.vest[k]]);
                            }
                        }
                    }
                }
        
                if (that.clothes.shirt) {
                    for (i = 0; i < that.clothes.skirt.length; i++) {
                        for (j = 0; j < that.clothes.shirt.length; j++) {
                            for (k = 0; k < that.clothes.vest.length; k++) {
                                looks.push([that.clothes.shirt[j], that.clothes.skirt[i], that.clothes.vest[k]]);
                            }
                        }
                    }
                }
        
                if (that.clothes.cardigan) {
                    for (i = 0; i < that.clothes.skirt.length; i++) {
                        for (j = 0; j < that.clothes.cardigan.length; j++) {
                            for (k = 0; k < that.clothes.vest.length; k++) {
                                looks.push([that.clothes.cardigan[j], that.clothes.skirt[i], that.clothes.vest[k]]);
                            }
                        }
                    }
                }
            }
        
            if (that.clothes.short) {
                if (that.clothes.top_tshirt) {
                    for (i = 0; i < that.clothes.short.length; i++) {
                        for (j = 0; j < that.clothes.top_tshirt.length; j++) {
                            for (k = 0; k < that.clothes.vest.length; k++) {
                                looks.push([that.clothes.top_tshirt[j], that.clothes.short[i], that.clothes.vest[k]]);
                            }
                        }
                    }
                }
        
                if (that.clothes.shirt) {
                    for (i = 0; i < that.clothes.short.length; i++) {
                        for (j = 0; j < that.clothes.shirt.length; j++) {
                            for (k = 0; k < that.clothes.vest.length; k++) {
                                looks.push([that.clothes.shirt[j], that.clothes.short[i], that.clothes.vest[k]]);
                            }
                        }
                    }
                }
        
                if (that.clothes.cardigan) {
                    for (i = 0; i < that.clothes.short.length; i++) {
                        for (j = 0; j < that.clothes.cardigan.length; j++) {
                            for (k = 0; k < that.clothes.vest.length; k++) {
                                looks.push([that.clothes.cardigan[j], that.clothes.short[i], that.clothes.vest[k]]);
                            }
                        }
                    }
                }
            }
        }
    
        return looks;
    }


    that.get_torse_looks = function () {

        looks = [];
    
        if (that.clothes.vest) {
            if (that.clothes.pants) {
                for (i = 0; i < that.clothes.pants.length; i++) {
                    for (j = 0; j < that.clothes.vest.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.pants[i], that.clothes.accessory[k]]);
                        } 
                    }
                }
            }
    
            if (that.clothes.skirt) {
                for (i = 0; i < that.clothes.skirt.length; i++) {
                    for (j = 0; j < that.clothes.vest.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.vest[j], that.clothes.skirt[i], that.clothes.accessory[k]]);
                        } 
                    }
                }
            }
    
            if (that.clothes.short) {
                for (i = 0; i < that.clothes.short.length; i++) {
                    for (j = 0; j < that.clothes.vest.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.vest[j], that.clothes.short[i], that.clothes.accessory[k]]);
                        } 
                    }
                }
            }
        }
    
        if (that.clothes.coat) {
            if (that.clothes.pants) {
                for (i = 0; i < that.clothes.pants.length; i++) {
                    for (j = 0; j < that.clothes.coat.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.coat[j], that.clothes.pants[i], that.clothes.accessory[k]]);
                        } 
                    }
                }
            }
    
            if (that.clothes.skirt) {
                for (i = 0; i < that.clothes.skirt.length; i++) {
                    for (j = 0; j < that.clothes.coat.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.coat[j], that.clothes.skirt[i], that.clothes.accessory[k]]);
                        } 
                    }
                }
            }
    
            if (that.clothes.short) {
                for (i = 0; i < that.clothes.short.length; i++) {
                    for (j = 0; j < that.clothes.coat.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.coat[j], that.clothes.short[i], that.clothes.accessory[k]]);
                        } 
                    }
                }
            }
        }
    
        if (!that.clothes.vest && !that.clothes.coat) {
            if (that.clothes.pants) {
                for (i = 0; i < that.clothes.pants.length; i++) {
                    for (j = 0; j < that.clothes.accessory.length; j++) {
                        looks.push([that.clothes.pants[i], that.clothes.accessory[j]]);
                    } 
                }
            }
    
            if (that.clothes.skirt) {
                for (i = 0; i < that.clothes.skirt.length; i++) {
                    for (j = 0; j < that.clothes.accessory.length; j++) {
                        looks.push([that.clothes.skirt[i], that.clothes.accessory[j]]);
                    } 
                }
            }
    
            if (that.clothes.short) {
                for (i = 0; i < that.clothes.short.length; i++) {
                    for (j = 0; j < that.clothes.accessory.length; j++) {
                        looks.push([that.clothes.short[i], that.clothes.accessory[j]]);
                    } 
                }
            }
        }
    
        return looks;
            
    }

    that.isSP = function () {
        return (window.innerWidth <= 1006);
    }

    
    that.get_legs_looks = function() {

        looks = [];

        if (that.clothes.vest) {
            if (that.clothes.top_tshirt) {
                for (i = 0; i < that.clothes.vest.length; i++) {
                    for (j = 0; j < that.clothes.top_tshirt.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.vest[i], that.clothes.top_tshirt[j], that.clothes.accessory[k]]);
                        }
                    }
                }
            }

            if (that.clothes.shirt) {
                for (i = 0; i < that.clothes.vest.length; i++) {
                    for (j = 0; j < that.clothes.shirt.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.vest[i], that.clothes.shirt[j], that.clothes.accessory[k]]);
                        }
                    }
                }
            }

            if (that.clothes.cardigan) {
                for (i = 0; i < that.clothes.vest.length; i++) {
                    for (j = 0; j < that.clothes.cardigan.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.vest[i], that.clothes.cardigan[j], that.clothes.accessory[k]]);
                        }
                    }
                }
            }
        }

        if (that.clothes.coat) {
            if (that.clothes.top_tshirt) {
                for (i = 0; i < that.clothes.coat.length; i++) {
                    for (j = 0; j < that.clothes.top_tshirt.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.coat[i], that.clothes.top_tshirt[j], that.clothes.accessory[k]]);
                        }
                    }
                }
            }

            if (that.clothes.shirt) {
                for (i = 0; i < that.clothes.coat.length; i++) {
                    for (j = 0; j < that.clothes.shirt.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.coat[i], that.clothes.shirt[j], that.clothes.accessory[k]]);
                        }
                    }
                }
            }

            if (that.clothes.cardigan) {
                for (i = 0; i < that.clothes.coat.length; i++) {
                    for (j = 0; j < that.clothes.cardigan.length; j++) {
                        for (k = 0; k < that.clothes.accessory.length; k++) {
                            looks.push([that.clothes.coat[i], that.clothes.cardigan[j], that.clothes.accessory[k]]);
                        }
                    }
                }
            }
        }

        if (!that.clothes.vest && !that.clothes.coat) {
            if (that.clothes.top_tshirt) {
                for (i = 0; i < that.clothes.top_tshirt.length; i++) {
                    for (j = 0; j < that.clothes.accessory.length; j++) {
                        looks.push([that.clothes.top_tshirt[i], that.clothes.accessory[j]]);
                    }
                }
            }

            if (that.clothes.shirt) {
                for (i = 0; i < that.clothes.shirt.length; i++) {
                    for (j = 0; j < that.clothes.accessory.length; j++) {
                        looks.push([that.clothes.shirt[i], that.clothes.accessory[j]]);
                    }
                }
            }

            if (that.clothes.cardigan) {
                for (i = 0; i < that.clothes.cardigan.length; i++) {
                    for (j = 0; j < that.clothes.accessory.length; j++) {
                        looks.push([that.clothes.cardigan[i], that.clothes.accessory[j]]);
                    }
                }
            }
        }
        return looks;
    }

    that.get_rest_looks = function () {
        looks = [];

        if (that.clothes.vest) {
            for (i = 0; i < that.clothes.vest.length; i++) {
                for (j = 0; j < that.clothes.accessory.length; j++) {
                    looks.push([that.clothes.vest[i],  that.clothes.accessory[j]]);
                }
            }
        }

        if (that.clothes.coat) {
            for (i = 0; i < that.clothes.coat.length; i++) {
                for (j = 0; j < that.clothes.accessory.length; j++) {
                    looks.push([that.clothes.coat[i],  that.clothes.accessory[j]]);
                }
            }
        }

        if (!that.clothes.vest && !that.clothes.coat) {
            for (i = 0; i < that.clothes.accessory.length; i++) {
                looks.push([that.clothes.accessory[i]]);
            }
        }
        return looks;
    }

}