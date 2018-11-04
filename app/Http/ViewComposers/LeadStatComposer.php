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
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LeadStatComposer
{
    /**
     * Renvois les stats des leads et de leurs sources pour le mois en cours
     * @return array
     */
    public function getLeadSourceCount()
    {
        //Recupere la liste des items présents dans la colonne 'prospect_source'
        $listeSources = DB::table('prospects')
            ->groupBy('prospect_source')
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->get(['prospect_source']);
        //init. un tableau
        $array = [];

        //itère la sur la liste
        foreach ($listeSources as $source)
        {
            $value = DB::table('prospects')
                ->where('prospect_source', '=', $source->prospect_source )
                ->whereYear('created_at', Carbon::now()->format('Y'))
                ->whereMonth('created_at', Carbon::now()->format('m'))
                ->count();

            $array [] = ['label' => $source->prospect_source, 'value' => $value];
        }
        return $array;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $array = $this->getLeadSourceCount();

        $view->with(['leadStat' => json_encode($array)]);
    }
}