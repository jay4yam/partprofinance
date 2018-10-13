@extends('layouts.app', ['title' => 'Créer un dossiers', 'activeDossier' => 'active'])

@section('css')
    <!-- JQUERY UI CSS -->
    <link rel="stylesheet" href="{{ asset('bower_components/jquery-ui/themes/base/autocomplete.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dossiers
            <small>Création d'un dossier : </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url()->route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">dossier</a></li>
            <li class="active">edition</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
        {{ Form::open(['route' => ['dossiers.store'], 'method' => 'POST', 'class' => 'form'] ) }}
            {{ Form::hidden('prospect_id', null, ['id' => 'prospect_id']) }}
            {{ Form::hidden('user_id', Auth::user()->id, ['id' => 'user_id']) }}
        <!-- Col. gauche -->
            <div class="col-md-9">
                <!-- Edition Dossier -->
                <div class="box" id="bobox">
                    <div class="box-header with-border">
                        <h3 class="box-title">Création du dossier</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">

                        <!-- Infos prospect (non editable) -->
                        <div class="form-group">
                            <div class="col-md-4 {{ $errors->has('prenom') ? ' has-error' : '' }}">
                                {{ Form::label('nom', 'Nom : ') }}
                                {{ Form::text('nom', null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-4 {{ $errors->has('prenom') ? ' has-error' : '' }}">
                                {{ Form::label('prenom', 'Prenom : ') }}
                                {{ Form::text('prenom', null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-4 {{ $errors->has('email') ? ' has-error' : '' }}">
                                {{ Form::label('email', 'Email : ') }}
                                {{ Form::text('email', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <!-- ./Infos prospect (non editable) -->

                        <!-- Type & objet du prêt -->
                        <div class="form-group col-md-12" style="padding: 10px 0">
                            <div class="col-md-6">
                                {{ Form::label('signature', 'Signature : ') }}
                                {{ Form::select('signature', ['Electronique' => 'Electronique', 'Physique' => 'Physique'], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6">
                                {{ Form::label('objet_du_pret', 'Objet du pret : ') }}
                                {{ Form::select('objet_du_pret', ['Voitures' => 'Voitures','Moto' => 'Moto', 'Caravane' => 'Caravane', 'Camping-car' => 'Camping-car', 'Bateaux' => 'Bateaux', 'Travaux' => 'Travaux'], null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <!-- ./ Type & objet du prêt -->

                        <!-- Montant & commission -->
                        <div class="form-group">
                            <div class="col-md-3 {{ $errors->has('montant_demande') ? ' has-error' : '' }}">
                                {{ Form::label('montant_demande', 'Montant demandé : ') }}
                                {{ Form::text('montant_demande', null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-2 {{ $errors->has('montant_final') ? ' has-error' : '' }}">
                                {{ Form::label('montant_final', 'Montant final : ') }}
                                {{ Form::text('montant_final', null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-2 {{ $errors->has('duree_du_pret') ? ' has-error' : '' }}">
                                {{ Form::label('duree_du_pret', 'duree_du_pret : ') }}
                                {{ Form::select('duree_du_pret', ['12'=>'12','24'=>'24','36'=>'36','48'=>'48','60'=>'60','72'=>'72','84'=>'84','96'=>'96'], '84', ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-2 {{ $errors->has('taux_commission') ? ' has-error' : '' }}">
                                {{ Form::label('taux_commission', 'Commission : ') }}
                                {{ Form::text('taux_commission', 12.00, ['class' => 'form-control', 'disable']) }}
                            </div>
                            <div class="col-md-3 {{ $errors->has('montant_commission_partpro') ? ' has-error' : '' }}">
                                {{ Form::label('montant_commission_partpro', 'Montant Com PartPro : ') }}
                                {{ Form::text('montant_commission_partpro', null, ['class' => 'form-control success', 'style' => 'color:#FFF;background-color:#00a65a', 'disable']) }}
                            </div>
                        </div>
                        <!-- ./Montant & commission -->

                        <!-- Organisme préteur  -->
                        <div class="form-group col-md-4" style="padding-top: 10px">
                            {{ Form::label('banque_id', 'Dossier passé chez : ') }}
                            {{ Form::select('banque_id', \App\Models\Banque::pluck('nom', 'id'), null , ['class' => 'form-control']) }}
                        </div>
                        <!-- ./Organisme préteur  -->

                        <!-- Num Dossier banque -->
                        <div class="form-group col-md-4" style="padding-top: 10px">
                            {{ Form::label('num_dossier_banque', 'N° de dossier : ') }}
                            {{ Form::text('num_dossier_banque', null , ['class' => 'form-control']) }}
                        </div>
                        <!-- ./Num Dossier banque -->

                        <!-- IBAN -->
                        <div class="form-group col-md-4" style="padding-top: 10px">
                            {{ Form::label('iban', 'Iban du client : ') }}
                            {{ Form::text('iban', null , ['class' => 'form-control']) }}
                        </div>
                        <!-- ./IBAN -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-center">
                    </div>
                    <!-- /.box-footer-->
                </div>
                <!-- /.Edition Dossier -->
            </div>
            <!-- ./ Col. gauche -->

            <!-- Col. droite -->
            <div class="col-md-3">
                <!-- Etat du Dossier -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Etat du dossier</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">

                        <!-- Infos prospect (non editable) -->
                        <div class="form-group">
                            {{ Form::label('created_at', 'Date de création : ') }}
                            {{ Form::date('created_at', Carbon\Carbon::now(), ['class' => 'form-control']) }}


                            {{ Form::label('status', 'Status du dossier : ') }}
                            {{ Form::select('status', ['Refusé' => 'Refusé', 'A l étude' => 'A l étude', 'Accepté' => 'Accepté', 'Payé' => 'Payé' , 'Impayé' => 'Impayé'], 'A l étude', ['class' => 'form-control']) }}

                            {{ Form::label('apporteur', 'Apporteur : ') }}
                            {{ Form::text('apporteur', null, ['class' => 'form-control']) }}
                        </div>
                        <!-- ./Infos prospect (non editable) -->

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-center">
                    </div>
                    <!-- /.box-footer-->
                </div>
                <!-- /.Etat du  Dossier -->

                <!-- Bouton Enregistré -->
                <div class="text-center">
                {{ Form::submit('Enregistrer', ['class' => 'btn btn-lg btn-success col-md-12']) }}
                </div>
            </div>
            <!-- ./ Col. droite -->

            {{ Form::close() }}
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('js')
    <script src="{{ asset('js/editDossier.js') }}" type="application/javascript"></script>
    <script src="{{ asset('bower_components/jquery-mask/jquery.mask.js') }}" type="application/javascript"></script>
    <script>
        $(document).ready(function () {
            //Affiche un message en cas de suppression d'un dossier
            $(".delete").on("submit", function(){
                return confirm("La suppression est definitive, êtes vous sure ?");
            });

            dossierJS.changeMontantDemande();
            dossierJS.autocompleteNom();
        });
    </script>
@endsection