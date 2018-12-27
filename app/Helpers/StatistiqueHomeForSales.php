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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class StatistiqueHomeForSales
{
    protected $year;
    protected $month;

    public function __construct()
    {
        $this->year = \Request::get('annee') ? \Request::get('annee') : Carbon::now()->format('Y');
        $this->month = \Request::get('mois') ? \Request::get('mois') : Carbon::now()->format('m');
    }

    /***
     * Retourne les prospect de l'utilisateur du mois en cours
     * @param int $userId
     * @return mixed
     */
    public function getProspectSaleThisMonth(int $userId)
    {
        $tempProspectOftheMonth = Cache::remember('tempProspectForSale'.$userId.'-'.$this->month.'-'.$this->year, 10, function () use ($userId){
            $tempProspect = new TempProspect();
            return $tempProspect->countUserOfTheMonthForSale($userId, $this->month, $this->year)->count();
        });

        $prospectOfTheMonth = Cache::remember('ProspectForSale'.$userId.'-'.$this->month.'-'.$this->year, 10, function () use ($userId){
            $prospect = new Prospect();
            return $prospect->salers($userId)->monthly($this->month, $this->year)->count();
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
        $numOfDossier = Cache::remember('numOfDossierForSale'.$userId.'-'.$this->month.'-'.$this->year, 10, function () use($userId){
            $dossier = new Dossier();
            return $dossier->dossierOfTheMonthForSales($userId, $this->month, $this->year)->count();
        });

         return $numOfDossier;
    }

    /**
     * Retourne le nombre de dossiers acceptés ce mois pour un commercial
     * @param int $userId
     * @return mixed
     */
    public function countAcceptedDossierForSale(int $userId)
    {
        $value = Cache::remember('dossiersAcceptesForSale'.$userId.'-'.$this->month.'-'.$this->year, 10, function () use($userId) {

            $dossier = new Dossier();

            return $dossier->dossierAcceptedOfTheMonthForSales($userId, $this->month, $this->year)->count();
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
        $value = Cache::remember('dossiersPaidForSale'.$userId.'-'.$this->month.'-'.$this->year, 10, function () use($userId) {

            $dossier = new Dossier();

            return $dossier->dossierPaidOfTheMonthForSale($userId, $this->month, $this->year)->count();
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
        $value = Cache::remember('dossiersRefusesSale'.$userId.'-'.$this->month.'-'.$this->year, 10, function () use ($userId) {

            $dossier = new Dossier();

            return $dossier->dossierRefusedOfTheMonthForSale($userId, $this->month, $this->year)->count();
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
        $value = Cache::remember('allCommissionsForSale'.$userId.'-'.$this->month.'-'.$this->year, 10, function () use ($userId) {

            $dossier = new Dossier();

            $dossierOfTheMonth = $dossier->dossierOfTheMonthForSales($userId, $this->month, $this->year)->get();

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
        $value = Cache::remember('commissionForSalaireForSale'.$userId.'-'.$this->month.'-'.$this->year, 10, function () use($userId){
            $dossier = new Dossier();

            $dossiers = $dossier->dossierAcceptedOfTheMonthForSales($userId, $this->month, $this->year)->get();

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

        $dossiers = $dossier->dossierPaidOfTheMonthForSale($userId, $this->month, $this->year)->get();

        $montant = 0;

        foreach ($dossiers as $dossier)
        {
            $montant += $dossier->montant_commission_partpro;
        }

        return $montant;
    }
}