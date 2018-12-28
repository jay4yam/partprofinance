 <div class="row">
        <!-- num de prospect -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $prospectsADate }}</h3>

                    <p>Prospects ce mois ci</p>
                </div>
                <div class="icon">
                    <i class="ion ion ion-person-add"></i>
                </div>
                @if( Request::get('mois') && Request::get('annee') )
                    <a href="/prospect?mois={{ Request::get('mois') }}&annee={{Request::get('annee')}}"
                       class="small-box-footer">Voir les prospects du mois <i class="fa fa-arrow-circle-right"></i></a>
                @else
                <a href="/prospect?mois={{\Carbon\Carbon::now()->format('m')}}&annee={{\Carbon\Carbon::now()->format('Y')}}"
                   class="small-box-footer">Voir les prospects du mois <i class="fa fa-arrow-circle-right"></i></a>
                @endif
            </div>
        </div>

        <!-- num de dossier pass&e en volume et en %-->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ $dossierADate }} </h3>

                    <p>@if($prospectsADate != 0)
                            {{ round( @$dossierADate / @$prospectsADate  * 100 ,2) }}
                        @endif % de dossier passés
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                @if( Request::get('mois') && Request::get('annee') )
                    <a href="{{ route('dossiers.index', ['mois' => Request::get('mois'), 'annee' => Request::get('annee')]) }}"
                       class="small-box-footer">
                        Voir les dossiers du mois <i class="fa fa-arrow-circle-right"></i>
                    </a>
                @else
                <a href="{{ route('dossiers.index', ['mois' => \Carbon\Carbon::now()->format('m'), 'annee' => \Carbon\Carbon::now()->format('Y')]) }}"
                   class="small-box-footer">
                    Voir les dossiers du mois <i class="fa fa-arrow-circle-right"></i>
                </a>
                @endif
            </div>
        </div>

        <!-- num de dossier accpetés -->
        <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $numAcceptedADate }}</h3>

                    <p>Dossiers Acceptés</p>
                </div>
                <div class="icon">
                    <i class="ion ion-folder"></i>
                </div>
                @if( Request::get('mois') && Request::get('annee') )
                    <a href="{{ route('dossiers.index', ['annee' => Request::get('annee'),'mois' => Request::get('mois'), 'status' =>'Accepté']) }}"
                       class="small-box-footer">
                        Voir <i class="fa fa-arrow-circle-right"></i>
                    </a>
                @else
                    <a href="{{ route('dossiers.index', ['annee' => \Carbon\Carbon::now()->format('Y'),'mois' => \Carbon\Carbon::now()->format('m'), 'status' =>'Accepté']) }}"
                       class="small-box-footer">
                        Voir <i class="fa fa-arrow-circle-right"></i>
                    </a>
                @endif
            </div>
        </div>

        <!-- Dossiers payés -->
        <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue-gradient">
                <div class="inner">
                    <h3>{{ $numPaidADate }}</h3>

                    <p>Dossier Payés</p>
                </div>
                <div class="icon">
                    <i class="ion ion-social-euro"></i>
                </div>
                @if( Request::get('mois') && Request::get('annee') )
                    <a href="{{ route('dossiers.index', ['annee' => Request::get('annee'), 'mois' => Request::get('mois'),'status' => 'Payé']) }}"
                       class="small-box-footer">
                        Voir <i class="fa fa-arrow-circle-right"></i>
                    </a>
                @else
                    <a href="{{ route('dossiers.index', ['annee' => \Carbon\Carbon::now()->format('Y'), 'mois' => \Carbon\Carbon::now()->format('m'),'status' => 'Payé']) }}"
                       class="small-box-footer">
                        Voir <i class="fa fa-arrow-circle-right"></i>
                    </a>
                @endif
            </div>
        </div>

        <!-- num de dossier  réfusé-->
        <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $numRefusADate }}</h3>

                    <p>Dossiers Réfusés</p>
                </div>
                <div class="icon">
                    <i class="ion ion-help-buoy"></i>
                </div>
                @if( Request::get('mois') && Request::get('annee') )
                    <a href="{{ route('dossiers.index', ['mois' => Request::get('mois'), 'annee' => Request::get('annee'), 'status' => 'Refusé']) }}"
                       class="small-box-footer">
                        Voir <i class="fa fa-arrow-circle-right"></i>
                    </a>
                @else
                    <a href="{{ route('dossiers.index', ['mois' => \Carbon\Carbon::now()->format('m'), 'annee' => \Carbon\Carbon::now()->format('Y'), 'status' => 'Refusé']) }}"
                       class="small-box-footer">
                        Voir <i class="fa fa-arrow-circle-right"></i>
                    </a>
                @endif
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
                    <h3>{{ round($commissionPartProADate, 2) }} €</h3>

                    <p>Total com du mois</p>
                </div>
                <div class="icon">
                    <i class="ion ion-social-euro"></i>
                </div>
                <a href="#" class="small-box-footer">Voir <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- montant commission dossier acceptés %-->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ round($commissionDossierAcceptedADate + $commissionPayeADate, 2) }} €</h3>

                    <p>Com Acceptées & Payées</p>
                </div>
                <div class="icon">
                    <i class="ion ion-social-euro"></i>
                </div>
                <a href="#" class="small-box-footer">Voir <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- montant commission possible commercial -->
        <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ round($commissionPartProADate * 0.05, 2) }} €</h3>

                    <p>Prime Possible</p>
                </div>
                <div class="icon">
                    <i class="ion ion-social-euro"></i>
                </div>
                <a href="#" class="small-box-footer">Voir <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- montant commission payée -->
        <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue-gradient">
                <div class="inner">
                    <h3>{{ round( ($commissionPayeADate - ($commissionPayeADate * 0.2)), 2) }} €</h3>

                    <p>Com' Payées</p>
                </div>
                <div class="icon">
                    <i class="ion ion-social-euro"></i>
                </div>
                <a href="#" class="small-box-footer">Voir <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- montant commission commercial réel -->
        <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-black">
                <div class="inner">
                    <h3>{{ round($commissionPayeADate * 0.05, 2) }} €</h3>

                    <p>Prime Réelle</p>
                </div>
                <div class="icon">
                    <i class="ion ion-social-euro"></i>
                </div>
                <a href="#" class="small-box-footer">Voir <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>