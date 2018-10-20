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

    public function edit(int $id)
    {
        $prospect = $this->tempProspectRepository->getById($id);

        return view('prospects.edit', compact('prospect'));
    }
}
