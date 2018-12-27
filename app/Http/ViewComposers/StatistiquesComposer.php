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
        $prospectsADate = $this->stat->getProspectForMonthAndYear($this->month, $this->year);

        $dossierADate = $this->stat->getDossierForMonthAndYear($this->month, $this->year);

        $percentageOfDossier = $this->stat->countTransfoProspectToDossier();

        $numAcceptedADate = $this->stat->countAcceptedDossierForMonthAndYear($this->month, $this->year);

        $numPaidADate = $this->stat->countPaidDossierADate($this->month, $this->year);

        $numRefusADate = $this->stat->countRefusedDossierADate($this->month, $this->year);

        $commissionPartProADate = $this->stat->commissionForMonthAndYear($this->month, $this->year);

        $commissionDossierAcceptedADate = $this->stat->commissionAcceptedADate($this->month, $this->year);

        $commissionPayeADate = $this->stat->commissionPayeeADate($this->month, $this->year);

        $view->with([
            'prospectsADate' => $prospectsADate,
            'dossierADate' => $dossierADate,
            'percentageOfDossier' => $percentageOfDossier,
            'numAcceptedADate' => $numAcceptedADate,
            'numPaidADate' => $numPaidADate,
            'numRefusADate' => $numRefusADate,
            'commissionPartProADate' => $commissionPartProADate,
            'commissionDossierAcceptedADate' => $commissionDossierAcceptedADate,
            'commissionPayeADate' => $commissionPayeADate
        ]);
    }
}