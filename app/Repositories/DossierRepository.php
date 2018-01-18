<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 18/01/2018
 * Time: 08:41
 */

namespace App\Repositories;


use App\Models\Dossier;

class DossierRepository
{
    /**
     * @var Dossier
     */
    protected $dossier;

    /**
     * DossierRepository constructor.
     * @param Dossier $dossier
     */
    public function __construct(Dossier $dossier)
    {
        $this->dossier = $dossier;
    }

    /**
     * Retourne la liste des dossiers paginés 10/10
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return $this->dossier->with('user', 'banque')->paginate(10);
    }
}