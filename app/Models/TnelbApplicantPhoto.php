<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TnelbApplicantPhoto extends Model
{
    use HasFactory;

    protected $table = 'tnelb_applicant_photos';

    protected $fillable = [
        'application_id',
        'login_id',
        'upload_path',
        'created_at',
        'updated_at'
    ];
}
