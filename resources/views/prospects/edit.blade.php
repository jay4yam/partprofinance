@extends('layouts.app', ['title' => 'Edition de prospects', 'activeDashboard' => 'active'])

@section('css')

@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Prospects
            <small>Edition fiche prospect</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url()->route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Prospect</a></li>
            <li class="active">edition</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xs-12">
                    <!-- box information -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Informations</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td>Civilite</td>
                                    <td id="civilite" class="data">
                                        <b class="value">{{ $user->prospect->civilite }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nom</td>
                                    <td id="nom" class="data">
                                        <b class="value">{{ $user->prospect->nom }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prénom</td>
                                    <td id="prenom" class="data">
                                        <b class="value">{{ $user->prospect->prenom }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td id="email" class="data">
                                        <b class="value">{{ $user->email }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Téléphone Fixe</td>
                                    <td id="numTelFixe" class="data">
                                        <b class="value">{{ $user->prospect->numTelFixe }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Téléphone Portable</td>
                                    <td id="numTelPortable" class="data">
                                        <b class="value">{{ $user->prospect->numTelPortable }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box information -->
                </div>
                <div class="col-md-4 col-xs-12">
                    <!-- box notes -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Informations</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-hover">
                                <tr id="civilite">
                                    <td>Civilite</td>
                                    <td class="data"><b class="value">{{ $user->prospect->civilite }}</b></td>
                                </tr>
                                <tr id="nom">
                                    <td>Nom</td>
                                    <td class="data"><b class="value">{{ $user->prospect->nom }}</b></td>
                                </tr>
                                <tr id="prenom">
                                    <td>Prénom</td>
                                    <td class="data"><b class="value">{{ $user->prospect->prenom }}</b></td>
                                </tr>
                                <tr id="prenom">
                                    <td>Prénom</td>
                                    <td class="data"><b class="value">{{ $user->prospect->prenom }}</b></td>
                                </tr>
                                <tr id="email">
                                    <td>Email</td>
                                    <td class="data"><b class="value">{{ $user->email }}</b></td>
                                </tr>
                                <tr id="numTelFixe">
                                    <td>Téléphone Fixe</td>
                                    <td class="data"><b class="value">{{ $user->prospect->numTelFixe }}</b></td>
                                </tr>
                                <tr id="numTelPortable">
                                    <td>Téléphone Portable</td>
                                    <td class="data"><b class="value">{{ $user->prospect->numTelPortable }}</b></td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box notes -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('js')
    <script src="{{ asset('js/editProspect.js') }}"></script>
    <script>
        $(document).ready(function () {
            editProspect.showEditButton();
            editProspect.clickOnEditButton();
        });
    </script>

@endsection