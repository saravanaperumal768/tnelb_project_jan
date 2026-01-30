<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_Renewals extends Model
{
    use HasFactory;

    // Table name (since Laravel won't automatically detect snake_case plural with underscores)
    protected $table = 'tnelb_renewal_applications';

    // Primary key (PostgreSQL serial column)
    protected $primaryKey = 'id';

    // If primary key is auto-incrementing
    public $incrementing = true;

    // Primary key type
    protected $keyType = 'int';

    // Fillable fields for mass assignment
    protected $fillable = [
        'applicant_name',
        'fathers_name',
        'applicants_address',
        'd_o_b',
        'age',
        'previously_number',
        'previously_date',
        'wireman_details',
        'login_id',
        'application_id',
        'form_name',
        'license_name',
        'status',
        'form_id',
        'processed_by',
        'payment_status',
        'appl_type',
        'license_number',
        'old_application',
        'aadhaar',
        'pancard',
        'aadhaar_doc',
        'pan_doc',
        'certificate_no',
        'certificate_date',
        'cert_verify',
        'license_verify'
    ];

    // Timestamps are already handled (created_at / updated_at)
    public $timestamps = true;
}
