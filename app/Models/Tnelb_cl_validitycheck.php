<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_cl_validitycheck extends Model
{
    use HasFactory;
    protected $table = 'tnelb_cl_validitychecks';

    protected $fillable = [
        'application_id',
        'login_id',
        'license_name',
        'form_name',
        // 'bank_guarantee_amount',
        'check_value',
        'ipaddress'
    ];

}
