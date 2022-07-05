jQuery(function ($) {

    var that = this;
    that.siteURL = $('body').attr('data-site-url');
    that.templateDir = $('body').attr('data-template-dir');
    that.offset = (window.innerWidth > 1006) ? $(window).height() * 0.8 : $(window).height() * 0.7;
    that.votes = (localStorage.votes) ? JSON.parse(localStorage.votes) : {}; 
    that.sounds = {};

    that.init = function () {
        that.top();
        that.dashboard();
        //that.chatbox();
        that.looks();
        that.contextMenu();
        that.youtube();
        setTimeout(function () {
            that.animations();
            $(window).on('scroll', that.onScroll);
        }, 500);
    }

    that.chatbox = function () {

        that.sounds.newMessage = new Audio();
        that.sounds.newMessage.src = that.templateDir + '/assets/audio/new-message.mp3';

        $('.chatbox-btn').on('click', function () {
            $('.chatbox').fadeToggle(300);
            $(this).toggleClass('active');
        });

        if ($('body').hasClass('home')) {
            setTimeout(function () {
                $('.chatbox').fadeIn(300);
                $('.chatbox-btn').addClass('active');
                that.sounds.newMessage.play();
            }, 5000);
        }
    }

    that.contextMenu = function () {
        $('.context .open').on('click', function () {
            $(this).toggleClass('active');
            $(this).next().stop().fadeToggle(300);
        });
        $('.context .menu li').on('click', function () {
            $(this).parents('.menu').stop().fadeOut(300);
            $(this).parents('.context').find('.open').removeClass('active');
        });
        $(document).on('click', function (e) {
            if ($(e.target).parents('.context').length === 0) {
                $('.context .menu').stop().fadeOut(300);
                $('.context .open').removeClass('active');
            }
        });
    }

    that.top = function () {
        if ($('.slides').length > 0) {
        }
    }

    that.onScroll = function () {
        that.animations();
    }

    that.animations = function () {

        $('.animate__animated').each(function() {
            var $el = $(this);

            var classList = $el[0].classList;

            var delay = 0;
            var anim = '';

            classList.forEach(function (theClass) {
                const parts = theClass.split('__');
                if (parts[0] === 'anim') anim = parts[1];
                else if (parts[0] === 'delay') delay = parseInt(parts[1]);
            });

            if (
                $el.offset().top <= $(window).height() - that.offset ||  //in first view
                $(window).scrollTop() + that.offset >= $el.offset().top ||  // on scroll
                $(window).scrollTop() >= $('body').outerHeight() - $(window).height() // in lastview
            ) {

                setTimeout(function () {
                    $el.css('visibility', 'visible').addClass('animate__' + anim);
                }, delay);
            }
        });
        
    }

    that.youtube = function () {
        if ($('#youtubeEmbed').length > 0) {
            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        }
    }

    that.looks = function () {
        if ($('.look-list').length > 0) {
            var loggedIn = eval($('.look-list').attr('data-logged-in'));

            $('.look .vote-btn').addClass('disabled');
            
            if (loggedIn) {
                $.ajax({
                    url: that.siteURL + '/get-votes',
                    method: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code === 200) {
                            that.votes = res.votes;
                            that.showVotes();
                        }
                    }, 
                    error: function (xhr, statusText) {
                        console.error(statusText);
                    },
                    complete: function () {
                        $('.look .vote-btn').removeClass('disabled');
                    }
                });
            } else {
                $('.look .vote-btn').removeClass('disabled');
                that.showVotes();
            }

 

            $('.look .vote-btn').on('click', function (e) {
                e.preventDefault();
                var $btn = $(this);

                if (!$btn.hasClass('disabled')) {
                    $btn.addClass('disabled');
                    var $look = $(this).parents('.look');
                    var lookID = $look.attr('data-id');
                    var vote = ($(this).hasClass('like')) ? 'like' : 'dislike';
                    var action = $(this).hasClass('on') ? 'remove' : 'add';

                    $look.find('.vote-btn').removeClass('on');

                    if (action === 'add') $btn.addClass('on');
                    else $btn.removeClass('on');

                    $.ajax({
                        url: that.siteURL + '/vote',
                        method: 'POST',
                        data: {
                            ID: lookID,
                            vote: vote,
                            action: action
                        },
                        dataType: 'json',
                        success: function (res) {
                            if (res.code === 200) {
                                console.log(res);
                            }
                        },
                        error: function (xhr, statusText) {
                            console.error(statusText);
                        },
                        complete: function () {
                            $btn.removeClass('disabled');

                            if (!loggedIn) {
                                if (that.votes[lookID]) {
                                    const prevVote = that.votes[lookID];
                                    if (vote !== prevVote) {
                                        that.votes[lookID] = vote;
                                    } else {
                                        delete that.votes[lookID];
                                    }
                                } else {
                                    that.votes[lookID] = vote;
                                }
                                localStorage.votes = JSON.stringify(that.votes);
                            }
                        }
                    });

                }
            });
        }
    }

    that.showVotes = function () {
        $('.look').each(function () {
            var lookID = parseInt($(this).attr('data-id'));
            if (that.votes[lookID]) {
                $(this).find('.vote-btn.' + that.votes[lookID]).addClass('on');
            }
        });
    }

    var waitUntilLoad = setInterval(function () {
        if ($('body').hasClass('fade')) {
            that.init();
            clearInterval(waitUntilLoad);
        }
    }, 20);


});
