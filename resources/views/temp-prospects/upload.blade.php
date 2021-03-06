@extends('layouts.app', ['title' => 'Import de prospects', 'activeProspect' => 'active'])

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Import
            <small>Importer vos leads</small>
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
            </div>
        </div>
    </section>

@endsection