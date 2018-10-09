@extends('layouts.app', ['title' => 'Gestion des dossiers', 'activeDossier' => 'active'])

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dossiers
            <small>liste des dossiers</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url()->route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">dossier</a></li>
            <li class="active">liste</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Liste des dossiers</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table id="listedossier" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>date</th>
                        <th>clients</th>
                        <th>status</th>
                        <th>banque</th>
                        <th>montant demande</th>
                        <th>montant final</th>
                        <th>commission</th>
                        <th>Iban</th>
                        <th style="width: 15%">Edition</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dossiers as $dossier)
                        <tr>
                            <td>{{ $dossier->id }}</td>
                            <td>{{ $dossier->created_at->format('d M y') }}</td>
                            <td>{{ $dossier->prospect->nom }}</td>
                            <td class="{{ str_slug($dossier->status) }}">{{ $dossier->status }}</td>
                            <td><img src="{{ asset('storage/img').'/'. $dossier->banque->logo}}" height="30"></td>
                            <td>{{ number_format($dossier->montant_demande, 2, ',', ' ')  }} €</td>
                            <td>{{ number_format($dossier->montant_final, 2, ',', ' ') }} €</td>
                            <td>{{ $dossier->montant_commission_partpro ? number_format($dossier->montant_commission_partpro, 2, ',', ' ') :  number_format($dossier->montant_final * $dossier->taux_commission /100, 2, ',', ' ') }} €</td>
                            <td>
                                {!! $dossier->prospect->iban ? '<small class="label bg-green">Oui</small>' : '<small class="label bg-red">Non</small>' !!}
                            </td>
                            <td>
                                <a href="{{ url()->route('dossiers.edit', ['dossier' => $dossier]) }}" class="btn btn-default pull-left">
                                    <i class="fa fa-pencil" aria-hidden="true"></i> Editer
                                </a>
                                <form class='delete' action="{{ route('dossiers.destroy', ['dossier' => $dossier->id]) }}" method="post">
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
                    <tr>
                        <th>id</th>
                        <th>date</th>
                        <th>clients</th>
                        <th>status</th>
                        <th>banque</th>
                        <th>montant demande</th>
                        <th>montant final</th>
                        <th>commission</th>
                        <th>Iban</th>
                        <th style="width: 15%">Edition</th>
                    </tr>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
                {{ $dossiers->links() }}
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