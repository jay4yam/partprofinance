<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 20/01/2018
 * Time: 17:31
 */

namespace App\Http\ViewComposers;

use App\Helpers\StatistiquesHelper;
use Carbon\Carbon;
use Illuminate\View\View;

class StatistiquesComposer
{
    protected $stat;
    protected $year;
    protected $month;

    public function __construct(StatistiquesHelper $stat)
    {
        $this->stat = $stat;
        $this->year = \Request::get('annee') ? \Request::get('annee') : Carbon::now()->format('Y');
        $this->month = \Request::get('mois') ? \Request::get('mois') : Carbon::now()->format('m');
    }

    /**
     * gère le renvois du tableau à la vue appelé par cette class de Composer
     * @param View $view
     */
    public function compose(View $view)
    {
        $prospects = $this->stat->getProspectThisMonth();
        $prospectsADate = $this->stat->getProspectForMonthAndYear($this->month, $this->year);
        $dossiers = $this->stat->getDossierThisMonth();
        $percentageOfDossier = $this->stat->countTransfoProspectToDossier();
        $numAccepted = $this->stat->countAcceptedDossier();
        $numPaid = $this->stat->countPaidDossier();
        $numRefus = $this->stat->countRefusedDossier();
        $commissionPartPro = $this->stat->commissionOfTheMonth();
        $commissionPaid = $this->stat->commissionPaid();
        $commissionDossierAccepted = $this->stat->commissionAccepted();
        $commissionPaye = $this->stat->commissionPayee();

        $view->with([
            'prospects' =>  $prospects,
            'prospectsADate' => $prospectsADate,
            'dossiers'  =>  $dossiers,
            'percentageOfDossier' => $percentageOfDossier,
            'numAccepted' => $numAccepted,
            'numPaid' => $numPaid,
            'numRefus' => $numRefus,
            'caPartProPayé' => $commissionPaid,
            'commissionPartPro' => $commissionPartPro,
            'commissionDossierAccepted' => $commissionDossierAccepted,
            'commissionPaye' => $commissionPaye
        ]);
    }
}