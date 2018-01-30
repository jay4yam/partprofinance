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
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- 1ere ligne de stats -->
        <div class="row">
            <!-- num de dossier -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $prospects }}</h3>

                        <p>Prospects ce mois ci</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- num de dossier pass&e en volume et en %-->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3>{{ $dossiers }} </h3>

                        <p>{{ round($percentageOfDossier,2) }} % de dossier passés</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- num de dossier accpetés -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $numAccepted }}</h3>

                        <p>Dossiers Acceptés</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-folder"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- num de dossier  réfusé-->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ $numRefus }}</h3>

                        <p>Dossiers Réfusés</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-help-buoy"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- 2eme ligne de stats -->
        <div class="row">
            <!-- commsission du mois -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ round($commissionPartPro, 2) }} €</h3>

                        <p>Total com du mois</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-social-euro"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- montant commission dossier acceptés %-->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3>{{ round($commissionDossierAccepted + $commissionPaye, 2) }} €</h3>

                        <p>Acceptes + Payés</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-social-euro"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- montant commission possible commercial -->
            <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ round( ($commissionDossierAccepted + $commissionPaye) * 0.05, 2) }} €</h3>

                        <p>Prime possible</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-social-euro"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- montant commission payée -->
            <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue-gradient">
                    <div class="inner">
                        <h3>{{ round($commissionPaye, 2) }} €</h3>

                        <p>Com' payées</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-social-euro"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- montant commission commercial réel -->
            <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-black">
                    <div class="inner">
                        <h3>{{ round($commissionPaye * 0.05, 2) }} €</h3>

                        <p>Prime réelle</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-social-euro"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->

                <!-- TO DO List -->
                @include('task._taskHome')
                <!-- /.box -->

            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">

                <!-- Statistique leads -->
                <div class="box box-solid">
                    <div class="box-header">
                        <i class="fa fa-calendar"></i>

                        <h3 class="box-title">Statistique Lead</h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <!-- button with a dropdown -->
                            <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-stats -->
                    <div class="box-body no-padding">
                        <!--The stats -->
                        @include('stats._leadsStats')
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                    </div>
                </div>
                <!-- /.box -->

            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->

        <!-- calendar row -->
        <div class="row">
            @include('calendrier.index')
        </div>

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
