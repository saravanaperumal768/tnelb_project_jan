<?php

namespace App\Models\Admin;

use App\Models\MstLicence;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstFeesDetail extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'mst_fees_details';

    // Primary key
    protected $primaryKey = 'id';

    // Disable timestamps auto-management if you handle manually
    public $timestamps = false;

    // Mass assignable fields
    protected $fillable = [
        'licence_id',
        'licence_code',
        'fees',
        'fees_as_on',
        'fees_ends_on',
        'fees_status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    // 🔹 Casts for date/time fields
    protected $casts = [
        'fees_as_on'  => 'datetime',
        'fees_ends_on' => 'datetime',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    // 🔹 (Optional) Relationship — if licence_id references mst_licences
    public function licence()
    {
        return $this->belongsTo(MstLicence::class, 'licence_id', 'id');
    }
}
