<?php

namespace App\Http\Controllers\Admin;

use App\Models\EA_Application_model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class SecretaryController extends Controller
{
    public function index()
    {
        $applications = DB::table('tnelb_application_tbl')
            ->where('status', '!=', 'P') // Secretary only processes verified applications
            ->get();

        return view('admin.dashboards.secretary', compact('applications'));
    }
    public function view_secratary(Request $request)
    {
        // var_dump('expression');die;
        $formId = $request->query('form_id');

        $new_applications = DB::table('tnelb_application_tbl as ta')
        ->where('ta.form_id', $formId)
        ->where(function($q) {
            $q->where(function($q2) {
                $q2->where('ta.processed_by', 'A');
            })
            ->orWhereIn('ta.status', ['RF', 'F']);
        })
        ->where('ta.appl_type', 'N')
        ->select('ta.*')
        ->orderByDesc('ta.id')
        ->get();


       $renewal = DB::table('tnelb_application_tbl as ta')
        ->where('ta.form_id', $formId)
        ->where(function($q) {
            $q->where(function($q2) {
                $q2->where('ta.processed_by', 'A');
            })
            ->orWhereIn('ta.status', ['RF', 'F']);
        })
        ->where('ta.appl_type', 'R')
        ->select('ta.*')
        ->orderByDesc('ta.id')
        ->get();


        return view('admin.secretary.view_pending', compact('new_applications','renewal'));

    }
    public function view_president(Request $request)
    {

        $formId = $request->query('form_id');

        $new_applications = DB::table('tnelb_application_tbl as ta')
            ->where('ta.processed_by', 'SE')
            ->where('ta.appl_type', 'N')
            ->where('ta.status', 'F','RF')
            ->where('ta.form_id', $formId)
            ->select('ta.*')
             ->orderByDesc('ta.id')
            ->get();

        $renewal_applications = DB::table('tnelb_application_tbl as ta')
            ->where('ta.processed_by', 'SE')
            ->where('ta.appl_type', 'R')
            ->where('ta.status', 'F','RF')
            ->where('ta.form_id', $formId)
            ->select('ta.*')
             ->orderByDesc('ta.id')
            ->get();

        return view('admin.auditor.view', compact('new_applications','renewal_applications'));
        
    }
    public function completed_secratary(Request $request)
    {

        $formId = $request->query('form_id');
        
        $workflows = DB::table('tnelb_application_tbl as ta')
        ->whereIn('ta.status', ['F','A'])
            ->where('ta.form_id', $formId)
            ->select('ta.*')
            ->get();

            return view('admin.secretary.completed', compact('workflows'));
    }
    public function completed_pres(Request $request)
    {
        
        $formId = $request->query('form_id');

        $workflows = DB::table('tnelb_application_tbl as ta')
            ->leftJoin('tnelb_license as l', 'l.application_id', '=', 'ta.application_id')
            ->leftJoin('tnelb_renewal_license as rl', 'rl.application_id', '=', 'ta.application_id')
            ->where('ta.status', 'A')
            ->where('ta.processed_by','PR')
            ->where('ta.form_id', $formId)
            ->select(
                'ta.*',
                DB::raw("
                    CASE 
                        WHEN l.application_id IS NOT NULL 
                          OR rl.application_id IS NOT NULL 
                        THEN 1 ELSE 0 
                    END AS has_licence
                "),

                DB::raw("COALESCE(l.id, rl.id) AS licence_id"),
                DB::raw("COALESCE(l.license_number, rl.license_number) AS licence_number"),
                DB::raw("COALESCE(l.issued_at, rl.issued_at) AS licence_issued_at"),
                DB::raw("COALESCE(l.expires_at, rl.expires_at) AS licence_expires_at"),
                DB::raw("COALESCE(l.issued_by, rl.issued_by) AS licence_issued_by"),
                DB::raw("
                    CASE 
                        WHEN l.application_id IS NOT NULL THEN 'NEW'
                        WHEN rl.application_id IS NOT NULL THEN 'RENEWAL'
                        ELSE NULL
                    END AS licence_type
                ")
            )
            ->orderByDesc('ta.id')
            ->get();


            // var_dump($workflows);die;


            return view('admin.secretary.completed', compact('workflows'));
    }
    
    public function view_sec_forma_pending(Request $request, $type)
    {

        // return $type;
 
        // $formId = $request->query('form_id');
     $workflows = DB::table('tnelb_ea_applications as ta')
            ->whereIn('ta.processed_by', ['A', 'SPRE']) 
            ->Where('ta.application_status', 'F')
            ->orderByDesc('updated_at')
            // ->where('ta.form_id', $formId)
            ->select('ta.*')
           
            ->get();


            // ---------------

    //    $workflows = DB::table('tnelb_ea_applications as ta')
    // ->where(function($q) {
    //     $q->where('ta.processed_by', '=', 'A')
    //       ->orWhereIn('ta.application_status', ['RF', 'F']);
    // })
    // ->orderby('updated_at', 'DESC')
    // // ->where('ta.appl_type', '=', 'N')
    // ->select('ta.*')
    // ->get();

        // $workflows = DB::table('tnelb_ea_applications as ta')
        //     ->where('ta.processed_by', 'A')
        //     ->orWhere('ta.application_status', 'RF')
        //     // ->where('ta.form_id', $formId)
        //     ->select('ta.*')
        //     ->get();

        // dd($workflows->first()->form_name);
        // exit;

        
    return view('admin.secretary.view_pending_forma', compact('workflows'));
        
    
       
    
    }

    public function view_sec_forma_completed(Request $request)
    {
     $workflows = DB::table('tnelb_ea_applications as ta')
        ->whereIn('ta.application_status', ['F','A', 'RE'])
        ->whereIn('processed_by', ['PR', 'SE'])
        ->orderByDesc('updated_at')
            // ->where('ta.form_id', $formId)
            ->select('ta.*')
            ->get();
        // $formId = $request->query('form_id');
    
       // $workflows = DB::table('tnelb_ea_applications as ta')
       //      ->whereIn('ta.processed_by', ['A', 'SPRE']) 
       //      ->orWhere('ta.application_status', 'RF')
       //      // ->where('ta.form_id', $formId)
       //      ->select('ta.*')
       //      ->get();

    $applicationIds = $workflows->pluck('application_id');

    // Fetch from both tables
    $licenses = DB::table('tnelb_license')
        ->whereIn('application_id', $applicationIds)
        ->select('application_id', 'license_number')
        ->get()
        ->keyBy('application_id');

    $renewalLicenses = DB::table('tnelb_renewal_license')
        ->whereIn('application_id', $applicationIds)
        ->select('application_id', 'license_number')
        ->get()
        ->keyBy('application_id');
    
        return view('admin.secretary.view_completed_forma', compact(
        'workflows',
        'licenses',
        'renewalLicenses'
    ));
    
    }

    public function secratary_completed(Request $request)
    {

        $formId = $request->query('form_id');

        if($formId == 2){

            $workflows = DB::table('tnelb_application_tbl as ta')
            ->whereIn('ta.processed_by', ['S2','SE'])
            ->where('ta.form_id', $formId)
            ->where(function ($query) {
                $query->where('ta.status', 'A')
                      ->orWhere('ta.status', 'F');
            })
            ->select('ta.*')
            ->orderByDesc('ta.updated_at')
            ->get();
            
        } else {
            $workflows = DB::table('tnelb_application_tbl as ta')
            ->whereIn('ta.processed_by', ['SE','PR'])
            ->where('ta.form_id', $formId)
            ->where(function ($query) {
                $query->where('ta.status', 'A')
                        ->orWhere('ta.status', 'F');
            })
            ->select('ta.*')
            ->orderByDesc('ta.updated_at')
            ->get();
            
        }


        return view('admin.secretary.completed', compact('workflows'));
    }
}
