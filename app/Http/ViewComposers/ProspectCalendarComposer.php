<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 01/02/2018
 * Time: 08:22
 */

namespace App\Http\ViewComposers;


use App\Models\User;
use App\Repositories\ProspectRepository;
use Carbon\Carbon;
use Illuminate\View\View;

class ProspectCalendarComposer
{
    /**
     * @var ProspectRepository
     */
    protected $user;

    /**
     * prospectCalendarComposer constructor.
     * @param ProspectRepository $prospectRepository
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
        $value = \Cache::remember('getYears', 3600, function (){

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
     * Retourne les années du created_at de chaque utilisateur présents en base
     * @return array
     */
    public function getMonths()
    {
        $value = \Cache::remember('getMonths', 3600, function (){

            //itère sur toutes les entrées user en base pour toper les années
            $users = $this->user->all(['created_at'])->groupBy(function ($item){ return Carbon::parse($item->created_at)->format('M'); });

            //recupère le résultat en tant que clé du tableau
            $months = array_keys($users->toArray());

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
     * Gère l'envois de la data la vue : task.home
     * @param View $view
     */
    public function compose(View $view)
    {
        $years = $this->getYears();
        $months = $this->getMonths();

        $view->with(['years' => $years, 'months' => $months]);
    }
}