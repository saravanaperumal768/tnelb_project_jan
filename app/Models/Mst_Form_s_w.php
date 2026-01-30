<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mst_Form_s_w extends Model
{
    use HasFactory;

    protected $table = 'tnelb_application_tbl';
    public $timestamps = false;
    protected $fillable = [
        'applicant_name', 
        'fathers_name', 
        'applicants_address', 
        'd_o_b', 
        'age', 
        'previously_number', 
        'previously_date', 
        'login_id',
        'application_id',
        'status',
        'wireman_details',
        'form_name',
        'form_id',
        'license_name',
        'aadhaar',
        'pancard',
        'payment_status',
        'appl_type',
        'license_number',
        'old_application',
        'aadhaar_doc',
        'pan_doc',
        'certificate_no',
        'certificate_date',
        'cert_verify',
        'license_verify',
        'submitted_date',
        'created_at',
        'updated_at'

    ];
}
