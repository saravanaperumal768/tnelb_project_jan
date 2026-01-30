<?php

namespace App\Models\admin;

use App\Models\Admin\TnelbMenuPage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TnelbMenu extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table="tnelb_menus";

    protected $fillable = ['menu_name_en',  'menu_name_ta', 'page_url', 'page_type', 'status', 'page_url_ta', 'order_id', 'pdf_en', 'pdf_ta', 'external_url', 'footer_quicklinks', 'updated_by'];

    public function menuPage()
    {
        return $this->hasOne(TnelbMenupage::class, 'menu_id');
    }
    
    
}
