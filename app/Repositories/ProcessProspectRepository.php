<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 27/01/2018
 * Time: 15:37
 */

namespace App\Repositories;


use App\Models\ProcessProspect;
use App\Models\TempProspect;

class ProcessProspectRepository
{
    /**
     * @var ProcessProspect
     */
    protected $processProspect;

    /**
     * @var TempProspect
     */
    protected $tempProspect;

    /**
     * ProcessProspectRepository constructor.
     * @param TempProspect $tempProspect
     * @param ProcessProspect $processProspect
     */
    public function __construct(TempProspect $tempProspect, ProcessProspect $processProspect)
    {
        $this->processProspect = $processProspect;
        $this->tempProspect = $tempProspect;
    }

    public function updateStatus(array $inputs)
    {
        $tempProspect = $this->tempProspect->findOrFail($inputs['temp_prospect_id']);

        $tempProspect->processProspect()->update(['status' => $inputs['status']]);
    }
}