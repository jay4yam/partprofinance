<?php

namespace App\Http\Controllers;

use App\Http\Requests\DossierRequest;
use App\Repositories\DossierRepository;
use Illuminate\Http\Request;

class DossierController extends Controller
{
    /**
     * @var DossierRepository
     */
    protected $dossierRepository;

    /**
     * DossierController constructor.
     * @param DossierRepository $dossierRepository
     */
    public function __construct(DossierRepository $dossierRepository)
    {
        $this->dossierRepository = $dossierRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dossiers = $this->dossierRepository->getAll();

        return view('dossiers.index', compact('dossiers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dossiers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DossierRequest $request)
    {
        try {
            $dossier = $this->dossierRepository->store($request->all());
        }catch (\Exception $exception){
            return back()->with( ['message' => $exception->getMessage()] );
        }

        return redirect()->route('dossiers.edit', ['dossier' => $dossier])->with(['message' => 'Création du dossier OK !']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dossier = $this->dossierRepository->getById($id);

        return view('dossiers.edit', compact('dossier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $this->dossierRepository->update($request->all(), $id);

        }catch (\Exception $exception){

            return back()->with( ['message' => $exception->getMessage()] );
        }

        return back()->with(['message' => 'Dossier mise  jour OK!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Gère la recherche de nom d'utilisateur pour l'autocomplete de la vue dossiers.create
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function autoCompleteNom(Request $request)
    {
        $results = $this->dossierRepository->autoCompleteName($request);

        return response()->json($results);
    }
}