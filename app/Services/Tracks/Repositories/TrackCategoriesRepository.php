<?php

namespace App\Services\Tracks\Repositories;

use App\Mxs\Repository;
use App\Services\Tracks\Models\TrackCategory;

class TrackCategoriesRepository extends Repository
{
    /**
     * TracksRepository constructor.
     *
     * @param TrackCategory $model
     */
    public function __construct(TrackCategory $model)
    {
        parent::__construct($model);
    }
}
