@php
    //Appel de la class StatistiqueHomeForSales
    $stats = new \App\Helpers\StatistiqueHomeForSales();
@endphp
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{{ ucfirst($name) }}</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
        </div>
        <div class="box-body">
            <div class="row">
                <!-- num de Prospect -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $stats->getProspectSaleThisMonth($id) }}</h3>

                            <p>Prospects ce mois ci</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion ion-person-add"></i>
                        </div>
                        <a href="/prospect?mois={{\Carbon\Carbon::now()->format('m')}}&annee={{\Carbon\Carbon::now()->format('Y')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- num de dossier pass&e en volume et en %-->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3>{{ $stats->getDossierSaleThisMonth($id) }} </h3>

                            <p>
                                @if($stats->getDossierSaleThisMonth($id) != 0)
                                    {{ round( $stats->getDossierSaleThisMonth($id) / $stats->getProspectSaleThisMonth($id) * 100 ,2) }}
                                @endif
                                    % de dossier passés
                            </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('dossiers.index', ['mois' => \Carbon\Carbon::now()->format('m'), 'annee' => \Carbon\Carbon::now()->format('Y')]) }}"
                           class="small-box-footer">
                            Voir les dossiers du mois <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- num de dossier acceptés -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $stats->countAcceptedDossierForSale($id) }}</h3>

                            <p>Dossiers Acceptés</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-folder"></i>
                        </div>
                        <a href="{{ route('dossiers.index', ['annee' => \Carbon\Carbon::now()->format('Y'),'mois' => \Carbon\Carbon::now()->format('m'), 'status' =>'Accepté']) }}"
                           class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Dossiers payés -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue-gradient">
                        <div class="inner">
                            <h3>{{ $stats->countPaidDossierForSale($id) }}</h3>

                            <p>Dossier Payés</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-social-euro"></i>
                        </div>
                        <a href="{{ route('dossiers.index', ['annee' => \Carbon\Carbon::now()->format('Y'), 'mois' => \Carbon\Carbon::now()->format('m'),'status' => 'Payé']) }}"
                           class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- num de dossier  réfusé-->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $stats->countRefusedDossierForSale($id) }}</h3>

                            <p>Dossiers Réfusés</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-help-buoy"></i>
                        </div>
                        <a href="{{ route('dossiers.index', ['mois' => \Carbon\Carbon::now()->format('m'), 'annee' => \Carbon\Carbon::now()->format('Y'), 'status' => 'Refusé']) }}"
                           class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->

            <!-- 2eme ligne de stats -->
            <div class="row">
                <!-- commsission du mois -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ round( $stats->commissionOfTheMonthForSale($id), 2) }} €</h3>

                            <p>Total com du mois</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-social-euro"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- montant commission dossier acceptés %-->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3>{{ round($stats->commissionAcceptedForSale($id) + $stats->commissionPayeeForSale($id), 2) }} €</h3>

                            <p>Acceptes + Payés</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-social-euro"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- montant commission possible commercial -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ round( $stats->commissionAcceptedForSale($id) + $stats->commissionPayeeForSale($id) * 0.05, 2) }} €</h3>

                            <p>Prime Possible</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-social-euro"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- montant commission payée -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue-gradient">
                        <div class="inner">
                            <h3>{{ round( ($stats->commissionPayeeForSale($id) - ($stats->commissionPayeeForSale($id) * 0.2)), 2) }} €</h3>

                            <p>Com' payées</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-social-euro"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- montant commission commercial réel -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-black">
                        <div class="inner">
                            <h3>{{ round($stats->commissionPayeeForSale($id) * 0.05, 2) }} €</h3>

                            <p>Prime réelle</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-social-euro"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </div>
    </div>
</div>

