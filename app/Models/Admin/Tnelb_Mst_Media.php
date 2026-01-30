<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_Mst_Media extends Model
{
    use HasFactory;

     public $timestamps = true;

    protected $table="tnelb_mst_media";

     protected $fillable = ['type', 'title_en','title_ta', 'alt_text_en', 'alt_text_ta', 'filepath_img_pdf', 'status', 'created_by', 'updated_by'];
}
