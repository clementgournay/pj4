jQuery(function ($) {

    var that = this;
    that.receiptModals = {};
    that.pluginURL = $('.manage-receipts').attr('data-plugin-url');

    that.init = function () {
        that.modals();
        that.list();
        that.viewReceipt();
    }

    that.modals = function () {

        
        if ($('#client-selection').length > 0) {
            that.receiptModals.clientSelection = new Modal({
                selector: '#client-selection',
                init: function () {
                    var self = this;
                    $('#client-selection .search').on('keyup', function (e) {
                        if (e.keyCode === 13) {
                            self.search();
                        }
                    });

                    $('#client-selection .search-btn').on('click', function () {
                        self.search();
                    }); 

                    self.search = function() {
                        if (!$('#client-selection').hasClass('in-progress')) {
                            $('#client-selection').addClass('in-progress');
                            var searchSTR = $('#client-selection .search').val();
                            if (searchSTR.length >= 3) {
                                $.ajax({
                                    url: that.pluginURL + 'includes/search-user.php?search=' + searchSTR,
                                    method: 'GET',
                                    dataType: 'json',
                                    success: function (resp) {
                                        console.log(resp);
                                        $('#client-selection tbody').html('');
                                        resp.data.forEach(function (row) {
                                            var client = row.data;
                                            $('#client-selection tbody').append('<tr data-user-id="' + client.ID + '"><td class="tac">' + client.ID + '</td><td class="tac">' + client.user_nicename + '</td><td class="tac">' + client.lastname + '</td><td class="tac">' + client.firstname + '</td><td class="tac"><button type="button" class="btn select">Sélectionner</button></<td></tr>')
                                        });
                                        self.events();
                                    },
                                    error: function (xhr, statusText) {
                                        console.error(statusText);
                                    },
                                    complete: function() {
                                        $('#client-selection').removeClass('in-progress');
                                    }                       
                                })
                            }
                        }
                    }

                    self.events = function () {
                        $('#client-selection .select').on('click', function () {
                            var userID = $(this).parents('tr').attr('data-user-id');
                            if (!$('#client-selection').hasClass('in-progress')) {
                                $('#client-selection').addClass('in-progress');
                                var orderID = that.receiptModals.clientSelection.getData('order-id');
                                $.ajax({
                                    url: that.pluginURL + 'includes/attribute-user.php?order_id=' + orderID + '&user_id=' + userID,
                                    method: 'GET',
                                    dataType: 'json',
                                    success: function (resp) {
                                        if (resp.code === 200) {
                                            that.receiptModals.clientSelection.close();
                                            var nameSTR = (resp.data.firstname) ? resp.data.firstname : '';
                                            if (resp.data.lastname) nameSTR += ' ' + resp.data.lastname;
                                            $('.manage-receipts.view-receipt .client .display-name').html('(' + resp.data.user_login + ')');
                                            $('.manage-receipts.view-receipt .client .name').html(nameSTR);
                                            $('.manage-receipts.view-receipt .client .red').hide();
                                            $('.disattribute').show();
                                            $('.manage-receipts.list tr[data-order-id="' + orderID + '"] .user').html(nameSTR + '<br>(' + resp.data.user_login + ')');
                                            $('.manage-receipts.list tr[data-order-id="' + orderID + '"] .disattribute').show();
                                            $('.manage-receipts.list tr[data-order-id="' + orderID + '"] .attribute').hide();
                                        }
                                    },
                                    error: function (xhr, statusText) {
                                        console.error(statusText);
                                    },
                                    complete: function() {
                                        $('#client-selection').removeClass('in-progress');
                                    }                       
                                })
                            }
                        });
                    }
                }
            });

            if ($('.manage-receipts.view-receipts').length > 0) {
                that.receiptModals.clientSelection.setData('order-id', $('[name=order_id]').val());
            }

        }
    }

    that.list = function () {
        if ($('.manage-receipts.list').length > 0) {

            $('.list .search input').on('keydown', function (e) {
                if (e.keyCode === 13) {
                    that.searchReceipts();
                }
            });

            $('.list .search .price').on('change', function () {
                var val = $(this).val();
                if (val.length > 0) {
                    $('tbody tr').hide();
                    $('tbody tr:contains(' + val + ')').show();
                } else {
                    $('tbody tr').show();
                }
            });

            $('.list .search .search-btn').on('click', function () {
                that.searchReceipts();
            });

            $('.list select.number').on('change', function () {
                var page = $('.list').attr('data-page');
                var date = $('.list').attr('data-date');
                var number = $(this).val();
                window.location.href = './admin.php?page=manage_receipts&index=' + page + '&number=' + number + '&date=' + date;
            });

            $('.list .action-btn').on('click', function () {
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
            });

            $('.list .actions .action.view').on('click', function () {
                var id = $(this).parents('tr').attr('data-order-id');
                window.location.href = './admin.php?page=manage_receipts&feature=view_receipt&id=' + id;
            });

            $('.list .actions .action.attribute').on('click', function () {
                var id = $(this).parents('tr').attr('data-order-id');
                that.receiptModals.clientSelection.setData('order-id', id, false, false);
                that.receiptModals.clientSelection.open();
            });

            $('.list .actions .action.disattribute').on('click', function () {
                var id = $(this).parents('tr').attr('data-order-id');
                $.ajax({
                    url: that.pluginURL + 'includes/attribute-user.php?order_id=' + id + '&remove=true',
                    method: 'GET',
                    dataType: 'json',
                    success: function (resp) {
                        if (resp.code === 200) {
                            $('.manage-receipts.list [data-order-id=' + id + '] .user').html('Non attribué');
                            $('.manage-receipts.list [data-order-id=' + id + '] .attribute').show();
                            $('.manage-receipts.list [data-order-id=' + id + '] .disattribute').hide();
               
                        }
                    },
                    error: function (xhr, statusText) {
                        console.error(statusText);
                    },
                    complete: function() {
                        $('.view-receipt').removeClass('in-progress');
                    }                       
                });
            });

            $('body').append('<div id="expand"><i class="fas fa-arrow-right"></i></div>');
            $('#expand').on('click', function () {
                $('.list .outer').toggleClass('expanded');
                $(this).find('i').toggleClass('fa-arrow-left');
                $(this).find('i').toggleClass('fa-arrow-right');
                
            });
           
        }
    }

    that.searchReceipts = function () {
        var page = $('.list').attr('data-page');
        var number = $('.list').attr('data-number');
        var date = $('.list .search input').val();
        var url = './admin.php?page=manage_receipts&index=' + page + '&number=' + number;
        if (date !== '') url += '&date=' + date;
        window.location.href = url;
    }

    that.viewReceipt = function () {
        $('.attribute').on('click', function () {
            that.receiptModals.clientSelection.open();
        });

        $('.disattribute').on('click', function () {
            if (!$('.view-receipt').hasClass('in-progress')) {
                $('.view-receipt').addClass('in-progress');
                var orderID = $('input[name="order_id"]').val();
                $.ajax({
                    url: that.pluginURL + 'includes/attribute-user.php?order_id=' + orderID + '&remove=true',
                    method: 'GET',
                    dataType: 'json',
                    success: function (resp) {
                        if (resp.code === 200) {
                            $('.manage-receipts.view-receipt .client .display-name').html('');
                            $('.manage-receipts.view-receipt .client .name').html('');
                            $('.manage-receipts.view-receipt .client .red').show();
                            $('.disattribute').hide();
                        }
                    },
                    error: function (xhr, statusText) {
                        console.error(statusText);
                    },
                    complete: function() {
                        $('.view-receipt').removeClass('in-progress');
                    }                       
                })
            }
        });
    }

    that.init();

});