<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 10/10/2018
 * Time: 23:10
 */

namespace App\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return $this->user->orderBy('id', 'desc')->paginate(10);
    }

    /**
     * @param int $id
     */
    public function getById(int $id)
    {
        return $this->user->findOrFail($id);
    }

    /**
     * Gère l'ajout utilisateur
     * @param array $inputs
     * @param UploadedFile $avatar
     */
    public function store(array $inputs, UploadedFile $avatar)
    {
        $user = new User();

        $this->save($user, $inputs, $avatar);
    }

    /**
     * Methode privée d'ajout utilisateur
     * @param User $user
     * @param array $inputs
     * @param UploadedFile $avatar
     */
    private function save(User $user, array $inputs, UploadedFile $avatar = null)
    {
        $user->name = $inputs['name'];
        $user->email = $inputs['email'];
        $user->password = bcrypt($inputs['password']);
        $user->role = $inputs['role'];
        $user->commission_rate = $inputs['commission_rate'];

        if($avatar && $avatar->isValid()){
            $file = $avatar;
            $name = 'avatar-'.time().'.'.$avatar->getClientOriginalExtension();
            try {
                if( $user->avatar && Storage::exists('/public/avatar/'.$user->avatar ) ) {
                    Storage::delete('/public/avatar/'.$user->avatar);
                }
                $file->storeAs('public/avatar', $name);
                $user->avatar = $name;
            }catch (\Exception $exception){
                throw new $exception;
            }
        }
        $user->save();
    }

    /**
     * Gère la mise à jour d'un prospect
     * @param int $userId
     * @param array $inputs
     * @param UploadedFile|null $avatar
     */
    public function update(int $userId, array $inputs, UploadedFile $avatar = null)
    {
        $user = $this->user->findOrFail($userId);

        $this->save($user, $inputs, $avatar);
    }
}