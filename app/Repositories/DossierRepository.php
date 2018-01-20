<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 18/01/2018
 * Time: 08:41
 */

namespace App\Repositories;


use App\Models\Dossier;
use App\Models\Prospect;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DossierRepository
{
    /**
     * @var Dossier
     */
    protected $dossier;

    /**
     * DossierRepository constructor.
     * @param Dossier $dossier
     */
    public function __construct(Dossier $dossier)
    {
        $this->dossier = $dossier;
    }

    /**
     * Retourne la liste des dossiers paginés 10/10
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return $this->dossier->orderBy('created_at', 'DESC')->with('user', 'banque')->paginate(10);
    }

    /**
     * Retourne un dossier en particulier
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
    {
        return $this->dossier->with('user', 'banque')->findOrFail($id);
    }

    /**
     * @param array $inputs
     * @param $id
     * @param Prospect $prospect
     */
    public function update(array $inputs, $id)
    {
        DB::transaction(function () use ($id, $inputs){
            $dossier = $this->getById($id);

            $dossier->update($inputs);

            $user = User::findOrFail( $inputs['user_id']);

            $user->prospect()->update(['iban' => $inputs['iban']]);
        });
    }

    /**
     * Enregistre un nouveau dossier
     * @param array $inputs
     */
    public function store(array $inputs)
    {
        $dossier = new Dossier();

        //utilise methode privee save()
        $this->save($dossier, $inputs);
    }

    /**
     * Methode privee qui gére la sauv du Dossier
     * @param Dossier $dossier
     * @param array $inputs
     */
    private function save(Dossier $dossier, array $inputs)
    {
        $dossier->signature = $inputs['signature'];
        $dossier->objet_du_pret = $inputs['objet_du_pret'];
        $dossier->duree_du_pret = $inputs['duree_du_pret'];
        $dossier->montant_demande = $inputs['montant_demande'];
        $dossier->montant_final = $inputs['montant_final'];
        $dossier->taux_commission = $inputs['taux_commission'];
        $dossier->montant_commission_partpro = $inputs['montant_commission_partpro'];
        $dossier->apporteur = $inputs['apporteur'];
        $dossier->taux_commission = $inputs['taux_commission'];
        $dossier->status = $inputs['status'];
        $dossier->banque_id = $inputs['banque_id'];
        $dossier->iban = $inputs['iban'];
        $dossier->user_id = $inputs['user_id'];

        DB::transaction(function () use ($dossier) {

            $dossier->save();

            $user = User::findOrFail( $dossier->user_id );

            if($dossier->iban){
                $user->prospect()->update(['iban' => $dossier->iban]);
            }
        });


    }

    /**
     * Retourne la liste des noms pour la fonction autocomplete
     * @param $request
     * @return array
     */
    public function autoCompleteName($request)
    {
        //retourne une collection contenant le nom-prenom-email
        $results = DB::table('prospects')
            ->join('users', 'users.id', '=', 'prospects.user_id')
            ->where('nom', 'LIKE', '%'.$request->term.'%')
            ->select('users.email', 'prospects.nom', 'prospects.prenom', 'prospects.user_id', 'prospects.iban')
            ->get();

        //init un tableau vide
        $array = [];

        //itère sur la collection pour peupler lz tableau array
        foreach ($results as $valeur)
        {
            $array[] = ['value' => $valeur->nom.' / '.$valeur->prenom.' / '.$valeur->email.' / '.$valeur->iban, 'id' => $valeur->user_id,];
        }

        //test si le tableau est rempli
        if(count($array))
            return $array;
        else
            return ['value'=>'Pas de résultat','id'=>''];
    }
}