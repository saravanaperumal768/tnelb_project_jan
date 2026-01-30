<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TnelbAppsInstitute extends Model
{
    protected $table = 'tnelb_applicant_institute';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'login_id',
        'application_id',
        'institute_name_address',
        'duration',
        'from_date',
        'to_date',
        'upload_doc',
        'institute_status'
    ];
}
