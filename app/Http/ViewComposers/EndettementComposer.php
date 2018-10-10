<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 20/01/2018
 * Time: 14:04
 */

namespace App\Http\ViewComposers;

use App\Repositories\DossierRepository;
use App\Repositories\ProspectRepository;
use Illuminate\View\View;

class EndettementComposer
{
    /**
     * @var ProspectRepository
     */
    protected $prospectRepository;

    protected $prospectId;

    protected $dossierRepository;

    protected $dossierId;

    /**
     * EndettementComposer constructor.
     * @param ProspectRepository $prospectRepository
     */
    public function __construct(ProspectRepository $prospectRepository, DossierRepository $dossierRepository)
    {
        $this->prospectRepository = $prospectRepository;

        $this->dossierRepository = $dossierRepository;

        //récupère l'id de l'utilisateur passée à la route en tant que variable prospect
        $this->prospectId = request()->route()->parameter('prospect');

        //récupère l'id du dossier passée à la route en tant que variable dossier
        $this->dossierId = request()->route()->parameter('dossier');
    }

    /**
     * Récupère l'utilisateur passé en param
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private function getUser()
    {
        $user = '';

        //si la route est celle des dossiers
        if($this->dossierId)
        {
            $dossier = $this->dossierRepository->getById($this->dossierId);

            $user = $this->prospectRepository->getById( $dossier->prospect_id );
        }
        //si la route est celle des prospect
        if($this->prospectId) {
            $user = $this->prospectRepository->getById($this->prospectId);
        }
        return $user;
    }

    /**
     * @return array
     */
    private function getCreditAndRevenus()
    {
        //récupère l'utilisateur
        $user = $this->getUser();

        //retourne le tableau des revenus et des charges
        return $this->prospectRepository->revenusAndChargesToArray($user);
    }

    /**
     * gère le renvois du tableau à la vue appelé par cette class de Composer
     * @param View $view
     */
    public function compose(View $view)
    {
        $array = $this->getCreditAndRevenus();

        $view->with(['revenus' => $array['revenus'], 'charges' => $array['charges']]);
    }
}