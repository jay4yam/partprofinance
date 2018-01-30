@extends('layouts.app', ['title' => 'Gestion des banques', 'activeBanque' => 'active'])

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

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

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Liste des banques</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table id="listebanque" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th style="width: 50%">Nom</th>
                        <th>Logo</th>
                        <th style="width: 15%">Edition</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($banques as $banque)
                        <tr>
                            <td>{{ $banque->id }}</td>
                            <td>{{ $banque->nom }}</td>
                            <td><img src="{{ asset('storage/img').'/'. $banque->logo}}" height="50"></td>
                            <td>
                                <a href="{{ url()->route('banques.edit', ['banque' => $banque]) }}" class="btn btn-default pull-left">
                                    <i class="fa fa-pencil" aria-hidden="true"></i> Editer
                                </a>
                                <form class='delete' action="{{ route('banques.destroy', ['banque' => $banque->id]) }}" method="post">
                                    {{ csrf_field() }}
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button class="btn btn-danger pull-right">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>Nom</th>
                        <th>Logo</th>
                        <th>Edition</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
                {{ $banques->links() }}
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

        <!-- Insertion de banque -->
            <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Insérer une banque</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        {{ Form::open([ 'route' => 'banques.store', 'method' => 'post', 'files' => true]) }}

                        <div class="form-group">
                            {{ Form::label('nom', 'Nom de la banque / Organisme préteur') }}
                            {{ Form::text('nom', null,['class' => 'form-control']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('logo', 'Insérer le logo') }}
                            {{ Form::file('logo', ['class' => 'form-control-file']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::submit('Sauvegarder', ['class' => 'btn btn-success']) }}
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

@section('js')
    <script>
        $(".delete").on("submit", function(){
        return confirm("La suppression est definitive, êtes vous sure ?");
        });
    </script>
@endsection