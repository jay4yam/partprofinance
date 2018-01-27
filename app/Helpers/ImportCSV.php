<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 13/01/2018
 * Time: 22:53
 */
namespace App\Helpers;

use App\Models\TempProspect;
use Illuminate\Foundation\Application;
use Maatwebsite\Excel\Collections\RowCollection;
use Maatwebsite\Excel\Excel;
use \Maatwebsite\Excel\Files\ExcelFile;

class ImportCSV extends ExcelFile
{
    public $fileName;

    protected $delimiter  = ';';
    protected $enclosure  = '"';
    protected $lineEnding = '\r\n';

    /**
     * ImportCSV constructor.
     * @param Application $app
     * @param Excel $excel
     * @param $fileName
     */
    public function __construct(Application $app, Excel $excel, $fileName)
    {
        $this->fileName = $fileName;
        parent::__construct($app, $excel);
    }

    /**
     * Implementation de la méthode abstraite de la classe mère ExcelFile
     * @return mixed
     */
    public function getFile()
    {
        return $this->fileName;
    }

    /**
     * Enregistre les prospects dans la table temporaire
     * @param RowCollection $results
     * @param $prospectSource
     */
    public function storeInTemp( RowCollection $results, $prospectSource )
    {
        //itère sur la collection passée en paramètre
        switch ($prospectSource){
            case 'assuragency':
                foreach ($results as $items)
                {
                    //Init un nouvel model pour la table temp_prospect
                    $tempData = new TempProspect();

                    //Peuple le model
                    $tempData->prospect_source = $prospectSource;
                    $tempData->total_credit = $items[0];
                    $tempData->total_credit_mensualite = $items[1];
                    $tempData->civilite = $items[2];
                    $tempData->nom = $items[3];
                    $tempData->prenom = $items[4];
                    $tempData->date_de_naissance = $items[5];
                    $tempData->adresse = $items[6];
                    $tempData->adresse_2 = $items[7];
                    $tempData->code_postal = $items[8];
                    $tempData->ville = $items[9];
                    $tempData->tel_fixe = $items[10];
                    $tempData->tel_portable = $items[11];
                    $tempData->tel_pro = $items[12];
                    $tempData->email = $items[13];
                    $tempData->situation_familiale = $items[14];
                    $tempData->nombre_denfants_a_charge = $items[15];
                    $tempData->votre_profession = $items[16];
                    $tempData->type_de_votre_contrat = $items[17];
                    $tempData->depuis_contrat_mois = $items[18];
                    $tempData->depuis_contrat_annee = $items[19];
                    $tempData->votre_salaire = $items[20];
                    $tempData->periodicite_salaire = $items[21];
                    $tempData->habitation = $items[22];
                    $tempData->lgmt_depuis_mois = $items[23];
                    $tempData->lgmt_depuis_annee = $items[24];
                    $tempData->montant_de_votre_loyer = $items[25];
                    $tempData->valeur_de_votre_bien_immobilier = $items[26];
                    $tempData->mensualite_immo = $items[27];
                    $tempData->restant_du_ce_jour = $items[28];
                    $tempData->treso_demande = $items[31];
                    $tempData->autre_revenu = $items[32];
                    $tempData->autre_charge = $items[33];
                    $tempData->civ_du_conjoint = $items[50];
                    $tempData->nom_du_conjoint = $items[51];
                    $tempData->prenom_du_conjoint = $items[52];
                    $tempData->date_de_naissance_du_conjoint = $items[53];
                    $tempData->profession_du_conjoint = $items[54];
                    $tempData->contrat_du_conjoint = $items[55];
                    $tempData->contrat_conjoint_depuis_mois = $items[56];
                    $tempData->contrat_conjoint_depuis_annee = $items[57];
                    $tempData->salaire_conjoint = $items[58];
                    $tempData->periodicite_salaire_conjoint = $items[59];
                    $tempData->nombre_de_credits_en_cours = $items[60];

                    //Sauv. le model
                    $tempData->save();
                }
                break;
            case 'devisprox':
                foreach ($results as $items)
                {
                    //Init un nouvel model pour la table temp_prospect
                    $tempData = new TempProspect();

                    //Peuple le model
                    $tempData->prospect_source = $prospectSource;
                    $tempData->nom = $items[2];
                    $tempData->prenom = $items[3];
                    $tempData->email = $items[4];

                    //Sauv. le model
                    $tempData->save();
                }
                break;
        }
    }
}