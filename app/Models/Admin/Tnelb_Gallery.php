<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Tnelb_Mst_Media;
use App\Models\Admin\Tnelb_Gallerycat;


class Tnelb_Gallery extends Model
{
    use HasFactory;

    public $timestamps = true;

   
    protected $table = 'tnelb_galleries';

    // Mass assignable attributes
    protected $fillable = [
        'imagetitle',
        'image',
        'status',
        'updatedby',
        'category_id'

    
    ];

  public function media()
    {
        return $this->belongsTo(Tnelb_Mst_Media::class, 'image', 'id');
    }

    // Each gallery belongs to a category
    public function category()
    {
        return $this->belongsTo(Tnelb_Gallerycat::class, 'category_id', 'id');
    }
}
