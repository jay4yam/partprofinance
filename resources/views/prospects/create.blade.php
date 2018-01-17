@extends('layouts.app', ['title' => 'Création des infos du prospects', 'activeDashboard' => 'active'])

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Prospects
            <small>Créer un prospect</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url()->route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Prospect</a></li>
            <li class="active">création de prospect</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            {{ Form::open(['route' =>'prospect.store', 'method' => 'POST']) }}
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
                                    <td><label for="civilite">Civilité</label></td>
                                    <td class="data">
                                        <select id="civilite" name="civilite" class="form-control">
                                            <option value="Madame">Madame</option>
                                            <option value="Monsieur">Monsieur</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nom">nom</label></td>
                                    <td class="data">
                                        <input type="text" id="nom" name="nom" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="prenom">prenom</label></td>
                                    <td class="data">
                                        <input type="text" id="prenom" name="prenom" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="email">email</label></td>
                                    <td class="data">
                                        <input type="text" id="email" name="email" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="numTelFixe">Téléphone Fixe</label></td>
                                    <td class="data">
                                        <input type="text" id="numTelFixe" name="numTelFixe" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="numTelPortable">Téléphone Portable</label></td>
                                    <td class="data">
                                        <input type="text" id="numTelPortable" name="numTelPortable" class="form-control">
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
                                    <td><label for="nationalite">nationalite</label></td>
                                    <td class="data">
                                        <input type="text" class="form-control" id="nationalite" name="nationalite">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="paysNaissance">Pays de Naissance</label></td>
                                    <td class="data">
                                        <input type="text" class="form-control" id="paysNaissance" name="paysNaissance">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="departementNaissance">Département de Naissance</label></td>
                                    <td class="data">
                                        <input type="text" class="form-control" id="departementNaissance" name="departementNaissance">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="VilleDeNaissance">VilleDeNaissance</label></td>
                                    <td class="data">
                                        <input type="text" class="form-control" id="VilleDeNaissance" name="VilleDeNaissance">
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
                                    <td class="data">
                                        <input type="text" class="form-control" id="profession" name="profession">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="professionDepuis">professionDepuis</label></td>
                                    <td class="data">
                                        <input type="text" class="form-control" id="professionDepuis" name="professionDepuis">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="revenusNetMensuel">revenusNetMensuel</label></td>
                                    <td class="data">
                                        <input type="text" class="form-control" id="revenusNetMensuel" name="revenusNetMensuel">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box revenus -->
                    <!-- box revenus conjoint-->
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
                                        <input type="text" class="form-control" id="professionConjoint" name="professionConjoint">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="professionDepuisConjoint">profession Depuis Conjoint</label></td>
                                    <td class="data">
                                        <input type="text" class="form-control" id="professionDepuisConjoint" name="professionDepuisConjoint">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="revenusNetMensuelConjoint">revenus net mensuel conjoint</label></td>
                                    <td class="data">
                                        <input type="text" class="form-control" id="revenusNetMensuelConjoint" name="revenusNetMensuelConjoint">
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
                                        <input type="text" class="form-control" id="habiteDepuis" name="habiteDepuis">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="adresse">adresse</label></td>
                                    <td class="data">
                                        <input type="text" class="form-control" id="adresse" name="adresse">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="complementAdresse">complement adresse</label></td>
                                    <td class="data">
                                        <input type="text" class="form-control" id="complementAdresse" name="complementAdresse">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="codePostal">code postal</label></td>
                                    <td class="data">
                                        <input type="text" class="form-control" id="codePostal" name="codePostal">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="ville">ville</label></td>
                                    <td class="data">
                                        <input type="text" class="form-control" id="ville" name="ville">
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
                                <textarea title="notes" name="value" id="notes" class="form-control"></textarea>
                            </div>
                            <button type="submit" id="ajaxnotesupdate" class="btn btn-success updateNotesbutton">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </button>
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
                                        <input type="text" class="form-control" id="loyer" name="loyer">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="pensionAlimentaire">pension alimentaire</label></td>
                                    <td id="pensionAlimentaire" class="data">
                                        <input type="text" class="form-control" id="pensionAlimentaire" name="pensionAlimentaire">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="credits">credits</label></td>
                                    <td>
                                        <input type="text" class="form-control" id="credits" name="credits">
                                    </td>
                                </tr>
                            </table>
                            <div class="text-center" style="padding-top: 10px;">
                                <button id="addCreditButton" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Ajouter un credit
                                </button>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box charges -->
                </div>
            </div>
            <div class="row">
                <div class="text-center">
                    <button class="btn btn-success">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Enregistrer
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </section>
@endsection