<?php

namespace App\Services\Tracks\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['download_links' => 'array'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['category', 'creator'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'creator_id',
        'category_id',
        'description',
        'download_links',
        'released_on',
    ];

    /**
     * Is the given user the creator of this track?
     *
     * @param User $user
     *
     * @return bool
     */
    public function isCreator(User $user)
    {
        return $this->creator_id == $user->getKey();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(TrackCategory::class);
    }
}
