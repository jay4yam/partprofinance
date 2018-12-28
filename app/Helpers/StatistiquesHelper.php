<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 20/01/2018
 * Time: 17:26
 */

namespace App\Helpers;

use App\Models\Dossier;
use App\Models\Prospect;
use App\Models\TempProspect;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class StatistiquesHelper
{
    /* STATS POUR ADMIN */

    /**
     * Retourne le nombre d'utilisateur crée ce mois ci
     * @return mixed
     */
    public function getProspectThisMonth()
    {
        $tempProspectOftheMonth = Cache::remember('currentMonthTempProspect', 10, function () {
            $tempProspect = new TempProspect();
            return  $tempProspect->countUserOfTheMonth()->count();
        });

        $prospectOfTheMonth = Cache::remember('currentMonthUser', 10, function () {
            $user = new User();
            return  $user->guest()->countUserOfTheMonth()->count();
        });

        return $tempProspectOftheMonth + $prospectOfTheMonth;
    }

    /**
     * retourne le nombre de prospects du mois (tempPropects & Prospect)
     * @param $month
     * @param $year
     * @return mixed
     */
    public function getProspectForMonthAndYear($month, $year)
    {
        $tempProspectOftheMonth = Cache::remember('TempProspectForAdmin'.$month.'-'.$year, 100, function () use($month, $year){
            $tempProspect = new TempProspect();
            return $tempProspect->countUserWithDate($month, $year)->count();
        });

        $prospectOfTheMonth = Cache::remember('ProspectForAdmin'.$month.'-'.$year, 100, function () use ($month, $year){
            $prospect = new Prospect();
            return $prospect->countUserWithDate($month, $year)->count();
        });

        return $tempProspectOftheMonth + $prospectOfTheMonth;
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
     * OK Retourne les dossiers du mois et de l'année passé en paramètre
     * @param $month
     * @param $year
     * @return mixed
     */
    public function getDossierForMonthAndYear($month, $year)
    {
        $numOfDossier = Cache::remember('dossierForMonthYearForAdmin'.'-'.$month.'-'.$year, 10, function () use($month, $year){
            $dossier = new Dossier();
            return $dossier->dossierForMonthAndYear($month, $year)->count();
        });

        return $numOfDossier;
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
     * Retourne dossier acceptés pour les dates passés en parametre
     * @param $month
     * @param $year
     * @return mixed
     */
    public function countAcceptedDossierForMonthAndYear($month, $year)
    {
        $dossier = new Dossier();

        return $dossier->dossierAcceptedForTheMonthAndYear($month, $year)->count();

    }

    /**
     * Retourne le nombre de dossiers acceptés ce mois ci
     * @return mixed
     */
    public function countPaidDossier()
    {
        $value = Cache::remember('dossiersPaid', 10, function () {

            $dossier = new Dossier();

            return $dossier->dossierPayeeOfTheMonth()->count();
        });

        return $value;
    }

    /**
     * Retourne le nombre de dossiers acceptés les mois / années passé en paramètre
     * @param $month
     * @param $year
     * @return mixed
     */
    public function countPaidDossierADate($month, $year)
    {
        $dossier = new Dossier();

        return $dossier->dossierPayeeForMonthAndYear($month, $year)->count();
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
     * Retourne le nombre de dossier refusé du mois en cours
     * @param $month
     * @param $year
     * @return mixed
     */
    public function countRefusedDossierADate($month, $year)
    {
        $dossier = new Dossier();

        return $dossier->dossierRefusedForMonthAndYear($month, $year)->count();

    }

    /**
     * Retourne la somme de tous les dossiers du mois
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
     * Affiche la commission partpro possible pour le mois / annee passé en params
     * @param $month
     * @param $year
     * @return int
     */
    public function commissionForMonthAndYear($month, $year)
    {

        $dossier = new Dossier();

        $dossierOfTheMonth = $dossier->dossierForMonthAndYear($month, $year)->get();

        $commissionPartProFinance = 0;

        foreach ($dossierOfTheMonth as $dossier) {
            $commissionPartProFinance += $dossier->montant_commission_partpro;
        }

        return $commissionPartProFinance;
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
     * Retourne la commission possible des dossiers acceptés des mois/annee passés en param
     * @param $month
     * @param $year
     * @return int
     */
    public function commissionAcceptedADate($month, $year)
    {
        $dossier = new Dossier();

        $dossiers = $dossier->dossierAcceptedForTheMonthAndYear($month, $year)->get();

        $montant = 0;

        foreach ($dossiers as $dossier) {
            $montant += $dossier->montant_commission_partpro;
        }

        return $montant;
    }

    public function commissionPaid()
    {
        $value = Cache::remember('caPartPro', 10, function () {
            $dossier = new Dossier();

            $dossiers = $dossier->dossierPayeeOfTheMonth()->get();

            $montant = 0;

            foreach ($dossiers as $dossier) {
                $montant += $dossier->montant_commission_partpro;
            }
            return $montant;
        });
        return $value;
    }

    /**
     * Retourne la somme des commissions payées ce mois
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

    /**
     * Retourne le montant des commissions sur les dossiers payés des mois/annee passés en param
     * @param $month
     * @param $year
     * @return int
     */
    public function commissionPayeeADate($month, $year)
    {
        $dossier = new Dossier();

        $dossiers = $dossier->dossierPayeeForMonthAndYear($month, $year)->get();

        $montant = 0;

        foreach ($dossiers as $dossier)
        {
            $montant += $dossier->montant_commission_partpro;
        }

        return $montant;
    }
}