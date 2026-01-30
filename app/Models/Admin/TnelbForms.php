<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TnelbForms extends Model
{
    use HasFactory;

    public $timestamps = true;
protected $casts = [
    'freshamount_starts' => 'datetime',
    'renewalamount_starts' => 'datetime',
    'latefee_starts' => 'datetime',
];
    protected $table="tnelb_forms";

   protected $fillable = [
    'form_name',
    'license_name',
    'fresh_amount',

     'fresh_period',
    'renewal_period',

    'freshamount_starts',
    'freshamount_ends',
    'renewal_amount',
    'renewalamount_starts',
    'renewalamount_ends',
    'latefee_amount',
    'latefee_starts',
    'latefee_ends',
    'duration_freshfee',
    'duration_renewalfee',
    'duration_latefee',
    'status',
    'instructions',
    'instruction_renewal',
    'created_by',
    'updated_by',
    'old_id',
    'Assigned',
];

}
