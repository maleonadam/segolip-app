<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // relationship with orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    // check user role
    public function hasRole($name)
    {
        foreach ($this->roles as $role) {
            if ($role->name == $name) return true;
        }
        return false;
    }

    // assigning a role
    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }

    // removing a role
    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }
}
