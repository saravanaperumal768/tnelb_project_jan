<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_Temp_Tbl extends Model
{
    use HasFactory;
    protected $table  = 'tnelb_temp_uploaded_documents';

       protected $fillable = [
        'login_id',
        'application_id',
        'module',
        'ownership_type',
        'document_category',
        'document_sub_category',
        'file_name',
        'file_path',
        'uploaded_at',
        'is_final',
        'moved_as',
        'original_pdfname',
        'equip_code'
    ];
}
