<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 10/10/2018
 * Time: 20:36
 */

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FilterModelByDate
{

    /**
     * @param $annee
     * @param $model
     * @return mixed
     */
    public function FilterByYear($model, $annee)
    {
        if(isset($annee) && $annee != '') {

             $modelFiltered = $model->whereYear('created_at', $annee)
                            ->with('user', 'dossier', 'tasks')
                            ->paginate(10)->setPath($_SERVER['REQUEST_URI']);
            return $modelFiltered;
        }

        return $model;
    }

    /**
     * @param $model
     * @param $month
     * @return mixed
     */
    public function FilterByMonth($model, $month){

        if(isset($month) && $month != '') {

            $prospects = $model
                ->whereMonth('created_at', $month)
                ->with('user', 'dossier', 'tasks')
                ->paginate(10)->setPath($_SERVER['REQUEST_URI']);
            return $prospects;
        }

        return $model;
    }
}