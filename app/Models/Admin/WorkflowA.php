<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowA extends Model
{
    use HasFactory;

      protected $table = 'tnelb_workflow_a'; 

    protected $fillable = [
        'application_id',
        'appl_status',
        'processed_by',
        'forwarded_to',
        'role_id',
        'is_verified',
        'query_status',
        'remarks',
        'created_at',
        'updated_at',
        'login_id',
        'queries',
        'raised_by',
    ];
}
