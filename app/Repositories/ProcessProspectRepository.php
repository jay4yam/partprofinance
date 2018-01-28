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
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

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

    /**
     * Gère le chamgement du status de la table 'process_prospects'
     * @param array $inputs
     */
    public function updateStatus(array $inputs)
    {
        $tempProspect = $this->tempProspect->findOrFail($inputs['temp_prospect_id']);

        $tempProspect->processProspect()->update(['status' => $inputs['status']]);
    }

    /**
     * Gère l'envois du mail
     * @param array $inputs
     * @param TempProspect $prospect
     */
    public function sendRelanceUne(array $inputs, TempProspect $prospect)
    {
        //Gère l'envois du mail
        $this->sendEmail($inputs['mailcontent'], $prospect);

        //gère l'envois du sms
        $this->sendSMS($inputs['smscontent'], $prospect);
    }

    /**
     * Gère l'envois de l'email
     * @param $text
     * @param TempProspect $prospect
     */
    private function sendEmail($text, TempProspect $prospect)
    {
        Mail::raw($text, function ($message) use($prospect) {
            $message->to($prospect->email);
            $message->subject('Descolo & Partprofinance : le rachat de crédit simplifié');
        });
    }

    /**
     * Gère l'envois du sms
     * @param $text
     * @param TempProspect $prospect
     */
    private function sendSMS($text, TempProspect $prospect)
    {
        $nexmo = app('Nexmo\Client');

        $nexmo->message()->send([
                'to' => '33'.$prospect->tel_portable,
                'from' => '0615805566',
                'text' => $text,
            ]);
    }

    /**
     * Gère la modification des dates de relance 1 et 4
     * @param TempProspect $prospect
     */
    public function updateRelancesDate(TempProspect $prospect)
    {
        try {
            $prospect->processProspect()->update([
                'relance_status' => 'relance_1',
                'relance_j1' => Carbon::tomorrow(),
                'relance_j4' => Carbon::now()->addDays(4),
            ]);
            $prospect->save();
        }catch (\Exception $exception){
            throw new \Exception('Impossible de mettre à jour');
        }
    }
}