@extends('layouts.app', ['title' => 'Edition de prospects', 'activeDashboard' => 'active'])

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
        <div class="container-fluid">
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
                                    <td>Date de Naissance</td>
                                    <td id="dateDeNaissance" class="data">
                                        <b class="value">{{ $user->prospect->dateDeNaissance }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Situation Familiale</td>
                                    <td id="situationFamiliale" class="data">
                                        <b class="value">{{ $user->prospect->situationFamiliale }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
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
                                        <b class="value">{{ $user->prospect->revenusNetMensuelConjoint }}</b><b> €</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
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
                                        <b class="value">{{ $user->prospect->ville }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
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

                    <!-- box Endettement -->
                    @include('endettement._graph')
                    <!-- /.box Endettement -->

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
                                    <td>Loyer</td>
                                    <td id="loyer" class="data">
                                        <b class="value">{{ $user->prospect->loyer }}</b><b> €</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pension Alimentaire</td>
                                    <td id="pensionAlimentaire" class="data">
                                        <b class="value">{{ $user->prospect->pensionAlimentaire }}</b><b> €</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php $index = 0; ?>
                                @foreach(json_decode($user->prospect->credits, true) as $credit => $montant)
                                    <tr>
                                        <td>{{ $credit }}</td>
                                        <td id="credits" class="data">
                                            <b class="value">{{ $montant }}</b><b> €</b>
                                            <a href="#" id="{{ $index }}" class="deleteCredit pull-right btn-xs btn-danger">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                            <a href="#" class="updateData pull-right btn-xs btn-success" style="margin-right: 10px;">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $index++; ?>
                                @endforeach
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
    <!-- /.content -->
@endsection

@section('js')
    <script src="{{ asset('js/editProspect.js') }}"></script>
    <script>
        $(document).ready(function () {
            editProspect.showEditButton();
            editProspect.clickOnEditButton();
            editProspect.ajaxUpdateNotes();
            editProspect.addCredit();
            editProspect.deleteCredit();
        });

        $(".delete").on("submit", function(){
            return confirm("La suppression est definitive, êtes vous sure ?");
        });
    </script>
    <!-- ChartJS -->
    <script src="{{ asset('bower_components/chart.js/Chart.js') }}"></script>
    <!-- endettement -->
    <script src="{{ asset('js/endettement.js') }}"></script>
    <script>
        //récupération de la sommes des charges
        var charges = <?php echo $user->prospect->loyer; ?>;
        charges += <?php $valeur2=0; foreach(json_decode($user->prospect->credits, true) as $valeur){ $valeur2+= $valeur;} echo $valeur2 ?>;
        charges += <?php echo $user->prospect->pensionAlimentaire ? $user->prospect->pensionAlimentaire : 0 ; ?>;

        //récupération de la sommes des revenus
        var revenus = <?php echo $user->prospect->revenusNetMensuel; ?>;
        revenus += <?php echo $user->prospect->revenusNetMensuelConjoint ? $user->prospect->revenusNetMensuelConjoint:0 ; ?>;

        //Fonction arrondir le taux d'endettement
        function precisionRound(number, precision) {
            var factor = Math.pow(10, precision);
            return Math.round(number * factor) / factor;
        }
        //Affiche le taux d'endettement
        $('#txEndettement').html('<b>'+ precisionRound( (charges / revenus)*100, 2)+'</b> %');

        $(document).ready(function () {
            endettement.graphEndettement(charges, revenus);
        });
    </script>


@endsection