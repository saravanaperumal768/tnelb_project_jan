<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_bankguarantee_a extends Model
{
    use HasFactory;

    protected $table = 'tnelb_bankguarantee_sb';

    protected $fillable = [
        'application_id',
        'login_id',
        'bank_guarantee_address',
        'bank_guarantee_validity',
        'bank_guarantee_amount',
        'status'
    ];
}
