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
                return Carbon::parse($item->created_at)->format('m');
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

            $arrayMonth = $this->getArrayMonth();

            $arrayDiff = array_intersect_key($arrayMonth, $array);

            //retour de la valeur en cache
            return $arrayDiff;
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
                return Carbon::parse($item->created_at)->format('m');
            });

            //recupère le résultat en tant que clé du tableau
            $months = array_keys( $dossiers->toArray() );

            //init un tab vide
            $array = [];

            //itère sur le tableau pour enregistrer les valeurs dans un tableau au format date '01' => '01, '02' => '02,
            foreach ($months as $cle => $value)
            {
                $array[$value] = $value;
            }

            //appel la méthode privée qui renvois les 12 mois de l'année au format date '01=>'janv', '02'=>'fev'
            $arrayMonth = $this->getArrayMonth();

            //intersect les deux tableaux pour ne garder que les mois présents en base au format '01=>'janv' (human)
            $arrayDiff = array_intersect_key($arrayMonth, $array);

            //retour de la valeur en cache
            return $arrayDiff;
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
     * @return array
     */
    private function getArrayMonth()
    {
        return ['01'=>'Janv', '02'=>'Fev', '03'=>'Mars', '04'=>'Avril', '05'=>'Mai', '06'=>'Juin',
                '07'=> 'Juillet', '08'=>'Août', '09'=>'Sept', '10'=> 'Oct', '11'=> 'Nov', '12'=>'Dec'];
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

        $dossierMonths = $this->getDossiersMonths();

        $view->with([   'prospectYears' => $prospectYears,
                        'prospectMonths' => $prospectMonths,
                        'dossierYears' => $dossierYears,
                        'dossierMonths' => $dossierMonths
        ]);
    }
}