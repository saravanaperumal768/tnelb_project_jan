<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_Whatsnew extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table="tnelb_whatsnew";

    protected $fillable = ['subject_en', 'subject_ta','startdate', 'enddate', 'page_type', 'status', 'updated_by', 'newsboardcontent_en', 'newsboardcontent_ta',
    'pdf_en', 'pdf_ta', 'external_url'];
}
