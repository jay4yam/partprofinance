<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProspectRequest;
use App\Repositories\ProspectRepository;
use Illuminate\Http\Request;

class ProspectController extends Controller
{
    /**
     * @var ProspectRepository
     */
    protected $prospectRepository;

    /**
     * ProspectController constructor.
     * @param ProspectRepository $prospectRepository
     */
    public function __construct(ProspectRepository $prospectRepository)
    {
        $this->prospectRepository = $prospectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prospects = $this->prospectRepository->getAll();

        return view('prospects.index', compact('prospects'));
    }

    /**
     * Affiche la page de création de prospect from scratch /// distinct de la page création après importation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('prospects.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param ProspectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProspectRequest $request)
    {
        try {
            $this->prospectRepository->store($request->all());
        }catch (\Exception $exception) {
            return redirect()->route('prospect.index')->with(['message' => $exception->getMessage()]);
        }

        return redirect()->route('prospect.index')->with(['message' => 'Insertion Prospect OK']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->prospectRepository->getById($id);

        return view('prospects.edit', compact('user'));
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
        $message = $this->prospectRepository->update($request->all(), $id);

        return response($message);
    }

    /**
     * Gère la requête Ajax 'addCredit'
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function ajaxAddCredit(Request $request, $id)
    {
        $message = $this->prospectRepository->update($request->all(), $id);

        return response($message);
    }

    /**
     * Gère la réception des data passées en param par la requête ajax
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxUpdateCredit(Request $request, $id)
    {
        $message = $this->prospectRepository->updateCreditRow($request->all(), $id);

        return response($message);
    }

    /**
     * Gère la requête Ajax DeleteCredit
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function ajaxDeleteCredit(Request $request, $id)
    {
        $message = $this->prospectRepository->update($request->all(), $id);

        return response($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = $this->prospectRepository->delete($id);

        return redirect()->route('prospect.index')->with('message', $message);
    }
}
