<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group_id',
        'username',
        'password',
        'is_active',
        'is_admin',
        'fullname',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function group()
    {
        return $this->belongsTo(UserGroup::class);
    }

    public function canAccess($resource)
    {
        if ($this->is_admin) return true;
        $acl = $this->group->acl();
        return isset($acl[$resource]) && $acl[$resource] == true;
    }
}
