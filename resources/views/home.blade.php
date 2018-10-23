@extends('layouts.app', ['title' => 'Tableau de bord', 'activeDashboard' => 'active'])

@section('css')
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Statistique du mois</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- 2 ligne de stats -->
        @if(Auth::user()->role == 'admin')
            @include('stats._statsHome', [
            'annee' => Request::get('annee') ? Request::get('annee') : \Carbon\Carbon::now()->format('Y') ,
            'mois' => Request::get('mois') ? Request::get('mois') : \Carbon\Carbon::now()->format('m')
            ])
        @endif
        <!-- /.row -->

        @if(Auth::user()->role == 'staff')
            @include('stats._statsHomeSale')
        @endif

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
                <!-- TO DO List -->
                @include('task._taskHome')
                <!-- /.box -->
            </section>
            <!-- /.Left col -->

            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">
                <!-- Statistique leads -->
                @include('stats._leadsStats')
                <!-- /.box -->
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->

        <!-- calendar row -->
        <div class="row">
            @include('calendrier.index')
        </div>
        <!-- ./ calendar row -->
    </section>
    <!-- /.content -->
@endsection

@section('js')
    <!-- Morris.js charts -->
    <script src="{{ asset('bower_components/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('bower_components/morris.js/morris.min.js') }}"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('js/pages/dashboard.js') }}"></script>
@endsection
