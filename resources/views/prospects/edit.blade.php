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
                <!-- Informations -->
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
                <!-- Notes -->
                <div class="col-md-4 col-xs-12">
                    <!-- box notes -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Notes</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <form id="notesUpdate">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="id" value="notes">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-sticky-note-o" aria-hidden="true"></i></span>
                                    <textarea title="notes" name="value" id="notes" class="form-control">{{ $user->prospect->notes }}</textarea>
                                </div>
                                <button type="submit" id="ajaxnotesupdate" class="btn btn-success updateNotesbutton">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box notes -->
                </div>
                <!-- Civilite -->
                <div class="col-md-8 col-xs-12">
                    <!-- box revenus -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Civilite</h3>

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
                                    <td>Nationalite</td>
                                    <td id="nationalite" class="data">
                                        <b class="value">{{ $user->prospect->nationalite }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pays de Naissance</td>
                                    <td id="paysNaissance" class="data">
                                        <b class="value">{{ $user->prospect->paysNaissance }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Département Naissance</td>
                                    <td id="departementNaissance" class="data">
                                        <b class="value">{{ $user->prospect->departementNaissance }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ville De Naissance</td>
                                    <td id="VilleDeNaissance" class="data">
                                        <b class="value">{{ $user->prospect->VilleDeNaissance }}</b>
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
                <!-- Endettement -->
                <div class="col-md-4 col-xs-12">
                    <!-- box notes -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Endettement</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <canvas id="pieChart" style="height:250px"></canvas>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box notes -->
                </div>
                <!-- Revenus -->
                <div class="col-md-8 col-xs-12">
                    <!-- box revenus -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Revenus</h3>

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
                                    <td>Secteur d'activité</td>
                                    <td id="secteurActivite" class="data">
                                        <b class="value">{{ $user->prospect->secteurActivite }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Profession</td>
                                    <td id="profession" class="data">
                                        <b class="value">{{ $user->prospect->profession }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Depuis</td>
                                    <td id="professionDepuis" class="data">
                                        <b class="value">{{ $user->prospect->professionDepuis }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Revenus Net Mensuel</td>
                                    <td id="revenusNetMensuel" class="data">
                                        <b class="value">{{ $user->prospect->revenusNetMensuel }}</b><b>€</b>
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
                <!-- Revenus Conjoint-->
                <div class="col-md-8 col-xs-12">
                    <!-- box revenus -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Revenus conjoint</h3>

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
                                    <td>Secteur d'activité conjoint</td>
                                    <td id="secteurActiviteConjoint" class="data">
                                        <b class="value">{{ $user->prospect->secteurActiviteConjoint }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Profession conjoint</td>
                                    <td id="professionConjoint" class="data">
                                        <b class="value">{{ $user->prospect->professionConjoint }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Depuis conjoint</td>
                                    <td id="professionDepuisConjoint" class="data">
                                        <b class="value">{{ $user->prospect->professionDepuisConjoint }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Revenus Net Mensuel conjoint</td>
                                    <td id="revenusNetMensuelConjoint" class="data">
                                        <b class="value">{{ $user->prospect->revenusNetMensuelConjoint }} €</b>
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
                <!-- Habitation -->
                <div class="col-md-8 col-xs-12">
                    <!-- box revenus -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Habitation</h3>

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
                                    <td>Habitation</td>
                                    <td id="habitation" class="data">
                                        <b class="value">{{ $user->prospect->habitation }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Habite Depuis</td>
                                    <td id="habiteDepuis" class="data">
                                        <b class="value">{{ $user->prospect->habiteDepuis }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Adresse</td>
                                    <td id="adresse" class="data">
                                        <b class="value">{{ $user->prospect->adresse }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Complément adresse</td>
                                    <td id="complementAdresse" class="data">
                                        <b class="value">{{ $user->prospect->complementAdresse }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Code postal</td>
                                    <td id="codePostal" class="data">
                                        <b class="value">{{ $user->prospect->codePostal }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ville</td>
                                    <td id="ville" class="data">
                                        <b class="value">{{ $user->prospect->ville }} €</b>
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
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('js')
    <script src="{{ asset('js/editProspect.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('bower_components/Chart.js/Chart.js') }}"></script>
    <script>
        $(document).ready(function () {
            editProspect.showEditButton();
            editProspect.clickOnEditButton();
            editProspect.ajaxUpdateNotes();
            editProspect.graphEndettement();
        });
    </script>

@endsection