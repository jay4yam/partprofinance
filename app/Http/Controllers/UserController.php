<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return ;
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
        return redirect()->route('user.edit')->with(['message' => 'utilisateur crée avec succès']);
    }
}
