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
use App\Interfaces\Iimporter;

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
                    $tempData->nom = $items->nom;
                    $tempData->email = $items->e_mail;
                    $tempData->date_de_naissance = $items->date_de_naissance;
                    $tempData->adresse = $items->adresse;
                    $tempData->adresse_2 = $items->adresse_2;
                    $tempData->code_postal = $items->code_postal;
                    $tempData->ville = $items->ville;
                    $tempData->tel_professionnel = $items->tel_professionnel;
                    $tempData->situation_familiale =  $items->situation_familiale;
                    $tempData->nombre_denfants_a_charge = $items->nombre_denfants_a_charge;
                    $tempData->votre_profession = $items->votre_profession;
                    $tempData->type_de_votre_contrat = $items->type_de_votre_contrat;
                    $tempData->depuis_contrat_mois = $items->depuis_contrat_mois;
                    $tempData->votre_salaire = $items->votre_salaire;
                    $tempData->lgmt_depuis_mois = $items->lgmt_depuis_mois;
                    $tempData->montant_de_votre_loyer = $items->montant_de_votre_loyer;
                    $tempData->valeur_de_votre_bien_immobilier = $items->valeur_de_votre_bien_immobilier;
                    $tempData->rd_immo = $items->rd_immo;
                    $tempData->restant_du_ce_jour = $items->restant_du_ce_jour;
                    $tempData->nom_du_conjoint = $items->nom_du_conjoint;
                    $tempData->date_de_naissance_du_conjoint = $items->date_de_naissance_du_conjoint;
                    $tempData->profession_du_conjoint = $items->profession_du_conjoint;
                    $tempData->contrat_du_conjoint = $items->contrat_du_conjoint;
                    $tempData->contrat_conjoint_depuis_mois = $items->contrat_conjoint_depuis_mois;
                    $tempData->salaire_conjoint = $items->salaire_conjoint;

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
                    $tempData->nom = $items->nom;
                    $tempData->email = $items->email;
                    $tempData->prenom = $items->prenom;

                    //Sauv. le model
                    $tempData->save();
                }
                break;
        }

    }
}