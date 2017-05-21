<?php

namespace App\Services\Tracks\Models\Observers;

use App\Services\Tracks\Mail\TrackCreated;
use App\Services\Tracks\Mail\TrackDeleted;
use App\Services\Tracks\Mail\TrackEdited;
use App\Services\Tracks\Models\Track;
use App\User;
use Illuminate\Support\Facades\Mail;

class TrackObserver
{
    /**
     * Called when a track is created.
     *
     * @param Track $track
     */
    public function created(Track $track)
    {
        Mail::to(User::areAdmins()->get())
            ->send(new TrackCreated($track));
    }

    /**
     * Called when a track is edited.
     *
     * @param Track $track
     */
    public function updated(Track $track)
    {
        Mail::to(User::areAdmins()->get())
            ->send(new TrackEdited($track));
    }

    /**
     * Called when a track is deleted.
     *
     * @param Track $track
     */
    public function deleted(Track $track)
    {
        Mail::to(User::areAdmins()->get())
            ->send(new TrackDeleted($track));
    }
}