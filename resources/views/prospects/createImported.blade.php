@extends('layouts.app', ['title' => 'Création des infos du prospects', 'activeDashboard' => 'active'])

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Prospects
            <small>Insérez les informations sur votre prospects</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url()->route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Prospect</a></li>
            <li class="active">Insertion informations</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            {{ Form::open(['route' =>'prospect.store', 'method' => 'POST']) }}
            {{ Form::hidden('tempProspectId', $tempProspect->id) }}
            <div class="row">
                <!-- col gauche -->
                <div class="col-md-8 col-xs-12">
                    <!-- box informations -->
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
                                    <td><label for="civilite">Source </label></td>
                                    <td class="data">
                                        {{ Form::text('prospect_source', $tempProspect->prospect_source, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="civilite">Civilité</label></td>
                                    <td class="data">
                                        {{ Form::select('civilite', ['Madame' => 'Madame', 'Monsieur' => 'Monsieur' ], $tempProspect->civilite , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nom">nom</label></td>
                                    <td class="data {{ $errors->has('nom') ? ' has-error' : '' }}">
                                        {{ Form::text('nom', $tempProspect->nom , ['class' => 'form-control', 'id' => 'nom']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nom">nom jeune fille</label></td>
                                    <td class="data {{ $errors->has('nomjeunefille') ? ' has-error' : '' }}">
                                        {{ Form::text('nomjeunefille', $tempProspect->nomjeunefille , ['class' => 'form-control', 'id' => 'nomjeunefille']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="prenom">prenom</label></td>
                                    <td class="data {{ $errors->has('prenom') ? ' has-error' : '' }}">
                                        {{ Form::text('prenom', $tempProspect->prenom , ['class' => 'form-control', 'id' => 'prenom']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="email">email</label></td>
                                    <td class="data {{ $errors->has('email') ? ' has-error' : '' }}">
                                        {{ Form::email('email', $tempProspect->email , ['class' => 'form-control', 'id' => 'email']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="numTelFixe">Téléphone Fixe</label></td>
                                    <td class="data">
                                        {{ Form::text('numTelFixe', $tempProspect->tel_fixe , ['class' => 'form-control', 'id' => 'numTelFixe']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="numTelPortable">Téléphone Portable</label></td>
                                    <td class="data {{ $errors->has('numTelPortable') ? ' has-error' : '' }}">
                                        {{ Form::text('numTelPortable', $tempProspect->tel_portable , ['class' => 'form-control', 'id' => 'numTelPortable']) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box informations -->

                    <!-- box civilite -->
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
                                    <td><label for="dateDeNaissance">Date De Naissance</label></td>
                                    <td class="data">
                                        {{ Form::date('dateDeNaissance', @Carbon\Carbon::now() , ['class' => 'form-control', 'id' => 'dateDeNaissance']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="situationFamiliale">Situation Familiale</label></td>
                                    <td class="data">
                                        <select id="situationFamiliale" name="situationFamiliale" class="form-control">
                                            <option value="Célibataire">Célibataire</option>
                                            <option value="Marié(e)">Marié(e)</option>
                                            <option value="Divorcé(e)">Divorcé(e)</option>
                                            <option value="Vie maritale/Pacs">Vie maritale/Pacs</option>
                                            <option value="Veuf(ve)">Veuf(ve)</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nbEnfantACharge">Nb Enfants à charge</label></td>
                                    <td class="data {{ $errors->has('nbEnfantACharge') ? ' has-error' : '' }}">
                                        {{ Form::text('nbEnfantACharge', $tempProspect->nombre_denfants_a_charge, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nationalite">nationalite</label></td>
                                    <td class="data {{ $errors->has('nationalite') ? ' has-error' : '' }}">
                                        {{ Form::text('nationalite', $tempProspect->nationalite, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="paysNaissance">Pays de Naissance</label></td>
                                    <td class="data {{ $errors->has('paysNaissance') ? ' has-error' : '' }}">
                                        {{ Form::text('paysNaissance', $tempProspect->pays_de_naissance, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="departementNaissance">Département de Naissance</label></td>
                                    <td class="data {{ $errors->has('departementNaissance') ? ' has-error' : '' }}">
                                        {{ Form::text('departementNaissance', $tempProspect->dpt_de_naissance, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="VilleDeNaissance">VilleDeNaissance</label></td>
                                    <td class="data {{ $errors->has('VilleDeNaissance') ? ' has-error' : '' }}">
                                        {{ Form::text('VilleDeNaissance', $tempProspect->ville_de_naissance, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box civilite -->

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
                                    <td><label for="secteurActivite">secteur d'activite</label></td>
                                    <td class="data">
                                        <select id="secteurActivite" name="secteurActivite" class="form-control">
                                            <option value="Secteur privé">Secteur privé</option>
                                            <option value="Secteur public">Secteur public</option>
                                            <option value="Secteur agricole">Secteur agricole</option>
                                            <option value="Artisans-Commerçants">Artisans-Commerçants</option>
                                            <option value="Professions libérales">Professions libérales</option>
                                            <option value="Autres">Autres</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="profession">profession</label></td>
                                    <td class="data {{ $errors->has('profession') ? ' has-error' : '' }}">
                                        {{ Form::text('profession', null, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="professionDepuis">professionDepuis</label></td>
                                    <td class="data">
                                        <?php $date = Carbon\Carbon::createFromDate($tempProspect->depuis_contrat_annee, $tempProspect->depuis_contrat_mois, 01) ? Carbon\Carbon::createFromDate($tempProspect->depuis_contrat_annee, $tempProspect->depuis_contrat_mois, 01) : '01/01/1900' ; ?>
                                        {{ Form::date('professionDepuis',$date , ['class' => 'form-control', 'id' => 'professionDepuis']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="revenusNetMensuel">revenusNetMensuel</label></td>
                                    <td class="data {{ $errors->has('revenusNetMensuel') ? ' has-error' : '' }}">
                                        {{ Form::text('revenusNetMensuel', $tempProspect->votre_salaire, ['class' => 'form-control', 'id' => 'revenusNetMensuel']) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box revenus -->

                    <!-- box revenus conjoint-->
                    <div id="box-conjoint" class="box">
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
                                    <td><label for="secteurActiviteConjoint">secteur Activite Conjoint</label></td>
                                    <td class="data">
                                        <select id="secteurActiviteConjoint" name="secteurActiviteConjoint" class="form-control">
                                            <option value="Secteur privé">Secteur privé</option>
                                            <option value="Secteur public">Secteur public</option>
                                            <option value="Secteur agricole">Secteur agricole</option>
                                            <option value="Artisans-Commerçants">Artisans-Commerçants</option>
                                            <option value="Professions libérales">Professions libérales</option>
                                            <option value="Autres">Autres</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="professionConjoint">profession Conjoint</label></td>
                                    <td class="data">
                                        {{ Form::text('professionConjoint', $tempProspect->profession_du_conjoint, ['class' => 'form-control', 'id' => 'professionConjoint']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="professionDepuisConjoint">profession Depuis Conjoint</label></td>
                                    <td class="data">
                                        <?php $date2 = Carbon\Carbon::createFromDate($tempProspect->contrat_conjoint_depuis_annee, $tempProspect->contrat_conjoint_depuis_mois, 01) ? Carbon\Carbon::createFromDate($tempProspect->contrat_conjoint_depuis_annee, $tempProspect->contrat_conjoint_depuis_mois, 01) : '01/01/1900'?>
                                        {{ Form::date('professionDepuisConjoint', $date2, ['class' => 'form-control', 'id' => 'professionDepuisConjoint']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="revenusNetMensuelConjoint">revenus net mensuel conjoint</label></td>
                                    <td class="data">
                                        {{ Form::text('revenusNetMensuelConjoint', $tempProspect->salaire_conjoint, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box revenus conjoint -->

                    <!-- box habitation -->
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
                                    <td><label for="habitation">habitation</label></td>
                                    <td class="data">
                                        <select id="habitation" name="habitation" class="form-control">
                                            <option value="Accèdent à la propriété">Accèdent à la propriété</option>
                                            <option value="Propriétaire">Propriétaire</option>
                                            <option value="Locataire">Locataire</option>
                                            <option value="Logé par la famille">Logé par la famille</option>
                                            <option value="Logé par employeur">Logé par employeur</option>
                                            <option value="autre">autre</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="habiteDepuis">habiteDepuis</label></td>
                                    <td class="data">
                                        <?php $date = Carbon\Carbon::createFromDate($tempProspect->lgmt_depuis_annee, $tempProspect->lgmt_depuis_mois, 01) ? Carbon\Carbon::createFromDate($tempProspect->lgmt_depuis_annee, $tempProspect->lgmt_depuis_mois, 01) : '01/01/1900'; ?>
                                        {{ Form::date('habiteDepuis', $date, ['class' => 'form-control', 'id' => 'habiteDepuis']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="adresse">adresse</label></td>
                                    <td class="data {{ $errors->has('adresse') ? ' has-error' : '' }}">
                                        {{ Form::text('adresse', $tempProspect->adresse, ['class' => 'form-control'] ) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="complementAdresse">complement adresse</label></td>
                                    <td class="data">
                                        {{ Form::text('complementAdresse', $tempProspect->adresse_2, ['class' => 'form-control'] ) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="codePostal">code postal</label></td>
                                    <td class="data {{ $errors->has('codePostal') ? ' has-error' : '' }}">
                                        {{ Form::text('codePostal', $tempProspect->code_postal, ['class' => 'form-control', 'id' => 'codePostal'] ) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="ville">ville</label></td>
                                    <td class="data {{ $errors->has('ville') ? ' has-error' : '' }}">
                                        {{ Form::text('ville', $tempProspect->ville, ['class' => 'form-control'] ) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box habitation -->
                </div>

                <!-- col droite -->
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
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-sticky-note-o" aria-hidden="true"></i></span>
                                <textarea title="notes" name="notes" id="notes" class="form-control">{{ Carbon\Carbon::now()->format('d M Y à h:m') }} Création</textarea>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box notes -->

                    <!-- box charges -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Charges</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table id="chargesTable" class="table table-bordered table-hover">
                                <tr>
                                    <td><label for="loyer">loyer</label></td>
                                    <td>
                                        {{ Form::text('loyer', $tempProspect->montant_de_votre_loyer , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="pensionAlimentaire">pension alimentaire</label></td>
                                    <td id="pensionAlimentaire" class="data">
                                        {{ Form::text('pensionAlimentaire', $tempProspect->pension_alimentaire , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr id="creditrow-0">
                                    <td>
                                        <input type="text" class="form-control" id="credit-name-0" name="credit-name-0" placeholder="nom credit"></td>
                                    <td>
                                        <input type="text" class="form-control" id="credit-montant-0" name="credit-montant-0" placeholder="montant credit">
                                    </td>
                                </tr>
                            </table>
                            <div class="text-center" style="padding-top: 10px;">
                                <button id="addCreditButton" class="btn btn-info btn-sm">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Ajouter un credit
                                </button>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box charges -->

                    <!-- box Banque -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Banque</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table id="chargesTable" class="table table-bordered table-hover">
                                <tr>
                                    <td><label for="NomBanque">Banque</label></td>
                                    <td class="data {{ $errors->has('NomBanque') ? ' has-error' : '' }}">
                                        {{ Form::text('NomBanque', $tempProspect->banque, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="pensionAlimentaire">Banque depuis le </label></td>
                                    <td>
                                        {{ Form::date('BanqueDepuis',  @Carbon\Carbon::now(), ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box Banque -->

                    <!-- boutton submit -->
                    <div class="text-center col-md-12">
                        <button class="btn btn-lg btn-success">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Enregistrer
                        </button>
                    </div>
                    <!-- ./ boutton submit -->
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('bower_components/jquery-mask/jquery.mask.js') }}" type="application/javascript"></script>
    <script src="{{ asset('js/createProspect.js') }}" type="application/javascript"></script>
    <script>
        $(document).ready(function () {
            //Format Code Postal
            $('#codePostal').mask('00000', { placeholder: '_____'});

            //Format num tel
            $('#numTelFixe').mask('00.00.00.00.00', { placeholder: '__.__.__.__.__'});

            //Format num port
            $('#numTelPortable').mask('00.00.00.00.00', { placeholder: '__.__.__.__.__'});

            //Affiche ou masque la box des infos du conjoint en fonction de la situation familiale
            $('select#situationFamiliale').on('change', function (e) {
                e.preventDefault();

                var val = $('select#situationFamiliale option:selected').text();
                if(val != 'Marié(e)') {
                    $('#box-conjoint').removeClass().addClass('box collapsed-box')
                }
                if(val == 'Marié(e)'){
                    $('#box-conjoint').removeClass().addClass('box')
                }
            });

            //js ajout de nouvelle ligne de credit dans le tableau
            createProspect.addCredit();
        });
    </script>
@endsection