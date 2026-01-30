<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mst_experience extends Model
{
    use HasFactory;
    protected $table = 'tnelb_applicants_exp';

    protected $fillable = [
        'company_name', 
        'experience', 
        'designation', 
        'document', 
        'login_id',
        'application_id',
        'exp_serial',
        'upload_document'
    ];
}
