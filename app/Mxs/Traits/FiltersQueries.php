<?php

namespace App\Mxs\Traits;

trait FiltersQueries
{
    /**
     * Fields that can be filtered by.
     *
     * @var array
     */
    protected $filterableFields = [];

    /**
     * Apply the given filters to the given query.
     *
     * @param $query
     * @param array $filters
     * 
     * @return mixed
     */
    protected function applyFilters($query, array $filters = [])
    {
        $filters = collect($filters)->only($this->filterableFields)->filter();

        foreach ($filters as $key => $value) {
            if (method_exists(static::class, 'filterBy' . $key)) {
                call_user_func([$this, 'filterBy' . $key], $query, $value);
            } else {
                $query->where($key, $value);
            }
        }
        
        return $query;
    }
}