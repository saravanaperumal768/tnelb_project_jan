<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipmentforma_tbl extends Model
{
    use HasFactory;

    protected $table = 'equipmentforma_tbls'; 

    protected $fillable = [
          'form_name',
    'login_id',
    'application_id',
    'equip_id',
    'licence_id',
    'equipment_key',
    'equipment_value',
    'ipaddress',
    ];


}
