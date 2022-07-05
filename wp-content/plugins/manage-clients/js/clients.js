jQuery(function ($) {

    var that = this;
    

    that.init = function () {
        that.mainEvents();
        that.filtering();
        that.list();
        that.looking();
        that.dashboard();
        that.dressing();
    }

    that.mainEvents = function () {
        const urlSearchParams = new URLSearchParams(window.location.search);
        const params = Object.fromEntries(urlSearchParams.entries());
        if (params.saved) {
            var modal = new Modal({
                selector: '#save-success'
            });
            modal.open();
        }
    }

    that.filtering = function () {
        if ($('.category-btn').length > 0 && $('.look').length === 0) {

            that.filterCategories();

            $('.category-btn').click((function () {

                if (!$(this).hasClass('no-result')) {
                    $(this).parents('.filter-cont').find('.category-btn.all').removeClass('active');
                    $(this).toggleClass('active');

                    if ($(this).parents('.filter-cont').find('.category-btn.all').hasClass('active')) {
                        $(this).parents('.filter-cont').find('.category-btn:not(.all)').removeClass('active');
                    }
                    that.filterCategories();
                }
            }));

        }
    }

    that.filterCategories = function () {

        $('.results .item').each(function () {
            var category = $(this).attr('data-category');
            var brand = $(this).attr('data-brand');

            var $catBtn = $('.category-btn[data-category="' + category + '"]');
            var $brandBtn = $('.category-btn[data-brand="' + brand + '"]');

            if ($('.filter-brand').length > 0) {
                if (
                    ($catBtn.hasClass('active') || $('.filter-cat').find('.category-btn.all').hasClass('active')) && 
                 ($brandBtn.hasClass('active') || $('.filter-brand').find('.category-btn.all').hasClass('active'))
                ) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            } else {
                if ($catBtn.hasClass('active') || $('.filter-cat').find('.category-btn.all').hasClass('active')) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            }

        }); 

        $('.category-btn:not(.all)').each(function () {
            var $rows;

            if ($(this).attr('data-category')) {
                var category = $(this).attr('data-category');
                $rows = $('.item[data-category="' + category + '"]');
            } else if ($(this).attr('data-brand')) {
                var brand = $(this).attr('data-brand');
                $rows = $('.item[data-brand="' + brand + '"]');
            }
        
            const count = $rows.length;
            $(this).find('.cat-count').html(count);
            const countClient = $('.products.left .item[data-category="' + category + '"]').length;
            $(this).find('.cat-count.client').html(countClient);
            if (count === 0) {
                $(this).addClass('no-result');
            } else {
                $(this).removeClass('no-result');
            }
            
        });

        $('.category-btn.all .cat-count').html($('.results .item').length);
        $('.category-btn.all .cat-count.client').html($('.products.left .item').length);

        var countClient = $('.products.left .item:visible').length;
        var countShop = $('.products.right .item:visible').length;
        $('.products.left .count .value').html(countClient);
        $('.products.right .count .value').html(countShop);

        if (countClient === 0) $('.products.left .no-items').show();
        else $('.products.left .no-items').hide();

        if (countShop === 0) $('.products.right .no-items').show();
        else $('.products.right .no-items').hide();
        
        $('.filter-cont').each(function () {
            if ($(this).find('.category-btn.active').length === 0) {
                $(this).find('.category-btn.all').click();
            }
        });
    }

    that.list = function () {
        if ($('.manage-clients.list').length > 0) {


            $('.list .search input').on('keydown', function (e) {
                if (e.keyCode === 13) {
                    that.searchClients();
                }
            });

            $('.list .search-btn').on('click', function () {
                that.searchClients();
            });

            $('.list select.number').on('change', function () {
                var page = $('.list').attr('data-page');
                var number = $(this).val();
                window.location.href = './admin.php?page=manage_clients&index=' + page + '&number=' + number;
            });

            $('.list .action-btn').on('click', function () {
                $('.list .outer').toggleClass('expanded');
                $('#expand i').toggleClass('fa-arrow-left');
                $('#expand i').toggleClass('fa-arrow-right');

                var orderID = $(this).parents('tr').attr('data-order-id');
                $('.action-btn.active').each(function () {
                    if ($(this).parents('tr').attr('data-order-id') !== orderID) {
                        $(this).removeClass('active');
                        $(this).next('.actions').removeClass('shown');
                    }
                });
                if (!$(this).hasClass('active')) {
                    $(this).addClass('active');
                    $(this).next('.actions').addClass('shown');
                } else {
                    $('.list .actions').removeClass('shown');
                    $('.list .action-btn').removeClass('active');
                }
            });

            $('.list .actions .action').on('click', function () {
                $('#expand').click();
                $('.list .actions').removeClass('shown');
                $('.list .action-btn').removeClass('active');
                var userID = $(this).parents('tr').attr('data-user-id');
                var feature = $(this).attr('data-feature');
                window.location.href = './admin.php?page=manage_clients&feature=' + feature + '&user_id=' + userID
            });

            $('.list .actions .action.view').on('click', function () {
                var id = $(this).parents('tr').attr('data-order-id');
                window.location.href = './admin.php?page=manage_receipts&feature=view_receipt&id=' + id;
            });

            $('body').append('<div id="expand"><i class="fas fa-arrow-right"></i></div>');
            $('#expand').on('click', function () {
                $('.list .outer').toggleClass('expanded');
                $(this).find('i').toggleClass('fa-arrow-left');
                $(this).find('i').toggleClass('fa-arrow-right');
                
            });

        
        }
    }

    that.searchClients = function () {
        var page = $('.list').attr('data-page');
        var number = $('.list').attr('data-number');
        var search = $('.list .search input').val();
        var url = './admin.php?page=manage_clients&index=' + page + '&number=' + number;
        if (search !== '') url += '&search=' + search;
        window.location.href = url;
    }

    that.looking = function () {

        if ($('.manage-clients.look-editor').length > 0) {
            const lookEditor = new LookEditor({
                mode: 'seller'
            });
            lookEditor.init();
        }
        
    }

    that.dashboard = function () {
        if ($('.manage-clients .dashboard').length > 0) {

            var city = ($('.dashboard').find('.user-info .city').val() !== '') ? $('.dashboard').find('.user-info .city').val() : 'Paris';
            

            if ($('.looks .look').length > 0) {
                $('.looks').slick({
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    centerMode: true,
                    pager: true,
                    dots: true,
                    variableWidth: true
                });
            }

            $.ajax({
                url: 'https://api.openweathermap.org/data/2.5/weather?q=' + city + '&appid=c130f40b93bc9af9741ca81543fa4681',
                method: 'GET',
                success: function (res) {
                    console.log(res);
                    if (res.cod === 200) {
                        
                        var desc = 'Indéfinie';
                        var icon = '01d';
                        var temp = (res.main.temp - 273.15);
                        temp = parseInt(temp);

                        if (res.weather.length > 0) {
                            icon = res.weather[0].icon;
                            isNight = icon.includes('n');
                            switch(res.weather[0].main) {
                                case 'Thunderstorm':
                                    desc = 'Orageux';
                                    break;
                                case 'Drizzle':
                                    desc = 'Bruine';
                                    break;
                                case 'Rain':
                                    desc = 'Pluvieux';
                                    break;
                                case 'Snow':
                                    desc = 'Neigeux';
                                    break;
                                case 'Clear':
                                    desc = (isNight) ? 'Dégagé' : 'Ensoleillé';
                                    break;
                                case 'Clouds':
                                    desc = 'Nuageux';
                                    break;
                            }
                            
                        }

                        $('[data-weather-icon]').attr('src', 'http://openweathermap.org/img/wn/' + icon + '@2x.png');
                        $('[data-weather-temp]').html(temp);
                        $('[data-weather-desc]').html(desc);
                        $('[data-weather-location').html(res.name);
                    }
                },
                error: function (xhr, statusText) {
                    console.log(statusText);
                }
            });


        }
    }

    that.dressing = function () {
        if ($('.dressing').length > 0) {
            $('.send').on('click', function () {

                var $btn = $(this);

                if (!$btn.hasClass('in-progress')) {
                    
                    $btn.addClass('in-progress');
                    $btn.css('opacity', 0.5);
                    $btn.prop('disabled', true);
                    var rows = [];

                    $('.row').each(function () {
                        rows.push({productID: $(this).attr('data-product-id'), comment: $(this).find('textarea').val()})
                    });

                    $.ajax({
                        url: $btn.attr('data-action'),
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            seller_id: $btn.attr('data-seller-id'),
                            user_id: $btn.attr('data-user-id'),
                            rows: rows
                        },
                        success: function (resp) {
                            console.log(resp);
                            alert('Les informations ont été sauvegardées correctement.');
                        },
                        error: function (xhr, statusText) {
                            alert('Une erreur est survenue. Veuillez réessayer.');
                            console.log(statusText);
                        },
                        complete: function () {
                            $btn.removeClass('in-progress');
                            $btn.css('opacity', 1);
                            $btn.prop('disabled', false);
                        }
                    });
                }
            });
        }
    }

    that.init();

});