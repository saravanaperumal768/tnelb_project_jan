<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApplicationModel extends Model
{
    use HasFactory;

    protected $table = 'tnelb_application_tbl';

    public static function getForms($formId)
    {
        return self::where('form_id', $formId)
            ->select('*')
            ->first();
    }
    /**
     * Get pending applications count for a form.
     */
    public static function getPendingCount($formId)
    {
        return self::where('form_id', $formId)
            ->whereIn('status', ['P','RE'])
            ->where('payment_status', 'payment')
            ->count();
    }

    public static function getRejectCount($formId)
    {
        return self::where('form_id', $formId)
            ->where('status', 'RJ')
            ->count();
    }

     /**
     * Get pending applications count of all the assigned forms.
     */

    public static function getPendingCountsBySupervisor($supervisorId)
    {
        return self::whereIn('form_id', function ($query) use ($supervisorId) {
                $query->select('form_id')
                    ->from('staff_assigned_forms')
                    ->where('staff_id', $supervisorId)
                    ->where('is_active', 1); // Only active assignments
            })
            ->whereIn('status', ['P', 'RE']) // Pending or Rejected statuses
            ->groupBy('form_id')
            ->select('form_id', DB::raw('COUNT(*) as pending_count'))
            ->get();
    }

    /**
     * Get completed applications count for a form and role.
     */
    public static function getCompletedCount($formId, $processedBy)
    {
        return self::where('form_id', $formId)
            ->whereIn('status', ['F', 'A','RF'])
            ->whereIn('processed_by', [$processedBy,'A', 'SE', 'PR'])
            ->count();
    }

    /**
     * Get pending and completed counts for auditors.
     */
    public static function getAuditorPendingCounts()
    {
        
        return DB::table('mst_licences as f')
        ->leftJoin('tnelb_application_tbl as ta', 'ta.form_id', '=', 'f.id')
        ->where('f.status', 1)
        ->where('f.category_id', 2)
        ->select(
            'f.id',
            'f.form_name',
            'f.licence_name',
             'f.cert_licence_code as color_code',
                'f.category_id',
            DB::raw("COUNT(CASE WHEN ta.status = 'F' AND ta.processed_by = 'S' OR ta.processed_by='S2' THEN 1 END) as pending_count"),
            DB::raw("COUNT(CASE WHEN ta.status IN ('F', 'A', 'RF') AND ta.processed_by IN ('A', 'PR', 'SE') THEN 1 END) as completed_count"),
            DB::raw("COUNT(CASE WHEN ta.status = 'RJ' THEN 1 END) as rejected_count")
        )
        ->groupBy('f.id', 'f.form_name','f.licence_name')
        ->orderBy('f.id','asc')
        ->get();
       
    }

    /**
     * Get pending and completed counts for the secretary.
     */
    // public static function getSecretaryPendingCounts()
    // {
    //     return DB::table('tnelb_forms as f')
    //         ->leftJoin('tnelb_application_tbl as ta', 'ta.form_id', '=', 'f.id')
    //         ->select(
    //             'f.id',
    //             'f.form_name',
    //             'f.license_name',
    //             DB::raw("COUNT(CASE WHEN ta.status = 'F' AND ta.processed_by = 'A' OR ta.status = 'RF' AND ta.processed_by = 'S' OR ta.processed_by = 'S2'  THEN 1 END) as pending_count"),
    //             DB::raw("COUNT(CASE WHEN ta.status IN ('A','F') AND ta.processed_by = 'SE' THEN 1 END) as completed_count")
    //         )
    //         ->groupBy('f.id', 'f.form_name', 'f.license_name')
    //         ->get();
    // }


    public static function getSecretaryPendingCounts()
    {


        return DB::table('mst_licences as f')
            ->leftJoin('tnelb_application_tbl as ta', 'ta.form_name', '=', 'f.form_code')
            ->where('f.category_id', 2)
            ->where('f.status', 1)
            ->select(
                'f.id',
                'f.form_name',
                'f.licence_name',
                'f.cert_licence_code as color_code',
                'f.category_id',
                DB::raw("COUNT(CASE WHEN ta.status = 'F' AND ta.processed_by = 'A' OR ta.status = 'RF' AND ta.processed_by = 'S' OR ta.processed_by = 'S2'  THEN 1 END) as pending_count"),
                DB::raw("COUNT(CASE WHEN ta.status IN ('A','F','RF') AND ta.processed_by IN ('SE', 'PR') THEN 1 END) as completed_count"),
                DB::raw("COUNT(CASE WHEN ta.status = 'RJ' THEN 1 END) as rejected_count")
            )
            ->groupBy('f.id', 'f.form_name', 'f.licence_name')
            ->orderBy('f.id','asc')
            ->get();



    }
    public static function getform_wh_PendingCounts()
    {
        return DB::table('tnelb_application_tbl as ta')
        ->select(
            DB::raw("COUNT(CASE WHEN ta.status = 'P' OR ta.status = 'RF'  
                                 OR ta.processed_by = 'SE' THEN 1 END) as pending_count"),
            // DB::raw("COUNT(CASE WHEN ta.status IN ('A','F') AND ta.processed_by = 'SE' 
            //                      THEN 1 END) as completed_count")
        )
        ->where('ta.form_id', 3)   // simple filter
        ->value('pending_count');  
    }
    public static function getform_wh_completed()
    {
        return DB::table('tnelb_application_tbl as ta')
            ->select(
                DB::raw("
                    COUNT(
                        CASE 
                            WHEN ta.status IN ('A','F') 
                                 AND ta.processed_by = 'SE' 
                            THEN 1 
                        END
                    ) as completed_count
                ")
            )
            ->where('ta.form_id', 3)   // filter by form_id
            ->value('completed_count');  
    }

    public static function getSecretaryComplCounts()
    {
        return DB::table('tnelb_application_tbl')
            ->whereIn('processed_by', ['SE','PR'])
            ->whereIn('status', ['F','A'])
            ->select('application_id')
            ->count();
    }

     public static function getform_wh_rejected()
    {
        return DB::table('tnelb_application_tbl as ta')
        ->select(
            DB::raw("COUNT(CASE WHEN ta.status = 'RJ' THEN 1 END) as rejected_count"),
            // DB::raw("COUNT(CASE WHEN ta.status IN ('A','F') AND ta.processed_by = 'SE' 
            //                      THEN 1 END) as completed_count")
        )
        ->where('ta.form_id', 3)   // simple filter
        ->value('pending_count');  
    }
}
