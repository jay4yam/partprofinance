@extends('layouts.app', ['title' => 'Edition d\'un dossiers', 'activeDossier' => 'active'])

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dossiers
            <small>Edition du dossier : <b>{{ $dossier->user->prospect->nom }}</b> </small>
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
            {{ Form::model($dossier,['route' => ['dossiers.update', $dossier], 'method' => 'PATCH', 'class' => 'form'] ) }}
            <!-- Col. gauche -->
            <div class="col-md-9">
                <!-- Edition Dossier -->
                <div class="box box-{{ str_slug($dossier->status) }}">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edition du dossier</h3>

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
                                <div class="col-md-4">
                                {{ Form::label('nom', 'Nom : ') }}
                                {{ Form::text('nom', $dossier->user->prospect->nom, ['class' => 'form-control', 'disabled']) }}
                                </div>
                                <div class="col-md-4">
                                {{ Form::label('prenom', 'Prenom : ') }}
                                {{ Form::text('prenom', $dossier->user->prospect->prenom, ['class' => 'form-control', 'disabled']) }}
                                </div>
                                <div class="col-md-4">
                                {{ Form::label('email', 'Email : ') }}
                                {{ Form::text('email', $dossier->user->email, ['class' => 'form-control', 'disabled']) }}
                                </div>
                            </div>
                            <!-- ./Infos prospect (non editable) -->

                            <!-- Type & objet du prêt -->
                            <div class="form-group col-md-12" style="padding: 10px 0">
                                <div class="col-md-6">
                                {{ Form::label('signature', 'Signature : ') }}
                                {{ Form::select('signature', ['Electronique' => 'Electronique', 'Physique' => 'Physique'], $dossier->signature, ['class' => 'form-control']) }}
                                </div>
                                <div class="col-md-6">
                                {{ Form::label('objet_du_pret', 'Objet du pret : ') }}
                                {{ Form::select('objet_du_pret', ['Voitures' => 'Voitures','Moto' => 'Moto', 'Caravane' => 'Caravane', 'Camping-car' => 'Camping-car', 'Bateaux' => 'Bateaux', 'Travaux' => 'Travaux'], $dossier->objet_du_pret, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <!-- ./ Type & objet du prêt -->

                            <!-- Montant & commission -->
                            <div class="form-group">
                                <div class="col-md-3">
                                {{ Form::label('montant_demande', 'Montant demandé : ') }}
                                {{ Form::text('montant_demande', $dossier->montant_demande, ['class' => 'form-control']) }}
                                </div>
                                <div class="col-md-3">
                                {{ Form::label('montant_final', 'Montant final : ') }}
                                {{ Form::text('montant_final', $dossier->montant_final, ['class' => 'form-control']) }}
                                </div>
                                <div class="col-md-3">
                                {{ Form::label('taux_commission', 'Commission : ') }}
                                {{ Form::text('taux_commission', $dossier->taux_commission, ['class' => 'form-control', 'disable']) }}
                                </div>
                                <div class="col-md-3">
                                    <?php
                                    if( $dossier->montant_commission_partpro == null)
                                        $comPartPro = $dossier->montant_demande * $dossier->taux_commission / 100;
                                        $com = $dossier->montant_commission_partpro ? $dossier->montant_commission_partpro : $comPartPro;
                                    ?>
                                    {{ Form::label('montant_commission_partpro', 'Montant Com PartPro : ') }}
                                    {{ Form::text('montant_commission_partpro', $com, ['class' => 'form-control success', 'style' => 'color:#FFF;background-color:#00a65a', 'disable']) }}
                                </div>
                            </div>
                            <!-- ./Montant & commission -->

                            <!-- Organisme préteur  -->
                            <div class="form-group col-md-12" style="padding-top: 10px">
                                {{ Form::label('banque_id', 'Dossier passé chez : ') }}
                                {{ Form::select('banque_id', \App\Models\Banque::pluck('nom', 'id'), $dossier->banque_id , ['class' => 'form-control']) }}
                            </div>
                            <!-- Organisme préteur  -->
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
                <div class="box box-{{ str_slug($dossier->status) }}">
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
                            {{ Form::text('created_at', $dossier->created_at->format('d M y à h:m'), ['class' => 'form-control', 'disabled']) }}


                            {{ Form::label('status', 'Status du dossier : ') }}
                            {{ Form::select('status', ['Refusé' => 'Refusé','A l étude' => 'A l étude','Accepté' => 'Accepté','Payé' => 'Payé' ,'Impayé' => 'Impayé'], $dossier->status, ['class' => 'form-control']) }}

                            {{ Form::label('apporteur', 'Apporteur : ') }}
                            {{ Form::text('apporteur', $dossier->apporteur, ['class' => 'form-control']) }}
                        </div>
                        <!-- ./Infos prospect (non editable) -->

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-center">
                    </div>
                    <!-- /.box-footer-->
                </div>
                <!-- /.Etat du  Dossier -->
            </div>
            <!-- ./ Col. droite -->

            <div class="col-md-12 text-center">
                {{ Form::submit('Mettre à Jour', ['class' => 'btn btn-lg btn-warning']) }}
            </div>
            {{ Form::close() }}
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('js')
    <script>
        $(".delete").on("submit", function(){
            return confirm("La suppression est definitive, êtes vous sure ?");
        });
    </script>
@endsection