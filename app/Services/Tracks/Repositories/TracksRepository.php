<?php

namespace App\Services\Tracks\Repositories;

use App\Mxs\Repository;
use App\Services\Tracks\Models\Track;
use App\User;
use Carbon\Carbon;
use App\Services\Tracks\Http\Requests\Track as TrackRequest;
use Illuminate\Support\Facades\Auth;

class TracksRepository extends Repository
{
    /**
     * Fields that can be filtered by.
     *
     * @var array
     */
    protected $filterableFields = ['name', 'creator_id', 'category_id'];

    /**
     * The default field to order query results with.
     *
     * @var string
     */
    protected $queryOrderByDefaultField = 'released_on';

    /**
     * The default direction to order query results.
     *
     * @var string
     */
    protected $queryOrderByDefaultDirection = 'DESC';

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
     * Create a new track.
     *
     * @param $request
     *
     * @return Track
     */
    public function create(TrackRequest $request)
    {
        $attributes = $request->all();

        $attributes['released_on'] = $request->released_on
            ? Carbon::parse($request->released_on)
            : Carbon::now();

        $user = Auth::user();

        $attributes['creator_id'] = $user->getKey();

        if ($user->can('set-creator', Track::class) &&
            $creator = User::find($request->creator_id)
        ) {
            $attributes['creator_id'] = $creator->getKey();
        }

        return Track::create($attributes);
    }

    /**
     * Update an existing track.
     *
     * @param Track $track
     * @param $request
     *
     * @return Track
     */
    public function update(Track $track, TrackRequest $request)
    {
        $track->fill($request->except(['released_on', 'creator_id']));

        if ($request->released_on) {
            $track->released_on = Carbon::parse($request->released_on);
        }

        if (Auth::user()->can('set-creator', Track::class) &&
            $creator = User::find($request->creator_id)
        ) {
            $track->creator()->associate($creator);
        }

        return $track;
    }

    /**
     * Delete a track.
     *
     * @param Track $track
     */
    public function delete(Track $track)
    {
        $track->delete();
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
}
