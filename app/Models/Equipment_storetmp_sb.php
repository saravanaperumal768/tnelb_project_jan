<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment_storetmp_sb extends Model
{
    use HasFactory;

     protected $table='equipment_storetmp_sb';

    protected $fillable = ['form_name', 'login_id', 'application_id', 'equip_check', 'invoice', 'lab_auth', 'instrument3_yes', 'instrument3_id'];
}
