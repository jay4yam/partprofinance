@extends('layouts.app', ['title' => 'Edition d\'un prospect', 'activeDashboard' => 'active'])

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edition du Prospect
            <small>Editez les informations du prospect</small>
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
            {{ Form::model($prospect,['route' => ['temp_prospect.update', $prospect], 'method' => 'PATCH', 'class' => 'form'] ) }}
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
                                        {{ Form::text('prospect_source', $prospect->prospect_source, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="civilite">Civilité</label></td>
                                    <td class="data">
                                        {{ Form::select('civilite', ['Madame' => 'Madame', 'Monsieur' => 'Monsieur' ], $prospect->civilite , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nom">nom</label></td>
                                    <td class="data {{ $errors->has('nom') ? ' has-error' : '' }}">
                                        {{ Form::text('nom', $prospect->nom , ['class' => 'form-control', 'id' => 'nom']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nom">nom jeune fille</label></td>
                                    <td class="data {{ $errors->has('nomjeunefille') ? ' has-error' : '' }}">
                                        {{ Form::text('nomjeunefille', $prospect->nomjeunefille , ['class' => 'form-control', 'id' => 'nomjeunefille']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="prenom">prenom</label></td>
                                    <td class="data {{ $errors->has('prenom') ? ' has-error' : '' }}">
                                        {{ Form::text('prenom', $prospect->prenom , ['class' => 'form-control', 'id' => 'prenom']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="email">email</label></td>
                                    <td class="data {{ $errors->has('email') ? ' has-error' : '' }}">
                                        {{ Form::email('email', $prospect->email , ['class' => 'form-control', 'id' => 'email']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="numTelFixe">Téléphone Fixe</label></td>
                                    <td class="data">
                                        {{ Form::text('numTelFixe', $prospect->tel_fixe, ['class' => 'form-control', 'id' => 'numTelFixe']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="numTelPortable">Téléphone Portable</label></td>
                                    <td class="data {{ $errors->has('numTelPortable') ? ' has-error' : '' }}">
                                        {{ Form::text('numTelPortable', $prospect->tel_portable , ['class' => 'form-control', 'id' => 'numTelPortable']) }}
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
                                        {{ Form::date('dateDeNaissance', $prospect->date_de_naissance , ['class' => 'form-control', 'id' => 'dateDeNaissance']) }}
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
                                        {{ Form::text('nbEnfantACharge', $prospect->nombre_denfants_a_charge, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nationalite">nationalite</label></td>
                                    <td class="data {{ $errors->has('nationalite') ? ' has-error' : '' }}">
                                        {{ Form::text('nationalite', $prospect->nationalite, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="paysNaissance">Pays de Naissance</label></td>
                                    <td class="data {{ $errors->has('paysNaissance') ? ' has-error' : '' }}">
                                        {{ Form::text('paysNaissance', $prospect->pays_de_naissance, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="departementNaissance">Département de Naissance</label></td>
                                    <td class="data {{ $errors->has('departementNaissance') ? ' has-error' : '' }}">
                                        {{ Form::text('departementNaissance', $prospect->dpt_de_naissance, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="VilleDeNaissance">VilleDeNaissance</label></td>
                                    <td class="data {{ $errors->has('VilleDeNaissance') ? ' has-error' : '' }}">
                                        {{ Form::text('VilleDeNaissance', $prospect->ville_de_naissance, ['class' => 'form-control']) }}
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
                                        {{ Form::select('secteurActivite', [
                                        'Secteur privé' => 'Secteur privé', 'Secteur public' => 'Secteur public',
                                        'Secteur agricole' => 'Secteur agricole', 'Artisans-Commerçants' => 'Artisans-Commerçants',
                                        'Professions libérales' => 'Professions libérales', 'Autres' => 'Autres'
                                         ], $prospect->secteur_activite ,['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="profession">Type de Contrat</label></td>
                                    <td class="data {{ $errors->has('type_de_votre_contrat') ? ' has-error' : '' }}">
                                        {{ Form::text('type_de_votre_contrat', null, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="profession">profession</label></td>
                                    <td class="data {{ $errors->has('profession') ? ' has-error' : '' }}">
                                        {{ Form::text('profession', $prospect->votre_profession, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="professionDepuis">professionDepuis</label></td>
                                    <td class="data">
                                        {{ Form::date('professionDepuis', Carbon\Carbon::create($prospect->depuis_contrat_annee), ['class' => 'form-control', 'id' => 'professionDepuis']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="revenusNetMensuel">revenusNetMensuel</label></td>
                                    <td class="data {{ $errors->has('revenusNetMensuel') ? ' has-error' : '' }}">
                                        {{ Form::text('revenusNetMensuel', $prospect->votre_salaire, ['class' => 'form-control', 'id' => 'revenusNetMensuel']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="profession">Périodicité Salaire</label></td>
                                    <td class="data {{ $errors->has('periodicite_salaire') ? ' has-error' : '' }}">
                                        {{ Form::text('periodicite_salaire', $prospect->periodicite_salaire, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="profession">Autre revenu</label></td>
                                    <td class="data {{ $errors->has('autre_revenu') ? ' has-error' : '' }}">
                                        {{ Form::text('autre_revenu', null, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box revenus -->

                    <!-- box infos conjoint-->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Informations Conjoint</h3>
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
                                    <td><label for="civ_du_conjoint">Civilité du conjoint</label></td>
                                    <td class="data">
                                        {{ Form::select('civ_du_conjoint', ['Madame' => 'Madame', 'Monsieur' => 'Monsieur' ], $prospect->civ_du_conjoint , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nom conjoint">nom conjoint</label></td>
                                    <td class="data {{ $errors->has('nom_du_conjoint') ? ' has-error' : '' }}">
                                        {{ Form::text('nom_du_conjoint', $prospect->nom_du_conjoint , ['class' => 'form-control', 'id' => 'nom']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="prenom">prenom conjoint</label></td>
                                    <td class="data {{ $errors->has('prenom_du_conjoint') ? ' has-error' : '' }}">
                                        {{ Form::text('prenom_du_conjoint', $prospect->prenom_du_conjoint , ['class' => 'form-control', 'id' => 'prenom']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="dateDeNaissanceConjoint">Date De Naissance Conjoint</label></td>
                                    <td class="data">
                                        {{ Form::date('date_de_naissance_du_conjoint', $prospect->date_de_naissance_du_conjoint  , ['class' => 'form-control', 'id' => 'dateDeNaissance']) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box infos conjoint-->

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
                                        {{ Form::select('secteur_activite_conjoint', [
                                        'Secteur privé' => 'Secteur privé', 'Secteur public' => 'Secteur public',
                                        'Secteur agricole' => 'Secteur agricole', 'Artisans-Commerçants' => 'Artisans-Commerçants',
                                        'Professions libérales' => 'Professions libérales', 'Autres' => 'Autres'
                                         ], $prospect->secteur_activite_conjoint ,['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="profession">Type de Contrat</label></td>
                                    <td class="data {{ $errors->has('contrat_du_conjoint') ? ' has-error' : '' }}">
                                        {{ Form::text('contrat_du_conjoint', null, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="professionConjoint">profession Conjoint</label></td>
                                    <td class="data">
                                        {{ Form::text('professionConjoint', $prospect->profession_du_conjoint, ['class' => 'form-control', 'id' => 'professionConjoint']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="professionDepuisConjoint">profession Depuis Conjoint</label></td>
                                    <td class="data">
                                        {{ Form::date('professionDepuisConjoint', \Carbon\Carbon::create($prospect->contrat_conjoint_depuis_annee), ['class' => 'form-control', 'id' => 'professionDepuisConjoint']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="revenusNetMensuelConjoint">revenus net mensuel conjoint</label></td>
                                    <td class="data">
                                        {{ Form::text('revenusNetMensuelConjoint', $prospect->salaire_conjoint, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="profession">Périodicité Salaire</label></td>
                                    <td class="data {{ $errors->has('periodicite_salaire_conjoint') ? ' has-error' : '' }}">
                                        {{ Form::text('periodicite_salaire_conjoint', $prospect->periodicite_salaire_conjoint, ['class' => 'form-control']) }}
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
                                        {{ Form::date('habiteDepuis', Carbon\Carbon::create($prospect->lgmt_depuis_annee), ['class' => 'form-control', 'id' => 'habiteDepuis']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="adresse">adresse</label></td>
                                    <td class="data {{ $errors->has('adresse') ? ' has-error' : '' }}">
                                        {{ Form::text('adresse', $prospect->adresse, ['class' => 'form-control'] ) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="complementAdresse">complement adresse</label></td>
                                    <td class="data">
                                        {{ Form::text('complementAdresse', $prospect->adresse_2, ['class' => 'form-control'] ) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="codePostal">code postal</label></td>
                                    <td class="data {{ $errors->has('codePostal') ? ' has-error' : '' }}">
                                        {{ Form::text('codePostal', $prospect->code_postal, ['class' => 'form-control', 'id' => 'codePostal'] ) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="ville">ville</label></td>
                                    <td class="data {{ $errors->has('ville') ? ' has-error' : '' }}">
                                        {{ Form::text('ville', $prospect->ville, ['class' => 'form-control'] ) }}
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
                                <textarea title="notes" name="notes" id="notes" class="form-control">{{ $prospect->notes }}</textarea>
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
                                        {{ Form::text('loyer', $prospect->montant_de_votre_loyer , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="loyer">Mensualité immo</label></td>
                                    <td>
                                        {{ Form::text('mensualite_immo',$prospect->mensualite_immo , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="loyer">Valeur Immo</label></td>
                                    <td>
                                        {{ Form::text('valeur_de_votre_bien_immobilier',$prospect->valeur_de_votre_bien_immobilier , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="pensionAlimentaire">pension alimentaire</label></td>
                                    <td id="pensionAlimentaire" class="data">
                                        {{ Form::text('pensionAlimentaire', $prospect->pension_alimentaire , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="loyer">Autre charges</label></td>
                                    <td>
                                        {{ Form::text('autre_charge',$prospect->autre_charge , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nombre_de_credits_en_cours">Nb credits en cours</label></td>
                                    <td>
                                        {{ Form::text('nombre_de_credits_en_cours', $prospect->nombre_de_credits_en_cours , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="total_credit">Montant restant dû</label></td>
                                    <td>
                                        {{ Form::text('total_credit', $prospect->total_credit , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="total_credit_mensualite">Mensualite credit</label></td>
                                    <td>
                                        {{ Form::text('total_credit_mensualite', $prospect->total_credit_mensualite , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <!--
                                <tr id="creditrow-0">
                                    <td>
                                        <input type="text" class="form-control" id="credit-name-0" name="credit-name-0" placeholder="nom credit"></td>
                                    <td>
                                        <input type="text" class="form-control" id="credit-montant-0" name="credit-montant-0" placeholder="montant credit">
                                    </td>
                                </tr>
                                -->
                            </table>
                            <!--
                            <div class="text-center" style="padding-top: 10px;">
                                <button id="addCreditButton" class="btn btn-info btn-sm">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Ajouter un credit
                                </button>
                            </div>
                            -->
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
                                    <td class="data {{ $errors->has('banque') ? ' has-error' : '' }}">
                                        {{ Form::text('banque', $prospect->banque, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="BanqueDepuis">Banque depuis le </label></td>
                                    <td>
                                        {{ Form::date('BanqueDepuis', $prospect->banque_depuis, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box Banque -->

                    <!-- bouton submit -->
                    <div class="text-center col-md-12">
                        <button class="btn btn-lg btn-warning">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Mettre à jour
                        </button>
                    </div>
                    <!-- ./ bouton submit -->
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

            $('#numTelFixe').mask('00.00.00.00.00', { placeholder: '__.__.__.__.__'});

            $('#numTelPortable').mask('00.00.00.00.00', { placeholder: '__.__.__.__.__'});

            //Affiche et/ou Masque la box conjoint
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