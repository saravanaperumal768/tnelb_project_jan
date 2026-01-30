<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portaladmin_menu extends Model
{
    use HasFactory;

    
    protected $table="tnelb_portaladmin_menu_tbl";

    protected $fillable = ['menu_name', 'menu_type', 'link', 'status', 'belongs_to', 'position'];
}
