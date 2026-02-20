<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_Attachments_cl extends Model
{
    use HasFactory;

    protected $table="tnelb_attachments_cl";
    
    protected $fillable = [
        'login_id',
        'application_id',
        'form_name',
        'license_name',
        'document_category',
        'file_doc'
    ];
}
