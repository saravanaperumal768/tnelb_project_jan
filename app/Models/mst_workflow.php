<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_workflow extends Model
{
    use HasFactory;

    protected $table = 'mst_workflows';
    protected $fillable = [
        'login_id', 
        'application_id', 
        'payment_status', 
        'formname_appliedfor', 
        'license_name'
    ];

}
