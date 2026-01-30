<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TnelbApplicantStaffDetail extends Model
{
    use HasFactory;

    protected $casts = [
    'cc_validity' => 'date',
];

    protected $table = 'tnelb_applicant_cl_staffdetails';

    protected $fillable = [
        'login_id',
        'application_id',
        'staff_name',
        'staff_qualification',
        'staff_category',
        'cc_number',
        'cc_validity',
        'staff_cc_verify'
    ];
}
