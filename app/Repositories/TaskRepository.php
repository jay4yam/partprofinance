<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 30/01/2018
 * Time: 19:45
 */

namespace App\Repositories;


use App\Models\Task;

class TaskRepository
{
    /**
     * @var Task
     */
    protected $task;

    /**
     * TaskRepository constructor.
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task->with('user');
    }

    /**
     * retourne la listes des tasks paginées
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return $this->task->with('user')->orderBy('taskdate', 'desc')->paginate(6);
    }

    /**
     * Gère la sauvegarde d'une nouvelle tache
     * @param array $inputs
     */
    public function store(array $inputs)
    {
        // nouvelle task
        $task = new Task();

        // utilise la methode privée pour sauv. le model
        $this->save($task, $inputs);
    }

    /**
     * Méthode privée qui gère l'enregistrement sur
     * @param Task $task
     * @param array $inputs
     */
    private function save(Task $task, array $inputs)
    {
        $task->task_creator_user_id = $inputs['task_creator_user_id'];
        $task->taskdate = $inputs['taskdate'];
        $task->taskcontent = $inputs['taskcontent'];
        $task->level = $inputs['level'];
        $task->user_id = $inputs['user_id'];

        $task->save();
    }
}