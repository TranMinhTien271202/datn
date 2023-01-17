@extends('company.layout.app')
@section('content')
    <div class="row">
        <div class="ui-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="ui-item">
                <div class="left">
                    <i class="icon flaticon-briefcase"></i>
                </div>
                <div class="right">
                    <h4>{{ $JobPost->count() }}</h4>
                    <p>Tin tuyển dụng</p>
                </div>
            </div>
        </div>
        <div class="ui-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="ui-item ui-red">
                <div class="left">
                    <i class="icon la la-file-invoice"></i>
                </div>
                <div class="right">
                    <h4>{{ $Applied }}</h4>
                    <p>Ứng tuyển</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class=" col-lg-12">
            <!-- Graph widget -->
            <div class="graph-widget ls-widget">
                <div class="tabs-box">
                    <div class="widget-title">
                        <h4>Thống kê</h4>
                        <div class="chosen-outer">
                            <!--Tabs Box-->
                            <select id="time-search" class="chosen-select">
                                <option value="7">7 ngày trước</option>
                                <option value="28">28 ngày trước</option>
                            </select>
                        </div>
                    </div>

                    <div class="widget-content">
                        <canvas id="chart" width="100" height="45"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="image-layer" style="background-image: url({{ asset('/assets/client-bower/images/background/12.jpg') }});">
    </div>
    </div>
    <!-- End Info Section -->
@endsection
@section('script')
    @parent
    <script src="{{asset('assets/client-bower/js/chart.min.js')}}"></script>
    <script>
        Chart.defaults.global.defaultFontFamily = "Sofia Pro";
        Chart.defaults.global.defaultFontColor = '#888';
        Chart.defaults.global.defaultFontSize = '14';
        var date = {!!json_encode($arrayDate)!!};
        var applied = {!!json_encode($totalApplied)!!};
        showChart(date,applied)
        function showChart(date,applied){
            var ctx = document.getElementById('chart').getContext('2d');
            var chart = new Chart(ctx, {

                type: 'line',
                // The data for our dataset
                data: {
                    labels: date,
                    // Information about the dataset
                    datasets: [{
                        label: "Ứng tuyển",
                        backgroundColor: 'transparent',
                        borderColor: '#1967D2',
                        borderWidth: "1",
                        data: applied,
                        pointRadius: 3,
                        pointHoverRadius: 3,
                        pointHitRadius: 10,
                        pointBackgroundColor: "#1967D2",
                        pointHoverBackgroundColor: "#1967D2",
                        pointBorderWidth: "2",
                    }]
                },

                // Configuration options
                options: {

                    layout: {
                        padding: 10,
                    },

                    legend: {
                        display: false
                    },
                    title: {
                        display: false
                    },

                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: false
                            },
                            gridLines: {
                                borderDash: [6, 10],
                                color: "#d8d8d8",
                                lineWidth: 1,
                            },
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: false
                            },
                            gridLines: {
                                display: false
                            },
                        }],
                    },

                    tooltips: {
                        backgroundColor: '#333',
                        titleFontSize: 13,
                        titleFontColor: '#fff',
                        bodyFontColor: '#fff',
                        bodyFontSize: 13,
                        displayColors: false,
                        xPadding: 10,
                        yPadding: 10,
                        intersect: false
                    }
                },
            });
        }
        $('#time-search').on('change',function(){
           var time_filter = $('#time-search').val();
            $.ajax({
                type: "GET",
                url: "",
                data: {'time_filter':time_filter},
                    success: function(response) {
                        var date = response.arrayDate;
                        var applied = response.totalApplied;
                        showChart(date,applied)
                        toastr.success("Cập nhật dữ liệu")
                    },
                    error: function(response) {
                        toastr.error("Lỗi dữ liệu")
                    }
                });
        })
    </script>
@endsection
