<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Mst_education extends Model
{
    use HasFactory;
    protected $table = 'tnelb_applicants_edu';
    protected $fillable = [
        'educational_level', 
        'institute_name', 
        'year_of_passing', 
        'percentage', 
        'login_id',
        'application_id',
        'edu_serial',
        'upload_document'
    ];



    
}
