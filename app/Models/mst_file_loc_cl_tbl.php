<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_file_loc_cl_tbl extends Model
{
    use HasFactory;


    protected $table = 'mst_filepath_cl_tbl';

    protected $fillable = [
        'cert_license_id',
        'appl_type',
        'form_module',
        'filepath_temp',
        'filepath_pro',         
         'status',
        'created_by',
        'updated_by',
        'ipaddress',
        'module_code'
    ];
}
