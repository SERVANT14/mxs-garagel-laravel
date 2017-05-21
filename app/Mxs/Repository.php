<?php

namespace App\Mxs;

use App\Mxs\Traits\FiltersQueries;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Repository
{
    use FiltersQueries, ValidatesRequests;

    /**
     * @var Model
     */
    protected $model;

    /**
     * The default field to order query results with.
     *
     * @var string
     */
    protected $queryOrderByDefaultField = 'name';

    /**
     * The default direction to order query results.
     *
     * @var string
     */
    protected $queryOrderByDefaultDirection = 'ASC';

    /**
     * Repository constructor.
     *
     * @param $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Find the model based on ID or throw a not found exception.
     *
     * @param $id
     *
     * @return Model
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
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
        $query = $this->model->newQuery()->orderBy('name');

        return $this->applyOrderBy(
            $this->applyFilters($query, $filters)
        );
    }

    /**
     * Apply an order by clause to a query.
     *
     * @param $query
     * @param array $filters
     *
     * @return mixed
     */
    protected function applyOrderBy($query, array $filters = [])
    {
        return $query->orderBy($this->queryOrderByDefaultField, $this->queryOrderByDefaultDirection);
    }

    /**
     * Paginate filtered query results.
     *
     * @param array $filters
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(array $filters = [], $perPage = 25)
    {
        return $this->queryBy($filters)
            ->paginate($perPage)
            ->appends($filters);
    }
}