<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 18/01/2018
 * Time: 08:41
 */

namespace App\Repositories;


use App\Helpers\FilterModelByDate;
use App\Models\Dossier;
use App\Models\Prospect;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DossierRepository
{
    /**
     * @var Dossier
     */
    protected $dossier;

    protected $filter;

    /**
     * DossierRepository constructor.
     * @param Dossier $dossier
     */
    public function __construct(Dossier $dossier, FilterModelByDate $filter)
    {
        $this->dossier = $dossier;
        $this->filter = $filter;
    }

    /**
     * Retourne un dossier en particulier
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
    {
        return $this->dossier->with('user', 'banque', 'dossierable')->findOrFail($id);
    }

    /**
     * Retourne la liste des dossiers paginés 10/10
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        switch(\Auth::user()->role){
            case('admin'):
                return $this->dossier->orderBy('created_at', 'DESC')->with('user', 'banque', 'dossierable')->paginate(10);
                break;
            case ('staff'):
                return $this->dossier->owner()->orderBy('created_at', 'DESC')->with('user', 'banque', 'dossierable')->paginate(10);
                break;
        }
        return null;
    }

    /**
     * Retourne la vue filtré par l'utilisateur
     * @param array $inputs
     * @return $this|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Model|\Illuminate\Pagination\LengthAwarePaginator|mixed|null
     */
    public function getFilter(array $inputs)
    {
        $dossiers = $this->getAll();

        //Filtre sur les commerciaux
        if( isset($inputs['user'])) {
            $dossiers = $this->filter->FilterBySales($dossiers, $inputs['user']);
        }

        //recherche par mois
        if(isset($inputs['mois'])) {
            $dossiers = $this->filter->FilterByMonth($dossiers, $inputs['mois']);
        }

        //Filtre par année
        if( isset($inputs['annee'])){
            $dossiers = $this->filter->FilterByYear($dossiers, $inputs['annee']);
        }

        //recherche par nom
        if(isset($inputs['search'])) {
            $dossiers = $this->filter->filterDossierByName($dossiers, $inputs['search'], 'nom');
        }

        //filter par status
        if(isset($inputs['status'])){
            $dossiers = $this->filter->filterDossierByStatus($dossiers, $inputs['status']);
        }

        //recherche par iban
        if(isset($inputs['iban'])){
            $dossiers = $this->filter->filterDossierByIban($this->dossier, $inputs['iban']);
        }

        //recherche par mois et par année
        if(isset($inputs['mois']) && isset($inputs['annee'])){
            $dossiers = $this->filter->FilterByMonthAndYear($dossiers, $inputs['annee'], $inputs['mois']);
        }

        //recherche par mois, par année et par status
        if(isset($inputs['mois']) && isset($inputs['status'])){
            $dossiers = $this->filter->FilterByMonthAndStatus($dossiers, $inputs['mois'], $inputs['status']);
        }

        //recherche par mois, par année et par status
        if(isset($inputs['mois']) && isset($inputs['annee']) && isset($inputs['status'])){
            $dossiers = $this->filter->FilterByMonthAndYearAndStatus($dossiers, $inputs['annee'], $inputs['mois'], $inputs['status']);
        }

        return $dossiers;
    }

    /**
     * @param array $inputs
     * @param $id
     */
    public function update(array $inputs, $id)
    {
        DB::transaction(function () use ($id, $inputs){
            $dossier = $this->getById($id);

            $dossier->update($inputs);
            $dossier->save();

            $user = User::findOrFail( $inputs['user_id']);

            $user->prospect()->update(['iban' => $inputs['iban']]);
        });
    }

    /**
     * Enregistre un nouveau dossier
     * @param array $inputs
     * @return Dossier
     */
    public function store(array $inputs)
    {
        $dossier = new Dossier();

        //utilise methode privee save()
        $this->save($dossier, $inputs);

        return $dossier;
    }

    /**
     * Méthode privée qui gère la sauv. du Dossier
     * @param Dossier $dossier
     * @param array $inputs
     */
    private function save(Dossier $dossier, array $inputs)
    {
        $dossier->signature = $inputs['signature'];
        $dossier->objet_du_pret = $inputs['objet_du_pret'];
        $dossier->duree_du_pret = $inputs['duree_du_pret'];
        $dossier->montant_demande = $inputs['montant_demande'];
        $dossier->montant_final = $inputs['montant_final'];
        $dossier->taux_commission = $inputs['taux_commission'];
        $dossier->montant_commission_partpro = $inputs['montant_commission_partpro'];
        $dossier->apporteur = $inputs['apporteur'];
        $dossier->taux_commission = $inputs['taux_commission'];
        $dossier->num_dossier_banque = $inputs['num_dossier_banque'];
        $dossier->status = $inputs['status'];
        $dossier->banque_id = $inputs['banque_id'];
        $dossier->user_id = $inputs['user_id'];

        //Code placé dans une transaction afin de s'assurer de la mise en DB des bons éléments
        DB::transaction(function () use ($dossier, $inputs) {
            //1. Identification du prospect
            $prospect = Prospect::findOrFail( $inputs['prospect_id'] );

            //2. Si l'input contient l'iban, on met à jour le prospect
            if(isset($inputs['iban']) && $inputs['iban'] != ''){
                $prospect->update(['iban' => $inputs['iban']]);
            }

            //3. Enregistrement du nouveau dossier.
            $dossier->save();

            //4. Met à jour la table dossier avec la cle polymorphique qui va bien
            $prospect->dossiers()->save($dossier);
        });
    }

    /**
     * Supprime un dossier
     * @param $id
     */
    public function delete($id)
    {
        $dossier = $this->dossier->findOrFail($id);

        $dossier->delete();
    }

    /**
     * Retourne la liste des noms pour la fonction autocomplete
     * @param $request
     * @return array
     */
    public function autoCompleteName($request)
    {
        //retourne une collection contenant le nom-prenom-email
        $results = Prospect::where('nom', 'LIKE', '%'.$request->term.'%')->get();

        //init un tableau vide
        $array = [];

        //itère sur la collection pour peupler lz tableau array
        foreach ($results as $prospect)
        {
            $array[] = [
                        'value' => $prospect->nom.' / '.$prospect->prenom.' / '.$prospect->email.' / '.$prospect->iban,
                        'prospect_id' => $prospect->id,
                        'user_id' => $prospect->user_id];
        }

        //test si le tableau est rempli
        if(count($array))
            return $array;
        else
            return ['value'=>'Pas de résultat'];
    }
}