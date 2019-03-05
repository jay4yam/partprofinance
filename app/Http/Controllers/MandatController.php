<?php

namespace App\Http\Controllers;

use App\Repositories\ProspectRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MandatController extends Controller
{
    protected $prospectRepository;

    public function __construct(ProspectRepository $prospectRepository)
    {
        $this->prospectRepository = $prospectRepository;
    }

    /**
     * Affiche la vue de génération de mandat
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editMandat(Request $request)
    {
        //1. récupère l'id du prospect passé en paramètre
        $prospect = $this->prospectRepository->getById( $request->prospectId);

        //2. Init un tableau vide
        $zeDossier = null;

        //3. Parcours les dossiers du prospect pour voir si il en a plusieurs
        $allDossier = $prospect->dossiers->each(function ($dossier) use ($request, &$zeDossier){
            if($dossier->id == $request->dossierId)
            return $zeDossier = $dossier;
        });

        //5. retourne toutes les variables
        return view('mandat.generate', compact('prospect', 'zeDossier'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function generateMandat(Request $request)
    {
        //1. Options de la génération de pdf
        PDF::setOptions([
            'dpi' => 96,
            'fontHeightRatio' => 1,
            'defaultFont' => 'sans-serif',
            'defaultPaperSize' => 'a4',
            'isHtml5ParserEnabled' => true,
            'debugPng' => true,
            'images' => true
        ]);

        //2.récupère le prospect passé en paramétre
        $prospect = $this->prospectRepository->getById($request->prospectId);

        //3. Init la variable dossier vide
        $zeDossier = null;

        //4. Parcours les dossiers du prospect et enregistre le dossier passé en paramètre
        $allDossier = $prospect->dossiers->each(function ($dossier) use ($request, &$zeDossier){
            if($dossier->id == $request->dossierId)
                return $zeDossier = $dossier;
        });

        //test si le dossier "mandat/$prospect->nom
        if( !is_dir( storage_path('app/public/mandat/'.str_slug($prospect->nom)) ) )
        {
            \File::makeDirectory(storage_path('app/public/mandat').'/'.str_slug($prospect->nom).'/'.$zeDossier->id,0777,true);
        }

        //défini le chemin ou enregistrer le fichier
        $path = storage_path('app/public/mandat/'.str_slug($prospect->nom).'/'.$zeDossier->id);

        dd($path);
        //
        $pdf = PDF::loadView('mandat._view', ['prospect' => $prospect, 'zeDossier' => $zeDossier])->save( $path.'/mandat-' . str_slug($prospect->nom) . '.pdf' );

        dd($pdf);

        return $pdf->download('mandat-' . str_slug($prospect->nom) . '.pdf');

    }

    /**
     * Génère le contenu du mandat pour l'afficher dans la page
     * @param Model $prospect
     * @return string
     */
    private function mandatContent(Model $prospect)
    {
        $content = "ENTRE LES SOUSSIGNES :\n\n";
        $content .= $prospect->civilite." ".strtoupper($prospect->nom)." ".strtoupper($prospect->prenom)."\n";
        $content .= "Demeurant : ".$prospect->adresse.", ".$prospect->codePostal." ".$prospect->ville."\n";
        $content .= "Ci-après dénommé (e) (s) : « Le Mandant »\n\n";
        $content .= "Et :\n\n";
        $content .= "La société DESCOLO, SASU, immatriculée au RCS d’ANTIBES, sous le numéro 808781678, dont le siège social est";
        $content .= "situé 2721 Chemin de Saint-Claude – 06600 ANTIBES, et inscrite à l’ORIAS sous le numéro 15002962 en tant que";
        $content .= "Coutier en Opérations de Banque et Mandataire d’Intermédiaire en Assurance.\n";
        $content .= "Téléphone : 04.22.10.69.23 ou 06.17.16.17.76\n\n";
        $content .= "Ci-après dénommée : « Le Mandataire »\n\n";
        $content .= "\t\t\t\t\tIL EST CONVENU CE QUI SUIT :\n\n";
        $content .= "« Le Mandant » confère par les présentes au « Mandataire », qui accepte, mandat d’effectuer les études,";
        $content .= "démarches et négociations, auprès de tout organisme au choix du Mandataire, aux fins d’obtention d’un prêt";
        $content .= " répondant si possible aux caractéristiques suivantes :\n\n";
        $content .= "Montant envisagé : ".$prospect->dossier->first()->montant_final." EUROS\n\n";
        $content .= "Montant en lettre : VINGT NEUF MILLE CINQ CENT EUROS\n\n";
        $content .= "Durée envisagée : ".$prospect->dossier->first()->duree_du_pret." MOIS\n\n";
        $content .= "Objet du prêt : PRÊT PERSONNEL\n\n";
        $content .= "Il est précisé toutefois que le Mandataire a la possibilité de modifier les caractéristiques du prêt envisagé, afin de";
        $content .= "servir au mieux les intérêts du Mandant et sans qu’il soit nécessaire d’établir un nouveau mandat de recherche aux";
        $content .= "fins d’obtention d’un prêt.\n\n";
        $content .= "OBLIGATIONS DU MANDANT :\n";
        $content .= "Le Mandant doit fournir au Mandataire tous renseignements ou documents qui lui sont demandés pour la ";
        $content .= "constitution de son dossier, en vue de permettre de mener à bien le présent mandat dont il est chargé.\n";
        $content .= "En aucun cas, le Mandataire ne pourra assurer la gestion des dettes du Mandant et ce, en application des ";
        $content .= "dispositions de l’article L 342-1 du Code de la Consommation, ni effectuer des opérations de courtage ";
        $content .= "financier en application des dispositions des articles 519-1 et 519-2 du Code Monétaire et Financier.\n\n";
        $content .= "Le Mandant doit signaler immédiatement au Mandataire toutes informations complémentaires dont il a ";
        $content .= "connaissance, ou toutes modifications juridiques ou matérielles, pouvant amener à modifier ledit dossier.\n\n ";
        $content .= "Le Mandant reconnaît et accepte, qu’en cas de déclaration incomplète, erronée ou mensongère (par exemple : ";
        $content .= "découvert bancaire ou prêt en cours non mentionné, interdiction bancaire ou inscription au FICP « Fichier des";
        $content .= "Incidents de remboursements des Crédits aux Particuliers », retrait de carte bancaire ou de chéquier non signalé, ";
        $content .= "mise en règlement judiciaire ou en liquidation non mentionnée, fourniture de documents faux ou falsifiés,…etc.), la ";
        $content .= "prestation du Mandataire est immédiatement interrompue et celui-ci se réserve la possibilité de poursuivre le ";
        $content .= "Mandant en justice aux fins de solliciter des dommages-intérêts pour le préjudice subi par le Mandataire.\n\n";
        $content .= "OBLIGATIONS DU MANDATAIRE\n\n";
        $content .= "Le Mandataire devra entreprendre de façon générale, toutes démarches nécessaires pour mener à bien la mission ";
        $content .= "qui lui est confiée ce jour.\n\n";
        $content .= "En aucun cas, le Mandataire ne pourra assurer la gestion des dettes du Mandant en application des dispositions des ";
        $content .= "articles L 321-1 et L 342-1 du Code de la Consommation ni effectuer des opérations de courtage financier en ";
        $content .= "application des dispositions des articles 519-1 et 519-2 du Code Monétaire et Financier.\n\n";
        $content .= "Il doit informer le Mandant de l’accomplissement du présent mandat dès l’obtention de l’accord du prêt.\n\n";
        $content .= "Le Mandataire s’engage à ne demander aucune somme à quelque titre que ce soit si le financement recherché";
        $content .= "n’est pas trouvé, ou si le Mandant décide d’arrêter l’opération en cours de déroulement, avant l’accord donné";
        $content .= "par l’organisme de crédit sollicité.\n\n";
        $content .= "Il est expressément convenu que la responsabilité du Mandataire ne saurait être engagée pour quelque raison que";
        $content .= "ce soit en cas de non obtention du financement ou en cas de litige entre le mandant et un ou plusieurs prêteurs, et ";
        $content .= "que le Mandataire n’a aucune obligation de résultat.\n\n";
        $content .= "Les conditions générales ou particulières d’attribution du prêt sont susceptibles de modifications sans préavis";
        $content .= "De même, ni le Mandataire, ni l’organisme prêteur ne sont tenus de justifier les refus et rejets de demande de prêt.\n\n";
        $content .= "RÉMUNÉRATION DU MANDATAIRE :\n\n";
        $content .= "Le Mandant s’engage à verser au Mandataire, aux titres de frais de dossiers une somme égale à ".$prospect->dossier->first()->taux_commission ." % du montant ";
        $content .= "effectivement prêté par la banque émettrice du crédit, encaissable exclusivement lorsque le financement sera ";
        $content .= "accordé (soit ".$prospect->dossier->first()->taux_commission." %) et le prêt mis en place (en application des articles L 341-1 et L 341-2 du Code Monétaire et Financier).\n\n";
        $content .= "Le Mandant s’engage ainsi à verser au Mandataire la somme de ".$prospect->dossier->first()->montant_commission_partpro." EUROS\n\n";
        $content .= "La rémunération du mandataire s’effectuera par prélèvement SEPA, en exécution du Mandat de prélèvement SEPA ";
        $content .= "joint aux présentes, et ce dans un délai maximum de huit jours après la réception des fonds sur le compte du Mandant.\n\n";
        $content .= "En outre, il est bien convenu, qu’en cas de refus de prêt, le Mandataire ne pourra prétendre à aucune";
        $content .= "rémunération, qu’elle soit, de la part du Mandant.\n\n";
        $content .= "Par la même, le Mandant reconnaît qu’il ne lui a été demandé aucune somme d’argent pour l’étude de son dossier.\n";
        $content .= "« Aucun versement de quelque nature que ce soit ne peut être exigé d’un particulier avant l’obtention d’un ou de ";
        $content .= "plusieurs prêts d’argent ». Article L. 322-2 du Code de la consommation.\n\n";
        $content .= "Un crédit vous engage et doit être remboursé.\n\n";
        $content .= "Vérifiez votre capacité d’endettement avant de vous engager.\n\n";
        $content .= "Vous disposez d’un délai de rétractation de 14 jours suivant la signature de votre contrat pour renoncer à votre crédit.\n";
        $content .= "La baisse de la mensualité entraîne l’allongement de la durée de remboursement. Elle doit s’apprécier par rapport à la";
        $content .= "durée restant à courir des prêts objets du regroupement.\n\n";
        $content .= "Vous pouvez vous opposer sans frais à ce que vos données personnelles soient utilisées à des fins de sollicitations ";
        $content .= "commerciales en écrivant à :\nDESCOLO – Service réclamation – 2721, Chemin de St Claude 06600 ANTIBES.\n\n";
        $content .= "Vous pouvez signaler toute réclamation auprès de l’ACPR 61 Rue Taitbout 75009 PARIS.\n";
        $content .= "\n";
        $content .= "\t\t***";
        $content .= "\n";
        $content .= "Le présent Mandat est établi en deux exemplaires dont un est remis au Mandant.\n\n";
        $content .= "Il est résilié automatiquement après l’octroi du prêt et paiement du Mandataire.\n\n";
        $content .= "Le Mandant et le Mandataire s’engagent à respecter scrupuleusement la présente convention et à lui ";
        $content .= "conserver une totale confidentialité.\n";
        $content .= "\n\n";
        $content .= "Fait à ANTIBES le ".Carbon::now()->format('d/m/Y')."\n\n";
        $content .= "Le MANDANT\n";
        $content .= "Signature\n";
        $content .= "Lu et approuvé. Bon pour mandat.\n\n";
        $content .= "\n";
        $content .= "Le MANDATAIRE, Représenté par Monsieur Patrick PORTET, Président de la SASU DESCOLO\n";
        $content .=  "Lu et approuvé, bon pour acceptation de mandat.\n\n";
                    
        return $content;
    }
}
