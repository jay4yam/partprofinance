@extends('layouts.app', ['title' => 'Création d\'un coompte commercial', 'activeCommerciaux' => 'active'])

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Creation de compte utilisateur
            <small>Ajouter un nouvel utilisateur</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url()->route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Commerciaux</a></li>
            <li class="active">Ajout nouvel utilisateur</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            {{ Form::open(['route' =>'user.store', 'method' => 'POST', 'files' => 'true']) }}
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
                                    <td><label for="role">Role </label></td>
                                    <td class="data">
                                        {{ Form::select('role', ['admin'=>'Super admin', 'staff'=>'Commercial'], '', ['placeholder' => 'choisissez un role', 'class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nom">Nom </label></td>
                                    <td class="data">
                                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="email">Email</label></td>
                                    <td class="data">
                                        {{ Form::email('email', null, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="confirmationEmail">Confirmation Email</label></td>
                                    <td class="data">
                                        {{ Form::email('confirmationEmail', null, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nom">Mot de passe</label></td>
                                    <td class="data {{ $errors->has('password') ? ' has-error' : '' }}">
                                        {{ Form::password('password' , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nom">Mot de passe</label></td>
                                    <td class="data {{ $errors->has('passwordConfirmation') ? ' has-error' : '' }}">
                                        {{ Form::password('passwordConfirmation' , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="taux_commission">Taux de commission</label></td>
                                    <td class="data {{ $errors->has('taux_commission') ? ' has-error' : '' }}">
                                        {{ Form::text('taux_commission', null , ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box informations -->
                </div>

                <!-- col droite -->
                <div class="col-md-4 col-xs-12">
                    <!-- box notes -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Avatar</h3>
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
                                {{ Form::file('avatar', null , ['class' => 'form-control', 'id' => 'nom']) }}
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box notes -->
                    <!-- bouton submit -->
                    <div class="text-center col-md-12">
                        <button class="btn btn-lg btn-success">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Enregistrer
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

@endsection