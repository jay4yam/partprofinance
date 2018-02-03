<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 20/01/2018
 * Time: 17:26
 */

namespace App\Helpers;

use App\Models\Dossier;
use App\Models\TempProspect;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class StatistiquesHelper
{
    /**
     * Retourne le nombre d'utilisateur crée ce mois ci
     * @return mixed
     */
    public function getProspectThisMonth()
    {
        $value = Cache::remember('currentMonthUser', 10, function () {
            $tempProspect = new TempProspect();
            return  $tempProspect->countUserOfTheMonth()->count();
        });

        return $value;
    }

    /**
     * Retourne le nombre de dossier du mois
     * @return mixed
     */
    public function getDossierThisMonth()
    {
        $value = Cache::remember('numOfDossier', 10, function () {

            $dossier = new Dossier();

            $numOfDossier = $dossier->dossierOfTheMonth()->count();

            return $numOfDossier;
        });

        return $value;
    }

    /**
     * Retourne le taux de transfo des prospects vers les dossiers
     * @return float|int
     */
    public function countTransfoProspectToDossier()
    {
        //Nombre d'utilisateur creés ce mois ci
        $numOfUsers = $this->getProspectThisMonth();

        //Nombre de dossiers du mois
        $numOfDossier = $this->getDossierThisMonth();

        $pourcentage = 0;

        if($numOfUsers > 0) {
            $pourcentage = $numOfDossier / $numOfUsers * 100;
        }

        return $pourcentage;
    }

    /**
     * Retourne le nombre de dossiers acceptés ce mois ci
     * @return mixed
     */
    public function countAcceptedDossier()
    {
        $value = Cache::remember('dossiersAcceptes', 10, function () {

            $dossier = new Dossier();

            return $dossier->dossierAcceptedOfTheMonth()->count();
        });

        return $value;
    }

    /**
     * Retourne le nombre de dossier refusé du mois en cours
     * @return mixed
     */
    public function countRefusedDossier()
    {
        $value = Cache::remember('dossiersRefuses', 10, function () {

            $dossier = new Dossier();

            return $dossier->dossierRefusedOfTheMonth()->count();
        });

        return $value;
    }

    /**
     * Retourne la sommes de tous les dossiers du mois
     * @return mixed
     */
    public function commissionOfTheMonth()
    {
        $value = Cache::remember('allCommissions', 10, function () {

            $dossier = new Dossier();

            $dossierOfTheMonth = $dossier->dossierOfTheMonth()->get();

            $commissionPartProFinance = 0;

            foreach ($dossierOfTheMonth as $dossier) {
                $commissionPartProFinance += $dossier->montant_commission_partpro;
            }

            return $commissionPartProFinance;
        });

        return $value;
    }

    /**
     * Renvois le montant de la commission des dossiers acceptés du mois
     * @return int
     */
    public function commissionAccepted()
    {
        $value = Cache::remember('commissionForSalaire', 10, function () {
            $dossier = new Dossier();

            $dossiers = $dossier->dossierAcceptedOfTheMonth()->get();

            $montant = 0;

            foreach ($dossiers as $dossier) {
                $montant += $dossier->montant_commission_partpro;
            }

            return $montant;
        });

        return $value;
    }

    /**
     * Retourne la somme des commisions payée ce mois
     * @return int
     */
    public function commissionPayee()
    {
        $dossier = new Dossier();

        $dossiers = $dossier->dossierPayeeOfTheMonth()->get();

        $montant = 0;

        foreach ($dossiers as $dossier)
        {
            $montant += $dossier->montant_commission_partpro;
        }

        return $montant;
    }

}