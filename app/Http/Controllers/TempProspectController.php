<?php

namespace App\Http\Controllers;

use App\Repositories\TempProspectRepository;
use Illuminate\Http\Request;

class TempProspectController extends Controller
{
    protected $tempProspectRepository;

    public function __construct(TempProspectRepository $tempProspectRepository)
    {
        $this->tempProspectRepository = $tempProspectRepository;
    }

    /**
     * Affiche la page de création de prospect from scratch /// distinct de la page création après importation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('temp-prospects.create');
    }


    /**
     * Enregistre un nouveau prospect temporaire
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {

            $this->tempProspectRepository->store($request->all());

        }catch (\Exception $exception){

            return redirect()->route('prospect.import')->with(['message' => $exception->getMessage()]);
        }

        return redirect()->route('prospect.import')->with(['message' => 'Insertion Prospect OK']);
    }

    /**
     * Affiche la page d'edition d'un prospect temporaire
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $prospect = $this->tempProspectRepository->getById($id);

        return view('temp-prospects.edit', compact('prospect'));
    }

    /**
     * Gère la mise à jour de temp_prospect demandée par l'utilisateur
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(int $id, Request $request)
    {
        try {

            $this->tempProspectRepository->update($id, $request->all());

        }catch(\Exception $exception){
            return redirect()->route('prospect.import')->with(['message' => $exception->getMessage()]);
        }
        return redirect()->route('temp_prospect.edit', ['$prospect' => $id])->with(['message' => 'Mise à jour Ok']);
    }
}
