<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenceCategory extends Model
{
    use HasFactory;

     // Table name
    protected $table = 'mst_licence_category';

    // Primary key
    protected $primaryKey = 'id';

    // Disable auto-incrementing if using a sequence manually
    public $incrementing = false;

    // Column type of primary key
    protected $keyType = 'integer';

    // Timestamps: your table uses 'created_at' and 'updated_at' as date
    public $timestamps = false;

    // Fillable columns for mass assignment
    protected $fillable = [
        'category_name',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    // Optional: default values for attributes
    protected $attributes = [
        'status' => 2,
    ];
}
