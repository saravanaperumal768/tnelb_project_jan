<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProprietorformA extends Model
{
    use HasFactory;
    protected $table = 'proprietordetailsform_A';

    // Mass assignable attributes
    protected $fillable = [
        'login_id',
        'application_id',
        'proprietor_name',
        'proprietor_address',
        'age',
        'qualification',
        'fathers_name',
        'present_business',
        'competency_certificate_holding',
        'competency_certificate_number',
        'competency_certificate_validity',
        'presently_employed',
        'presently_employed_name',
        'presently_employed_address',
        'previous_experience',
        'previous_experience_name',
        'previous_experience_address',
        'previous_experience_lnumber',
        'previous_experience_lnumber_validity',

        'proprietor_cc_verify',
        'proprietor_contractor_verify',
        'proprietor_flag',
        'ownership_type',
        'ownership_count'
    ];
}
