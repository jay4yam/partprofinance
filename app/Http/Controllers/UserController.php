<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\DossierRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;
    protected $dossierRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     * @param DossierRepository $dossierRepository
     */
    public function __construct(UserRepository $userRepository, DossierRepository $dossierRepository)
    {
        $this->dossierRepository = $dossierRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Affiche la vue avec tous les utilisateurs
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = $this->userRepository->getAll();

        return view('commerciaux.index', compact('users'));
    }

    /**
     * Retourne la vue de création d'une utilisateur
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('commerciaux.create');
    }

    /**
     * Gère l'enregistrement d'un nouvel utilisateur
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try{
            $this->userRepository->store($request->all(), $request->avatar);
        }catch (\Exception $exception){
            return redirect()->route('user.index')->with(['message' => $exception->getMessage()]);
        }
        return redirect()->route('user.index')->with(['message' => 'utilisateur crée avec succès']);
    }

    /**
     * Affiche la page d'edition d'un utilisateur
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->userRepository->getById($id);

        return view('commerciaux.edit', compact('user'));
    }

    public function update(int $userId, Request $request)
    {
        try {
            $this->userRepository->update($userId, $request->all(), $request->avatar);
        }catch (\Exception $exception){
            return redirect()->back()->with(['message' => $exception->getMessage()]);
        }
        return redirect()->route('user.edit', ['id' => $userId])->with(['message' => 'utilisateur modifié avec succès']);
    }

    /**
     * Supression d'un utilisateur
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id){
        //1. recup l'utilisateur à supprimer
        $user = $this->userRepository->getById($id);

        //2. Vérifie si l'utilisateur a des prospects, des dossiers ou des task
        $this->checkUserRelationBeforeDelete($user);

        //3. Supprime l'utilisateur
        $user->delete();

        return back()->with(['message' => 'utilisateur supprimé avec succès']);
    }

    private function checkUserRelationBeforeDelete(User $user){
        DB::transaction(function () use($user){
            if($user->has('prospects')){

                foreach ($user->prospects as $prospect)
                {
                    $prospect->update(['user_id' => 1]);
                    $prospect->save();
                }
            }

            if($user->has('dossiers')){

                foreach ($user->dossiers as $dossier)
                {
                    $dossier->update(['user_id' => 1]);
                    $dossier->save();
                }
            }

            if($user->has('tasks')){

                foreach ($user->tasks as $task)
                {
                    $task->update(['user_id' => 1]);
                }
            }

            if($user->has('tempProspects')){
                foreach ($user->tempProspects as $tempProspect)
                {
                    $tempProspect->update(['user_id' => 1]);
                    $tempProspect->save();
                }
            }
        });
    }
}
