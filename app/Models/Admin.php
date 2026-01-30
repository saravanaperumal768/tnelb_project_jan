<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guard = 'admin';  // Ensure the guard is set for admin authentication

    protected $fillable = [
        'name', 'email', 'password',
    ];
}