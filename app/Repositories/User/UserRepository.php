<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $email
     * @param array|string $relations
     * @param array|string $columns
     * @return Model|Builder
     */
    public function findByEmail(string $email, array|string $relations = [], array|string $columns = ["*"]): Model|Builder
    {
        return $this->setBuilder($relations)->where("email", $email)->firstOrFail($columns);
    }

    /**
     * @param Request $request
     * @param array|string $relations
     * @param array|string $columns
     * @return Model|Builder|bool
     */
    public function login(
        Request $request,
        array|string $relations = [],
        array|string $columns = ["*"]
    ): Model|Builder|bool
    {
        return auth()->attempt($request->only(["email", "password"])) ?
            $this->findByEmail($request->email, $relations, $columns) :
            false;
    }

    public function createToken(User $user): string
    {
        return $user->createToken(env("APP_NAME"))->plainTextToken;
    }
}
