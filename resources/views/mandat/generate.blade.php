@extends('layouts.app', ['title' => 'Editer un mandat'])

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Mandat
            <small>Edition le mandat pour le prospect <b>{{ $prospect->nom }} {{ $prospect->prenom }}</b></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url()->route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Mandat</a></li>
            <li class="active">edition</li>
        </ol>
    </section>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    @include('mandat._view', $prospect)
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <a href="{{ route('mandat.generate', ['prospectId' => $prospect->id, 'dossierId' => $zeDossier->id]) }}">
                            <button class="btn btn-success margin-top30">
                                <i class="fa fa-file" aria-hidden="true"></i>  Générer le mandat
                            </button>
                        </a>

                        <a href="{{ route('prospect.show', ['prospect' => $prospect->id]) }}">
                            <button class="btn btn-default margin-top30">
                                <i class="icon-arrow-left" aria-hidden="true"></i>  Retour à la fiche prospect
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection