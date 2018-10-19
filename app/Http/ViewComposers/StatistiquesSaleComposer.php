<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 14/10/2018
 * Time: 13:58
 */

namespace App\Http\ViewComposers;

use App\Helpers\StatistiquesHelper;
use Illuminate\View\View;

class StatistiquesSaleComposer
{
    protected $user;
    protected $stat;

    public function __construct(StatistiquesHelper $stat)
    {
        $this->stat = $stat;
        $this->user = \Auth::user();
    }

    /**
     * gère le renvois du tableau à la vue appelé par cette class de Composer
     * @param View $view
     */
    public function compose(View $view)
    {
        //Compte le nombre de prospects d'un commercial
        $prospectsDuMoisPourLeCommercial = $this->stat->getProspectSaleThisMonth($this->user->id);

        $dossiersDuMoisPourLeCommercial = $this->stat->getDossierSaleThisMonth($this->user->id);

        $percentageOfDossier = $this->stat->countTransfoProspectToDossier();

        $numAcceptedDossierPourLeCommercial = $this->stat->countAcceptedDossierForSale($this->user->id);

        $numPaidDossierPourLeCommercial = $this->stat->countPaidDossierForSale($this->user->id);

        $numRefusedDossierPourLeCommercial = $this->stat->countRefusedDossierForSale($this->user->id);

        $commissionPartProPourLeCommercial = $this->stat->commissionOfTheMonthForSale($this->user->id);

        $commissionDossierAcceptedPourLeCommercial = $this->stat->commissionAcceptedForSale($this->user->id);

        $commissionDossierPayePourLeCommercial = $this->stat->commissionPayeeForSale($this->user->id);

        $view->with([
            'prospectsDuMoisPourLeCommercial' =>  $prospectsDuMoisPourLeCommercial,
            'dossiersDuMoisPourLeCommercial'  =>  $dossiersDuMoisPourLeCommercial,
            'percentageOfDossier' => $percentageOfDossier,
            'numAcceptedDossierPourLeCommercial' => $numAcceptedDossierPourLeCommercial,
            'numPaidDossierPourLeCommercial' => $numPaidDossierPourLeCommercial,
            'numRefusedDossierPourLeCommercial' => $numRefusedDossierPourLeCommercial,
            'commissionPartProPourLeCommercial' => $commissionPartProPourLeCommercial,
            'commissionDossierAcceptedPourLeCommercial' => $commissionDossierAcceptedPourLeCommercial,
            'commissionDossierPayePourLeCommercial' => $commissionDossierPayePourLeCommercial
        ]);
    }
}