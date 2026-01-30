<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    protected $guard = 'admin';
    
    protected $table = 'mst__staffs__tbls';

    public static function findByEmailOrUsername($value)
    {
        return self::where('email', $value)
            ->orWhere('name', $value)
            ->first();
    }
}
