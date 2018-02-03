<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 21/01/2018
 * Time: 11:36
 */

namespace App\Http\ViewComposers;

use App\Models\Dossier;
use App\Models\Prospect;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class LeadStatComposer
{
    public function getLeadSourceCount()
    {
        //Recupere la liste des items présents dans la colonne 'prospect_source'
        $listeSources = Prospect::with(['user' => function($query){
            $query->whereMonth('created_at',Carbon::now()->format('m'))->whereYear('created_at', Carbon::now()->format('Y'));
        }])->groupBy('prospect_source')->get(['prospect_source']);

        //init. un tableau
        $array = [];

        //itère la sur la liste
        foreach ($listeSources as $source)
        {
            $array [] = ['label' => $source->prospect_source, 'value' => Prospect::with('dossier')->get(['prospect_source'])->where('prospect_source', '=', $source->prospect_source)->count()];
        }
        return $array;
    }

    public function compose(View $view)
    {
        $array = $this->getLeadSourceCount();

        $view->with(['leadStat' => json_encode($array)]);
    }
}