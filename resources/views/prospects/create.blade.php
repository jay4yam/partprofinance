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
        <div class="container">
            <div class="row">
                <!-- Informations -->
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
                                    <td>
                                        <select id="civilite" name="civilite" class="form-control">
                                            <option value="Madame">Madame</option>
                                            <option value="Monsieur">Monsieur</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nom">nom</label></td>
                                    <td>
                                        <input type="text" id="nom" name="nom" class="form-control" value="{{ $tempProspect->nom }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="prenom">prenom</label></td>
                                    <td>
                                        <input type="text" id="prenom" name="prenom" class="form-control" value="{{ $tempProspect->prenom }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="email">email</label></td>
                                    <td>
                                        <input type="text" id="email" name="email" class="form-control" value="{{ $tempProspect->e_mail }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="numTelFixe">Téléphone Fixe</label></td>
                                    <td id="numTelFixe" class="data">
                                        <input type="text" id="numTelFixe" name="numTelFixe" class="form-control" value="{{ $tempProspect->tel_professionnel }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="numTelPortable">Téléphone Portable</label></td>
                                    <td id="numTelPortable" class="data">
                                        <input type="text" id="numTelPortable" name="numTelPortable" class="form-control">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box informations -->
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
                </div>
                <!-- Civilite -->
                <div class="col-md-8 col-xs-12">
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
                                    <td>
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
                                    <td>
                                        <input type="text" class="form-control" id="nationalite" name="nationalite">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="paysNaissance">Pays de Naissance</label></td>
                                    <td>
                                        <input type="text" class="form-control" id="paysNaissance" name="paysNaissance">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="departementNaissance">Département de Naissance</label></td>
                                    <td>
                                        <input type="text" class="form-control" id="departementNaissance" name="departementNaissance">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="VilleDeNaissance">VilleDeNaissance</label></td>
                                    <td>
                                        <input type="text" class="form-control" id="VilleDeNaissance" name="VilleDeNaissance">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box civilite -->
                </div>
                <!-- Endettement -->
                <div class="col-md-4 col-xs-12">
                    <!-- box Endettement -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Endettement : <span id="txEndettement"></span></h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <canvas id="pieChart" style="height: 138px; width: 340px;"></canvas>
                            <div id="legendDiv"></div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box Endettement -->
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
                                    <td><label for="secteurActivite">secteur d'activite</label></td>
                                    <td>
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
                                    <td>
                                        <input type="text" class="form-control" id="profession" name="profession">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="professionDepuis">professionDepuis</label></td>
                                    <td>
                                        <input type="text" class="form-control" id="professionDepuis" name="professionDepuis" value="{{ $tempProspect->votre_profession }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="revenusNetMensuel">revenusNetMensuel</label></td>
                                    <td>
                                        <input type="text" class="form-control" id="revenusNetMensuel" name="revenusNetMensuel" value="{{ $tempProspect->votre_salaire }}">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box revenus -->
                </div>
                <!-- Charges -->
                <div class="col-md-4 col-xs-12">
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
                                        <input type="text" class="form-control" id="loyer" name="loyer" value="{{ $tempProspect->montant_de_votre_loyer }}">
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
                <!-- Revenus Conjoint-->
                <div class="col-md-8 col-xs-12">
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
                                    <td>
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
                                    <td>
                                        <input type="text" class="form-control" id="professionConjoint" name="professionConjoint">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="professionDepuisConjoint">profession Depuis Conjoint</label></td>
                                    <td>
                                        <input type="text" class="form-control" id="professionDepuisConjoint" name="professionDepuisConjoint" value="{{ $tempProspect->profession_du_conjoint }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="revenusNetMensuelConjoint">revenus net mensuel conjoint</label></td>
                                    <td>
                                        <input type="text" class="form-control" id="revenusNetMensuelConjoint" name="revenusNetMensuelConjoint" value="{{ $tempProspect->salaire_conjoint }}">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box revenus conjoint -->
                </div>
                <!-- Habitation -->
                <div class="col-md-8 col-xs-12">
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
                                    <td>
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
                                    <td>
                                        <input type="text" class="form-control" id="habiteDepuis" name="habiteDepuis" value="{{ $tempProspect->lgmt_depuis_mois }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="adresse">adresse</label></td>
                                    <td>
                                        <input type="text" class="form-control" id="adresse" name="adresse" value="{{ $tempProspect->adresse }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="complementAdresse">complement adresse</label></td>
                                    <td>
                                        <input type="text" class="form-control" id="complementAdresse" name="complementAdresse" value="{{ $tempProspect->adresse_2 }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="codePostal">code postal</label></td>
                                    <td>
                                        <input type="text" class="form-control" id="codePostal" name="codePostal" value="{{ $tempProspect->code_postal }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="ville">ville</label></td>
                                    <td>
                                        <input type="text" class="form-control" id="ville" name="ville" value="{{ $tempProspect->ville }}">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box habitation -->
                </div>
                <!-- Supression -->
                <div class="col-md-12 col-xs-12">
                    <form class='delete' action="{{ route('prospect.destroy', ['prospect' => $user->id]) }}" method="post">
                        {{ csrf_field() }}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger">
                            <i class="fa fa-trash-o" aria-hidden="true"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection