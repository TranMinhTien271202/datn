@extends('admin.layout.app')
@section('title')
    {{ $title }}
@endsection
@section('style')
    @parent
    <style>

    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <form class="row" method="GET" action="" >
                            <div class="form-group col-5">
                                <label for="">{{ __('FROM') }}</label>
                                <input type="date" name="from"  class="form-control " 
                                    aria-describedby="helpId">
                            </div>
                            <div class="form-group col-5">
                                <label for="">{{ __('TO') }}</label>
                                <input type="date" name="to"  class="form-control" 
                                    aria-describedby="helpId">
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                  <button class="btn btn-primary mt-4"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <figure class="highcharts-figure">
                <div id="chart-1"></div>
            </figure>
        </div>
    </div>
@endsection
@section('script')
    @parent
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        Highcharts.chart('chart-1', {
            chart: {
                type: 'column'
            },
            title: {
                text: {!! json_encode($title) !!},
                align: 'left'
            },
            xAxis: {
                categories: {!! json_encode($date) !!}
            },
            yAxis: {
                min: 0,
                title: {
                    text: {!! json_encode($text_totalmoney) !!}
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'black',
                    }
                }
            },
            legend: {
                align: 'left',
                x: 70,
                verticalAlign: 'top',
                y: 70,
                floating: true,
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: {!! json_encode($dataMoney) !!}
        });
    </script>
@endsection
