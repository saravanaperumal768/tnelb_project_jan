<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_banksolvency_a extends Model
{
    use HasFactory;

  protected $table = 'tnelb_banksolvency_a';

    protected $fillable = [
        'application_id',
        'login_id',
        'bank_address',
        'bank_validity',
        'bank_amount',
        'status'
    ];

}
