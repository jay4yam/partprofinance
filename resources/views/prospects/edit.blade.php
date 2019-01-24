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
                <!-- Tasks -->
                <div class="col-xs-8">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Tâches & Rendez-vous</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            {{ Form::open([ 'route' => ['task.store'], 'method' => 'POST', 'class' => 'form-group']) }}
                                {{ Form::hidden('user_id', Auth::user()->id) }}
                                {{ Form::hidden('prospect_id', $prospect->id) }}
                                <div class="col-xs-3">
                                    {{ Form::label('taskdate', 'Programmez une date.') }}
                                    {{ Form::date('taskdate', Carbon\Carbon::now(), ['class' => 'form-control', 'id' => 'taskdate']) }}
                                </div>
                                <div class="col-xs-5">
                                    {{ Form::label('taskcontent', 'Description.') }}
                                    {{ Form::textarea('taskcontent', null, ['class' => 'form-control', 'id' => 'taskcontent']) }}
                                </div>
                                <div class="col-xs-2">
                                    {{ Form::label('level', 'Importance.') }}
                                    {{ Form::select('level', ['very high'=>'very high', 'high'=>'high', 'normal'=>'normal', 'low'=>'low'], null,['class' => 'form-control', 'id' => 'level']) }}
                                </div>
                                <div class="col-xs-2">
                                    {{ Form::label('tasksubmit', 'Sauv.') }}
                                    <button type="submit" class="btn btn-warning" id="tasksubmit">
                                        <i class="fa fa-calendar-plus-o" aria-hidden="true"></i> Save
                                    </button>
                                </div>
                            {{ Form::close() }}
                            <div class="col-md-12 margin-top30">
                                <ul class="todo-list">
                                    @if($prospect->has('tasks'))
                                        @foreach($prospect->tasks as $task)
                                            <li class="{{ $task->status == 0 ? 'done' : '' }}">
                                                <!-- drag handle -->
                                                <span class="handle">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </span>
                                                <!-- checkbox -->
                                                <input type="checkbox" value="{{ $task->status }}" class="taskdone" data-taskid="{{ $task->id }}" title="done" {{ $task->status == 0 ? 'checked' :'' }}>
                                                <!-- todo text -->
                                                <span class="text text-task" id="task-{{ $task->id }}">
                                                    {{ $task->taskcontent }} | <a href="{{ route('prospect.show', ['id' => $task->taskable->id]) }}">{{ $task->taskable->nom }}</a>
                                                </span>
                                                <!-- Emphasis label -->
                                                <small class="label level-{{ $task->level ? str_slug($task->level) : 'default' }} pull-right"><i class="fa fa-clock-o"></i> {{ @$task->taskdate->format('d M Y') }}</small>
                                                <!-- General tools such as edit or delete-->
                                                <div class="tools">
                                                    <i class="fa fa-edit edit-task" data-task-id="{{ $task->id }}"></i>
                                                    {{ Form::open(['route' => ['task.destroy', $task], 'method' => 'DELETE', 'class' => 'delete pull-right']) }}
                                                        <i class="fa fa-trash-o delete-task"></i>
                                                    {{ Form::close() }}
                                                </div>
                                            </li>
                                        @endforeach
                                   @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mandat -->
                <div class="col-xs-4">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Mandat</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                {{ Form::open([ 'route' => ['task.store'], 'method' => 'POST']) }}
                                {{ Form::hidden('prospect_id', $prospect->id) }}
                                    <label for="mandat_status">Etat du mandat:</label>
                                    <span class="button-checkbox">
                                        <button type="button" class="btn form-control {{ $prospect->mandat_status==1 ? 'btn-success active' : 'btn-default' }}" id="mandat_status" name="mandat_status" data-color="success">Mandat signé</button>
                                        <input type="checkbox" class="form-control hidden" />
                                    </span>
                                {{ Form::close() }}
                                </div>
                                <div class="col-md-12">
                                    <label for="mandat_status">Liste des dossiers:</label>
                                    <ul class="dossier-liste">
                                    @foreach($prospect->dossiers as $dossier)
                                        <li>{{ $dossier->montant_demande }} € | {{ $dossier->montant_final }} €
                                            <a class="pull-right" href="{{ route('mandat.edition', ['prospectId' => $prospect->id, 'dossierId' => $dossier->id]) }}">
                                                <button class="btn btn-warning btn-sm">Générer le mandat</button>
                                            </a>
                                            @if( is_dir( storage_path( 'app/public/mandat/'.strtolower($prospect->nom).'/'.$dossier->id ) ) )
                                                <a href="{{ asset('/storage/mandat/') }}/{{ strtolower($prospect->nom) }}/{{ $dossier->id }}/mandat-{{ str_slug($prospect->nom)}}.pdf" target="_blank">
                                                    <i class="fa fa-file"></i>
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                    <td>Source</td>
                                    <td id="prospect_source" class="data">
                                        <b class="value">{{ $prospect->prospect_source }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Civilite</td>
                                    <td id="civilite" class="data">
                                        <b class="value">{{ $prospect->civilite }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nom</td>
                                    <td id="nom" class="data">
                                        <b class="value">{{ $prospect->nom }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nom Jeune fille</td>
                                    <td id="nomjeunefille" class="data">
                                        <b class="value">{{ $prospect->nomjeunefille }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prénom</td>
                                    <td id="prenom" class="data">
                                        <b class="value">{{ $prospect->prenom }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td id="email" class="data">
                                        <b class="value">{{ $prospect->email }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Téléphone Fixe</td>
                                    <td id="numTelFixe" class="data">
                                        <b class="value">{{ $prospect->numTelFixe }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Téléphone Portable</td>
                                    <td id="numTelPortable" class="data">
                                        <b class="value">{{ $prospect->numTelPortable }}</b>
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
                                        <b class="value">{{ @$prospect->dateDeNaissance->format('d/m/Y') }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Situation Familiale</td>
                                    <td id="situationFamiliale" class="data">
                                        <b class="value">{{ $prospect->situationFamiliale }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nb Enfants à charge</td>
                                    <td id="nbEnfantACharge" class="data">
                                        <b class="value">{{ $prospect->nbEnfantACharge }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nationalite</td>
                                    <td id="nationalite" class="data">
                                        <b class="value">{{ $prospect->nationalite }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pays de Naissance</td>
                                    <td id="paysNaissance" class="data">
                                        <b class="value">{{ $prospect->paysNaissance }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Département Naissance</td>
                                    <td id="departementNaissance" class="data">
                                        <b class="value">{{ $prospect->departementNaissance }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ville De Naissance</td>
                                    <td id="VilleDeNaissance" class="data">
                                        <b class="value">{{ $prospect->VilleDeNaissance }}</b>
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
                                        <b class="value">{{ $prospect->secteurActivite }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Profession</td>
                                    <td id="profession" class="data">
                                        <b class="value">{{ $prospect->profession }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Depuis</td>
                                    <td id="professionDepuis" class="data">
                                        <b class="value">{{ @$prospect->professionDepuis->format('d/m/Y') }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Revenus Net Mensuel</td>
                                    <td id="revenusNetMensuel" class="data">
                                        <b class="value">{{ $prospect->revenusNetMensuel }}</b><b>€</b>
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
                                        <b class="value">{{ @$prospect->secteurActiviteConjoint }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Profession conjoint</td>
                                    <td id="professionConjoint" class="data">
                                        <b class="value">{{ @$prospect->professionConjoint }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Depuis conjoint</td>
                                    <td id="professionDepuisConjoint" class="data">
                                        <b class="value">{{ @$prospect->professionDepuisConjoint ? $prospect->professionDepuisConjoint->format('d/m/Y') : '10-10-1900' }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Revenus Net Mensuel conjoint</td>
                                    <td id="revenusNetMensuelConjoint" class="data">
                                        <b class="value">{{ $prospect->revenusNetMensuelConjoint }}</b><b> €</b>
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
                                        <b class="value">{{ $prospect->habitation }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Habite Depuis</td>
                                    <td id="habiteDepuis" class="data">
                                        <b class="value">{{ @$prospect->habiteDepuis->format('d/m/Y') }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Adresse</td>
                                    <td id="adresse" class="data">
                                        <b class="value">{{ $prospect->adresse }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Complément adresse</td>
                                    <td id="complementAdresse" class="data">
                                        <b class="value">{{ $prospect->complementAdresse }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Code postal</td>
                                    <td id="codePostal" class="data">
                                        <b class="value">{{ $prospect->codePostal }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ville</td>
                                    <td id="ville" class="data">
                                        <b class="value">{{ $prospect->ville }}</b>
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
                                    <textarea title="oldnotes" name="value" id="oldnotes" class="form-control">{{ $prospect->notes }}</textarea>
                                    <textarea title="notes" name="value" id="notes" class="form-control"></textarea>
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
                    @include('endettement._prospectgraph')
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
                                        <b class="value">{{ $prospect->loyer }}</b><b> €</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pension Alimentaire</td>
                                    <td id="pensionAlimentaire" class="data">
                                        <b class="value">{{ $prospect->pensionAlimentaire }}</b><b> €</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php $index = 0; ?>
                                @if( $prospect->credits != '' || $prospect->credits  != null)
                                    @foreach(json_decode($prospect->credits, true) as $credit => $montant)
                                        <tr>
                                            <td>{{ @$credit }}</td>
                                            <td id="credit-{{ $index }}" data-index="{{ $index }}" class="data">
                                                <b class="value">{{ @$montant }}</b><b> €</b>
                                                <a href="#" id="{{ @$index }}" class="deleteCredit pull-right btn-xs btn-danger">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </a>
                                                <a href="#" class="updateData pull-right btn-xs btn-success" style="margin-right: 10px;">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $index++; ?>
                                    @endforeach
                                @endif
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

                    <!-- box banque -->
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
                                    <td>Banque</td>
                                    <td id="NomBanque" class="data">
                                        <b class="value">{{ $prospect->NomBanque }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Depuis le</td>
                                    <td id="BanqueDepuis" class="data">
                                        <b class="value">{{ @$prospect->BanqueDepuis->format('d/m/Y') }}</b>
                                        <a href="#" class="updateData pull-right btn-xs btn-success">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box banque -->
                </div>
            </div>
            <div class="row">
                <div class="text-center">
                    <form class='delete' action="{{ route('prospect.destroy', ['prospect' => $prospect->id]) }}" method="post">
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
    <script src="{{ asset('bower_components/jquery-mask/jquery.mask.js') }}" type="application/javascript"></script>
    <script src="{{ asset('js/editProspect.js') }}"></script>
    <script src="{{ asset('js/task.js') }}"></script>
    <script>
        $(document).ready(function () {
            editProspect.showEditButton();
            editProspect.clickOnEditButton();
            editProspect.ajaxUpdateNotes();
            editProspect.ajaxUpdateMandatStatus();
            editProspect.addCredit();
            editProspect.deleteCredit();
            task.updateTask();
            task.updateTaskDoneOrNot();
        });

        $(".delete").on("submit", function(){
            return confirm("La suppression est definitive, êtes vous sure ?");
        });

        $('.delete-task').on('click', function () {
            $(this).parents('form').submit();
        });
    </script>
@endsection