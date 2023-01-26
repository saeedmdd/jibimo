<?php

namespace App\Repositories\Withdraw;

use App\Models\Withdraw;
use App\Repositories\BaseRepository;

class WithdrawRepository extends BaseRepository
{
    const PAY = "pay";
    const WITHDRAW =  "withdraw";
    public function __construct(Withdraw $model)
    {
        $this->model = $model;
    }

    /**
     * @param array|string $relations
     * @return int
     */
    public function getUserWithdraws(array|string $relations = []): int
    {
        return $this->setBuilder($relations)->where("user_id", auth()->id())->sum("amount");
    }

}
