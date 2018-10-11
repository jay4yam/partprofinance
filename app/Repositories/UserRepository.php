<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 10/10/2018
 * Time: 23:10
 */

namespace App\Repositories;


use App\Models\User;
use Illuminate\Http\UploadedFile;

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
        $this->user->findOrFail($id);
    }

    public function store(array $inputs, UploadedFile $avatar)
    {
        $user = new User();

        $this->save($user, $inputs, $avatar);
    }

    private function save(User $user, array $inputs, UploadedFile $avatar)
    {
        $user->name = $inputs['name'];
        $user->email = $inputs['email'];
        $user->password = bcrypt($inputs['password']);
        $user->role = $inputs['role'];

        if($avatar->isValid()){
            $file = $avatar;
            $name = 'avatar-'.time().'.'.$avatar->getClientOriginalExtension();
            try {
                $file->storeAs('public/avatar', $name);
            }catch (\Exception $exception){
                throw new $exception;
            }
        }
        $user->save();
    }
}