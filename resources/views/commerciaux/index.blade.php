@extends('layouts.app', ['title' => 'Liste des utilisateurs', 'activeCommerciaux' => 'active'])

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Commerciaux & utilisateurs
            <small>Gérer les utilisateurs</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url()->route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">commerciaux</a></li>
            <li class="active">liste</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Liste des Utilisateurs</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table id="listeusers" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Nom</th>
                        <th>Mail</th>
                        <th>Mot de passe</th>
                        <th>Role</th>
                        <th>Tx. Commissions</th>
                        <th>Avatar</th>
                        <th style="width: 15%">Edition</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>*******</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->commission_rate }}</td>
                            <td><img src="{{ asset('storage/avatar').'/'. $user->avatar}}" height="50"></td>
                            <td>
                                <a href="{{ url()->route('user.edit', ['user' => $user]) }}" class="btn btn-default pull-left">
                                    <i class="fa fa-pencil" aria-hidden="true"></i> Editer
                                </a>
                                <form class='delete' action="{{ route('user.destroy', ['banque' => $user->id]) }}" method="post">
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
                {{ $users->links() }}
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

    <script>
        $(function () {
            $('#listeusers').DataTable({
                'paging'      : false,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : true,
                'order'       : [[0, 'desc']],
                'info'        : true,
                'autoWidth'   : true
            });
        });

        $(".delete").on("submit", function(){
            return confirm("La suppression est definitive, êtes vous sure ?");
        });
    </script>
@endsection