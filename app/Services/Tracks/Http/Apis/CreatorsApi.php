<?php

namespace App\Services\Tracks\Http\Apis;

use App\Services\Tracks\Repositories\CreatorsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreatorsApi extends Controller
{
    /**
     * @var CreatorsRepository
     */
    protected $creatorsRepo;

    /**
     * CreatorsApi constructor.
     *
     * @param CreatorsRepository $creatorsRepo
     */
    public function __construct(CreatorsRepository $creatorsRepo)
    {
        $this->creatorsRepo = $creatorsRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->creatorsRepo->queryBy()->get();
    }
}
