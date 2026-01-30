<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminStaffRoles extends Model
{
    use HasFactory;

    protected $table = 'mst__roles';

    protected $fillable = ['user_id','name', 'email', 'password', 'role_id'];

}
