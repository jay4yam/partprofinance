<?php

namespace App\Repositories;

use App\Models\Prospect;
use App\Models\TempProspect;
use App\Models\User;
use Illuminate\Http\Request;

class ProspectRepository
{
    /**
     * @var User
     */
    protected $user;

    /**
     * ProspectRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Retourne un utilisateur et la table liée 'prospect'
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
    {
        return $this->user->with('prospect')->findOrFail($id);
    }

    /**
     * Retourne la liste des utilisateurs
     * @return mixed
     */
    public function getAll()
    {
        return $this->user->guest()->orderBy('id', 'desc')->with('prospect', 'dossier')->paginate(10);
    }

    /**
     * Gère l'ajout d'un model prospect
     * @param Request $request
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
                $user = User::create([
                    'name' => $inputs['nom'],
                    'email' => $inputs['email'],
                    'password' => bcrypt('partpro'),
                    'role' => 'guest',
                    'avatar' => 'avatar.png'
                ]);

            //2. vérifier si inputs contients // credit-name & credit montant
            $inputs = $this->checkInputCredit($inputs);

            //3. enregistre le model
            $user->prospect()->create($inputs);

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
        try {
            $user = $this->getById($id);

            //met à jour les items en base
            //si c'est le mail qui est mise a jour on update pas
            // le même model entre $user et $user->prospect
            if(isset($input['id']) && $input['id'] == "email")
            {
                //met à jour l'email de l'utilisateur
                $user->update([$input['id'] => $input['value']]);
                $user->save();
            }

            //Si c'est un item qui appartient à la table prospect
            if( isset($input['id']) && $input['id'] != "email"){
                //met à jour le champs de la table ($input[id] avec la nouvelle valeur $input[value]
                $user->prospect()->update([$input['id'] => $input['value']]);

                //sauv. le model
                $user->save();
            }

            //Ajout d'un crédit
            if( isset($input['creditName']) && isset($input['creditValue'])){
                //recupere le tableau de credit à modifier
                $creditArray = json_decode($user->prospect->credits, true);

                //Ajoute le nouveau credit et son montant
                $creditArray[ $input['creditName'] ] = (double)$input['creditValue'];

                //init une variable serialize du tableau credit pour sauv.
                $serializeCredit = json_encode($creditArray);

                //met à jour le credit
                $user->prospect()->update( ['credits' => $serializeCredit] );

                //sauv. le model
                $user->save();
            }

            //Suppression d'un crédit
            if( isset($input['creditToDelete'])){
                //recupere le tableau de credit à modifier
                $creditArray = json_decode($user->prospect->credits, true);

                //supprimer le credit du tableau
                unset( $creditArray[ $input['creditToDelete'] ] );

                //init. le nouveau tableau de credit à enregistré
                $serializeCredit = json_encode($creditArray);

                //enregistre le nouveau tableau de credit
                $user->prospect()->update( ['credits' => $serializeCredit ] );

                //sauv. le model.
                $user->save();

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
     * @return string
     */
    public function delete($id)
    {
            $user = $this->user->findOrFail($id);
            $user->dossier()->delete();
            $user->prospect()->delete();
            $user->delete();
    }

    /**
     * Retourne un tableau contenant "la somme revenus" et "la sommes des charges"
     * @param User $user
     * @return array
     */
    public function revenusAndChargesToArray(User $user)
    {
        //init un tableau vide
        $array = [];

        //additionne les revenus prospect & conjoint
        $array['revenus'] = $user->prospect->revenusNetMensuel + $user->prospect->revenusNetMensuelConjoint;

        //cree l'index charges du tableau pour y stocker les charges
        $array['charges'] = 0;

        //Si le champs credit n'est pas vide
        if($user->prospect->credits != '' || $user->prospect->credits != null) {
            //itère sur le tableau de credits de l'utilisateur pour additionner les montants des credits
            foreach (json_decode($user->prospect->credits) as $credit => $montant) {
                $array['charges'] += $montant;
            }
        }

        //additionne le loyer
        $array['charges'] += $user->prospect->loyer ? $user->prospect->loyer : 0;

        //additionne la pension alimentaire
        $array['charges'] += $user->prospect->pensionAlimentaire ? $user->prospect->pensionAlimentaire : 0 ;

        return $array;
    }

    /**
     * Met à jour une row du tableau credits stocké en base
     * @param array $inputs
     * @param $id
     */
    public function updateCreditRow(array $inputs, $id)
    {
        try {
            //recupere le user/prospect à mettre à jour
            $user = $this->getById($id);

            //recupere le tableau  stocké en base
            $credits = (array)json_decode($user->prospect->credits, true);

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

            $user->prospect()->update(['credits' => json_encode($credits)]);
        }catch (\Exception $exception){
            return ['fail' => $exception->getMessage()];
        }
        return ['success' => 'MAJ OK'];
    }
}