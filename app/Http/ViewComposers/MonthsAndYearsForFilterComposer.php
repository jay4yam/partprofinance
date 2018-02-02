<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 01/02/2018
 * Time: 21:12
 */

namespace App\Http\ViewComposers;


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MonthsAndYearsForFilterComposer
{
    /**
     * @var ProspectRepository
     */
    protected $user;

    /**
     * ProspectCalendarComposer constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Retourne les années du created_at de chaque utilisateur présents en base
     * @return array
     */
    public function getYears()
    {
        $value = Cache::remember('getYears', 3600, function (){

            //itère sur toutes les entrées user en base pour toper les années
            $users = $this->user->all(['created_at'])->groupBy(function ($item){ return Carbon::parse($item->created_at)->format('Y'); });

            //recupère le résultat en tant que clé du tableau
            $years = array_keys($users->toArray());

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
        $years = $this->getYears();

        $view->with(['years' => $years]);
    }
}