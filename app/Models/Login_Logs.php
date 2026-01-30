<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login_Logs extends Model
{
    use HasFactory;
    protected $table = 'tnelb_login_logs'; 

    protected $fillable = ['login_id', 'ipaddress', 'Idate', 'attempt', 'duration'];  

}
