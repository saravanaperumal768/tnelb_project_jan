<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_Usefullinks extends Model
{
    use HasFactory;

    protected $table = 'tnelb_usefullinks';

    public $timestamps = true;

    protected $fillable = ['menu_name_en',  'menu_name_ta', 'page_url', 'page_type', 'status', 'page_url_ta', 'order_id', 'pdf_en', 'pdf_ta', 'external_url', 'updated_by'];


    public function menuPage()
    {
        return $this->hasOne(\App\Models\Admin\TnelbMenuPage::class, 'usefullinks_id');

        
    }
}
