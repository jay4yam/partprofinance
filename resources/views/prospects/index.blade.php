@extends('layouts.app', ['title' => 'liste des prospects', 'activeDashboard' => 'active'])

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Prospects
            <small>liste des prospects</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url()->route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Prospect</a></li>
            <li class="active">liste</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Liste des prospect</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table id="listeprospect" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Date</th>
                        <th>Civ Nom Prénom</th>
                        <th>Téléphone / Email</th>
                        <th>Iban</th>
                        <th>Dossier</th>
                        <th>Edition</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($prospects as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                {{ $user->prospect->civilite }}
                                {{ $user->prospect->nom }}
                                {{ $user->prospect->prenom }}
                            </td>
                            <td>
                                {{ $user->prospect->numTelPortable }} /
                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            </td>
                            <td style="text-align: center">
                                {!! $user->prospect->iban ? '<small class="label bg-green">Oui</small>' : '<small class="label bg-red">Non</small>' !!}
                            </td>
                            <td>Dossier</td>
                            <td>
                                <a href="{{ url()->route('prospect.show', ['prospect' => $user]) }}">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>Date</th>
                        <th>Civ Nom Prénom</th>
                        <th>Téléphone / Email</th>
                        <th>Iban</th>
                        <th>Dossier</th>
                        <th>Edition</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
                {{ $prospects->links() }}
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection

@section('js')
    <!-- DataTables -->
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

    <!-- page script -->
    <script>
        $(function () {
            $('#listeprospect').DataTable({
                'paging'      : false,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : true
            });
        })
    </script>
@endsection