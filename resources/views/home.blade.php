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
        <div class="box">
            {{ Form::open([ 'route' => 'home', 'method' => 'GET', 'class' => 'form-inline']) }}
            <div class="form-group sep">
                {{ Form::select('annee', $dossierYears, request()->get('annee'), ['class' => 'form-control', 'placeholder' => 'choisissez l\'annee']) }}
            </div>
            <div class="form-group sep">
                {{ Form::select('mois', $dossierMonths, request()->get('mois'), ['class' => 'form-control', 'placeholder' => 'choisissez le mois']) }}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-search" aria-hidden="true"></i> Filtre
                </button>
            </div>
            <div class="form-group">
                <a href="{{ url()->route('home') }}" class="btn btn-warning">raz filtre</a>
            </div>
            {{ Form::close() }}
        </div>

        <!-- 2 ligne de stats -->
        @if(Auth::user()->role == 'admin')
            <!-- stat admin -->
            @include('stats._statsHome')

            @foreach(\App\Models\User::where('role', '=', 'staff')->get(['id', 'name']) as $user)
                @include('stats._statsForEachSales', ['id' => $user->id, 'name' => $user->name])
            @endforeach
        @endif
        <!-- /.row -->

        @if(Auth::user()->role == 'staff')
            <!-- stat d'un commercial -->
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
    <script src="{{ asset('js/task.js') }}"></script>

    <script>
        $(document).ready(function () {
            task.updateTask();
            task.updateTaskDoneOrNot();
        });

        $('.delete-task').on('click', function () {
            $(this).parents('form').submit();
        });
    </script>
@endsection
