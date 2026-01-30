<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tnelb_homeslider_tbl extends Model
{
    use HasFactory;

    public $timestamps = true;


    protected $table = 'tnelb_homeslider_tbls';
    protected $casts = [
        'slider_status' => 'integer', // or remove this line if not needed
    ];
    // Mass assignable attributes
    protected $fillable = [
        'slider_name',
        'slider_image',
        'slider_caption',
        'slider_status',
        'slider_name_ta',
        'slider_caption_ta',
        'updated_by'


    ];

    // Add a relation in your Slider model
    public function media()
{
    return $this->belongsTo(Tnelb_Mst_Media::class, 'slider_image', 'id');
}

}
