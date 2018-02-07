<div class="row">
    <!-- num de dossier -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $prospects }}</h3>

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
                <h3>{{ $dossiers }} </h3>

                <p>{{ round($percentageOfDossier,2) }} % de dossier passés</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- num de dossier accpetés -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $numAccepted }}</h3>

                <p>Dossiers Acceptés</p>
            </div>
            <div class="icon">
                <i class="ion ion-folder"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- num de dossier  réfusé-->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $numRefus }}</h3>

                <p>Dossiers Réfusés</p>
            </div>
            <div class="icon">
                <i class="ion ion-help-buoy"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
                <h3>{{ round($commissionPartPro, 2) }} €</h3>

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
                <h3>{{ round($commissionDossierAccepted + $commissionPaye, 2) }} €</h3>

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
                <h3>{{ round( ($commissionDossierAccepted + $commissionPaye) * 0.05, 2) }} €</h3>

                <p>Prime possible</p>
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
                <h3>{{ round(($commissionPaye * 0.2)-$commissionPaye, 2) }} €</h3>

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
                <h3>{{ round($commissionPaye * 0.05, 2) }} €</h3>

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