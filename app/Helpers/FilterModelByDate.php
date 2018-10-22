<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 10/10/2018
 * Time: 20:36
 */

namespace App\Helpers;

use App\Models\Dossier;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;


class FilterModelByDate
{
    /**
     * Retourne les models ou le commercial est userId
     * @param LengthAwarePaginator $model
     * @param $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Model
     */
    public function filterBySales($model, $userId)
    {
        if(isset($userId) && !empty($userId)) {
            $modelFiltered = $model->where('user_id', $userId)->paginate(10);
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
    public function filterByMonth($model = null, $month){

        //1. test si les inputs sont utilisé
        if(isset($month) && !empty($month)) {
            //2. Init un array vide
            $array = [];

            //3. Parcours la collection
            $modelFiltered = $model->each(function ($items) use($month, &$array){
                $array = $items->whereMonth('created_at', $month)->get();
            });

            //4. Recrée le LengthAwarePaginator pour reproduire la pagination
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $array->slice(($currentPage - 1) * 10, 10);
            $modelPaginate = new LengthAwarePaginator($currentPageItems, count($array), 10);
            $modelsFiltredToReturn = $modelPaginate->setPath($_SERVER['REQUEST_URI']);

            //5. Enregistre les valeurs
            return $modelsFiltredToReturn;
        }
        return null;
    }

    /**
     * Retourne un model quelconque filtré par année
     * @param $annee
     * @param $model
     * @return mixed
     */
    public function filterByYear($model, $annee)
    {
        if(isset($annee) && !empty($annee)) {
            $array = [];
             $modelFiltered = $model->each(function ($items) use($annee, &$array){
                 $array = $items->whereYear('created_at', $annee)->get();
             });

            //4. Recrée le LengthAwarePaginator pour reproduire la pagination
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $array->slice(($currentPage - 1) * 10, 10);
            $modelPaginate = new LengthAwarePaginator($currentPageItems, count($array), 10);
            $modelsFiltredToReturn = $modelPaginate->setPath($_SERVER['REQUEST_URI']);

            return $modelsFiltredToReturn;
        }
        return null;
    }

    /**
     * Retourne la liste des dossiers filtré par mois et par année
     * @param $model
     * @param $annee
     * @param $mois
     * @return LengthAwarePaginator
     */
    public function FilterByMonthAndYear($model, $annee, $mois)
    {
        if(isset($annee) && isset($mois)) {
            $array = [];
            $modelFiltered = $model->each(function ($items) use($annee, $mois,&$array){
                $array = $items->whereYear('created_at', $annee)
                                ->whereMonth('created_at', $mois)->get();
            });

            //4. Recrée le LengthAwarePaginator pour reproduire la pagination
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $array->slice(($currentPage - 1) * 10, 10);
            $modelPaginate = new LengthAwarePaginator($currentPageItems, count($array), 10);
            $modelsFiltredToReturn = $modelPaginate->setPath($_SERVER['REQUEST_URI']);

            return $modelsFiltredToReturn;
        }
        return null;
    }

    /**
     * Retourne la liste des dossiers filtré par mois et par année
     * @param $model
     * @param $annee
     * @param $mois
     * @return LengthAwarePaginator
     */
    public function FilterByMonthAndYearAndStatus($model, $annee, $mois, $status)
    {
        if(isset($annee) && isset($mois) && isset($status)) {
            $array = [];
            $modelFiltered = $model->each(function ($items) use($annee, $mois, $status, &$array){
                $array = $items->whereYear('created_at', $annee)
                                ->whereMonth('created_at', $mois)
                                ->where('status', '=', $status)
                                ->get();
            });

            //4. Recrée le LengthAwarePaginator pour reproduire la pagination
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $array->slice(($currentPage - 1) * 10, 10);
            $modelPaginate = new LengthAwarePaginator($currentPageItems, count($array), 10);
            $modelsFiltredToReturn = $modelPaginate->setPath($_SERVER['REQUEST_URI']);

            return $modelsFiltredToReturn;
        }
        return null;
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

            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $modelFiltered->slice(($currentPage - 1) * 10, 10);
            $usersPaginate = new LengthAwarePaginator($currentPageItems, count($modelFiltered), 10);
            $modelsFiltredToReturn = $usersPaginate->setPath($_SERVER['REQUEST_URI']);

            return $modelsFiltredToReturn;
        }
        return $model;
    }

    /**
     * Filtre le model par le nom
     * @param Model|null $model
     * @param $searchedName
     * @param $dbColumn
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filterDossierByName($model, $searchedName, $dbColumn)
    {
        $modelFiltered = null;
        //recherche par nom
        if( isset($searchedName) && !empty($searchedName) )
        {
            $modelFiltered = Dossier::with('prospect')->whereHas('prospect',  function ($query) use($searchedName){
                $query->where('nom', 'like', '%'.$searchedName.'%');
            })->paginate(10);
        }
         return $modelFiltered;
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

    /**
     * Filtre le vue par status de dossier
     * @param null $model
     * @param $status
     * @return LengthAwarePaginator
     */
    public function filterDossierByStatus($model = null, $status)
    {
        //recherche par status de dossier
        if( isset($status) && !empty($status) )
        {
            $array = [];
            $modelFiltered = $model->each(function ($items) use ($status, &$array){
                $array = $items->where('status', '=', $status)->get();
            });

            //4. Recrée le LengthAwarePaginator pour reproduire la pagination
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $array->slice(($currentPage - 1) * 10, 10);
            $modelPaginate = new LengthAwarePaginator($currentPageItems, count($array), 10);
            $modelsFiltredToReturn = $modelPaginate->setPath($_SERVER['REQUEST_URI']);

            return $modelsFiltredToReturn;
        }
        return null;
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
            $allModels = $model->with('user', 'dossiers', 'tasks')->get();
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
            $allModels = $model->with('user', 'dossiers', 'tasks')->get();
            $modelsWithTask = $allModels->filter(function ($model){
                if(count($model->dossiers)){ return $model;}
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
            $allModels = $model->with('user', 'dossiers', 'tasks')->get();
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
            $allModels = $model->with('user', 'dossiers', 'tasks')->get();
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
}