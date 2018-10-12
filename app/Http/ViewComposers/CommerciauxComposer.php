<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 12/10/2018
 * Time: 17:50
 */

namespace App\Http\ViewComposers;

use App\Models\User;
use Illuminate\View\View;

class CommerciauxComposer
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    private function getSalesUsers()
    {
        $users = $this->user->staff()->pluck('name', 'id');
        return $users;
    }

    /**
     * gère le renvois du tableau d'utilisateur
     * @param View $view
     */
    public function compose(View $view)
    {
        $array = $this->getSalesUsers();

        $view->with(['commerciaux' => $array]);
    }
}