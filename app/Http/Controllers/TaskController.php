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
     * @return \Illuminate\Http\RedirectResponse
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


    /**
     * Met à jour un item de la table task
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try{
            $this->taskRepository->update($id, $request->all());
        }catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage()]);
        }
        return response()->json(['message' => 'success']);
    }
}
