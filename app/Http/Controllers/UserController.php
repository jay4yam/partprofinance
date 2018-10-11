<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
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
        return view('Commerciaux.create');
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
}
