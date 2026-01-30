<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mst_equipment_tbl extends Model
{
    use HasFactory;

    protected $table = 'mst_equipment_tbls';

    protected $fillable = [
        'equip_licence_name',
        'equip_name',
         'licence_id',
         'status',
        'created_by',
        'updated_by',
        'ipaddress',
        'equipment_type'
    ];
}
