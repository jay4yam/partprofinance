@extends('layouts.app', ['title' => 'Dossier a envoye par mail', 'activeDashboard' => 'active'])

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dossiers
            <small>Envois d'email de création de dossier : <b>{{ $dossier->prospect->nom }}</b> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url()->route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">dossier</a></li>
            <li class="active">edition</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
        {{ Form::open(['route' => 'post.mail', 'method' => 'POST', 'class' => 'form', 'files' => 'true'] ) }}
        {{ Form::hidden('user_id', $dossier->prospect->id, ['id' => 'prospect_id']) }}
        <!-- Col. gauche -->
            <div class="col-md-12">
                <!-- Edition Dossier -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Envois dossier par mail</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            {{ Form::label('subject', 'Sujet :') }}
                            {{ Form::text('subject', 'Nouveau dossier ppf: '.$dossier->banque->nom.', capital :'. $dossier->montant_demande.' €, '.$dossier->objet_du_pret, ['class' => 'form-control']) }}
                        </div>
                        <!-- Infos prospect (non editable) -->
                        <div class="form-group">
                            {{ Form::label('message', 'Email :') }}
                            <textarea class="form-control" id="message" name="message" title="message">
                                <table>
                                <tr>
                                    <td>Nom :</td>
                                    <td>
                                        <b>{{ $dossier->prospect->nom }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prenom :</td>
                                    <td>
                                        <b>{{ $dossier->prospect->prenom }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Téléphone :
                                    </td>
                                    <td>
                                        <b>{{ $dossier->prospect->numTelPortable }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email Client : </td>
                                    <td>
                                        <b>{{ $dossier->prospect->email }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Iban Client : </td>
                                    <td>
                                        <b>{{ $dossier->prospect->iban }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Signature Electronique : </td>
                                    <td>
                                        <b>{{ $dossier->prospect->mandat_status ? 'oui' : 'non' }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Numéro de dossier : </td>
                                    <td>
                                        <b>{{ $dossier->num_dossier_banque }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date de Naissance : </td>
                                    <td>
                                        <b>{{ $dossier->prospect->dateDeNaissance->format('d M Y') }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Ville & Département : </td>
                                    <td>
                                       <b>{{ $dossier->prospect->codePostal }} - {{ $dossier->prospect->ville }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Commission TTC : </td>
                                    <td>
                                        <b>{{ $dossier->montant_commission_partpro }} €</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Commission HT : </td>
                                    <td>
                                        <b>{{ $dossier->montant_commission_partpro / 1.2 }} €</b>
                                    </td>
                                </tr>
                                </table>
                            </textarea>
                        </div>
                        <!-- ./Infos prospect (non editable) -->

                        <div class="form-group">
                            {{ Form::label('file', 'Pièce Jointe :') }}
                            {{ Form::file('file', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-center">
                    </div>
                    <!-- /.box-footer-->
                </div>
                <!-- /.Edition Dossier -->
            </div>
            <!-- ./ Col. gauche -->

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-lg btn-success"><i class="fa fa-envelope"></i> Envoyer l'email</button>
            </div>
            {{ Form::close() }}
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('js')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function () {
            CKEDITOR.replace('message');
        });
    </script>
@endsection