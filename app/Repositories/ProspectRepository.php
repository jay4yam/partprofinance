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
        return $this->user->guest()->with('prospect')->paginate(10);
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

            if($input['id'] == "email")
            {
                $user->update([$input['id'] => $input['value']]);
                $user->save();
            } else {
                $user->prospect()->update([$input['id'] => $input['value']]);
                $user->save();
            }
        }catch (\Exception $exception){
            return ['fail' => $exception->getMessage()];
        }
        return ['success' => 'MAJ OK'];
    }
}