<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FormsbModel extends Model
{
    use HasFactory;


     protected $table = 'tnelb_esb_applications';

    public static function getPendingCountFormsb()
    {
        return self::whereIn('application_status', ['P','RE'])
        // ->where('processed_by',['A','RE'])
        ->where('payment_status', 'paid')
            ->count();

            // return self::where('form_id', $formId)
            // ->whereIn('status', ['P','RE'])
            // ->where('payment_status', 'payment')
            // ->count();
    }
    public static function getcompleteCountFormsb()
    {
       return self::whereIn('application_status', ['F', 'A','RF'])
            ->whereIn('processed_by', ['A', 'SE', 'PR', 'S','SPRE'])
            ->count();
    }

      /**
     * Get pending and completed counts for auditors.
     */
    public static function getAuditorFormsbPendingCounts()
    {
        return DB::table('tnelb_esb_applications as ta')
        ->select(
            DB::raw("COUNT(CASE WHEN ta.application_status = 'F' AND ta.processed_by = 'S' OR ta.processed_by='S2' THEN 1 END) as pending_count"),
            DB::raw("COUNT(CASE WHEN ta.application_status IN ('F', 'A', 'RF') AND ta.processed_by IN ('A', 'PR', 'SE') THEN 1 END) as completed_count"),
            DB::raw("COUNT(CASE WHEN ta.application_status = 'RJ' THEN 1 END) as rejected_count")
        )
        ->first();
    }

    public static function getSecFormsbCounts()
    {
        return DB::table('tnelb_esb_applications as ta')
        ->select(
              DB::raw("COUNT(CASE WHEN ta.application_status = 'F' AND ta.processed_by = 'RE' or ta.processed_by = 'A'
             or ta.processed_by = 'SPRE' or ta.processed_by = 'S' THEN 1 END) as pending_count"),
            DB::raw("COUNT(CASE WHEN ta.application_status IN ('F', 'A', 'RF','RE') AND ta.processed_by IN ('A', 'PR', 'SE') THEN 1 END) as completed_count"),
            DB::raw("COUNT(CASE WHEN ta.application_status = 'RJ' THEN 1 END) as rejected_count")
        )
        ->first();
    }
}
