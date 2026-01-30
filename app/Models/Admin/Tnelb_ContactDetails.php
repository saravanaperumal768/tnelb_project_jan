<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_ContactDetails extends Model
{
    use HasFactory;

    public $timestamps = true;

   
    protected $table = 'tnelb_contact_details';

    protected $fillable = [
        'email',
        'mobilenumber',
        'status',
        'address',
        'created_by',
        'updated_by',

    
    ];
    
}
