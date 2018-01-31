<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 20/01/2018
 * Time: 17:31
 */

namespace App\Http\ViewComposers;

use App\Helpers\StatistiquesHelper;
use Illuminate\View\View;

class StatistiquesComposer
{
    protected $stat;

    public function __construct(StatistiquesHelper $stat)
    {
        $this->stat = $stat;
    }

    /**
     * gère le renvois du tableau à la vue appelé par cette class de Composer
     * @param View $view
     */
    public function compose(View $view)
    {
        $prospects = $this->stat->getProspectThisMonth();
        $dossiers = $this->stat->getDossierThisMonth();
        $percentageOfDossier = $this->stat->countTransfoProspectToDossier();
        $numAccepted = $this->stat->countAcceptedDossier();
        $numRefus = $this->stat->countRefusedDossier();
        $commissionPartPro = $this->stat->commissionOfTheMonth();
        $commissionDossierAccepted = $this->stat->commissionAccepted();
        $commissionPaye = $this->stat->commissionPayee();

        $view->with([
            'prospects' =>  $prospects,
            'dossiers'  =>  $dossiers,
            'percentageOfDossier' => $percentageOfDossier,
            'numAccepted' => $numAccepted,
            'numRefus' => $numRefus,
            'commissionPartPro' => $commissionPartPro,
            'commissionDossierAccepted' => $commissionDossierAccepted,
            'commissionPaye' => $commissionPaye
        ]);
    }
}