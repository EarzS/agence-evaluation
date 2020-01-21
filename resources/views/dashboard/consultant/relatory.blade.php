@extends('layouts.blank')

@push('stylesheets')
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('title', 'Relatory')

@section('main_container')

    <!-- page content -->
    <div class="right_col" role="main">
        
        <div class="page-title">
            <div class="title_left">
                <h3>Consultant <small>Relatory</small></h3>
            </div>
        </div>

        @foreach($relatory as $co_usuario => $consultant)
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{$consultant['no_usuario']}}</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th>Periodo</th>
                                    <th>Receita Liquida</th>
                                    <th>custoFixo</th>
                                    <th>Comissao</th>
                                    <th>Lucro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($consultant['period'] as $period => $values)
                                <tr>
                                    <td><!-- Period -->
                                        {{$period}}
                                    </td>
                                    <td><!-- Liquid Recipe -->
                                        {{$values['receita_liquida']}}
                                    </td>
                                    <td><!-- Fixed cost -->
                                        {{$values['custo_fixo']}}
                                    </td>
                                    <td><!-- Commission -->
                                        {{$values['comissao']}}
                                    </td>
                                    <td><!-- Profit -->
                                        {{$values['lucro']}}
                                    </td>
                                </tr>
                                @endforeach                 
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    <!-- /page content -->
@endsection