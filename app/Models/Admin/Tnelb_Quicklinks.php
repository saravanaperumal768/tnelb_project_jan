<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_Quicklinks extends Model
{
  use HasFactory;

  public $timestamps = true;

  protected $table = "tnelb_quicklinks";

  protected $fillable = [
    'footer_menu_en',
    'footer_menu_ta',
    'page_type',
    'page_url_en',
    'page_url_ta',
    'link_content_en',
    'link_content_ta',
    'pdf_en',
    'pdf_ta',
    'external_url',
    'updated_by',
    'status',
    'menu_id',
    'submenu_id',
    'order_id'
  ];


  public function menuPage()
  {
    return $this->hasOne(\App\Models\Admin\TnelbMenuPage::class, 'footer_quicklinks_id', 'id');
  }

//   public function menuPage()
// {
//     return $this->hasOne(TnelbMenuPage::class, 'footer_quicklinks_id');
// }

}
