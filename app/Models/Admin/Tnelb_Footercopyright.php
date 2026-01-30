<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_Footercopyright extends Model
{
    use HasFactory;

    protected $table = 'tnelb_footercopyrights';

    public $timestamps = true;

    protected $fillable = ['copyrights_en',  'copyrights_ta', 'updated_by'];

}
