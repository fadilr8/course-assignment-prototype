<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $guarded = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
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

    public function isAdmin() {
        foreach ($this->roles()->get() as $role) {
            if ($role->role == 'admin') {
                return true;
            }
        }

        return false;
    }

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function assignRole($role) {
        $this->roles()->attach($role);
    }

    public function lecturer() {
        return $this->hasOne(\App\Models\Lecturer::class);
    }
}
