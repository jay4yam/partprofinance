<?php

namespace App\Http\Controllers;

use App\Models\TempProspect;
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
     * Gère la mise à jour
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->processProspectRepository->update($id, $request->all());
        }catch (\Exception $exception){
            return response()->json([ 'message' => $exception->getMessage() ]);
        }
        return response()->json([ 'message' => 'maj_ok' ]);
    }

    /**
     * Met à jour le status de la piste
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request)
    {

        //1. utilise le repo pour mettre a jour le status quoi q'il arrive
        $this->processProspectRepository->updateStatus($request->all());

        //1.gère les différente action en fonction du status
        switch ($request['status'])
        {
            case 'nrp':
                //redirection vers la vue qui affiche le form Mail et SMS
                return redirect()->route('process.relanceUne', ['id' => $request->temp_prospect_id]);
                break;
            case 'intérêt':
                return redirect()->route('create.imported.prospect', ['prospectId' => $request->temp_prospect_id]);
                break;
            default:
                break;
        }

        return back();
    }

    /**
     * Affiche la vue avec les deux forms d'envois de SMS et de MAIL
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function relanceUne($id)
    {
        $prospect = TempProspect::findOrFail($id);

        $mailContent = $this->getMailContent($prospect);

        $smsContent = $this->getSMSContent($prospect);

        return view('prospects.relance', compact('prospect', 'mailContent', 'smsContent'));
    }

    /**
     * Retourne le contenu du mail
     * @param TempProspect $prospect
     * @return string
     */
    private function getMailContent(TempProspect $prospect)
    {
        $message = "Bonjour ".$prospect->civilite." ".$prospect->nom."\n";
        $message .= "Suite à votre demande de crédit de restructuration et compte-tenu des premiers éléments que vous nous avez indiqués";
        $message .= ", nous vous proposons les solutions de financement suivantes :\n\n";
        $message .= "Reprise de vos encours de prêts 11000 € + une trésorerie de 00€ (plus si vous le désirez) :\n";
        $message .= "Sur 96 mois, mensualités  de 159,32 €\n\n";
        $message .= "Nous pouvons également moduler sur des durées plus courtes OU plus longues si vous le désirez.\n";
        $message .= "Pour nous permettre de valider l’une de ces propositions et obtenir votre offre de prêt dans les meilleurs délais";
        $message .= "nous vous invitons à nous appeler au 06.15.80.55.66 ou 04.89.68.41.02 munissez-vous des pièces justificatives suivantes :\n\n";
        $message .= "Pièces relatives aux revenus du foyer :\n";
        $message .= "- Pièce d’identité en cours de validité (recto et verso).\n";
        $message .= "- Justificatif de domicile (Facture de téléphone, eau, EDF de préférence de moins de 3 mois)\n";
        $message .= "- Bulletins de salaires des 2 derniers mois + décembre 2016.\n";
        $message .= "Si retraité , dernier avis de paiement des retraites : principale + complémentaires\n";
        $message .= "Un RIB (Compte sur lequel seront effectuées les opérations = virement du crédit, prélèvement des mensualités).\n";
        $message .= "Pièces relatives à vos crédits en cours :\n";
        $message .= "Noms des organismes des crédits en cours\n\n";
        $message .= "Enfin, nous vous recommandons de ne pas multiplier les demandes sur Internet,";
        $message .= "cette démarche pourrait en effet nuire à de votre financement et aux conditions obtenues pour votre crédit.\n\n\n";
        $message .= "DESCOLO  2721 Chemin de Saint Claude 06600 Antibes\n";
        $message .= "Je reste naturellement à votre disposition pour des informations complémentaires au 06.15.80.55.66 ou le 04.89.68.41.02\n";
        $message .= "Cordialement\n";
        $message .= "Mme Emilie Pohier , votre conseiller financier";

        return $message;
    }

    /**
     * Retourne le contenu du sms
     * @param TempProspect $prospect
     * @return string
     */
    private function getSMSContent(TempProspect $prospect)
    {
        $message = "Bonjour ".$prospect->civilite." ".$prospect->nom."\n";
        $message .= "Suite à votre demande de rachat de crédit, nous répondons favorablement à cette demande";
        $message .= ", nous vous invitons au 04.89.68.41.02 ou au 06.15.80.55.66, afin de constituer votre dossier\n";
        $message .= "Cordialement\n\n";
        $message .= "Emilie Pohier, votre conseiller financier.\n";

        return $message;

    }

    /**
     * Traitement de l'envois de la relance 1 par l'utilisateur
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendRelanceUne(Request $request)
    {
        try {
            //Recupère le prospect qui est en train d'être traité
            $prospect = TempProspect::findOrFail($request->temp_prospect_id);

            $this->processProspectRepository->sendRelanceUne($request->all(), $prospect);

            //Va mettre à jour les dates des relance J+1 et J+4
            $this->processProspectRepository->updateRelancesDate($prospect);

        }catch (\Exception $exception){
            return redirect()->route('prospect.import')->with(['message' => $exception->getMessage()]);
        }

        return redirect()->route('prospect.import')->with(['message' => 'relance 1...Envoyée']);
    }
}
