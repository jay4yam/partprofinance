<?php

namespace App\Repositories;

use App\Models\User;

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
        return $this->user->guest()->orderBy('id', 'desc')->with('prospect')->paginate(10);
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
        try{
            $user = $this->user->findOrFail($id);
            $user->prospect()->delete();
            $user->delete();
        }catch (\Exception $exception){
            return back()->with(['message', $exception->getMessage()]);
        }

        return 'prospect supprimé';
    }
}