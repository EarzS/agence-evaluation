@extends('layouts.blank')

@push('stylesheets')
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('title', 'Graphic')

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        
        <div class="page-title">
            <div class="title_left">
                <h3>Consultant <small>Graphic</small></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_content">
                        <canvas id="myChart"></canvas>
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

        var labels = <?php echo json_encode($graphic['months']); ?>;

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                @foreach($graphic['consultants'] as $co_usuario => $consultant)
                    {
                        label: "{{$consultant['no_usuario']}}",
                        backgroundColor: getRandomColor(),
                        data: <?php echo json_encode(array_values($consultant['graphic']['period'])); ?>,
                        //data: [51, 30, 40, 28, 92, 50, 45]
                    },
                @endforeach
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: !0
                        }
                    }]
                }
            }
        });
    </script>
@endpush