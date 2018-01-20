<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 18/01/2018
 * Time: 08:41
 */

namespace App\Repositories;


use App\Models\Dossier;
use App\Models\Prospect;
use Illuminate\Support\Facades\DB;

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

    /**
     * Retourne un dossier en particulier
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
    {
        return $this->dossier->with('user', 'banque')->findOrFail($id);
    }

    /**
     * Met à jour un dossier
     * @param array $inputs
     * @param $id
     */
    public function update(array $inputs, $id)
    {
        try {
            $dossier = $this->getById($id);

            $dossier->update($inputs);

        }catch (\Exception $exception){ session()->flash( $exception->getMessage() ); }
    }

    /**
     * Retourne la liste des noms pour la fonction autocomplete
     * @param $request
     * @return array
     */
    public function autoCompleteName($request)
    {
        //retourne une collection contenant le nom-prenom-email
        $results = DB::table('prospects')
            ->join('users', 'users.id', '=', 'prospects.user_id')
            ->where('nom', 'LIKE', '%'.$request->term.'%')
            ->select('users.email', 'prospects.nom', 'prospects.prenom', 'prospects.user_id')
            ->get();

        //init un tableau vide
        $array = [];

        //itère sur la collection pour peupler lz tableau array
        foreach ($results as $valeur)
        {
            $array[] = ['value' => $valeur->nom.'-'.$valeur->prenom.'-'.$valeur->email, 'id' => $valeur->user_id,];
        }

        //test si le tableau est rempli
        if(count($array))
            return $array;
        else
            return ['value'=>'Pas de résultat','id'=>''];
    }
}