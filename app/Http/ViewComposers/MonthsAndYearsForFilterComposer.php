<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 01/02/2018
 * Time: 21:12
 */

namespace App\Http\ViewComposers;


use App\Models\Dossier;
use App\Models\Prospect;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MonthsAndYearsForFilterComposer
{
    /**
     * @var ProspectRepository
     */
    protected $prospect;
    protected $dossier;

    /**
     * ProspectCalendarComposer constructor.
     * @param Prospect $prospect
     */
    public function __construct(Prospect $prospect, Dossier $dossier)
    {
        $this->prospect = $prospect;
        $this->dossier = $dossier;
    }


    /**
     * Retourne les mois du created_at de chaque prospect présents en base
     * @return array
     */
    public function getProspectsMonths()
    {
        $value = Cache::remember('getProspectsMonths', 3600, function (){

            //itère sur toutes les entrées user en base pour toper les années
            $prospects = $this->prospect->all(['created_at'])->groupBy(function ($item){
                return Carbon::parse($item->created_at)->format('M');
            });

            //recupère le résultat en tant que clé du tableau
            $months = array_keys( $prospects->toArray() );

            //init un tab vide
            $array = [];

            //itère sur le tableau pour enregistrer les valeurs dans un tableau
            foreach ($months as $cle => $value)
            {
                $array[$value] = $value;
            }

            //retour de la valeur en cache
            return $array;
        });

        //retour de la fonction
        return $value;
    }

    /**
     * Retourne les années du created_at de chaque utilisateur présents en base
     * @return array
     */
    public function getProspectsYears()
    {
        $value = Cache::remember('getProspectsYears', 3600, function (){

            //itère sur toutes les entrées user en base pour toper les années
            $prospects = $this->prospect->all(['created_at'])->groupBy(function ($item){
                return Carbon::parse($item->created_at)->format('Y');
            });

            //recupère le résultat en tant que clé du tableau
            $years = array_keys( $prospects->toArray() );

            //init un tab vide
            $array = [];

            //itère sur le tableau pour enregistrer les valeurs dans un tableau
            foreach ($years as $cle => $value)
            {
                $array[$value] = $value;
            }

            //retour de la valeur en cache
            return $array;
        });

        //retour de la fonction
        return $value;
    }

    /**
     * Retourne les mois du created_at de chaque prospect présents en base
     * @return array
     */
    public function getDossiersMonths()
    {
        $value = Cache::remember('getDossiersMonths', 3600, function (){

            //itère sur toutes les entrées user en base pour toper les années
            $dossiers = $this->dossier->all(['created_at'])->groupBy(function ($item){
                return Carbon::parse($item->created_at)->format('M');
            });

            //recupère le résultat en tant que clé du tableau
            $months = array_keys( $dossiers->toArray() );

            //init un tab vide
            $array = [];

            //itère sur le tableau pour enregistrer les valeurs dans un tableau
            foreach ($months as $cle => $value)
            {
                $array[$value] = $value;
            }

            //retour de la valeur en cache
            return $array;
        });

        //retour de la fonction
        return $value;
    }

    /**
     * Retourne les années du created_at de chaque utilisateur présents en base
     * @return array
     */
    public function getDossiersYears()
    {
        $value = Cache::remember('getDossiersYears', 3600, function (){

            //itère sur toutes les entrées user en base pour toper les années
            $dossiers = $this->dossier->all(['created_at'])->groupBy(function ($item){
                return Carbon::parse($item->created_at)->format('Y');
            });

            //recupère le résultat en tant que clé du tableau
            $years = array_keys( $dossiers->toArray() );

            //init un tab vide
            $array = [];

            //itère sur le tableau pour enregistrer les valeurs dans un tableau
            foreach ($years as $cle => $value)
            {
                $array[$value] = $value;
            }

            //retour de la valeur en cache
            return $array;
        });

        //retour de la fonction
        return $value;
    }

    /**
     * Gère l'envois de la data la vue : task.home
     * @param View $view
     */
    public function compose(View $view)
    {
        //utilsiation methode getyears
        $prospectYears = $this->getProspectsYears();

        $prospectMonths = $this->getProspectsMonths();

        $dossierYears = $this->getDossiersYears();

        $dossierMonth = $this->getDossiersMonths();

        $view->with([   'prospectYears' => $prospectYears,
                        'prospectMonths' => $prospectMonths,
                        'dossierYears' => $dossierYears,
                        'dossierMonths' => $dossierMonth
        ]);
    }
}