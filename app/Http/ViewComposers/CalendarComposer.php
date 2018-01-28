<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 27/01/2018
 * Time: 23:04
 */

namespace App\Http\ViewComposers;

use App\Models\ProcessProspect;
use Carbon\Carbon;
use Illuminate\View\View;

class CalendarComposer
{
    protected $processProspect;

    public function __construct(ProcessProspect $processProspect)
    {
        $this->processProspect = $processProspect;
    }

    /**
     * Retourne la liste des processProspect de l'année et du mois en cours
     * @return \Illuminate\Database\Query\Builder|static
     */
    private function getMonthRelance()
    {
        $events = $this->processProspect->with('tempProspect')->where('status', '=', 'nrp')
            ->whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'))
            ->get();

        return $events;
    }

    /**
     * Renvois les events sous forme de tableau
     * @return string
     */
    private function buildJsonTable()
    {
        //Récupère la liste des év§nement relance
        $events = $this->getMonthRelance();

        //init un tableau
        $array = [];

        //itère sur la liste des events
        foreach ($events as $event)
        {
            $array [] = array("title" =>  "All Day Event",
                  "start" =>  $event->relance_j1,
                  "end" =>  $event->relance_j1,
                  "backgroundColor" => "black",
                  "borderColor" => "black");
        }

        //retourne le tableau au format json
        return json_encode($array);
    }


    /**
     * gère le renvois du tableau à la vue appelé par cette class de Composer
     * @param View $view
     */
    public function compose(View $view)
    {
        $events = $this->getMonthRelance();

        $view->with(['events' => $events]);
    }
}