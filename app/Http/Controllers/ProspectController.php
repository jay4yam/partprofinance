<?php

namespace App\Http\Controllers;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
