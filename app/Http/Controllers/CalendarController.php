<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\ProcessProspect;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
        $value = Cache::remember('eventNrp', 10, function () {
            try {
                $events = $this->processProspect->with('tempProspect')->where('status', '=', 'nrp')
                    ->whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'))
                    ->get(['id', 'temp_prospects_id', 'status', 'relance_status', 'relance_j1', 'created_at']);

                $array = [];

                foreach ($events as $event) {
                    $array[] = [
                        'title' => $event->relance_status.': '. $event->tempProspect->nom,
                        'start' => $event->relance_j1->format('Y-m-d'),
                        'backgroundColor' => $this->getBgColor($event->relance_status),
                        'borderColor' => $this->getBgColor($event->relance_status),
                    ];
                }
            }catch (\Exception $exception){
                throw $exception;
            }
            return json_encode($array);
        });

        return $value;
    }

    /**
     * Renvois un tableau json d'event contenant tous les dossiers crées ce mois
     * @return string
     */
    public function getMonthDossier()
    {
        $value = Cache::remember('eventDossier', 10, function () {
            $array = [];
            try {
                $dossiers = $this->dossier->with('user')->dossierOfTheMonth()->get();

                foreach ($dossiers as $dossier) {
                    $array[] = [
                        'title' => @$dossier->user->prospect->nom . ' : ' . $dossier->montant_final . ' €',
                        'start' => $dossier->created_at->format('Y-m-d'),
                        'backgroundColor' => '#00c0ef',
                        'borderColor' => '#00c0ef'
                    ];
                }
            } catch (\Exception $exception) {
                throw $exception;
            }
            return json_encode($array);
        });

        return $value;
    }

    /**
     * @param Task $task
     * @return string
     */
    public function getMonthTask(Task $task)
    {
        $value = Cache::remember('getMonthTask', 10, function () use($task){
            try {
                $tasksofTheMonth = $task->with('user')->whereYear('taskdate', Carbon::now()->format('Y'))
                    ->whereMonth('taskdate', Carbon::now()->format('m'))->get();


                $array = [];
                foreach ($tasksofTheMonth as $task) {
                    $array[] = [
                        'title' => 'Tache: ' . $task->taskcontent . '|' . $task->user->prospect->nom,
                        'start' => $task->taskdate->format(('Y m d')),
                        'backgroundColor' => 'grey',
                        'borderColor' => 'black'
                    ];
                }

            }catch (\Exception $exception){
                return response()->json(['message' => 'erreur loading']);
            }

            return json_encode($array);
        });

        return $value;
    }

    /**
     * Retourne la bonne couleur en fonction de la valeur de relance_status (string)
     * @param $string
     * @return string
     */
    private function getBgColor($string)
    {
        $color = '';
        switch ($string)
        {
            case 'relance_1':
                $color = 'green';
                break;
            case 'relance_2':
                $color = 'orange';
                break;
            case 'relance_3':
                $color = 'red';
                break;
        }

        return $color;
    }
}
