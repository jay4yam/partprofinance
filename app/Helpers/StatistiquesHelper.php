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
     * Retourne le nombre de dossiers acceptés ce mois ci
     * @param int $userId
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

    /* STATS POUR UN COMMERCIAL */

    /***
     * Retourne les prospect de l'utilisateur du mois en cours
     * @param int $userId
     * @return mixed
     */
    public function getProspectSaleThisMonth(int $userId)
    {
        /*$tempProspectOftheMonth = Cache::remember('currentSalesMonthTempProspect', 10, function () {
            $tempProspect = new TempProspect();
            return  $tempProspect->countUserOfTheMonthForSale()->count();
        });*/

        $prospectOfTheMonth = Cache::remember('currentSalesMonthUser', 10, function () use ($userId) {
            $prospect = new Prospect();
            return  $prospect->salers(Auth::user()->id)->monthly()->count();
        });

        return $prospectOfTheMonth;
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