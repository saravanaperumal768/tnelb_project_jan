<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B_Application extends Model
{
    use HasFactory;

     protected $casts = [
        'previous_application_validity' => 'date',
        'bank_validity'=> 'date',
    ];

    protected $table = 'tnelb_eb_applications'; 

    protected $fillable = [
        'login_id',
        'application_id',
        'form_name',
        'license_name',
        'application_status',
        'license_number',
        'payment_status',
        'applicant_name',
        'business_address',
        'address_proprietor',
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

        'manager_name_radio',
        'manager_name',
        
        'previous_contractor_license',
        'previous_application_number',
        'previous_application_validity',

        'bank_address',
        'bank_validity',
        'bank_amount',

        'bank_guarantee_address',
        'bank_guarantee_validity',
        'bank_guarantee_amount',


        'criminal_offence',
        'criminal_offence_details',

        'approval_letters',
        'qualification_certificate',
        'purchase_enclose',
        'test_reports_enclose',

        'authorized_sign',
        'name_of_authorised_to_sign',
        'age_of_authorised_to_sign',
        'qualification_of_authorised_to_sign',
        
        'three_specimen_sign',

        'single_specimen_sign',

        'single_specimen_sign',

        'separate_sheet',
        'declaration1',
        'declaration2',
        'enclosure',
        'aadhaar',
        'pancard',
        'gst_number',
        'appl_type',
        'aadhaar_doc',
        'pan_doc',
        'gst_doc',
        'old_application',
        'previous_contractor_license_verify',
        'application_ownershiptype',
        'dd_submit'
    ];
}
