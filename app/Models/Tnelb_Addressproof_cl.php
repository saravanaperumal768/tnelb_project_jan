<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_Addressproof_cl extends Model
{
    use HasFactory;
    protected $table = 'tnelb_addressproof_cl';

    protected $fillable = [
        'login_id',
        'application_id',
        'form_name',
        'license_name',
        'addressproofno',
        'file_doc',
        'type_doc'
        ];
}
