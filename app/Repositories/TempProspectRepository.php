<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 20/10/2018
 * Time: 00:26
 */

namespace App\Repositories;


use App\Models\TempProspect;

class TempProspectRepository
{
    protected $tempProspect;

    public function __construct(TempProspect $tempProspect)
    {
        $this->tempProspect = $tempProspect;
    }


    /**
     * Retourne un prospect Temportiare via son id
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getById(int $id)
    {
        return $this->tempProspect->with('owner', 'tasks')->findOrFail($id);
    }
}