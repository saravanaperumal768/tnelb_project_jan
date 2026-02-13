<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mst_filepath_module extends Model
{
    use HasFactory;

    protected $table = 'mst_filepath_module_cl';

    protected $fillable = [
        'cert_license_id',
        'module_name',
        'module_code',
         
        'status',
        'created_by',
        'updated_by',
        'ipaddress'
    ];
}
