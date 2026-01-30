<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TnelbMenuPage extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = "tnelb_menupages";

    protected $fillable = [
        'menu_id',
        'submenu_id',
        'page_url',
        'page_url_ta',
        'pdf_en',
        'pdf_ta',
        'external_url',
        'updated_by',
        'page_type',
        'status',
        'footer_quicklinks_id',
        'usefullinks_id',
        'footer_bottom_id'
    ];

    public function menu()
    {
        return $this->belongsTo(\App\Models\Admin\TnelbMenu::class, 'menu_id');
    }

    
}
