@extends('layouts.app', ['title' => 'Liste de leads', 'activeProspect' => 'active'])

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Leads
            <small>Liste des leads importés</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url()->route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Prospect</a></li>
            <li class="active">liste des leads importés</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
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
                            <table class="table table-bordered table-hover" id="tempprospect">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Ajouté le</th>
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
                                        <td>
                                            {{ $prospect->created_at->format('d M Y') }}<br>
                                            via {{ $prospect->prospect_source }}
                                        </td>
                                        <td>
                                            <b>{{ ucfirst( strtolower($prospect->nom) ) }}</b>
                                            <div class="notes">{!!  $prospect->notes  !!}</div>
                                        </td>
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
                                            {{ Form::open(['route' => ['temp_prospect.destroy', $prospect], 'method' => 'DELETE', 'class' => 'delete']) }}
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
    <!-- DataTables -->
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

    <script type="text/javascript">

        $(function () {
            $('#tempprospect').DataTable({
                'paging'      : false,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : true,
                'order'       : [[0, 'desc']],
                'info'        : true,
                'autoWidth'   : true
            });
        });

        $(function () {
            $('select[name="relancestatus"]').on('change', function (e) {
                e.preventDefault();

                var processId = $(this).data('processid');
                var selectValue = $(this).val();

                $.ajax({
                    method: "PUT",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

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

        $(".delete").on("submit", function(){
            return confirm("La suppression est definitive, êtes vous sure ?");
        });
    </script>
@endsection