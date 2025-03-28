<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class NewUser extends Authenticatable
{
    protected $fillable = [
        'login',
        'email',
        'password',
        'image'
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public $timestamps = false;
}
