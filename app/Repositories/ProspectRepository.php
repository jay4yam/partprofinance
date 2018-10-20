<?php

namespace App\Repositories;

use App\Helpers\FilterModelByDate;
use App\Models\Prospect;
use App\Models\TempProspect;
use App\Models\User;
use Carbon\Carbon;
use Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProspectRepository
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Prospect
     */
    protected $prospect;

    /**
     * @var Filter;
     */
    protected $filter;

    /**
     * ProspectRepository constructor.
     * @param User $user
     */
    public function __construct(User $user, Prospect $prospect, FilterModelByDate $filter)
    {
        $this->user = $user;
        $this->prospect = $prospect;
        $this->filter = $filter;
    }

    /**
     * Retourne un prospect et la table liée 'user'
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
    {
        return $this->prospect->with('user', 'dossiers', 'tasks')->findOrFail($id);
    }

    /**
     * Retourne la liste des utilisateurs
     * @return mixed
     */
    public function getAll()
    {
        //test le role de l'utilisateur
        switch (\Auth::user()->role){
            case 'staff':
                //retourne la vue avec les prospects qui n'appartiennent qu'à cet utilisateur
                return $this->prospect->owner()->orderBy('id', 'desc')->with('user', 'dossiers', 'tasks')->paginate(10);
                break;
            case 'admin':
                //retourne la vue avec tous les  prospects car admin
                return $this->prospect->orderBy('id', 'desc')->with('user', 'dossiers', 'tasks')->paginate(10);
                break;
        }
        return null;
    }

    /**
     * Gère la réception des datas pour filtrer la vue prospect.index
     * Retourne une collection de prospect
     * @param array $inputs
     * @return mixed
     */
    public function getFilter(array $inputs)
    {
        $prospects = $this->getAll();

        //Filtre par commerciaux
        if( isset($inputs['user']) && $inputs['user'] != '' ) {
            $prospects = $this->filter->FilterBySales($this->prospect, $inputs['user']);
        }

        //recherche par mois
        if(isset($inputs['mois']) && $inputs['mois'] != '') {
            $prospects = $this->filter->FilterByMonth($this->prospect, $inputs['mois']);
        }

        //Filtre par année
        if( isset($inputs['annee']) && $inputs['annee'] != '' ){
            $prospects = $this->filter->FilterByYear($this->prospect, $inputs['annee']);
        }

        //recherche par nom
        if(isset($inputs['search'])) {
            $prospects = $this->filter->filterByName($this->prospect, $inputs['search'], 'nom');
        }

        //recherche par iban
        if(isset($inputs['iban'])){
            $prospects = $this->filter->filterByIban($this->prospect, $inputs['iban']);
        }

        //recherche par rappel
        if(isset($inputs['rappel'])){
            $prospects = $this->filter->filterByTask($this->prospect, $inputs['rappel']);
        }

        //recherche par dossier
        if(isset($inputs['dossier'])){
            $prospects = $this->filter->filterByDossier($this->prospect, $inputs['dossier']);
        }

        //recherche par mandat
        if(isset($inputs['mandat'])){
            $prospects = $this->filter->filterByMandat($this->prospect, $inputs['mandat']);
        }

        return $prospects;
    }



    /**
     * Gère l'ajout d'un model prospect
     * @param array $request
     */
    public function store(array $request)
    {
        $prospect = new Prospect();

        $this->save($prospect, $request);
    }

    /**
     * Gère la sauv d'un nouveau model prospect
     * @param Prospect $prospect
     * @param array $inputs
     */
    private function save(Prospect $prospect, array $inputs)
    {
        \DB::transaction(function () use($prospect, $inputs) {

            //1. Crée l'utilisateur sur la table user
           $user = \Auth::user();

            //2. vérifier si inputs contients // credit-name & credit montant
            $inputs = $this->checkInputCredit($inputs);

            try{
            //3. enregistre le model
            $user->prospect()->create($inputs);
            }catch (\Exception $exception){
                throw new $exception;
            }

            //4. Si il s'agit d'un import de prospect
            if(isset($inputs['tempProspectId']))
            {
                //recupère le prospect temporaire
                $tempProspect = TempProspect::FindOrfail($inputs['tempProspectId']);

                //Supprime l'entrée dans la table processProspect
                $tempProspect->processProspect()->delete();

                //Supprime le prospect temporaire
                $tempProspect->delete();
            }
        });
    }

    private function checkInputCredit(array $inputs)
    {
        $arrayNom = [];
        $arrayMontant = [];
        $credits = [];
        $newInputs = $inputs;

        //Fonction native laravel, itère sur toutes les row du tableau newinputs
        $creditName = array_where($newInputs, function ($value, $key) use (&$newInputs, &$arrayNom, &$arrayMontant){

            //test si il y a une clé qui s'appelle credit-name
            if (strpos($key, 'credit-name-') !== false) {

                //alors on ajoute cette clé à un tableau de nom de credit
                $arrayNom [] = $value;

                //on supprime la clé 'credit-name-' du tableau
                unset($newInputs[$key]);
            }

            //test si il y a une clé qui s'appelle credit-montant
            if (strpos($key, 'credit-montant-') !== false) {

                //alors on ajoute le montant à un tableau de montant
                $arrayMontant [] = $value;

                //on supprime la clé 'credit-montant-' du tableau
                unset($newInputs[$key]);
            }
        });

        //Itère sur les tableaux $arrayNom && $arrayMontant
        for($i=0; $i < count($arrayMontant); $i++)
        {
            //enregistre les nouvels valeurs dans un nouveau tableau de credit
            $credits [$arrayNom[$i]] =  $arrayMontant[$i] ;
        }

        //ajoute le nouveau tableau de credit encodé en json pour enregistrement en base
        $newInputs['credits'] = json_encode($credits);

        //On retourne les nouveaux tableau newInputs avec toutes les valeurs compatibles avec la sauv. pour ce model
        return $newInputs;
    }

    /**
     * Gère la mise à jour d'un item de la base
     * @param array $input
     * @param $id
     * @return array
     */
    public function update(array $input, $id)
    {
        $prospect = $this->getById($id);
        try {
            //met à jour les items en base
            //update mail
            if(isset($input['id']) && $input['id'] == "email")
            {
                //met à jour l'email de l'utilisateur
                $prospect->update([$input['id'] => $input['value']]);
                $prospect->save();
            }

            //Si c'est un item qui appartient à la table prospect
            if( isset($input['id']) && $input['id'] != "email"){
                //met à jour le champs de la table ($input[id] avec la nouvelle valeur $input[value]
                $prospect->update([$input['id'] => $input['value']]);

                //sauv. le model
                $prospect->save();
            }

            //Ajout d'un crédit
            if( isset($input['creditName']) && isset($input['creditValue'])){
                //recupere le tableau de credit à modifier
                $creditArray = json_decode($prospect->credits, true);

                //Ajoute le nouveau credit et son montant
                $creditArray[ $input['creditName'] ] = (double)$input['creditValue'];

                //init une variable serialize du tableau credit pour sauv.
                $serializeCredit = json_encode($creditArray);

                //met à jour le credit
                $prospect->update( ['credits' => $serializeCredit] );

                //sauv. le model
                $prospect->save();
            }

            //Suppression d'un crédit
            if( isset($input['creditToDelete'])){
                //recupere le tableau de credit à modifier
                $creditArray = json_decode($prospect->credits, true);

                //supprimer le credit du tableau
                unset( $creditArray[ $input['creditToDelete'] ] );

                //init. le nouveau tableau de credit à enregistré
                $serializeCredit = json_encode($creditArray);

                //enregistre le nouveau tableau de credit
                $prospect->update( ['credits' => $serializeCredit ] );

                //sauv. le model.
                $prospect->save();

            }

        }catch (\Exception $exception){
            //retourne un message avec l'erreur pour débuger
            return ['fail' => $exception->getMessage()];
        }
        //si on est là c'est que les étapes de sauv. du model ce sont bien déroulées
        return ['success' => 'MAJ OK'];
    }

    /**
     * Supprime un prospect
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        \DB::transaction(function () use ($id){
            $prospect = $this->prospect->findOrFail($id);
            $prospect->dossier()->delete();
            $prospect->delete();
        });
    }

    /**
     * Retourne un tableau contenant "la somme revenus" et "la sommes des charges"
     * @param Prospect $prospect
     * @return array
     */
    public function revenusAndChargesToArray(Prospect $prospect)
    {
        //init un tableau vide
        $array = [];

        //additionne les revenus prospect & conjoint
        $array['revenus'] = $prospect->revenusNetMensuel + $prospect->revenusNetMensuelConjoint;

        //cree l'index charges du tableau pour y stocker les charges
        $array['charges'] = 0;

        //Si le champs credit n'est pas vide
        if($prospect->credits != '' || $prospect->credits != null) {
            //itère sur le tableau de credits de l'utilisateur pour additionner les montants des credits
            foreach (json_decode($prospect->credits) as $credit => $montant) {
                $array['charges'] += $montant;
            }
        }

        //additionne le loyer
        $array['charges'] += $prospect->loyer ? $prospect->loyer : 0;

        //additionne la pension alimentaire
        $array['charges'] += $prospect->pensionAlimentaire ? $prospect->pensionAlimentaire : 0 ;

        return $array;
    }

    /**
     * Met à jour une row du tableau credits stocké en base
     * @param array $inputs
     * @param $id
     * @return array
     */
    public function updateCreditRow(array $inputs, $id)
    {
        try {
            //recupere le user/prospect à mettre à jour
            $prospect = $this->getById($id);

            //recupere le tableau  stocké en base
            $credits = (array)json_decode($prospect->credits, true);

            //init la nouvelle clé
            $newKey = $inputs['nomCredit'];
            //init le nouveau montant
            $newValue = $inputs['montantCredit'];
            //init l'index du tableau stocké qu'il faut updater
            $indexToUpdate = (int)$inputs['index'];
            //init un nouveau tableau avec les clés mais cette fois ci sous forme d'index
            $newArray = array_keys($credits);
            //Init la veille clé à updater
            $oldKey = $newArray[$indexToUpdate];
            //Insère la nouvelle clé à la place de l'ancienne
            $credits[$newKey] = $credits[$oldKey];
            //supprime l'ancienne clé
            unset($credits[$oldKey]);

            $credits[$newKey] = $newValue;

            $prospect->update(['credits' => json_encode($credits)]);
        }catch (\Exception $exception){
            return ['fail' => $exception->getMessage()];
        }
        return ['success' => 'MAJ OK'];
    }
}