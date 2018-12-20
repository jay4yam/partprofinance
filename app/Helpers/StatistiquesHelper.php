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

    public function getProspectForMonthAndYear($month, $year)
    {
        $tempProspect = new TempProspect();
        $tempProspectOftheMonth = $tempProspect->countUserWithDate($month, $year)->count();

        $prospect = new Prospect();
        $prospectOfTheMonth = $prospect->countUserWithDate($month, $year)->count();

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
     * Retourne les dossiers du mois et de l'année passé en paramètre
     * @param $month
     * @param $year
     * @return mixed
     */
    public function getDossierForMonthAndYear($month, $year)
    {
        $dossier = new Dossier();

        $numOfDossier = $dossier->dossierForMonthAndYear($month, $year)->count();

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



    /****************************/
    /*                          */
    /* STATS POUR UN COMMERCIAL */
    /*                          */
    /****************************/

    /***
     * Retourne les prospect de l'utilisateur du mois en cours
     * @param int $userId
     * @return mixed
     */
    public function getProspectSaleThisMonth(int $userId)
    {
        $tempProspectOftheMonth = Cache::remember('currentSalesMonthTempProspect', 10, function () use ($userId) {
            $tempProspect = new TempProspect();
            return  $tempProspect->countUserOfTheMonthForSale($userId)->count();
        });

        $prospectOfTheMonth = Cache::remember('currentSalesMonthUser', 10, function () use ($userId) {
            $prospect = new Prospect();
            return  $prospect->salers($userId)->monthly()->count();
        });

        return $tempProspectOftheMonth + $prospectOfTheMonth;
    }

    /**
     * Retourne le nombre de dossier du mois de l'utilisateur en cours
     * @param int $userId
     * @return mixed
     */
    public function getDossierSaleThisMonth(int $userId)
    {
        $value = Cache::remember('numOfDossierForSale', 10, function () use($userId) {

            $dossier = new Dossier();

            $numOfDossier = $dossier->dossierOfTheMonthForSale($userId)->count();

            return $numOfDossier;
        });

        return $value;
    }

    /**
     * Retourne le nombre de dossiers acceptés ce mois pour un commercial
     * @param int $userId
     * @return mixed
     */
    public function countAcceptedDossierForSale(int $userId)
    {
        $value = Cache::remember('dossiersAcceptesForSale', 10, function () use($userId) {

            $dossier = new Dossier();

            return $dossier->dossierAcceptedOfTheMonthForSale($userId)->count();
        });

        return $value;
    }

    /**
     * Retourne le nombre de dossiers acceptés ce mois ci
     * @param int $userId
     * @return mixed
     */
    public function countPaidDossierForSale(int $userId)
    {
        $value = Cache::remember('dossiersPaidForSale', 10, function () use($userId) {

            $dossier = new Dossier();

            return $dossier->dossierPaidOfTheMonthForSale($userId)->count();
        });

        return $value;
    }

    /**
     * Retourne le nombre de dossier refusé du mois en cours
     * @param int $userId
     * @return mixed
     */
    public function countRefusedDossierForSale(int $userId)
    {
        $value = Cache::remember('dossiersRefusesSale', 10, function () use ($userId) {

            $dossier = new Dossier();

            return $dossier->dossierRefusedOfTheMonthForSale($userId)->count();
        });

        return $value;
    }

    /**
     * Retourne la sommes de tous les dossiers du mois
     * @param int $userId
     * @return mixed
     */
    public function commissionOfTheMonthForSale(int $userId)
    {
        $value = Cache::remember('allCommissionsForSale', 10, function () use ($userId) {

            $dossier = new Dossier();

            $dossierOfTheMonth = $dossier->dossierOfTheMonthForSale($userId)->get();

            $commissionPartProFinance = 0;

            foreach ($dossierOfTheMonth as $dossier) {
                $commissionPartProFinance += $dossier->montant_commission_partpro;
            }

            return $commissionPartProFinance;
        });

        return $value;
    }

    /**
     * Renvois le montant de la commission des dossiers acceptés du mois pour le commercial
     * @param int $userId
     * @return int
     */
    public function commissionAcceptedForSale(int $userId)
    {
        $value = Cache::remember('commissionForSalaireForSale', 10, function () use($userId){
            $dossier = new Dossier();

            $dossiers = $dossier->dossierAcceptedOfTheMonthForSale($userId)->get();

            $montant = 0;

            foreach ($dossiers as $dossier) {
                $montant += $dossier->montant_commission_partpro;
            }

            return $montant;
        });

        return $value;
    }

    /**
     * Retourne la somme des commisions payée ce mois pour le commercial
     * @param int userId
     * @return int
     */
    public function commissionPayeeForSale(int $userId)
    {
        $dossier = new Dossier();

        $dossiers = $dossier->dossierPaidOfTheMonthForSale($userId)->get();

        $montant = 0;

        foreach ($dossiers as $dossier)
        {
            $montant += $dossier->montant_commission_partpro;
        }

        return $montant;
    }
}