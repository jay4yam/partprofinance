<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 30/01/2018
 * Time: 19:45
 */

namespace App\Repositories;


use App\Models\Prospect;
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
        $this->task = $task->with('user', 'taskable');
    }

    /**
     * Retourne une tache
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
    {
        return $this->task->findOrFail($id);
    }

    /**
     * retourne la listes des tasks paginées
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return $this->task->orderBy('taskdate', 'desc')->paginate(6);
    }

    /**
     * Gère la sauvegarde d'une nouvelle tache
     * @param array $inputs
     */
    public function store(array $inputs)
    {
        // nouvelle task
        $task = new Task();

        // utilise la méthode privée pour sauv. le model
        $this->save($task, $inputs);
    }

    /**
     * Méthode privée qui gère l'enregistrement sur
     * @param Task $task
     * @param array $inputs
     */
    private function save(Task $task, array $inputs)
    {
        $task->taskdate = $inputs['taskdate'];
        $task->taskcontent = $inputs['taskcontent'];
        $task->level = $inputs['level'];
        $task->user_id = $inputs['user_id'];
        $task->save();

        $prospect = Prospect::findOrFail($inputs['prospect_id']);

        $prospect->tasks()->save($task);

        \Cache::forget('tasks');
    }

    /**
     * met à jour une task
     * @param $id
     * @param array $inputs
     */
    public function update($id, array $inputs)
    {
        $task = $this->getById($id);

        $task->update([ $inputs['type'] => $inputs['value'] ]);

        $task->save();

        \Cache::forget('tasks');
    }

    /**
     * Supprime une tache
     * @param $id
     */
    public function delete($id)
    {
        $task = $this->task->findOrFail($id);
        $task->delete();
        \Cache::forget('tasks');
    }
}