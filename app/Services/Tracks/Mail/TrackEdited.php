<?php

namespace App\Services\Tracks\Mail;

use App\Services\Tracks\Models\Track;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TrackEdited extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Track
     */
    private $track;

    /**
     * Create a new message instance.
     *
     * @param Track $track
     */
    public function __construct(Track $track)
    {
        $this->track = $track;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.tracks.edited', ['track' => $this->track])
            ->subject('Track Edited - ' . $this->track->name);
    }
}
