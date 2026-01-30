<?php

namespace App\Models\Admin;

use App\Models\MstLicence;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesValidity extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mst_fees_validity';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'licence_id',
        'form_type',
        'validity',
        'validity_start_date',
        'validity_date_end',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'ipaddress',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'vadity_start_date' => 'date',
        // 'validity_date_end'   => 'date',
        // 'created_at' => 'datetime',
        // 'updated_at' => 'datetime',
    ];

    /**
     * Optional relationship with Licence model
     * (assuming mst_licences table)
     */
    public function licence()
    {
        return $this->belongsTo(MstLicence::class, 'licence_id', 'id');
    }
}