<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\Tnelb_Gallery;

class Tnelb_Gallerycat extends Model
{
    use HasFactory;

      public $timestamps = true;

   
    protected $table = 'tnelb_gallerycats';

    // Mass assignable attributes
    protected $fillable = [
        'catname',
        'createdby',
        'updatedby',
   

    
    ];

     public function galleries()
    {
        return $this->hasMany(Tnelb_Gallery::class, 'category_id', 'id');
    }
}
