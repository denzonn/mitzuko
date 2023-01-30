@extends('layouts.admin')

@section('title')
    Admin Dashboard Pages - Store
@endsection

@push('addon-style')
    <style>
        #curve_chart {
            border-radius: 10px !important;
        }
    </style>
@endpush

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading" data-aos="fade-up">
                <h2 class="dashboard-title">Admin Dashboard</h2>
                <p class="dashboard-subtitle">Manage it well and get money</p>
            </div>
            <div class="dashboard-content" data-aos="fade-up">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="dashboard-card-title">Costumer</div>
                                <div class="dashboard-card-subtitle">{{ $costumer }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="dashboard-card-title">Profit</div>
                                <div class="dashboard-card-subtitle">Rp. {{ $marginProfit }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="dashboard-card-title">Transaction</div>
                                <div class="dashboard-card-subtitle">{{ $transaction }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" data-aos="fade-up">
                    <div class="col-12 mt-2 " id="chart">
                        <h4>Selling Transaction</h4>
                        <div class="row d-inline-block">
                            <div class="col-12">
                                <div id="curve_chart" style="width: 750px; height: 400px" class="mb-5 mr-2"></div>
                            </div>
                        </div>
                        <div class="row d-inline-block">
                            <div class="col-12">
                                <div id="piechart_3d" style="width: 450px; height: 400px;" class="mb-5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            $.ajax({
                url: '/api/purchases/month',
                type: 'get',
                success: function(response) {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Hari');
                    data.addColumn('number', 'Total Transaksi');

                    // console.log(response.data);
                    // var quantity = parseInt(response.data[0].total_quantity);
                    // // console.log(typeof(quantity));
                    // // console.log(response.status);

                    for (var i = 0; i < response.data.length; i++) {
                        // var quantity = parseInt(response.data[i].total_quantity);
                        data.addRows([
                            [response.data[i].hari, response.data[i].total_quantity],
                        ]);
                        // console.log(response.data[i].quantity);
                    }

                    var options = {
                        title: 'Total Transaksi Perbulan',
                        curveType: 'function',
                        legend: {
                            position: 'bottom'
                        },
                        pointSize: 10,
                        series: {
                            pointShape: 'circle'
                        },
                        animation: {
                            duration: 1000,
                            easing: 'linear',
                            startup: true,
                        },
                        backgroundColor: 'none',
                        // borderRadius: '10px',

                    };

                    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
                    chart.draw(data, options);
                }
            });
        }
    </script>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            $.ajax({
                url: '/api/top/product',
                type: 'get',
                success: function(response) {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Nama Product');
                    data.addColumn('number', 'Total Transaksi');

                    for (var i = 0; i < response.data.length; i++) {
                        var quantity = parseInt(response.data[i].total_quantity);
                        data.addRows([
                            [response.data[i].name, quantity],

                        ]);
                        // console.log(response.data[i].quantity);
                    }

                    var options = {
                        title: '5 Top Product Terlaris',
                        is3D: true,
                        animation: {
                            duration: 1000,
                            easing: 'out',
                            startup: true,
                        },
                        backgroundColor: 'none',
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                    chart.draw(data, options);
                }
            });
        }
    </script>
@endpush
