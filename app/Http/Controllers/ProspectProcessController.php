<?php

namespace App\Http\Controllers;

use App\Repositories\ProcessProspectRepository;
use Illuminate\Http\Request;

class ProspectProcessController extends Controller
{
    /**
     * @var
     */
    protected $processProspectRepository;

    /**
     * ProspectProcessController constructor.
     * @param ProcessProspectRepository $processProspectRepository
     */
    public function __construct(ProcessProspectRepository $processProspectRepository)
    {
        $this->processProspectRepository = $processProspectRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request)
    {
        //1. utilise le repo pour mettre a jour le status
        $this->processProspectRepository->updateStatus($request->all());

        //2.gère les différente action en fonction du status
        switch ($request['status'])
        {
            case 'nrp':
                //envois mail + sms
                //creer relance j+1
                //crée relance j+4
                break;
            case 'intérêt':
                return redirect()->route('create.imported.prospect', ['prospectId' => $request->temp_prospect_id]);
                break;
        }

        return back();
    }
}
