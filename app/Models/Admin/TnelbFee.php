<?php

namespace App\Models\Admin;

use App\Models\MstLicence;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TnelbFee extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'tnelb_fees';

    /**
     * Primary key
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     * (You manage timestamps manually since your table doesn’t follow Laravel's default pattern)
     */
    public $timestamps = false;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'cert_licence_id',
        'fees_type',
        'fees',
        'start_date',
        'end_date',
        'fees_status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'ipaddress',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'fees'        => 'integer',
        'fees_status' => 'integer',
        'created_by'  => 'integer',
        'updated_by'  => 'integer',
        // 'start_date'  => 'date',
        // 'end_date'    => 'date',
        // 'created_at'  => 'datetime',
        // 'updated_at'  => 'datetime',
    ];

    /**
     * (Optional) Relationship example
     * If cert_licence_id references mst_licences or another table
     */
    public function licence()
    {
        return $this->belongsTo(MstLicence::class, 'cert_licence_id', 'id');
    }
}
