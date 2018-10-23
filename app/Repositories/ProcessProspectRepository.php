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
     * Gère la mise a jour d'un item de la table processprotpect
     * @param $id
     * @param array $inputs
     */
    public function update($id, array $inputs)
    {
        //recup le process a mettre à jour
        $processProspect = $this->processProspect->findOrFail($id);

        //test l'input type
        switch ($inputs['type']){
            //si
            case 'relance_status':
                //met à jour la date de la relance
                $newRelance_j1 = Carbon::now()->addDay(1);

                //met à jout le nom de l'item relance_status
                $processProspect->update([
                    $inputs['type'] => $inputs['value'],
                    'relance_j1' => $newRelance_j1 ]);
                //sauv. le process
                $processProspect->save();
                break;
        }
    }

    /**
     * Gère le changement du status de la table 'process_prospects'
     * @param int $tempProspectId
     * @param string $status
     */
    public function updateStatus(int $tempProspectId, string $status)
    {
        //1. recupère le prospect passé en paramètre
        $tempProspect = $this->tempProspect->findOrFail($tempProspectId);

        //Test si le prospect à une relation avec la table processProspect
        if($tempProspect->processProspect()->count()){
            //On met à jour le status dans la table process prospect
            $tempProspect->processProspect()->update(['status' => $status]);

        }
        //si le prospect n'a pas de relation avec la table processProspect
        else{
            //creation du nouveau model processProspect
            $processProspect = new ProcessProspect(['status' => $status ]);

            //Mise à jour du lien entre les tables tempProspect et ProcessProspect
            $tempProspect->processProspect()->save($processProspect);
        }
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

        $num = $prospect->tel_portable;

        $nexmo->message()->send([
                'to' => '33'.$num,
                'from' => '0615805566',
                'text' => $text,
            ]);
    }

    /**
     * Gère la modification des dates de relance 1 et 4
     * @param TempProspect $prospect
     * @throws \Exception
     */
    public function updateRelancesDate(TempProspect $prospect)
    {
        try {

            $prospect->processProspect()->update([
                'relance_status' => 'relance_1',
                'relance_j1' => Carbon::tomorrow(),
                'relance_j4' => Carbon::now()->addDays(4)
            ]);

        }catch (\Exception $exception){
            throw new \Exception('Impossible de mettre à jour');
        }
    }
}