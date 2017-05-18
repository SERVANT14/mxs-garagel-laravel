<?php

namespace App\Mxs;

use App\Mxs\Traits\FiltersQueries;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    use FiltersQueries;

    /**
     * @var Model
     */
    protected $model;

    /**
     * Repository constructor.
     *
     * @param $model
     */
    public function __construct($model)
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
}