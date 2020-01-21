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

        function getRandomColor() {
            var letters = '0123456789ABCDEF'.split('');
            var color = '#';
            for (var i = 0; i < 6; i++ ) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        var period = <?php echo json_encode($graphic['consultants']['carlos.arruda']['graphic']['period']); ?>;
        console.log(period);

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'Setemper', 'November','December'],
                datasets: [
                @foreach($graphic['consultants'] as $co_usuario => $consultant)
                    {
                        label: "{{$consultant['no_usuario']}}",
                        backgroundColor: getRandomColor(),
                        //data: <?php echo json_encode($consultant['graphic']['period']); ?>,
                        data: [51, 30, 40, 28, 92, 50, 45]
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