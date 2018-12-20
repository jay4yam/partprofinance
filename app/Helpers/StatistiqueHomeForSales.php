<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 28/10/2018
 * Time: 18:03
 */

namespace App\Helpers;

use App\Models\Dossier;
use App\Models\Prospect;
use App\Models\TempProspect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class StatistiqueHomeForSales
{
    /***
     * Retourne les prospect de l'utilisateur du mois en cours
     * @param int $userId
     * @return mixed
     */
    public function getProspectSaleThisMonth(int $userId)
    {
        $tempProspect = new TempProspect();
        $tempProspectOftheMonth = $tempProspect->countUserOfTheMonthForSale($userId)->count();

        $prospect = new Prospect();
        $prospectOfTheMonth = $prospect->salers($userId)->monthly()->count();


        return $tempProspectOftheMonth + $prospectOfTheMonth;
    }

    /**
     * Retourne le nombre de dossier du mois de l'utilisateur en cours
     * @param int $userId
     * @return mixed
     */
    public function getDossierSaleThisMonth(int $userId)
    {
            $dossier = new Dossier();

            $numOfDossier = $dossier->dossierOfTheMonthForSale($userId)->count();

            dd($numOfDossier);

            return $numOfDossier;
    }

    /**
     * Retourne le nombre de dossiers acceptés ce mois pour un commercial
     * @param int $userId
     * @return mixed
     */
    public function countAcceptedDossierForSale(int $userId)
    {
        $value = Cache::remember('dossiersAcceptesForSale'.$userId, 10, function () use($userId) {

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
        $value = Cache::remember('dossiersPaidForSale'.$userId, 10, function () use($userId) {

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
        $value = Cache::remember('dossiersRefusesSale'.$userId, 10, function () use ($userId) {

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
        $value = Cache::remember('allCommissionsForSale'.$userId, 10, function () use ($userId) {

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
        $value = Cache::remember('commissionForSalaireForSale'.$userId, 10, function () use($userId){
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