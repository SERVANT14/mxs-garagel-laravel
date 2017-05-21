<?php

namespace App\Services\Tracks\Http\Apis;

use App\Services\Tracks\Models\Track;
use App\Services\Tracks\Repositories\TracksRepository;
use Illuminate\Http\Request;
use App\Services\Tracks\Http\Requests\Track as TrackRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TracksApi extends Controller
{
    /**
     * @var TracksRepository
     */
    protected $tracksRepo;

    /**
     * TracksApi constructor.
     *
     * @param TracksRepository $tracksRepo
     */
    public function __construct(TracksRepository $tracksRepo)
    {
        $this->tracksRepo = $tracksRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->tracksRepo->paginate($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TrackRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrackRequest $request)
    {
        return $this->tracksRepo->create($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->tracksRepo->find($id)->load(['creator', 'category']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TrackRequest $request
     * @param Track $track
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TrackRequest $request, Track $track)
    {
        return $this->tracksRepo->update($track, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Track $track
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Track $track)
    {
        abort_if(Auth::guest() || Auth::user()->cannot('manage', $track), 403);

        $this->tracksRepo->delete($track);

        return ['deleted' => true];
    }
}
