<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mst_documents extends Model
{
    use HasFactory;
    protected $table = 'tnelb_applicants_doc';
    protected $fillable = [
        'login_id',
        'application_id',
        'uploaded_doc',
        'created_at',
        'updated_at'
        
    ];
}
