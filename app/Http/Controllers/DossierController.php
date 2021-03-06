<?php

namespace App\Http\Controllers;

use App\Http\Requests\DossierRequest;
use App\Models\Dossier;
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
    public function index(Request $request)
    {
        $dossiers = $this->dossierRepository->getFilter($request->all());

        return view('dossiers.index', compact('dossiers'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dossiers.create');
    }

    /**
     * Gère l'enregistrement d'un nouveau dossier
     * @param DossierRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DossierRequest $request)
    {
        try {

            $dossier = $this->dossierRepository->store($request->all());

        }catch (\Exception $exception){
            return back()->with( ['message' => $exception->getMessage()] );
        }

        //si la sauv a bien eu lieu on renvois vers la page d'envois d'email
        return redirect()->route('send.mail.dossier', ['dossier' => $dossier])->with(['message' => 'Création du dossier OK !']);
    }

    /**
     * Show the form for editing the specified resource.
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->dossierRepository->delete($id);
        }catch (\Exception $exception) {

            return back()->with(['message' => $exception->getMessage()]);
        }

        return back()->with(['message' => 'dossier supprimé']);
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

    /**
     * GET : Renvois la vue qui affiche le mail a envoyer a seb et portet
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendMailShow($id)
    {
        $dossier = $this->dossierRepository->getById($id);

        return view('mails.senddossierbymail', compact('dossier'));
    }

    /**
     * POST : Gère l'envois du mail interne vers partprofinance et descolo
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postMail(Request $request)
    {
        try {
            $subject = $request->subject;
            $content = $request->message;
            $file = $request->file('file');

            \Mail::send('mails.dossiercreated', ['content' => $content], function ($message) use($subject, $file){
                $message->subject($subject);
                $message->from('partprofinance@partprofinance.ovh', 'PartPro Finance CRM');
                $message->to('partprofinance@gmail.com');
                if($file){ $message->attach($file); }
            });
        }catch (\Exception $exception){
            return back()->with(['message' => $exception->getMessage()]);
        }
        return redirect()->route('dossiers.index')->with(['message' => 'email envoyé']);
    }

    /**
     * Retourne un dossier en fonction de son id
     * @param Request $request
     * @return string
     */
    public function getDossier(Request  $request)
    {
        $id = $request->dossierId;

        $dossier = $this->dossierRepository->getById($id);

        return json_encode($dossier);
    }
}
