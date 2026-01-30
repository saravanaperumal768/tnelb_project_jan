<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_submenus extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = "tnelb_submenus";

    protected $fillable = ['menu_name_en', 'menu_name_ta', 'parent_code', 'page_url', 'page_url_ta', 'page_type', 'status',  'order_id', 'submenu_content_en', 'submenu_content_ta', 'pdf_en', 'pdf_ta'];


    public function submenuPage()
    {
        return $this->hasOne(\App\Models\Admin\TnelbMenuPage::class, 'submenu_id', 'id');
    }

    public function parentMenu()
    {
        return $this->belongsTo(\App\Models\Admin\TnelbMenu::class, 'parent_code');
    }
}
