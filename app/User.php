<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Is this user an administrator?
     *
     * @return bool
     */
    public function isAdmin()
    {
        return (bool)$this->is_admin;
    }

    /**
     * Query scope that filters down results to only admin users.
     *
     * @param $query
     */
    public function scopeAreAdmins($query)
    {
        $query->where('is_admin', true);
    }
}
