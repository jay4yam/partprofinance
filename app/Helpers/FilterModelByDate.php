<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 10/10/2018
 * Time: 20:36
 */

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;


class FilterModelByDate
{
    /**
     * Retourne les models ou le commercial est userId
     * @param Model $model
     * @param $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Model
     */
    public function filterBySales(Model $model, $userId)
    {
        if(isset($userId) && !empty($userId)) {
            $modelFiltered = $model->where('user_id', $userId)->paginate(10);
            return $modelFiltered;
        }
        return $model;
    }

    /**
     * Retourne un model quelconque filtré par année
     * @param $annee
     * @param $model
     * @return mixed
     */
    public function filterByYear(Model $model, $annee)
    {
        if(isset($annee) && !empty($annee)) {
             $modelFiltered = $model->whereYear('created_at', $annee)->paginate(10);
            return $modelFiltered;
        }
        return $model;
    }

    /**
     * Retourne un model quelconque filtré par mois
     * @param $model
     * @param $month
     * @return mixed
     */
    public function filterByMonth(Model $model = null, $month){

        if(isset($month) && !empty($month)) {

            $modelFiltered = $model->whereMonth('created_at', $month)->paginate(10);
            return $modelFiltered;
        }
        return $model;
    }

    /**
     * Filtre le model par le nom
     * @param Model|null $model
     * @param $searchedName
     * @param $dbColumn
     * @return LengthAwarePaginator|Model
     */
    public function filterByName(Model $model = null, $searchedName, $dbColumn)
    {
        //recherche par nom
        if( isset($searchedName) && !empty($searchedName) )
        {
            $modelFiltered = $model->where($dbColumn, 'LIKE', '%'.$searchedName.'%')->paginate(10);
            return $modelFiltered;
        }
        return $model;
    }

    /**
     * Filtre le model par le nom
     * @param Model|null $model
     * @param $searchedName
     * @param $dbColumn
     * @return LengthAwarePaginator|Model
     */
    public function filterDossierByName(Model $model = null, $searchedName, $dbColumn)
    {
        $modelFiltered2return = null;

        //recherche par nom
        if( isset($searchedName) && !empty($searchedName) )
        {
            $collection = New Collection();
            $allModels = $model->with('user', 'banque', 'prospect')->get();
            $modelFiltered= $allModels->each(function ($dossier) use ($searchedName, $collection) {
                $nom = $dossier->prospect->nom;
                $pos = strpos( strtolower($nom), $searchedName);
                if($pos !== false)
                    $collection->push($dossier);
            });
            //Get current page form url e.g. &page=1
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $collection->slice(($currentPage - 1) * 10, 10);
            $usersPaginate = new LengthAwarePaginator($currentPageItems, count($collection), 10);
            $modelFiltered2return = $usersPaginate->setPath($_SERVER['REQUEST_URI']);
        }
        return $modelFiltered2return;
    }

    /**
     * Filtre par iban
     * @param Model|null $model
     * @param $iban
     * @return LengthAwarePaginator
     */
    public function filterByIban(Model $model = null, $iban)
    {
        $modelFiltered2return = null;

        if(isset($iban) && $iban = 'on') {
            $allModels = $model->with('user', 'dossier', 'tasks')->get();
            $modelFiltered = $allModels->filter(function ($model) {
                if ($model->iban != '') return $model;
            });

            //Get current page form url e.g. &page=1
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $modelFiltered->slice(($currentPage - 1) * 10, 10);
            $usersPaginate = new LengthAwarePaginator($currentPageItems, count($modelFiltered), 10);
            $modelFiltered2return = $usersPaginate->setPath($_SERVER['REQUEST_URI']);
        }

        return $modelFiltered2return;
    }

    /**
     * Filtre par iban
     * @param Model|null $model
     * @param $iban
     * @return LengthAwarePaginator
     */
    public function filterDossierByIban(Model $model = null, $iban)
    {
        $modelFiltered2return = null;

        if(isset($iban) && $iban = 'on') {
            $allModels = $model->with('user', 'banque', 'prospect')->get();
            $modelFiltered = $allModels->filter(function ($model) {
                if ($model->prospect->iban != '') {
                    return $model;
                }
            });

            //Get current page form url e.g. &page=1
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $modelFiltered->slice(($currentPage - 1) * 10, 10);
            $usersPaginate = new LengthAwarePaginator($currentPageItems, count($modelFiltered), 10);
            $modelFiltered2return = $usersPaginate->setPath($_SERVER['REQUEST_URI']);
        }

        return $modelFiltered2return;
    }

    public function filterDossierByStatus(Model $model = null, $status)
    {
        //recherche par status de dossier
        if( isset($status) && !empty($status) )
        {
            $modelFiltered = $model->where('status', '=', $status)->paginate(10);
            return $modelFiltered;
        }
        return $model;
    }

    /**
     * Retourne un model qui contient des task
     * @param Model|null $model
     * @param $task
     * @return LengthAwarePaginator
     */
    public function filterByTask(Model $model = null, $task)
    {
        $modelsWithTask2return = null;

        if( isset($task) && $task = 'on')
        {
            $allModels = $model->with('user', 'dossier', 'tasks')->get();
            $modelsWithTask = $allModels->filter(function ($model){
                if(count($model->tasks)){ return $model;}
            });
            //Get current page form url e.g. &page=1
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $modelsWithTask->slice(($currentPage - 1) * 10, 10);
            $usersPaginate = new LengthAwarePaginator($currentPageItems, count($modelsWithTask), 10);
            $modelsWithTask2return = $usersPaginate->setPath($_SERVER['REQUEST_URI']);
        }

        return $modelsWithTask2return;
    }

    /**
     * @param Model|null $model
     * @param $dossier
     * @return LengthAwarePaginator
     */
    public function filterByDossier(Model $model = null, $dossier)
    {
        $modelsWithDossier2return = null;

        if( isset($dossier) && $dossier = 'on')
        {
            $allModels = $model->with('user', 'dossier', 'tasks')->get();
            $modelsWithTask = $allModels->filter(function ($model){
                if(count($model->dossier)){ return $model;}
            });
            //Get current page form url e.g. &page=1
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $modelsWithTask->slice(($currentPage - 1) * 10, 10);
            $usersPaginate = new LengthAwarePaginator($currentPageItems, count($modelsWithTask), 10);
            $modelsWithDossier2return = $usersPaginate->setPath($_SERVER['REQUEST_URI']);
        }

        return $modelsWithDossier2return;
    }

    /**
     * Retourne les models qui ont signé le mandat
     * @param Model|null $model
     * @param $mandat
     * @return LengthAwarePaginator
     */
    public function filterByMandat(Model $model = null, $mandat)
    {
        $modelsWithMandat2return = null;

        if( isset($mandat) && $mandat = 'on')
        {
            $allModels = $model->with('user', 'dossier', 'tasks')->get();
            $modelFiltered = $allModels->filter(function ($model) {
                if ($model->mandat_status) {
                    return $model;
                }
            });
            //Get current page form url e.g. &page=1
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $modelFiltered->slice(($currentPage - 1) * 10, 10);
            $usersPaginate = new LengthAwarePaginator($currentPageItems, count($modelFiltered), 10);
            $modelsWithMandat2return = $usersPaginate->setPath($_SERVER['REQUEST_URI']);
        }

        return $modelsWithMandat2return;
    }
}