<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 16/01/2018
 * Time: 20:35
 */

namespace App\Repositories;


use App\Models\Banque;

class BanquesRepository
{
    protected $banque;

    public function __construct(Banque $banque)
    {
        $this->banque = $banque;
    }

    /**
     * Retourne la liste des banques
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return $this->banque->paginate(10);
    }

    /**
     * Retourne un model banque via son id
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
    {
        return $this->banque->findOrFail($id);
    }

    /**
     * Gère l'enregistrement d'un nouveau model
     * @param array $inputs
     */
    public function store(array $inputs)
    {
        $banque = new Banque();

        $this->save($banque, $inputs);
    }

    /**
     * Sauv. un model banque & l'image si elle existe
     * @param Banque $banque
     * @param array $inputs
     */
    private function save(Banque $banque, array $inputs)
    {
        $banque->nom = $inputs['nom'];

        if( isset( $inputs['logo'] ) && $inputs['logo']->isValid() )
        {
            $file = $inputs['logo'];
            $ext = $file->getClientOriginalExtension();
            $name = str_slug($inputs['nom']).'-logo.'.$ext;
            $file->storeAs( "public/img", $name);
        }
        $banque->logo = $inputs['nom'].'-logo.'.$inputs['logo']->getClientOriginalExtension();

        $banque->save();
    }

    /**
     * Met à jour un model
     * @param array $inputs
     * @param $id
     */
    public function update(array $inputs, $id)
    {
        $banque = $this->getById($id);

        $banque->update([ 'nom' => $inputs['nom'] ]);

        if( isset( $inputs['logo'] ) && $inputs['logo']->isValid() )
        {
            $file = $inputs['logo'];
            $ext = $file->getClientOriginalExtension();
            $name = str_slug($inputs['nom']).'-logo.'.$ext;
            $file->storeAs( "public/img", $name);

            $banque->update(['logo' => $name]);
        }

    }

    /**
     * Supprimer une banque
     * @param $id
     */
    public function delete($id)
    {
        $banque = $this->getById($id);

        $banque->delete();
    }

}