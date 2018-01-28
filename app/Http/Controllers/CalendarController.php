<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\ProcessProspect;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    protected $processProspect;
    protected  $dossier;

    public function __construct(ProcessProspect $processProspect, Dossier $dossier)
    {
        $this->processProspect = $processProspect;
        $this->dossier = $dossier;
    }

    /**
     * Renvois un tableau json d'event contenant les relances de chaques prospects
     * @return string
     */
    public function getMonthRelance()
    {
        $events = $this->processProspect->with('tempProspect')->where('status', '=', 'nrp')
            ->whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'))
            ->get(['id', 'temp_prospects_id', 'status', 'relance_status', 'relance_j1', 'relance_j4']);

        $array = [];

        foreach($events as $event)
        {
            $array[] = [
                'title' => 'Relance J+1 :'.$event->tempProspect->nom,
                'start' => $event->relance_j1,
                'backgroundColor' => '#000000',
                'borderColor' => 'black'
            ];
            $array[] = [
                'title' => 'Relance J+4 :'.$event->tempProspect->nom,
                'start' => $event->relance_j4,
                'backgroundColor' => 'darkorange',
                'borderColor' => 'orange'
            ];
        }

        return json_encode($array);
    }

    /**
     * Renvois un tableau json d'event contenant tous les dossiers crées ce mois
     * @return string
     */
    public function getMonthDossier()
    {
        $array = [];
        try {
            $dossiers = $this->dossier->with('prospect')->dossierOfTheMonth()->get();

            foreach ($dossiers as $dossier) {
                $array[] = [
                    'title' => $dossier->prospect->nom . ' : ' . $dossier->montant_final . ' €',
                    'start' => $dossier->created_at->format('Y-m-d'),
                    'backgroundColor' => '#00c0ef',
                    'borderColor' => '#00c0ef'
                ];
            }
        }catch (\Exception $exception){
            throw $exception;
        }
        return json_encode($array);
    }
}
