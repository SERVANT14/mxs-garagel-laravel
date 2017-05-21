<?php

namespace App\Services\Tracks\Models;

use Illuminate\Database\Eloquent\Model;

class TrackCategory extends Model
{
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
}
