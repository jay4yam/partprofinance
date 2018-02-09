<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 30/01/2018
 * Time: 20:21
 */

namespace App\Http\ViewComposers;

use App\Repositories\TaskRepository;
use Illuminate\View\View;

class TaskComposer
{
    /**
     * @var TaskRepository
     */
    protected $taskRepository;

    /**
     * TaskComposer constructor.
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Gère l'envois de la data la vue : task.home
     * @param View $view
     */
    public function compose(View $view)
    {
        $tasks = \Cache::remember('tasks', 10, function (){
            return $this->taskRepository->getAll();
        });

        $view->with(['tasks' => $tasks]);
    }
}