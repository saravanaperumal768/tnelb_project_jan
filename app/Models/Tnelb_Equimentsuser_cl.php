<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_Equimentsuser_cl extends Model
{
    use HasFactory;

    protected $table = 'tnelb_equimentsuser_cl';
    protected $fillable = [
        'login_id',
        'application_id',
        'form_name',
        'license_name',
        'licence_id',
        'equipment_id',
        'serial_no',
        'model_no',
        'model_no',
        'testreport_file',
        'purchasereport_file',
        'dateoftest'

    ];
}
