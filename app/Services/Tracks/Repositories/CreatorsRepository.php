<?php

namespace App\Services\Tracks\Repositories;

use App\Mxs\Repository;
use App\User;

class CreatorsRepository extends Repository
{
    /**
     * CreatorsRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
