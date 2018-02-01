<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskRepository;

    /**
     * TaskController constructor.
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        try {
            $this->taskRepository->store($request->all());
        }catch (\Exception $exception){
            return back()->with('message', $exception->getMessage());
        }
        return back()->with('message', 'Nouvelle tache ajoutée');
    }
}