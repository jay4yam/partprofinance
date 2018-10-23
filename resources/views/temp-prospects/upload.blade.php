@extends('layouts.app', ['title' => 'Import de prospects', 'activeDashboard' => 'active'])

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Prospects
            <small>Importer vos fiches prospect</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url()->route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Prospect</a></li>
            <li class="active">liste des imports</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Upload de fichier -->
                <div class="col-md-6 col-xs-12">
                    <!-- box informations -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Import de fichier .csv</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                                {{ Form::open([ 'route' => 'prospect.upload', 'method' => 'POST', 'files' => true]) }}
                                <div class="form-group">
                                    <label for="fournisseur">Import depuis</label>
                                    <select id="fournisseur" name="fournisseur" class="form-control">
                                        <option value="devisprox">DevisProx</option>
                                        <option value="assuragency">AssurAgency</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="csvfile">Importer votre fichier</label>
                                    <input class="form-control-file" type="file" name="csvfile" id="csvfile">
                                    {!! $errors->first('csvfile', '<small class="text-danger help-block">:message</small>') !!}
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class=" btn btn-success">
                                        <i class="fa fa-upload" aria-hidden="true"></i>
                                        Uploader votre fichier
                                    </button>
                                </div>
                            {{ Form::close() }}
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box informations -->
                </div>

                <!-- Affiche les fichiers uploader dans le dossier import-->
                <div class="col-md-6 col-xs-12">
                    <!-- box fichier à traiter -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Fichiers déjà importés</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Nom du fichier</th>
                                    <th>Traiter le fichier</th>
                                </tr>
                                </thead>
                                @foreach(File::allFiles( storage_path('app/public/csvimport') ) as $file)
                                    <tr>
                                        <td>
                                            {{ $file->getFilename() }}
                                        </td>
                                        <td>
                                            {{ Form::open(['route' => 'prospect.csv.import', 'method' => 'post', 'style' => 'float:left']) }}
                                                {{ Form::hidden('fileName', $file->getFilename() ) }}
                                                <button class="btn btn-warning">
                                                    <i class="fa fa-cog"></i> Importer
                                                </button>
                                            {{ Form::close() }}
                                            {{ Form::open(['route' => 'remove.file', 'method' => 'DELETE']) }}
                                                {{ Form::hidden('fileName', $file->getFilename() ) }}
                                                <button class="btn btn-danger pull-right">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </button>
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box box fichier à traiter -->
                </div>

                <!-- Affiche les prospects contenu dans l'un des fichiers .csv-->
                <div class="col-md-12">
                    <!-- box tableau des prospect présent dans un fichier -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Liste des prospects stockés temporairement</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Ajouté le</th>
                                    <th>Source</th>
                                    <th>Nom</th>
                                    <th>Tel Port</th>
                                    <th style="width: 10%">Email</th>
                                    <th>Status</th>
                                    <th>Relance</th>
                                    <th style="width: 10%">Actions</th>
                                </tr>
                                </thead>
                                @foreach($prospectsTemp as $prospect)
                                    <tr>
                                        <td>{{ $prospect->id }}</td>
                                        <td>{{ $prospect->created_at->format('d M Y') }}</td>
                                        <td>{{ $prospect->prospect_source }}</td>
                                        <td>{{ $prospect->nom }}</td>
                                        <td>{{ $prospect->tel_portable }}</td>
                                        <td>{{ $prospect->email }}</td>
                                        <td>
                                            {{ Form::open(['route' =>'process.update.status', 'method' => 'POST', 'class' => 'form-inline']) }}
                                                {{ Form::hidden('temp_prospect_id', $prospect->id) }}
                                                {{ Form::select('status', ['non traite' => 'non traite','nrp' => 'nrp', 'faux num'=> 'faux num', 'intérêt' => 'intérêt', 'sans suite' => 'sans suite'], @$prospect->processProspect->status , ['class'=> 'form-control']) }}
                                                <button type="submit" class="btn btn-warning"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                                            {{ Form::close() }}
                                        </td>
                                        <td>
                                            @if(@$prospect->processProspect->relance_status)
                                                <div class="progress progress-sm active">
                                                    @php
                                                        switch(@$prospect->processProspect->relance_status)
                                                        {
                                                            case 'relance_1':
                                                                $value = 33;
                                                                $class = 'progress-bar-success';
                                                                break;
                                                            case 'relance_2':
                                                                $value= 66;
                                                                $class = 'progress-bar-warning';
                                                                break;
                                                            case 'relance_3':
                                                                $value=100;
                                                                $class = 'progress-bar-danger';
                                                                break;
                                                        }
                                                    @endphp
                                                    <div id="progress-{{$prospect->processProspect->id}}" class="progress-bar {{ $class }} progress-bar-striped" role="progressbar" aria-valuenow="{{ $value }}" aria-valuemin="0" aria-valuemax="100" style="width: {{$value}}%">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            <br>
                                                <div class="form-group">
                                                    {{ Form::select('relancestatus',
                                                    ['relance_1' => 'relance 1', 'relance_2' => 'relance 2', 'relance_3' => 'relance 3'],
                                                    @$prospect->processProspect->relance_status, ['class' => 'form-control', 'data-processid' => $prospect->processProspect->id] ) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            {{ Form::open(['route' => ['delete.temp.prospect', $prospect], 'method' => 'DELETE']) }}
                                            <button class="btn btn-danger pull-right">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                            {{ Form::close() }}
                                            <a href="{{ url()->route('temp_prospect.edit', ['id' => $prospect->id]) }}">
                                                <button class="btn btn-default pull-right mr5">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </button>
                                            </a>
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {{ $prospectsTemp->links() }}
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box tableau des prospect présent dans un fichier -->
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')
    <script type="text/javascript">
        $(function () {
            $('select[name="relancestatus"]').on('change', function (e) {
                e.preventDefault();

                var processId = $(this).data('processid');
                var selectValue = $(this).val();

                $.ajax({
                    method: "PUT",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'http://' + location.host + '/process/update/' + processId,
                    data: {type: 'relance_status', value: selectValue},
                    beforeSend: function () {
                        $('.ajax-spinner').show();
                    },
                    success: function () {
                        var value = '';
                        var classs = '';
                        $('.ajax-spinner').hide();
                        switch (selectValue){
                            case 'relance_1':
                                value = 33;
                                classs = 'progress-bar-success';
                                break;
                            case 'relance_2':
                                value = 66;
                                classs = 'progress-bar-warning';
                                break;
                            case 'relance_3':
                                value = 100;
                                classs = 'progress-bar-danger';
                                break;
                        }
                        var progress = $('#progress-'+processId);
                        progress.attr('aria-valuenow', value);
                        progress.width(value+'%').removeClass().addClass('progress-bar '+ classs +' progress-bar-striped');
                    }
                });
            });
        });
    </script>
@endsection