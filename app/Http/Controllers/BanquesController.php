<?php

namespace App\Http\Controllers;

use App\Repositories\BanquesRepository;
use Illuminate\Http\Request;

class BanquesController extends Controller
{
    protected $banqueRepository;

    public function __construct(BanquesRepository $banquesRepository)
    {
        $this->banqueRepository = $banquesRepository;
    }

    /**
     * Retourne la vue listant les banques
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $banques = $this->banqueRepository->getAll();

        return view('banques.index', compact('banques'));
    }

    /**
     * Renvois vers la vue index en lui passant la banque en param
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($banque)
    {
        $banque = $this->banqueRepository->getById($banque);

        return view('banques.edit', compact('banque'));
    }

    public function update(Request $request, $id)
    {
        $this->banqueRepository->update($request->all(), $id);
        return redirect()->route('banques.index');
    }

    /**
     * Réponse de la requête enregistrement de l'utilisateur
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->banqueRepository->store( $request->all() );

        return back();
    }

    /**
     * Supprime une banque
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->banqueRepository->delete($id);

        return back();
    }
}
