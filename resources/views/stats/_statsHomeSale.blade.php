<div class="row">
    <!-- num de dossier -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $prospectsDuMoisPourLeCommercial }}</h3>

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
                <h3>{{ $dossiersDuMoisPourLeCommercial }} </h3>

                <p>{{ round($percentageOfDossier,2) }} % de dossier passés</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('dossiers.index', ['mois' => \Carbon\Carbon::now()->format('m'), 'annee' => \Carbon\Carbon::now()->format('Y')]) }}"
               class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- num de dossier acceptés -->
    <div class="col-lg-2 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $numAcceptedDossierPourLeCommercial }}</h3>

                <p>Dossiers Acceptés</p>
            </div>
            <div class="icon">
                <i class="ion ion-folder"></i>
            </div>
            <a href="{{ route('dossiers.index', ['annee' => \Carbon\Carbon::now()->format('Y'), 'mois' => \Carbon\Carbon::now()->format('m'),'status' =>'Accepté']) }}"
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
                <h3>{{ $numPaidDossierPourLeCommercial }}</h3>

                <p>Dossier Payés</p>
            </div>
            <div class="icon">
                <i class="ion ion-folder"></i>
            </div>
            <a href="{{ route('dossiers.index', ['mois' => \Carbon\Carbon::now()->format('m'), 'annee' => \Carbon\Carbon::now()->format('Y'), 'status' =>'Payé']) }}"
               class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- num de dossiers refusés -->
    <div class="col-lg-2 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $numRefusedDossierPourLeCommercial }}</h3>

                <p>Dossiers Réfusés</p>
            </div>
            <div class="icon">
                <i class="ion ion-folder"></i>
            </div>
            <a href="{{ route('dossiers.index', ['mois' => \Carbon\Carbon::now()->format('m'), 'annee' => \Carbon\Carbon::now()->format('Y'), 'status' =>'Refusé']) }}"
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
    <!-- commission du mois -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ round($commissionPartProPourLeCommercial, 2) }} €</h3>

                <p>Total com du mois</p>
            </div>
            <div class="icon">
                <i class="ion ion-social-euro"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- montant commission dossiers acceptés & payés x%-->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-teal">
            <div class="inner">
                <h3>{{ round($commissionDossierAcceptedPourLeCommercial + $commissionDossierPayePourLeCommercial, 2) }} €</h3>

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
                <h3>{{ round( ($commissionDossierAcceptedPourLeCommercial + $commissionDossierPayePourLeCommercial) * Auth::user()->commission_rate / 100, 2) }} €</h3>

                <p>Prime CC possible</p>
            </div>
            <div class="icon">
                <i class="ion ion-social-euro"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- montant commission partpro payée -->
    <div class="col-lg-2 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue-gradient">
            <div class="inner">
                <h3>{{ round( ($commissionDossierPayePourLeCommercial ), 2) }} €</h3>

                <p>Com' PP payées</p>
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
                <h3>{{ round( ($commissionDossierPayePourLeCommercial * Auth::user()->commission_rate) / 100, 2) }} €</h3>

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