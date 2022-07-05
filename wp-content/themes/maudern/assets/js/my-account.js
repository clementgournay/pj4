jQuery(function ($) {

    var that = this;
    that.rootURL = $('[name=root_url]').val();
    that.myAccountURL = $('[name=my_account_url]').val();

    that.init = function () {
        that.dashboard();
        that.preferences();
        that.achats();
        that.createLook();
    }

    that.dashboard = function () {
        if ($('.dashboard').length > 0) {

            var city = ($('.dashboard').find('.user-info .city').val() !== '') ? $('.dashboard').find('.user-info .city').val() : 'Paris';
            
            $('.looks').not('.slick-initialized').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                centerMode: true,
                pager: true,
                dots: true,
                variableWidth: true
            });


            $('.looks .look').off('.dashboardEvents');
            $('.looks .look').on('click.dashboardEvents', function () {
                var look = $(this).attr('data-look');
                window.location.href = that.myAccountURL + '/dressing/looks?look=' + look;
            });

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

    that.preferences = function () {
        if ($('.preferences').length > 0) {

            $('.selection-tags .tag').off('.tagEvents');
            $('.selected-tags .tag i').off('.tagEvents');
            $('#filter').off('.tagEvents');

            $('.selection-tags .tag').on('click.tagEvents', function() {
                $(this).clone().append('<i class="fa fa-times"></i>').appendTo($('.selected-tags'));
                $(this).remove();
                setTimeout(that.preferences, 200);
            });

            $('.selected-tags .tag i').on('click.tagEvents', function () {
                $(this).parents('.tag').clone().appendTo('.selection-tags');
                $(this).parents('.tag').remove();
            });

            $('#filter').on('keyup.tagEvents', function () {
                $('.selection-tags .tag:contains(' + $(this).val() + ')').show();
                $('.selection-tags .tag:not(:contains(' + $(this).val() + '))').hide();
            });
        }
    }

    that.achats = function () {
        if ($('.achats').length > 0) {

            var reclamationModal = new Modal({
                selector: '#reclamations',
                callback: function (resp) {
                    if (resp.code === 200) {
                        alert('Votre demande a bien été envoyée au vendeur.');
                    } else {
                        alert('Une erreur est survenue, veuillez réessayer');
                    }
                }
            });

            var advicesModal = new Modal({
                selector: '#advices'
            });

            var shareClothesModal = new Modal({
                selector: '#share-clothes'
            });

            $('.table.actions .row').each(function () {
                $(this).height($('.table.receipt .row[data-product-id="' + $(this).attr('data-product-id') + '"]').height());
            });

            that.filterCategories();

            $('.category-btn').click((function () {
                    if (!$(this).hasClass('no-result')) {
                    $(this).parents('.tr').find('.category-btn.all').removeClass('active');
                    $(this).toggleClass('active');

                    if ($(this).parents('.tr').find('.category-btn.all').hasClass('active')) {
                        $(this).parents('.tr').find('.category-btn:not(.all)').removeClass('active');
                    }
                    that.filterCategories();
                }
            }));

            $('.reclamation-btn').on('click', function () {
                reclamationModal.setData('product_id', $(this).parents('.row').attr('data-product-id'));
                reclamationModal.open();
            });

            $('.advices-btn').on('click', function () {
                advicesModal.setData('composition', $(this).parents('.td').find('[name="composition"]').val());
                advicesModal.open();
            });

            $('.sell-btn').on('click', function () {
                var productURL = $(this).parents('.row').attr('data-product-url');
                window.location.href = productURL;
            });

            $('.share-btn').on('click', function () {
                var productURL = $(this).parents('.row').attr('data-product-url');
                var formattedBody = 'Je te recommande mon article !\n' + productURL;
                var mailToLink = "mailto:x@y.com?body=" + encodeURIComponent(formattedBody);
                $('#share-clothes').find('.copy').off('click');
                $('#share-clothes').find('.copy').on('click', function () {
                    navigator.clipboard.writeText(productURL).then(function() {
                        console.log('Async: Copying to clipboard was successful!');
                      }, function(err) {
                        console.error('Async: Could not copy text: ', err);
                      });
                });
                shareClothesModal.setData('fb-url', 'https://www.facebook.com/sharer/sharer.php?u=' + productURL, 'href')
                shareClothesModal.setData('twitter-url', 'http://twitter.com/share?text=text goes here&url=' + productURL + '&hashtags=dika', 'href')
                shareClothesModal.setData('mail-url', mailToLink, 'href')
                shareClothesModal.open();
            });

            $('.related-btn').on('click', function () {
                window.location.href = that.myAccountURL + '/dressing/looks';
            });

        }
    }

    that.filterCategories = function () {

        $('.results .row').each(function () {
            var category = $(this).attr('data-category');
            var brand = $(this).attr('data-brand');

            var $catBtn = $('.category-btn[data-category="' + category + '"]');
            //var $brandBtn = $('.category-btn[data-brand="' + brand + '"]');

            if (($catBtn.hasClass('active') || $('.categories').find('.category-btn.all').hasClass('active'))/* && ($brandBtn.hasClass('active') || $('.brands').find('.category-btn.all').hasClass('active'))*/) {
                $(this).show();
            } else {
                $(this).hide();
            }

        }); 

        $('.category-btn:not(.all)').each(function () {
            var $rows;

            if ($(this).attr('data-category')) {
                var category = $(this).attr('data-category');
                $rows = $('.receipt .row[data-category="' + category + '"]');
            } else if ($(this).attr('data-brand')) {
                var brand = $(this).attr('data-brand');
                $rows = $('.receipt .row[data-brand="' + brand + '"]');
            }
        
            var $count = $(this).find('.cat-count');
            const count = $rows.length;
            $count.html('(' + count + ')');
            if (count === 0) {
                $(this).addClass('no-result');
            } else {
                $(this).removeClass('no-result');
            }
            
        });

        console.log($('.results .row').length)
        $('.category-btn.all .count').html('(' + $('.results .row').length + ')');
        $('.filters .tr').each(function () {
            if ($(this).find('.category-btn.active').length === 0) {
                $(this).find('.category-btn.all').click();
            }
        });
    }

    that.createLook = function () {
        if ($('.woocommerce-MyAccount-content .look-editor').length > 0) {
            var lookEditor = new LookEditor({
                mode: 'client'
            });
            lookEditor.init();
        }
    }

    that.init();
});