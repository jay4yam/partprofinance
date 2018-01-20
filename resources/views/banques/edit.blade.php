@extends('layouts.app', ['title' => 'Edition d\'une des banques', 'activeBanque' => 'active'])

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Banques
            <small>liste des banques</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url()->route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">banques</a></li>
            <li class="active">liste</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- /.box Modifier une banque -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Modifier une banque</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                {{ Form::open([ 'route' => ['banques.update', $banque], 'method' => 'PATCH', 'files' => true]) }}

                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('nom', 'Nom de la banque / Organisme préteur') }}
                        {{ Form::text('nom', @$banque->nom, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('logo', 'Insérer le logo') }}
                        {{ Form::file('logo', ['class' => 'form-control-file']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <img src="{{ asset('storage/img').'/'. $banque->logo}}" width="100">
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::submit('Mettre à jour', ['class' => 'btn btn-warning']) }}
                </div>
                {{ Form::close() }}
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection