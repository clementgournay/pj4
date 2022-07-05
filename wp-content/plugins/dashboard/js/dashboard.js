jQuery(function ($) {

    var that = this;
    that.PLUGIN_URL = $('.dashboard-page').attr('data-plugin-url');
    that.orders = [];
    that.monthes = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    that.objectives = {
        '2021-01': 5000,
        '2021-02': 5000,
        '2021-03': 6000,
        '2021-04': 5000,
        '2021-05': 5600,
        '2021-06': 5000,
        '2021-07': 6000,
        '2021-08': 7000,
        '2021-09': 5000,
        '2021-10': 5000,
        '2021-11': 6000,
        '2021-12': 8000,
        '2022-01': 5000,
        '2022-02': 5000,
        '2022-03': 6000,
    }


    that.init = function () {
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(that.drawChart);
        that.menu();
        that.events();

        that.endDate = new Date();
        var todaySTR = that.endDate.toISOString().split('T')[0];
        that.startDate = new Date();
        that.startDate.setMonth(that.startDate.getMonth() - 6);
        var sixMonthAgoSTR = that.startDate.toISOString().split('T')[0];
        that.getOrders(sixMonthAgoSTR, todaySTR, function() {
            that.drawCharts();
            that.buildTables();
        });
    }

    that.getOrders = function (startDate, endDate, callback) {
        

        $.ajax({
            method: 'GET',
            url: that.PLUGIN_URL + '/includes/get-orders.php?start_date=' + startDate + '&end_date=' + endDate,
            dataType: 'json',
            success: function(resp) {
                console.log(resp);
                if (resp.code = 200) {
                    that.orders = resp.data.reverse();
                    if (callback) callback();
                }
            }
        });
    }

    that.menu = function () {
        $('.board-btn').on('click', function() {
            $('.board-btn').removeClass('active');
            $(this).addClass('active');
            $('.board').removeClass('active');
            $('.board[data-board="' + $(this).attr('data-board') + '"]').addClass('active');
            that.drawCharts();
        });
    }

    that.events = function () {
        $('#sales .search-btn').on('click', function () {
        
            var searchStartDateSTR = $('#sales .start-date').val();
            var searchEndDateSTR = $('#sales .end-date').val();
            var searchStartDate = new Date(searchStartDateSTR);
            var searchEndDate = new Date(searchEndDateSTR);
            if (searchStartDate.getTime() < that.startDate.getTime() || searchEndDate.getTime() > that.endDate.getTime()) {
                $('#sales').addClass('in-progress');
                that.startDate = searchStartDate;
                that.endDate = searchEndDate;
                that.getOrders(searchStartDateSTR, searchEndDateSTR, function () {
                    that.drawSalesChart();
                });
            } else {
                that.drawSalesChart();
            }
        });
        $('#sales-category .search-btn').on('click', function () {
            var searchStartDateSTR = $('#sales-category .start-date').val();
            var searchEndDateSTR = $('#sales-category .end-date').val();
            var searchStartDate = new Date(searchStartDateSTR);
            var searchEndDate = new Date(searchEndDateSTR);
            if (searchStartDate.getTime() < that.startDate.getTime() || searchEndDate.getTime() > that.endDate.getTime()) {
                $('#sales-category').addClass('in-progress');
                that.startDate = searchStartDate;
                that.endDate = searchEndDate;
                that.getOrders(searchStartDateSTR, searchEndDateSTR, function () {
                    that.drawSalesCategoryChart();
                });
            } else {
                that.drawSalesCategoryChart();
            }
        });
        $('#sales-category-pie .search-btn').on('click', function () {
            var searchStartDateSTR = $('#sales-category-pie .start-date').val();
            var searchEndDateSTR = $('#sales-category-pie .end-date').val();
            var searchStartDate = new Date(searchStartDateSTR);
            var searchEndDate = new Date(searchEndDateSTR);
            if (searchStartDate.getTime() < that.startDate.getTime() || searchEndDate.getTime() > that.endDate.getTime()) {
                $('#sales-category-pie').addClass('in-progress');
                that.startDate = searchStartDate;
                that.endDate = searchEndDate;
                that.getOrders(searchStartDateSTR, searchEndDateSTR, function () {
                    that.drawSalesCategoryPieChart();
                });
            } else {
                that.drawSalesCategoryPieChart();
            }
        });
    }

    that.drawCharts = function () {
        if ($('[data-board="sales"]').hasClass('active')) {
            that.drawSalesChart();
            that.drawSalesCategoryChart();
            that.drawSalesCategoryPieChart();
        }
    }

    that.buildTables = function () {
        if ($('[data-board="sales"]').hasClass('active')) {
            var tableData = {};
            that.orders.forEach(function (order) {
                var date = new Date(order.date.date);
                var dateSTR = date.toISOString().split('T')[0];
                var parts = dateSTR.split('-');
                var monthSTR = parts[0] + '-' + parts[1];

                var catValues = {};
                order.items.forEach(function (item) {
                    if (!catValues[item.category]) catValues[item.category] = parseFloat(item.total);
                    else catValues[item.category] += parseFloat(item.total);
                });

                if (!tableData[monthSTR]) {
                    var monthWord = that.monthes[parseInt(parts[1]) - 1];
                    var label = monthWord + ' ' + parts[0];

                    var data = {label: label, sales: parseFloat(order.total)};

                    for (let cat in catValues) {
                        data[cat] = catValues[cat];
                    }
                    tableData[monthSTR] = data;

                } else {
                    tableData[monthSTR].sales += parseFloat(order.total);
                    for (let cat in catValues) {
                        tableData[monthSTR][cat] += catValues[cat];
                    }
                }
            });
        }

        console.log(tableData);

        $('#sales-table thead').append('<tr><th width="100"></th></tr>');
        $('#sales-table tbody').append('<tr><th>Manteaux</th></tr>');
        $('#sales-table tbody').append('<tr><th>Vestes</th></tr>');
        $('#sales-table tbody').append('<tr><th>Gillets</th></tr>');
        $('#sales-table tbody').append('<tr><th>Robes</th></tr>');
        $('#sales-table tbody').append('<tr><th>Jupes</th></tr>');
        $('#sales-table tbody').append('<tr><th>Pantalons</th></tr>');
        $('#sales-table tbody').append('<tr><th>Shorts</th></tr>');
        $('#sales-table tbody').append('<tr><th>Combinaisons</th></tr>');
        $('#sales-table tbody').append('<tr><th>Accessoires</th></tr>');
        $('#sales-table tbody').append('<tr><th>Non classés</th></tr>');
        $('#sales-table tbody').append('<tr><th>Chiffre d\'affaire</th></tr>');
        $('#sales-table tbody').append('<tr><th>Objectif</th></tr>');
        $('#sales-table tbody').append('<tr><th>Ecart</th></tr>');
        for (let key in tableData) {
            if (!tableData[key].coat) tableData[key].coat = 0;
            if (!tableData[key].vest) tableData[key].vest = 0;
            if (!tableData[key].cardigan) tableData[key].cardigan = 0;
            if (!tableData[key].dress) tableData[key].dress = 0;
            if (!tableData[key].skirt) tableData[key].skirt = 0;
            if (!tableData[key].pants) tableData[key].pants = 0;
            if (!tableData[key].short) tableData[key].short = 0;
            if (!tableData[key].jumpsuit) tableData[key].jumpsuit = 0;
            if (!tableData[key].accessory) tableData[key].accessory = 0;
            if (!tableData[key].unknown) tableData[key].unknown = 0;
            $('#sales-table thead tr').append('<th>' + tableData[key].label + '</th>');
            $('#sales-table tbody tr:nth-child(1)').append('<td class="tac">' + tableData[key].coat.toFixed(2) + '€</td>');
            $('#sales-table tbody tr:nth-child(2)').append('<td class="tac">' + tableData[key].vest.toFixed(2) + '€</td>');
            $('#sales-table tbody tr:nth-child(3)').append('<td class="tac">' + tableData[key].cardigan.toFixed(2) + '€</td>');
            $('#sales-table tbody tr:nth-child(4)').append('<td class="tac">' + tableData[key].dress.toFixed(2) + '€</td>');
            $('#sales-table tbody tr:nth-child(5)').append('<td class="tac">' + tableData[key].skirt.toFixed(2) + '€</td>');
            $('#sales-table tbody tr:nth-child(6)').append('<td class="tac">' + tableData[key].pants.toFixed(2) + '€</td>');
            $('#sales-table tbody tr:nth-child(7)').append('<td class="tac">' + tableData[key].short.toFixed(2) + '€</td>');
            $('#sales-table tbody tr:nth-child(8)').append('<td class="tac">' + tableData[key].jumpsuit.toFixed(2) + '€</td>');
            $('#sales-table tbody tr:nth-child(9)').append('<td class="tac">' + tableData[key].accessory.toFixed(2) + '€</td>');
            $('#sales-table tbody tr:nth-child(10)').append('<td class="tac">' + tableData[key].unknown.toFixed(2) + '€</td>');
            $('#sales-table tbody tr:nth-child(11)').append('<td class="tac">' + tableData[key].sales.toFixed(2) + '€</td>');
            $('#sales-table tbody tr:nth-child(12)').append('<td class="tac">' + that.objectives[key] + '€</td>');
            $('#sales-table tbody tr:nth-child(13)').append('<td class="tac">' + (tableData[key].sales - that.objectives[key]).toFixed(2) + '€</td>');
        }

        console.lo

        $('#sales-table').removeClass('in-progress');
    }

    that.drawSalesChart = function () {

        var startDateSTR = $('#sales .start-date').val();
        var startDate = new Date(startDateSTR);
        var endDateSTR = $('#sales .end-date').val();
        var endDate = new Date(endDateSTR);
        var graphData = {};
        that.orders.forEach(function (order) {
            var date = new Date(order.date.date);
            var dateSTR = date.toISOString().split('T')[0];
            var parts = dateSTR.split('-');
            var monthSTR = parts[0] + '-' + parts[1];
            if (date.getTime() >= startDate.getTime() && date.getTime() <= endDate.getTime()) {
                if (!graphData[monthSTR]) {
                    var monthWord = that.monthes[parseInt(parts[1]) - 1];
                    var label = monthWord + ' ' + parts[0];
                    graphData[monthSTR] = {label: label, value: parseFloat(order.total)};
                } else {
                    graphData[monthSTR].value += parseFloat(order.total);
                }
            }
        });

        var arr = [
            ['Mois', 'Ventes réalisés', 'Objectif']
        ];
        
        for(let key in graphData) {
            var item = [
                graphData[key].label,
                graphData[key].value,
                that.objectives[key]
            ];
            arr.push(item);
        }

        var data = google.visualization.arrayToDataTable(arr);

        var options = {
            title: '',
            colors: ['#5964ce', 'purple'],
            chartArea: {left: 50, top: 20, width: "100%", height: "90%"},
            vAxis: {
                format:'# €',
                gridlines: {
                    color: 'transparent'
                }
            }
        };

        var chart = new google.visualization.AreaChart(document.querySelector('#sales .chart'));

        chart.draw(data, options);

        $('#sales').removeClass('in-progress');

    }

    that.drawSalesCategoryChart = function () {

        var startDateSTR = $('#sales-category .start-date').val();
        var startDate = new Date(startDateSTR);
        var endDateSTR = $('#sales-category .end-date').val();
        var endDate = new Date(endDateSTR);
        var graphData = {};
        that.orders.forEach(function (order) {
            var date = new Date(order.date.date);
            var dateSTR = date.toISOString().split('T')[0];
            var parts = dateSTR.split('-');
            var monthSTR = parts[0] + '-' + parts[1];
            if (date.getTime() >= startDate.getTime() && date.getTime() <= endDate.getTime()) {

                var catValues = {};
                order.items.forEach(function (item) {
                    if (!catValues[item.category]) catValues[item.category] = parseFloat(item.total);
                    else catValues[item.category] += parseFloat(item.total);
                });

                if (!graphData[monthSTR]) {
                    var monthWord = that.monthes[parseInt(parts[1]) - 1];
                    var label = monthWord + ' ' + parts[0];
                    var data = {label: label};
                    for (let cat in catValues) {
                        data[cat] = catValues[cat];
                    }
                    graphData[monthSTR] = data;
                } else {
                    for (let cat in catValues) {
                        graphData[monthSTR][cat] += catValues[cat];
                    }
                }
            }
        });
        
        var arr = [
            ['Mois', 'Manteaux', 'Vestes', 'Hauts et t-shirts', 'Gillets', 'Robes', 'Jupes', 'Pantalons', 'Shorts', 'Combinaisons', 'Accessoires', 'Non classé']
        ];
        
        for(let key in graphData) {
            if (!graphData[key].coat) graphData[key].coat = 0;
            if (!graphData[key].vest) graphData[key].vest = 0;
            if (!graphData[key].top_tshirt) graphData[key].top_tshirt = 0;
            if (!graphData[key].cardigan) graphData[key].cardigan = 0;
            if (!graphData[key].dress) graphData[key].dress = 0;
            if (!graphData[key].skirt) graphData[key].skirt = 0;
            if (!graphData[key].pants) graphData[key].pants = 0;
            if (!graphData[key].short) graphData[key].short = 0;
            if (!graphData[key].jumpsuit) graphData[key].jumpsuit = 0;
            if (!graphData[key].accessory) graphData[key].accessory = 0;
            if (!graphData[key].unknown) graphData[key].unknown = 0;
            var item = [
                graphData[key].label,
                graphData[key].coat,
                graphData[key].vest,
                graphData[key].cardigan,
                graphData[key].top_tshirt,
                graphData[key].dress,
                graphData[key].skirt,
                graphData[key].pants,
                graphData[key].short,
                graphData[key].jumpsuit,
                graphData[key].accessory,
                graphData[key].unknown
            ];
            arr.push(item);
        }


        var data = google.visualization.arrayToDataTable(arr);

        var options = {
            title: '',
            colors: ['#5964ce', 'purple', 'blue', 'cyan', 'green', 'orange', 'orange', 'pink', 'magenta', 'black'],
            chartArea: {left: 50, top: 20, width: "100%", height: "90%"},
            vAxis: {
                format:'# €',
                gridlines: {
                    color: 'transparent'
                }
            }
        };

        var chart = new google.visualization.LineChart(document.querySelector('#sales-category .chart'));

        chart.draw(data, options);

        $('#sales-category').removeClass('in-progress');

    }

    that.drawSalesCategoryPieChart = function () {

        var startDateSTR = $('#sales-category .start-date').val();
        var startDate = new Date(startDateSTR);
        var endDateSTR = $('#sales-category .end-date').val();
        var endDate = new Date(endDateSTR);
        var graphData = {};
        that.orders.forEach(function (order) {
            var date = new Date(order.date.date);
            if (date.getTime() >= startDate.getTime() && date.getTime() <= endDate.getTime()) {
                order.items.forEach(function (item) {
                    if (!graphData[item.category]) graphData[item.category] = parseFloat(item.total);
                    else graphData[item.category] += parseFloat(item.total);
                });
            }
        });

        if (!graphData.coat) graphData.coat = 0;
        if (!graphData.vest) graphData.vest = 0;
        if (!graphData.top_tshirt) graphData.top_tshirt = 0;
        if (!graphData.cardigan) graphData.cardigan = 0;
        if (!graphData.dress) graphData.dress = 0;
        if (!graphData.skirt) graphData.skirt = 0;
        if (!graphData.pants) graphData.pants = 0;
        if (!graphData.short) graphData.short = 0;
        if (!graphData.jumpsuit) graphData.jumpsuit = 0;
        if (!graphData.accessory) graphData.accessory = 0;
        if (!graphData.unknown) graphData.unknown = 0;

        var data = google.visualization.arrayToDataTable([
            ['Catégorie', 'Vêtements vendus'],
            ['Manteaux', graphData.coat], 
            ['Vestes', graphData.vest], 
            ['Hauts et t-shirts', graphData.top_tshirt],
            ['Gillets', graphData.cardigan],
            ['Robes', graphData.dress],
            ['Jupes', graphData.skirt],
            ['Pantalons', graphData.pants],
            ['Shorts', graphData.shorts],
            ['Combinaisons', graphData.jumpsuit],
            ['Accessoires', graphData.accessory],
            ['Non classé', graphData.unknown]
          ]);
  
          var options = {
            title: '',
            legend: 'none',
            pieHole: 0.4,
            pieSliceText: 'label',
            colors: ['#5e64a3', '#8187cd', '#a8aeed', '#b9bef0', '#c7cbf1', '#d4d6ed', '#dddfec'],
            chartArea: {left: 10, top: 10, width: "90%", height: "90%"},
          };
  
          var chart = new google.visualization.PieChart(document.querySelector('#sales-category-pie .chart'));
  
          chart.draw(data, options);

          $('#sales-category-pie').removeClass('in-progress');
    }

/**/

    if ($('.dashboard-page').length > 0) that.init();

});