<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment_storetmp_A extends Model
{
    use HasFactory;

    protected $table='equipment_storetmp_a';

    protected $fillable = ['form_name', 'login_id', 'application_id', 'equip_check', 'tested_documents', 'tested_report_id', 'validity_date_eq1', 'original_invoice_instr', 'invoice_report_id', 'validity_date_eq2','instrument3_yes', 'instrument3_id', 'validity_date_eq3'];
}
