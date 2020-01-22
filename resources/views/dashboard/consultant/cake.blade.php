@extends('layouts.blank')

@push('stylesheets')
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('title', 'Cake')

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        
        <div class="page-title">
            <div class="title_left">
                <h3>Consultant <small>Cake</small></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_content text-center">
                        <canvas id="myCake" width="770" height="385"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /page content -->
@endsection

@push('scripts')
    <!-- ChartJs -->
    <script src="{{ asset("js/Chart.bundle.min.js") }}"></script>

    <script type="text/javascript">

        var randomScalingFactor = function() {
          return Math.round(Math.random() * 100);
        };
        var randomColorFactor = function() {
          return Math.round(Math.random() * 255);
        };
        var getRandomColor = function(opacity) {
          return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
        };

        var labels = [];
        var data = [];
        var backgroundColors = []

        @foreach ($cake['cake'] as $co_usuario => $consultant)
            labels.push('{{$co_usuario}}');
            data.push({{$consultant['percentage']}});
            backgroundColors.push(getRandomColor());
        @endforeach

        var ctx = document.getElementById('myCake').getContext('2d');
        var myCake = new Chart(ctx, {
            type: "doughnut",
            tooltipFillColor: "rgba(51, 51, 51, 0.55)",
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: backgroundColors
                }]
            },
            options: {
                legend: !1,
                responsive: !1,
            }
        });
    </script>
@endpush