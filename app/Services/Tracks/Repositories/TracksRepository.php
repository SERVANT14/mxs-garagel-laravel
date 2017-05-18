<?php

namespace App\Services\Tracks\Repositories;

use App\Mxs\Repository;
use App\Services\Tracks\Models\Track;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TracksRepository extends Repository
{
    /**
     * Fields that can be filtered by.
     *
     * @var array
     */
    protected $filterableFields = ['name', 'creator_id', 'category_id'];

    /**
     * TracksRepository constructor.
     *
     * @param Track $model
     */
    public function __construct(Track $model)
    {
        parent::__construct($model);
    }

    /**
     * Get a query for this entity with the given filters applied.
     *
     * @param array $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function queryBy(array $filters = [])
    {
        $query = $this->model->newQuery()->orderBy('released_on', 'DESC');

        return $this->applyFilters($query, $filters);
    }

    /**
     * A custom filter for the name field.
     *
     * @param $query
     * @param $value
     */
    protected function filterByName($query, $value)
    {
        $query->where('name', 'LIKE', "%{$value}%");
    }

    /**
     * Paginate filtered query results.
     *
     * @param array $filters
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public function paginate(array $filters = [], $perPage = 20)
    {
        return $this->queryBy($filters)
            ->paginate($perPage)
            ->appends($filters);
    }
}
