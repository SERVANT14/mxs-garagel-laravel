<?php

namespace App\Policies;

use App\User;
use App\Services\Tracks\Models\Track;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TrackPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user is able to manually set a creator of a track.
     *
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function setCreator(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create tracks.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true; // all users can create tracks.
    }

    /**
     * Determine whether the user can update or delete the track.
     *
     * @param  \App\User $user
     * @param  \App\Services\Tracks\Models\Track $track
     * @return mixed
     */
    public function manage(User $user, Track $track)
    {
        return $user->isAdmin() || $track->isCreator($user);
    }
}
