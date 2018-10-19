@extends('layouts.app', ['title' => '1ere Relance du prospect', 'activeDashboard' => 'active'])

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
                <!-- Formulaire de relance de prospect -->
                <div class="col-md-12 col-xs-12">
                    <!-- box informations -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Formulaire de 1ere Relance </h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        {{ phpinfo() }}
                        <div class="box-body">
                            {{ Form::open([ 'route' => 'process.send.relance.une', 'method' => 'POST']) }}
                            {{ Form::hidden('temp_prospect_id', $prospect->id) }}
                            <div class="form-group">
                                {{ Form::label('Envois du mail') }}
                                {{ Form::textarea('mailcontent', $mailContent, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('Envois du SMS') }}
                                {{ Form::textarea('smscontent', $smsContent, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class=" btn btn-success">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    Envoyer la 1ere relance
                                </button>
                            </div>
                            {{ Form::close() }}
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box informations -->
                </div>
            </div>
        </div>
    </section>

    @endsection