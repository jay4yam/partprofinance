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

        <!-- menu box -->
            @include('filters._prospect')
        <!-- /. menu box -->

        <!-- Table prospect box -->
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
                        <th style="width: 8%">Rappel</th>
                        <th style="width: 8%">Mandat</th>
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
                            <td>
                                @foreach($user->dossier as $dossier)
                                    <small class="label {{ str_slug($dossier->status) }}">
                                        <a href="#" class="showdossier" data-toggle="modal" data-dossierid="{{ $dossier->id }}" data-target="#modal-default">
                                        {{ number_format($dossier->montant_demande, 2, ',', ' ')  }} €
                                        </a>
                                    </small>
                                @endforeach
                            </td>
                            <td>
                                @if($user->tasks)
                                    @foreach($user->tasks as $task)
                                        <small class="label level-{{ $task->level ? str_slug($task->level) : 'default' }}" data-toggle="tooltip" data-placement="top" title="{{ $task->taskcontent }}">
                                            <i class="fa fa-clock-o"></i> {{ $task->taskdate->format('d M y') }}
                                        </small>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                {!! @$user->prospect->mandat_status ? '<small class="label bg-green">Oui</small>' : '<small class="label bg-red">Non</small>' !!}
                            </td>
                            <td>
                                <a href="{{ url()->route('prospect.show', ['prospect' => $user]) }}" class="btn btn-default">
                                    <i class="fa fa-pencil" aria-hidden="true"></i> Détails
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
                        <th>Rappel</th>
                        <th>Mandat</th>
                        <th>Edition</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
                {{ @$prospects->links() }}
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.Table prospect box -->

    </section>
    <!-- /.content -->

    <!-- /.modal dossier -->
    <div class="modal fade" id="modal-default" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 id="dossier-title"></h4>
                </div>
                <div class="modal-body">
                    <p id="dossier-content"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">fermer</button>
                    <a href="{{ url()->route('dossiers.edit', ['dossier' => $dossier]) }}" class="btn btn-info pull-right">
                        <i class="fa fa-pencil" aria-hidden="true"></i> Editer
                    </a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal dossier -->
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
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $(function () {
            $('.showdossier').on('click', function (e) {
                e.preventDefault();

                var dossierId = $(this).data("dossierid");

                $.ajax({
                    method: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'http://' + location.host + '/get/dossier/info',
                    data: {dossierId: dossierId},
                    beforeSend: function () {
                        $('.ajax-spinner').show();
                    },
                    success: function (allData) {
                        $('.ajax-spinner').hide();
                        var data = JSON.parse(allData);
                        //console.log(data);
                        var title = 'Dossier de '+data.user.name+'';
                        $('#dossier-title').html(title);

                        var table = '<table class="table table-bordered table-hover dataTable">';
                            table += '<tr><td>Status Dossier</td><td>'+ data.status +'</td></tr>';
                            table += '<tr><td>Signature</td><td>'+ data.signature +'</td></tr>';
                            table += '<tr><td>Num Dossier</td><td>'+ data.num_dossier_banque +'</td></tr>';
                            table += '<tr><td>Objet du prêt</td><td>'+ data.objet_du_pret +'</td></tr>';
                            table += '<tr><td>Montant Demandé</td><td>'+ data.montant_demande +'</td></tr>';
                            table += '<tr><td>Montant Final</td><td>'+ data.montant_final +'</td></tr>';
                            table += '<tr><td>Montant Commission Partpro</td><td>'+ data.montant_commission_partpro +'</td></tr>';

                        $('#dossier-content').html(table);
                    }
                });
            });
        });
    </script>
@endsection